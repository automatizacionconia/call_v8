<template>
    <div>
        <v-row class="justify-center mt-2">
            <v-col cols="12" md="10">

                <v-data-table
                    dense
                    :headers="headers"
                    :items="itemRoles"
                    item-key="id"
                    class="elevation-1"
                >   
                    <template v-slot:item.empr_estado="{ item }">
                        <v-icon
                            :color="item.empr_estado == 1 ? 'green' : 'red'"
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
                        <v-tooltip bottom 
                        v-if="item.empr_estado == 1"
                        >
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
                            <v-toolbar-title>Empresas</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-btn color="primary" @click="nuevoSistema"><v-icon left>mdi-plus</v-icon>Nuevo</v-btn>
                        </v-toolbar>
                    </template>
                </v-data-table>
            </v-col>
        </v-row>

        <v-dialog v-model="dialogNuevo" width="500px" persistent>
            <Formulario v-if="dialogNuevo" :item="itemSeleccionado" @close="close()" @cancelar="cancelar()" />
        </v-dialog>

        <v-dialog v-model="dialogDelete" max-width="300px" persistent>
            <DialogEliminarRegistro
                @eliminarRegistro="eliminarRegistro"
                @cancelarEliminar="canceldialogDelete()"
            >
            </DialogEliminarRegistro>
        </v-dialog>

    </div>
  </template>
  <script>

import { HeaderInterface } from "../interfaces/header.interfaces";
import { EmpresasService } from "@/pages/seguridad/empresas/services/empresas.service";
import { UtilService } from "@/services/util.service";
import Formulario  from "./Formulario.vue";

export default {
    components: {
        Formulario
    },
    data: () => ({
        expanded: [],
        dialogNuevo: false,
        dialogDelete: false,
        itemRoles: [],
        headers: HeaderInterface,
        model:{
            cod_emp: null,
            nombre: null
        },
        itemSeleccionado: null,
        dialogAccesos: false

    }),
    async created() {
        await this.listar();
    },
    methods: {
        async listar() {
            UtilService.showLoader();
            try {
                const response = await EmpresasService.index();
                this.itemRoles = response.data.data;
            } catch (error) {
                UtilService.showErrors(error);
            } finally {
                UtilService.hideLoader();
            }
        },
        
        nuevoSistema() {
            this.dialogNuevo = true;
        },
        close() {
            this.dialogNuevo = false;
            this.listar();
        },
        cancelar() {
            this.dialogNuevo = false;
        },
        editarSistema(item) {
            this.itemSeleccionado = item;
            this.dialogNuevo = true;
        },
        deseoEliminar(item) {
            this.itemSeleccionado = item;
            this.dialogDelete = true;
        },
        canceldialogDelete() {
            this.dialogDelete = false;
        },
        async eliminarRegistro() {
            UtilService.showLoader();
            try {
                await EmpresasService.destroy(this.itemSeleccionado.empr_codigo);
                
                this.listar();
                
            } catch (error) {
                UtilService.showErrors(error);
            } finally {
                UtilService.hideLoader();
                this.dialogDelete = false;
            }
        },
        cancelarAccesos(){
            this.dialogAccesos = false;
        }
    },
  }
</script>