<template>
    <div>
        <v-row class="justify-center mt-2">
            <v-col cols="12" md="10">
                <v-card>
                    <v-card-text>     
                        <v-row>                   
                            <v-col cols="12" sm="6">
                                <v-text-field hide-details clearable dense solo label="Ingrese algún dato de busqueda" v-model="dataFilters.dato" autocomplete="off"></v-text-field>
                            </v-col>  
                            <v-col cols="12" md="2">
                                <v-select clearable hide-details 
                                    v-model="dataFilters.perf_codigo" :items="dataRoles"
                                    item-text="perf_nombre" 
                                    item-value="perf_codigo"
                                    label="Rol" solo dense>
                                </v-select>
                            </v-col>
                            <v-col cols="12" md="2">
                                <v-select clearable hide-details v-model="dataFilters.usua_estado" :items="itemEstado"                            
                                    label="Estado" solo dense>
                                </v-select>
                            </v-col>                                     
                            <v-col cols="12" sm="2">
                                <v-btn text color="entidad" dark @click="buscar()" >
                                    <v-icon>mdi-magnify</v-icon>Buscar
                                </v-btn>
                            </v-col>             
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12" md="10">
                <v-data-table
                    dense           
                    :headers="headers"
                    :loading="loading"
                    :items="dataUsuarios"
                    :server-items-length="total"
                    :options.sync="options"
                    :footer-props="footerProps"
                    :items-per-page="itemsPerPage"
                >            
                    <template v-slot:item.acciones="{ item }">
                        <v-btn-toggle tile borderless
                                                >
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn                    
                                    text
                                    small
                                    v-bind="attrs"
                                    v-on="on"  
                                    v-if="item.usua_estado = 1"
                                    @click="openDialogEditar(item)"                                                  
                                >
                                    <v-icon color="entidad">
                                        mdi-pencil
                                    </v-icon> 
                                </v-btn>
                                </template>
                            <span>EDITAR</span>
                            </v-tooltip>

                            <v-tooltip bottom v-if="item.usua_estado == 1">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn               
                                        text
                                        small
                                        v-bind="attrs"
                                        v-on="on"
                                        @click="showDesactivar(item)"                                               
                                    >
                                        <v-icon  color="red">mdi-account-cancel</v-icon>
                                    </v-btn>
                                </template>
                            <span>DESACTIVAR</span>
                            </v-tooltip>

                            <v-tooltip bottom v-else>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn    
                                        text
                                        small  
                                        v-bind="attrs"
                                        v-on="on"   
                                        @click="activarUsuario(item)"                                                  
                                    >
                                        <v-icon color="green">mdi-account-check</v-icon>
                                    </v-btn>
                                </template>
                            <span>ACTIVAR</span>
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
                            <span>ACCESOS</span>
                            </v-tooltip>
                        </v-btn-toggle>

                    </template>

                    <template v-slot:item.estado="{ item }">
                        <v-icon
                            :color="item.estado == 1 ? 'green' : 'red'"
                        >mdi-circle
                        </v-icon>
                    </template>     
                    
                    <template v-slot:top>
                        <v-toolbar flat>
                            <v-toolbar-title>Usuarios del sistema</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-btn color="primary" @click="nuevoFormulario()"><v-icon left>mdi-plus</v-icon>Nuevo Usuario</v-btn>
                        </v-toolbar>
                    </template>     
                </v-data-table> 
            </v-col>
        </v-row>

        <v-dialog v-model="dialogNuevo" width="500px" persistent>
            <Formulario :item="itemSeleccionado" v-if="dialogNuevo" @close="close()" @cancelar="cancelar()" />
        </v-dialog>

        <v-dialog v-model="dialogDelete" max-width="300px" persistent>
            <DialogEliminarRegistro
                @eliminarRegistro="eliminarRegistro"
                @cancelarEliminar="canceldialogDelete()"
            >
            </DialogEliminarRegistro>
        </v-dialog>

        <v-dialog v-model="dialogAccesos" max-width="500px" persistent>
                <Accesos :usua_codigo="itemSeleccionado.usua_codigo" v-if="dialogAccesos" @cancelarAccesos="cancelarAccesos()" @close="cancelarAccesos" />
        </v-dialog>

    </div>
</template>

<script>     
    import { PaginadoService } from '@/services/paginado.service';
    import { RolesService } from '@/pages/seguridad/roles/services/roles.service';
    import { UsuariosService } from '../services/usuarios.service';
    import { HeaderInterface } from "../interfaces/header.interfaces";

    import { UtilService } from "@/services/util.service";
    import { estados } from "@/services/estado.service";

    import Formulario  from "./Formulario.vue";
    import Accesos from './Accesos.vue';

    export default {
        components: {
            Formulario,
            Accesos
        },
        data () {
            return {  
                loading: false,              
                headers: HeaderInterface,
                footerProps: PaginadoService.FooterProps,
                itemsPerPage: PaginadoService.ItemsPerPage,   
                options: {},
                dataUsuarios: [],          
                total: 0,                    
                dataFilters:{
                    dato: null,                                
                    usua_estado: null,
                },
                dialogNuevo: false,        
                dialogDelete: false,
                model: {},
                dataSelect: [],
                selectEmpresa: null,
                dataRoles: [],
                dialogAccesos: false,
                dataEmpresas: [],
                dataSistemas: [],
                dataMenuSistema: [],
                itemEstado: estados,    
                itemSeleccionado: {},                                                
            }
        },
        async created(){
            this.dataFilters.per_page = this.itemsPerPage;   
            const responseRoles = await RolesService.index();
            this.dataRoles = responseRoles.data.data           
        },        
        methods:{
            buscar(){
                this.dataFilters.page = 1;            
                if(this.options.page == 1){
                    this.getDataApi();
                }
                this.options.page = 1;                
            },
            updateOptions(){                                                                                                
                this.dataFilters.page = this.options.page;       
                this.dataFilters.per_page = this.options.itemsPerPage;
                this.getDataApi();                                                                
            },
            async getDataApi(){                            
                try{
                    this.loading  = true
                    let api = await UsuariosService.index(this.dataFilters);
                    this.total = api.data.meta.total;                           
                    this.dataUsuarios = api.data.data;
                    
                    this.loading  = false
                }catch(error){
                    this.loading  = false
                    UtilService.showErrors(error);
                } 
            },           
            showDesactivar(model){
                this.model = model
                this.dialogDelete= true
            },
            nuevoFormulario(){
                this.itemSeleccionado = {};
                this.dialogNuevo = true
            },
            close(){
                this.dialogNuevo = false
                this.getDataApi()
            },
            cancelar(){
                this.dialogNuevo = false
            },
            openDialogEditar(item){
                this.itemSeleccionado = item
                this.itemSeleccionado.usua_estado = item.estado;
                this.dialogNuevo = true
            },
            async activarUsuario(item){
                UtilService.showLoader();
                try{
                    await UsuariosService.activar(item.usua_codigo);
                    await this.getDataApi()
                }catch(error){
                    UtilService.showErrors(error);
                }finally{
                    UtilService.hideLoader();
                }
            },
            async eliminarRegistro(){
                UtilService.showLoader();
                try{
                    await UsuariosService.destroy(this.model.usua_codigo);
                    await this.getDataApi()
                    this.dialogDelete = false
                }catch(error){
                    UtilService.showErrors(error);
                }finally{
                    UtilService.hideLoader();
                }
            },
            async canceldialogDelete() {
                this.dialogDelete = false;
            },
            cancelarAccesos(){
                this.dialogAccesos = false;
            }
        },
        watch: {
            options: {
                handler() {                    
                    this.updateOptions()                                      
                },
                deep: false,
            },
        },
    }
</script>

<style  scoped>

</style>