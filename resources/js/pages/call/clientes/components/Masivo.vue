<template>
    <v-container>
      <v-card class="pa-4 mb-4">
        <v-row>
          <v-col cols="4">
            <v-btn color="primary" dark @click="descargarPlantilla">
              <v-icon left>mdi-download</v-icon> Descargar Plantilla
            </v-btn>
          </v-col>
          <v-col cols="8" class="text-right">
            <v-form v-model="valid" lazy-validation ref="form">
                  <v-row class="d-flex justify-end">
                    <v-col cols="4">
                        <v-file-input
                        v-model="file"
                        accept=".xlsx"
                        label="Seleccionar archivo"
                        outlined
                        dense
                        hide-details
                        show-size
                        prepend-icon="mdi-file-excel"
                        :rules="[
                            v => !!v || 'El archivo es requerido',
                            v => (v && v.size < 2000000) || 'El archivo debe ser menor a 2MB',
                        ]"
                        ></v-file-input>
                    </v-col>
                    <v-col cols="3">
                        <v-btn
                        color="success" 
                        dark 
                        @click="cargarExcel">
                        <v-icon left>mdi-upload</v-icon> Cargar Excel
                        </v-btn>
                    </v-col>
                  </v-row>
                </v-form>
          </v-col>
        </v-row>
      </v-card>

      <v-card>
        <v-data-table
          :headers="headers"
          :items="items"
          class="elevation-2"
          dense
        >
          <!-- <template v-slot:[`item.actions`]="{ item }">
            <v-btn icon color="red" @click="eliminarItem(item)">
              <v-icon>mdi-delete</v-icon>
            </v-btn>
          </template> -->
        </v-data-table>
      </v-card>
    </v-container>
</template>

<script>
import { UtilService } from "@/services/util.service";
import { CargaMasivaService } from "../services/cargaMasiva.service";
import { environment } from "@/environment";
  export default {
    data() {
      return {
        headers: [
          { text: "Ítem", value: "id" },
          { text: "Nombre", value: "NOMBRES" },
          { text: "Monto", value: "MONTO" },
          { text: "Teléfono", value: "TELEFONO" },
          { text: "Acciones", value: "actions", sortable: false },
        ],
        items: [],
        valid: false,
        totalAdjuntados: 0,
        file: null,
        env: environment,
      };
    },
    methods: {
      async descargarPlantilla() {
        window.open(`${this.env.apiUrl}/call/cliente/download-template`, "_blank");
    },
    async cargarExcel() {
      if (!this.$refs.form.validate()) {
            return;
        }
        try{
            UtilService.showLoader();
            let formDataFile = new FormData();
            formDataFile.append("file", this.file);
            let data = await CargaMasivaService.store(formDataFile);
            this.items = data.data.data;
          
            this.items.forEach((item, index) => {
                item.id = index + 1;
            });

            this.totalAdjuntados = this.items.length;
            this.file = null;
            this.$refs.form.reset();
            this.$refs.form.resetValidation();

        }catch(error){
            UtilService.showErrors(error);
        }finally{
            UtilService.hideLoader();
        }
      },
      eliminarItem(item) {
        this.items = this.items.filter(i => i.id !== item.id);
      },
    },
  };
</script>
  
<style scoped>
.v-card {
    border-radius: 10px;
}
</style>