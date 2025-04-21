<template>
    <div>
        <v-card>
            <v-card-text>
                <v-row no-gutters>
                    <v-col cols="6">
                        <v-btn
                            class="primary"
                            dark
                            @click="dialogNuevo = true; itemSeleccionado = {}"
                        >
                            Nuevo cliente
                            <v-icon right dark>mdi-file-plus-outline</v-icon>
                        </v-btn>
                    </v-col>
                </v-row>

                <v-row class="">
                    <v-col cols="12" sm="4">
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
                            class="mt-2"
                            dense
                            :headers="headers"
                            :loading="loading"
                            :items="data"
                            :server-items-length="total"
                            :options.sync="options"
                            :footer-props="footerProps"
                            :items-per-page="itemsPerPage"
                        >
                            <template v-slot:item.accion="{ item }">
                                <v-btn
                                    text
                                    small
                                    color="entidad"
                                    @click="editar(item)"
                                >
                                    <v-icon>mdi-square-edit-outline</v-icon> EDITAR
                                </v-btn>
                            </template>

                            <template v-slot:item.clie_estado="{ item }">
                                <v-chip
                                    small
                                    dark
                                    :color="item.clie_estado ? 'green' : 'red'"
                                >
                                    {{ item.clie_estado ? 'Activo' : 'Inactivo' }}
                                </v-chip>
                            </template>
                            <template v-slot:item.clie_celular="{ item }">
                                <v-chip
                                class="ma-2"
                                color="pink"
                                label
                                text-color="white"
                                small
                                >
                                <v-icon left small>
                                    mdi-cellphone-iphone
                                </v-icon>
                                {{ item.clie_celular }}
                                </v-chip>
                            </template>
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

        <v-dialog v-model="dialogNuevo" width="500px" persistent>
            <FormAdd :item="itemSeleccionado" v-if="dialogNuevo" @close="close()" @cancelar="cancelar()" />
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
import { ClienteService } from '../services/cliente.service';

import FormAdd from "./FormAdd.vue";

export default {
    components: {
        FormAdd,
    },
    data() {
        return {
            loading: false,
            headers: HeaderInterface,
            footerProps: FooterProps,
            itemsPerPage: ItemsPerPage,
            options: {},
            data: [],
            total: 0,
            dataFilters: {
                dato: null,
                estado_id: null,
                dependencia_id: null,
            },
            dataEstados: [],
            dataDependencias: [],
            environment: environment,
            dialogNuevo: false,
            itemSeleccionado: {},
        };
    },
    async created() {
        this.dataFilters.per_page = this.itemsPerPage;
    },
    methods: {
        buscar() {
            this.dataFilters.page = 1;
            if (this.options.page == 1) {
                this.getDataApi();
            }
            this.options.page = 1;
        },
        updateOptions() {
            this.dataFilters.page = this.options.page;
            this.dataFilters.per_page = this.options.itemsPerPage;
            this.getDataApi();
        },
        async getDataApi() {
            try {
                UtilService.showLoader();
                const response = await ClienteService.index(
                    this.dataFilters
                );
                this.total = response.data.meta.total;
                this.data = response.data.data;

            }catch(error){
                UtilService.showErrors(error);
            }finally{
                UtilService.hideLoader();
            }
        },
        editar(item) {
            this.itemSeleccionado = item;
            this.dialogNuevo = true;
        },
        close() {
            this.dialogNuevo = false;
            this.getDataApi();
        },
        cancelar() {
            this.dialogNuevo = false;
        },
    },
    watch: {
        options: {
            handler() {
                this.updateOptions();
            },
            deep: false,
        },
    },
};
</script>

<style scoped></style>
