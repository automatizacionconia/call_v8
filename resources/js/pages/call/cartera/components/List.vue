<template>
    <div>
        <v-row>
            <v-col cols="6">
                <v-card>
                    <v-card-title>
                        <span class="text-h6 primary--text font-weight-bold">Clientes</span>
                    </v-card-title>
                    <v-card-text>
                        <v-row class="">
                            <v-col cols="12" sm="6">
                                <v-text-field
                                    hide-details
                                    clearable
                                    dense
                                    outlined
                                    label="Ingrese algún dato de busqueda"
                                    v-model="dataFilters.dato_cliente"
                                    autocomplete="off"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="2">
                                <v-btn color="entidad" dark @click="buscar()"
                                    >
                                    <v-icon>mdi-magnify</v-icon> BUSCAR
                                    </v-btn
                                >
                            </v-col>
                            <v-col cols="12" md="6" class="d-flex justify-end">
                                <v-btn 
                                color="success" 
                                dark 
                                @click="asiganarHorario()"
                                v-if="itemSeleccionado.length > 0"
                                    >
                                    <v-icon>
                                        mdi-account-multiple-plus
                                    </v-icon> 
                                    {{ itemSeleccionado.length }} Asignar horario
                                    </v-btn
                                >
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <v-data-table
                                    v-model="itemSeleccionado"
                                    class="mt-2"
                                    dense
                                    :headers="headers"
                                    :loading="loading"
                                    :items="data"
                                    :single-select="singleSelect"
                                    item-key="clie_codigo"
                                    show-select
                                    :search="dataFilters.dato_cliente"
                                >
                                <template v-slot:item.clie_deuda="{ item }">
                                <v-chip
                                    small
                                    dark
                                    color="green"
                                    outlined
                                >
                                    {{ item.clie_deuda }}
                                </v-chip>
                            </template>
                                </v-data-table>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="6">
                <!-- agentes -->
                <v-card>
                    <v-card-title>
                        <span class="text-h6 primary--text font-weight-bold">Grupo de programaciones</span>
                    </v-card-title>
                    <v-card-text>
                        <v-row>
                            <v-col cols="12">
                                <v-text-field
                                    hide-details
                                    clearable
                                    dense
                                    outlined
                                    label="Ingrese algún dato de busqueda"
                                    v-model="dataFilters.dato"
                                    autocomplete="off"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <v-data-table
                                    class="mt-2"
                                    dense
                                    :headers="headersAgente"
                                    :loading="loading"
                                    :items="dataGrupos"
                                    :search="dataFilters.dato"
                                >
                                    <!-- <template v-slot:item.acciones="{ item }">
                                        <v-btn
                                            color="primary"
                                            icon
                                            @click="itemSeleccionado = item.clie_codigo"
                                        >
                                            <v-icon>mdi-account-multiple-plus</v-icon>
                                        </v-btn>
                                    </template> -->
                                    <template v-slot:item.programaciones="{ item }">
                                        <v-chip
                                            small
                                            dark
                                            color="green"
                                            outlined
                                            v-for="(programacion, index) in item.programaciones"
                                            :key="index"
                                        >
                                            {{ programacion.prog_hora }}
                                        </v-chip>
                                    </template>

                                    <template v-slot:item.grup_estado="{ item }">
                                        <v-chip
                                            small
                                            dark
                                            :color="item.grup_estado==1 ? 'green' : 'red'"
                                            outlined
                                        >
                                            {{ item.grup_estado==1 ? 'Activo' : 'Inactivo' }}
                                        </v-chip>
                                    </template>
                                </v-data-table>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
        

        <v-dialog v-model="dialogHorario" max-width="900px" persistent>
            <AsignarHorario
            v-if="dialogHorario"
            :item="itemSeleccionado"
            :itemAgentes="dataAgente"
            @cancelar="dialogHorario = false"
            @saved="save"
            ></AsignarHorario>
        </v-dialog>

    </div>
</template>

<script>
import {
    FooterProps,
    ItemsPerPage,
} from "@/services/common/paginado.service";
import { ErrorService } from "@/services/common/error.service";
import { environment } from "@/pages/environments";
import { HeaderInterface } from "../interfaces/header.interfaces";
import { UtilService } from "@/services/util.service";
import { CarteraService } from '../services/cartera.service';
import { AgenteInterface } from '../interfaces/header.agente.interfaces';
import { CarteraInterface } from '../interfaces/header.cartera.interfaces';
import AsignarHorario from './AsignarHorario.vue';
import { GrupoService } from "../services/grupo.service";

export default {
    components: {
        AsignarHorario,
    },
    data() {
        return {
            title: "Cartera",
            singleSelect: false,
            loading: false,
            headers: HeaderInterface,
            headersAgente: [
                { text: "Grupo", value: "grup_nombre" },
                { text: "Programación", value: "programaciones" },
                { text: "Estado", value: "grup_estado" },
                // { text: "Acciones", value: "acciones", sortable: false },
            ],
            headersCartera: CarteraInterface,
            footerProps: FooterProps,
            itemsPerPage: ItemsPerPage,
            data: [],
            dataAgente: [],
            dataEstados: [ 
                { id: 1, descripcion: "Activo" },
                { id: 0, descripcion: "Inactivo" },
            ],
            dataFilters: {
                dato_cliente: "",
                dato: "",
                estado: 1,
            },
            dataDependencias: [],
            environment: environment,
            dialogHorario: false,
            itemSeleccionado: [],
            expanded: [],
            dataGrupos: [],
        };
    },
    async created() {
        await this.getClientes();
        await this.getGrupos();
        await this.getAgentes();
    },
    methods: {
        buscar() {
            this.getClientes();
        },
        async getClientes() {
            try {
                UtilService.showLoader();
                const response = await CarteraService.clientes();
                this.data = response.data.data;

            }catch(error){
                UtilService.showErrors(error);
            }finally{
                UtilService.hideLoader();
            }
        },
        async getGrupos() {
            try {
                UtilService.showLoader();
                const response = await GrupoService.index();
                this.dataGrupos = response.data.data;
            }catch(error){
                UtilService.showErrors(error);
            }finally{
                UtilService.hideLoader();
            }
        },
        async getAgentes() {
            try {
                UtilService.showLoader();
                const response = await CarteraService.agentes();
                this.dataAgente = response.data.data;

            }catch(error){
                UtilService.showErrors(error);
            }finally{
                UtilService.hideLoader();
            }
        },
        asiganarHorario() {
            this.dialogHorario = true;
        },
        save() {
            this.singleSelect = false;
            this.itemSeleccionado = [];
            this.dialogHorario = false;
            this.getGrupos();
        },
    },
    watch: {
    },
};
</script>

<style scoped></style>
