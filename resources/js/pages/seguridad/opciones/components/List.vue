<template>
    <div>
        <v-row class="justify-center mt-2">
            <v-col cols="12" md="10">
                <base-list-tool-bar
                        :title="`Criterios de búsqueda`"
                        :baseFilters="headers"
                    >
                        <template v-slot:filterCustom>
                            <v-col>
                                <v-select
                                    v-model="filters.opci_estado"
                                    :items="itemEstado"
                                    label="Estado"
                                    solo
                                    dense
                                    hide-details
                                    class="me-2"
                                ></v-select>
                            </v-col>
                            <v-col>
                                <v-btn color="primary" text @click="listarData" right>
                                    <v-icon>mdi-magnify</v-icon> Buscar
                                </v-btn>
                            </v-col>
                        </template>
                    </base-list-tool-bar>
            </v-col>
            <v-col cols="12" md="10">
                <v-data-table
                    :single-expand="true"
                    :expanded.sync="expanded"
                    dense
                    :headers="headers"
                    :items="model"
                    item-key="id"
                    class="elevation-1"
                >
                    <template v-slot:item.opci_icon="{ item }">
                        <v-icon
                            v-if="item.opci_icon"
                        >{{ item.opci_icon }}
                        </v-icon>
                    </template>

                    <template v-slot:item.opci_estado="{ item }">
                        <v-icon
                            :color="item.opci_estado == 1 ? 'green' : 'red'"
                        >mdi-circle
                        </v-icon>
                    </template>
                    <template v-slot:item.acciones="{ item }">
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
                                <v-icon
                                    v-on="on"
                                    @click="editarSistema(item)"
                                    color="warning"
                                >mdi-pencil
                                </v-icon>
                            </template>
                            <span>Editar</span>
                        </v-tooltip>
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
                                <v-icon
                                    v-on="on"
                                    @click="deseoEliminar(item)"
                                    color="error"
                                >mdi-delete
                                </v-icon>
                            </template>
                            <span>Eliminar</span>
                        </v-tooltip>
                    </template>

                    <template v-slot:top>
                        <v-toolbar flat>
                            <v-toolbar-title>Lista de opciones del sistema</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-btn color="primary" @click="dialogOpciones = true">
                                <v-icon left>mdi-plus</v-icon>Nuevo
                            </v-btn>
                            
                        </v-toolbar>
                    </template>
                </v-data-table>
            </v-col>
        </v-row>

        <v-dialog v-model="dialogOpciones" width="500px" persistent>
            <Formulario v-if="dialogOpciones" :item="itemSeleccionado" @close="close()" @cancelar="cancelar()" />
        </v-dialog>

        <v-dialog v-model="dialogDelete" max-width="300px" persistent>
            <DialogEliminarRegistro
                @eliminarRegistro="eliminarRegistro"
                @cancelarEliminar="CanceldialogDelete()"
            >
            </DialogEliminarRegistro>
        </v-dialog>
    </div>
</template>
<script>
import { mapGetters } from "vuex";
import { UtilService } from "@/services/util.service";
import { HeaderInterface } from "../interfaces/header.interfaces";
import { OpcionesService } from "@/pages/seguridad/opciones/services/opciones.service";

import Formulario  from "./Formulario.vue";
import FilterComponent from '../../../../components/base/FilterComponent.vue';

export default {
    components: {
        Formulario,
        FilterComponent,
    },
    data: () => ({
        expanded: [],
        headers: HeaderInterface,
        model: [],
        dialogOpciones: false,
        dialogDelete: false,
        itemSeleccionado: null,
        itemEstado: [
            { text: "Activo", value: 1 },
            { text: "Inactivo", value: 0 },
        ],
    }),
    mounted() {
        this.listarData();
    },
    computed: {
        ...mapGetters({
            getFilters: "filter/getFilters",
        }),
        filters: {
            get() {
                return this.getFilters;
            },
            set(value) {
                this.setFilters(value);
            },
        },
    },
    methods: {
        async listarData() {
            UtilService.showLoader();
            try {
                const response = await OpcionesService.index(this.filters);
                this.model = response.data.data;
            } catch (error) {
                UtilService.showErrors(error);
            } finally {
                UtilService.hideLoader();
            }
        },
        editarSistema(item) {
            this.itemSeleccionado = item;
            this.dialogOpciones = true;
        },
        deseoEliminar(item) {
            this.itemSeleccionado = item;
            this.dialogDelete = true;
        },
        async eliminarRegistro() {
            UtilService.showLoader();
            try {
                await OpcionesService.destroy(this.itemSeleccionado.opci_codigo);
                await this.listarData();

            } catch (error) {
                UtilService.showErrors(error);
            } finally {
                UtilService.hideLoader();
                this.dialogDelete = false;
            }
        },
        async cancelar() {
            this.itemSeleccionado = null;
            this.dialogOpciones = false;
        },
        async close() {
            this.itemSeleccionado = null;
            this.dialogOpciones = false;
            await this.listarData();
        },
        async CanceldialogDelete() {
            this.dialogDelete = false;
        },
    },
};
</script>