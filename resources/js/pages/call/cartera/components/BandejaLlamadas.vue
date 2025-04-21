<template>
    <div>
        <v-row>
            <v-col cols="10">
                <v-card>
                    <v-card-title>
                        <span class="text-h6 primary--text font-weight-bold">Agentes</span>
                    </v-card-title>
                    <v-card-text>
                        <v-row>
                            <v-col cols="4">
                                <v-select
                                    hide-details
                                    clearable
                                    dense
                                    outlined
                                    label="Grupo"
                                    v-model="dataFilters.grup_codigo"
                                    :items="dataGrupo"
                                    item-text="grup_nombre"
                                    item-value="grup_codigo"
                                ></v-select>
                            </v-col>
                            <v-col cols="12" sm="2">
                                <v-btn color="entidad" dark @click="buscar()"
                                    >
                                    <v-icon>mdi-magnify</v-icon> BUSCAR
                                    </v-btn
                                >
                            </v-col>

                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <v-data-table
                                    dense
                                    :headers="headersCartera"
                                    :items="dataCartera"
                                    group-by="grup_nombre"
                                    >
                                    <template v-slot:item.actions="{ item }">
                                        <v-btn
                                            @click="verLlamadas(item)"
                                            color="primary"
                                            text>
                                            <v-icon
                                                class="mr-2"
                                                color="primary"
                                            >
                                                mdi-phone
                                            </v-icon>
                                        </v-btn>
                                    </template>
                                </v-data-table>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
        <v-navigation-drawer
            v-model="drawer"
            fixed
            right
            temporary
            width="500"
            
        >
        <v-toolbar color="primary" dark class="notificaciones-header" flat>
          <v-avatar size="32" class="mr-2">
            <v-icon>
                mdi-phone
            </v-icon>
          </v-avatar>
          <v-toolbar-title>Llamadas realizadas</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-btn icon @click="drawer = false">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-toolbar>
            <HistorialLlamadas v-if="drawer" :item="itemSeleccionado" />
        </v-navigation-drawer>

    </div>
    
</template>

<script>
import {
    FooterProps,
    ItemsPerPage,
} from "@/services/common/paginado.service";
import { ErrorService } from "@/services/common/error.service";
import { environment } from "@/pages/environments";
import { UtilService } from "@/services/util.service";
import { AgenteInterface } from '../interfaces/header.agente.interfaces';
import { CarteraInterface } from '../interfaces/header.cartera.interfaces';
import AsignarHorario from './AsignarHorario.vue';
import HistorialLlamadas from './HistorialLlamadas.vue';
import { CarteraService } from '../services/cartera.service';
import { GrupoService } from "../services/grupo.service";

export default {
    components: {
        AsignarHorario,
        HistorialLlamadas,
    },
    data() {
        return {
            title: "Cartera",
            drawer: false,
            singleSelect: false,
            loading: false,
            headersAgente: AgenteInterface,
            headersCartera: CarteraInterface,
            footerProps: FooterProps,
            itemsPerPage: ItemsPerPage,
            data: [],
            dataCartera: [],
            dataEstados: [ 
                { id: 1, descripcion: "Activo" },
                { id: 0, descripcion: "Inactivo" },
            ],
            dataFilters: {
                dato_cliente: "",
                dato: "",
                estado: 1,
                grup_codigo: null,
            },
            dataDependencias: [],
            dataGrupo: [],
            environment: environment,
            dialogHorario: false,
            itemSeleccionado: null,
            expanded: [],
        };
    },
    async created() {
        await this.getGrupos();
    },
    methods: {
        buscar() {
            this.bandejaCartera();
        },
        async getGrupos() {
            try {
                UtilService.showLoader();
                const response = await GrupoService.index();
                this.dataGrupo = response.data.data;
            }catch(error){
                UtilService.showErrors(error);
            }finally{
                UtilService.hideLoader();
            }
        },
        async bandejaCartera() {
            try {
                UtilService.showLoader();
                const response = await CarteraService.asignados(this.dataFilters);
                this.dataCartera = response.data.data;

            }catch(error){
                UtilService.showErrors(error);
            }finally{
                UtilService.hideLoader();
            }
        },
        asiganarHorario() {
            this.dialogHorario = true;
        },
        verLlamadas(item) {
            this.itemSeleccionado = item;
            this.drawer = true;
        },
    },
    watch: {
    },
};
</script>

<style scoped></style>
