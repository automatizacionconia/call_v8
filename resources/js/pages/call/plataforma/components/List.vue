<template>
    <div>
        <v-row class="justify-center">
            <v-col cols="8">
                <v-card>
                    <v-card-text>
                        <v-row no-gutters>
                            <v-col cols="6">
                                <v-btn
                                    class="primary"
                                    dark
                                    @click="nuevo()"
                                >
                                    Nuevo plataforma
                                    <v-icon right dark>mdi-file-plus-outline</v-icon>
                                </v-btn>
                            </v-col>
                        </v-row>
                        <v-row class="mb-0">
                                <v-col cols="12" md="4">
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
                                <v-col cols="12" sm="3">
                                    <v-btn color="entidad" dark @click="buscar()">
                                        <v-icon>mdi-magnify</v-icon> BUSCAR                                 
                                        </v-btn
                                    >
                                </v-col>
                            </v-row>
                        
                        <v-row>
                            <v-col cols="12">
                                <v-data-table
                                    class=" mt-2"
                                    dense
                                    :headers="headers"
                                    :loading="loading"
                                    :items="dataResponse"
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

                                    <template v-slot:item.plat_estado="{ item }">
                                        <v-chip
                                            small
                                            dark
                                            :color="item.plat_estado ? 'green' : 'red'"
                                        >
                                            {{ item.plat_estado ? 'Activo' : 'Inactivo' }}
                                        </v-chip>
                                    </template>
                                </v-data-table>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
        

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
import { PlataformaService } from '../services/plataforma.service';

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
            dataResponse: [],
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
                const response = await PlataformaService.index(this.dataFilters);
                this.total = response.data.meta.total;
                this.dataResponse = response.data.data;
                
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
        nuevo() {
            this.itemSeleccionado = {};
            this.dialogNuevo = true;
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
