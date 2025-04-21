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
                    <template v-slot:item.perf_estado="{ item }">
                        <v-icon
                            :color="item.perf_estado == 1 ? 'green' : 'red'"
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

                        <v-tooltip bottom>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn                  
                                        text
                                        small   
                                        v-bind="attrs"
                                        v-on="on"
                                        @click="dialogAccesos = true; itemSeleccionado = item"                                                
                                    >
                                    <v-icon color="primary">mdi-format-list-checks</v-icon> 
                                    </v-btn>
                                </template>
                            <span>Ver accesos</span>
                            </v-tooltip>
                    </template>
                    <template v-slot:top>
                        <v-toolbar flat>
                            <v-toolbar-title>Roles de usuarios</v-toolbar-title>
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

        <v-dialog v-model="dialogAccesos" max-width="500px" persistent>
                <AccesosRoles :perf_codigo="itemSeleccionado.perf_codigo" v-if="dialogAccesos" @cancelarAccesos="cancelarAccesos()" @close="cancelarAccesos" />
        </v-dialog>
    </div>
  </template>
  <script>

import { HeaderInterface } from "../interfaces/header.interfaces";
import { RolesService } from "@/pages/seguridad/roles/services/roles.service";
import { UtilService } from "@/services/util.service";
import Formulario  from "./Formulario.vue";
import AccesosRoles from "./AccesosRoles.vue";

export default {
    components: {
        Formulario,
        AccesosRoles
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
        await this.listarRoles();
    },
    methods: {
        async listarRoles() {
            UtilService.showLoader();
            try {
                const response = await RolesService.index();
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
            this.listarRoles();
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
                await RolesService.delete(this.itemSeleccionado);
                this.listarRoles();
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