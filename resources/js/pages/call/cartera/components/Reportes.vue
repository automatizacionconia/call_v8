<template>
    <div>
        <v-row>
            <v-col cols="10">
                <v-card>
                    <v-card-title>
                        <span class="text-h6 primary--text font-weight-bold">Reporte / exportar</span>
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
                            <v-col cols="12" sm="8">
                                <v-btn color="entidad" dark @click="buscar()"
                                    >
                                    <v-icon>mdi-magnify</v-icon> BUSCAR
                                    </v-btn
                                >
                                <v-btn color="success" dark @click="exportExcel()">
                                    <v-icon>
                                        mdi-export
                                    </v-icon> EXPORTAR A EXCEL
                                </v-btn>

                            </v-col>

                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <v-data-table
                                    dense
                                    :headers="headersCartera"
                                    :items="dataCartera"
                                    >
                                </v-data-table>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
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
import { ReporteInterface } from '../interfaces/header.reportes.interfaces';
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
            singleSelect: false,
            loading: false,
            headersCartera: ReporteInterface,
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
        exportExcel() {
            window.open(
                `${this.environment.APP_URL}/api/call/cartera/export-excel?dato=${this.dataFilters.dato}&estado=${this.dataFilters.estado}&grup_codigo=${this.dataFilters.grup_codigo}`,
            );
        },
    },
    watch: {
    },
};
</script>

<style scoped></style>
