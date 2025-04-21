<template>
    <v-card>
      <v-toolbar dense color="primary" dark elevation="0">
        <v-toolbar-title>Asignación de agente y horario</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn icon @click="cancelar" small>
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </v-toolbar>
  
      <v-card-text>
        <v-form ref="form" v-model="valid" lazy-validation class="pa-3">
          <v-row class="mb-4">
              <v-col cols="7">
                  <v-card>
                      <v-card-text>
                        <span class="text-h6 primary--text font-weight-bold">Grupo</span>
                        <v-divider class="my-2"></v-divider>
                        <v-text-field
                            v-model="model.grupo"
                            label="Nombre del grupo"
                            dense
                            hide-details
                            outlined
                            :rules="[validacion.ruleRequerido]"
                        ></v-text-field>

                          <span class="text-h6 primary--text font-weight-bold">Agente</span>
                          <v-divider class="my-2"></v-divider> 
                          <v-select 
                              v-model="model.agente" 
                              :items="itemAgentes" 
                              label="Asignar al agente" 
                              dense 
                              hide-details
                              outlined
                              item-value="agen_codigo"
                              item-text="agen_nombre"
                              :rules="[validacion.ruleRequerido]"
                              >
                          </v-select>           
                          <v-divider class="my-2"></v-divider> 
                          <span class="text-h6 primary--text font-weight-bold">Clientes seleccionados</span>
                          <v-divider class="my-2"></v-divider> 
                          <v-data-table class="mt-2" 
                              dense 
                              :headers="headers" 
                              :items="itemSeleccionado">
                          
                          </v-data-table>
                      </v-card-text>
                  </v-card>
              </v-col>
    
            <v-col cols="5">
              <v-card>
                <v-card-title><span class="text-h6 primary--text font-weight-bold">Horario del inicio de llamada</span>
                </v-card-title>
                <v-card-text>
                  <v-list dense>
                  <v-list-item v-for="(day, index) in days" :key="index">
                    <v-list-item-content>
                      <v-checkbox 
                        v-model="selectedDays" 
                        :label="day.text" 
                        :value="day.value" 
                        dense 
                        hide-details
                      ></v-checkbox>
                    </v-list-item-content>
                    
                    <v-list-item-action>
                      <v-text-field
                        v-model="selectedTime[day.value]"
                        type="time"
                        dense
                        hide-details
                        outlined
                        x-small
                      ></v-text-field>
                    </v-list-item-action>
                  </v-list-item>
                </v-list>
                </v-card-text>
              </v-card>
            </v-col>
          </v-row>
      </v-form>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="primary" @click="guardar">Guardar programación</v-btn>
        <v-btn @click="cancelar">Cancelar</v-btn>
    </v-card-actions>
    </v-card>
  </template>
  
  <script>
  import { UtilService } from "@/services/util.service";
  import { ValidacionService } from '@/services/validacion.service';
  import { CarteraService } from '../services/cartera.service';
  
  export default {
    props: {
      item: {
        type: Array,
        required: true,
      },
      itemAgentes: {
        type: Array,
        required: true,
      },
    },
    data() {
      return {
        itemSeleccionado: this.item,
        model: {
          agente: null,
        },
        validacion: ValidacionService,
        headers: [
          { text: "Nombre", value: "clie_nombres" },
          { text: "Apellido", value: "clie_paterno" },
          { text: "Monto", value: "clie_deuda" },
        //   { text: "Días", value: "dias", sortable: false },
        //   { text: "Horario", value: "horario", sortable: false },
        ],
        days: [
            {value: 1, text: "Lunes"},
            {value: 2, text: "Martes"},
            {value: 3, text: "Miercoles"},
            {value: 4, text: "Jueves"},
            {value: 5, text: "Viernes"},
            {value: 6, text: "Sabado"},
            {value: 7, text: "Domingo"}
        ],
        selectedDays: [],
        selectedTime: {},
        valid: false,
      };
    },
    methods: {
        cancelar() {
            this.$emit("cancelar");
        },
        async guardar() {

          if (this.$refs.form.validate()) {
            const days = this.selectedDays;
            const time = this.selectedTime;

            try {
                UtilService.showLoader();
                let model = {
                    grupo: this.model.grupo,
                    agente: this.model.agente,
                    clientes: this.itemSeleccionado,
                    dias: days,
                    horas: time,
                };
                const response = await CarteraService.store(model)
                this.$emit('saved');
            } catch (error) {
                UtilService.showErrors(error);
            } finally {
                UtilService.hideLoader();
            }
          }

        },
    },
  };
  </script>
  
  <style scoped>
  .time-input {
    width: 100%;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
  }
  </style>
  