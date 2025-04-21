<template>
    <v-card flat color="basil">
        <v-card-text class="py-1">
            <v-tabs v-model="tab" color="black" grow>
                <v-tab key="1"> Usuario </v-tab>
                <v-tab key="2"> Dependencias adicionales</v-tab>
            </v-tabs>

            <v-tabs-items v-model="tab">
                <v-tab-item key="1">
                    <v-card color="basil" flat>
                        <v-card-text>
                            <v-row>
                                <v-col
                                    cols="12"
                                    sm="10"
                                    class="pt-1"
                                    offset-sm="1"
                                >
                                    <v-card>
                                        <v-card-text class="pt-0">
                                            <v-row no-gutters class="py-2">
                                                <p
                                                    class="title font-weight-bold mb-0"
                                                >
                                                    Actualizar empleado
                                                </p>
                                            </v-row>

                                            <v-row no-gutters class="py-2">
                                                <v-col cols="12">
                                                    <v-alert
                                                        text
                                                        type="info"
                                                        elevation="2"
                                                    >
                                                        Datos obligratorios (*)
                                                    </v-alert>
                                                </v-col>
                                            </v-row>
                                            <v-form
                                                v-model="validForm"
                                                ref="form"
                                                lazy-validation
                                            >
                                                <v-row>
                                                    <v-col cols="12" md="6">
                                                        <v-row>
                                                            <v-col
                                                                cols="12"
                                                                md="6"
                                                            >
                                                                <v-text-field
                                                                    hide-details
                                                                    v-model="
                                                                        model.dni
                                                                    "
                                                                    label="DNI *"
                                                                    outlined
                                                                    dense
                                                                    :rules="
                                                                        validacion.rules
                                                                    "
                                                                    readonly
                                                                >
                                                                </v-text-field>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row>
                                                            <v-col
                                                                cols="12"
                                                                md="6"
                                                            >
                                                                <v-text-field
                                                                    hide-details
                                                                    v-model="
                                                                        model.paterno
                                                                    "
                                                                    label="Paterno *"
                                                                    outlined
                                                                    dense
                                                                    readonly
                                                                    :rules="
                                                                        validacion.rules
                                                                    "
                                                                >
                                                                </v-text-field>
                                                            </v-col>
                                                            <v-col
                                                                cols="12"
                                                                md="6"
                                                            >
                                                                <v-text-field
                                                                    hide-details
                                                                    v-model="
                                                                        model.materno
                                                                    "
                                                                    label="Materno *"
                                                                    outlined
                                                                    dense
                                                                    readonly
                                                                    :rules="
                                                                        validacion.rules
                                                                    "
                                                                ></v-text-field>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row>
                                                            <v-col cols="12">
                                                                <v-text-field
                                                                    hide-details
                                                                    v-model="
                                                                        model.nombres
                                                                    "
                                                                    label="Nombres *"
                                                                    outlined
                                                                    dense
                                                                    readonly
                                                                    :rules="
                                                                        validacion.rules
                                                                    "
                                                                ></v-text-field>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row>
                                                            <v-col
                                                                cols="12"
                                                                class="py-0"
                                                            >
                                                                <v-radio-group
                                                                    hide-details
                                                                    v-model="
                                                                        model.ind_sexo
                                                                    "
                                                                    row
                                                                >
                                                                    <v-radio
                                                                        label="Masculino"
                                                                        value="1"
                                                                    ></v-radio>
                                                                    <v-radio
                                                                        label="Femenino"
                                                                        value="2"
                                                                    ></v-radio>
                                                                </v-radio-group>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row>
                                                            <v-col cols="12">
                                                                <v-text-field
                                                                    hide-details
                                                                    v-model="
                                                                        model.email
                                                                    "
                                                                    label="Email"
                                                                    outlined
                                                                    dense
                                                                ></v-text-field>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row>
                                                            <v-col cols="12">
                                                                <v-autocomplete
                                                                    hide-details
                                                                    v-model="
                                                                        model.cargo_id
                                                                    "
                                                                    :items="
                                                                        dataCargos
                                                                    "
                                                                    label="Cargo"
                                                                    outlined
                                                                    dense
                                                                    item-value="id"
                                                                    item-text="descripcion"
                                                                ></v-autocomplete>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row>
                                                            <v-col cols="12">
                                                                <v-autocomplete
                                                                    hide-details
                                                                    v-model="
                                                                        model.dependencia_id
                                                                    "
                                                                    :items="
                                                                        dataDependencias
                                                                    "
                                                                    label="Dependencia *"
                                                                    outlined
                                                                    dense
                                                                    item-value="id"
                                                                    item-text="descripcion"
                                                                    :rules="
                                                                        validacion.rules
                                                                    "
                                                                ></v-autocomplete>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row>
                                                            <v-col
                                                                cols="12"
                                                                md="4"
                                                            >
                                                                <v-select
                                                                    hide-details
                                                                    v-model="
                                                                        model.estado_empleado_id
                                                                    "
                                                                    :items="
                                                                        dataEmpleadoEstados
                                                                    "
                                                                    label="Estado *"
                                                                    outlined
                                                                    dense
                                                                    item-value="id"
                                                                    item-text="descripcion"
                                                                ></v-select>
                                                            </v-col>
                                                        </v-row>
                                                    </v-col>
                                                    <v-col col="12" md="6">
                                                        <v-row>
                                                            <v-col
                                                                cols="12"
                                                                md="4"
                                                            >
                                                                <v-text-field
                                                                    hide-details
                                                                    v-model="
                                                                        model.usuario
                                                                    "
                                                                    label="Usuario *"
                                                                    outlined
                                                                    dense
                                                                    :rules="
                                                                        validacion.rules
                                                                    "
                                                                    readonly
                                                                ></v-text-field>
                                                            </v-col>
                                                            <v-col
                                                                cols="12"
                                                                md="4"
                                                            >
                                                                <v-select
                                                                    hide-details
                                                                    v-model="
                                                                        model.estado_usuario_id
                                                                    "
                                                                    :items="
                                                                        dataUsuarioEstados
                                                                    "
                                                                    label="Estado *"
                                                                    outlined
                                                                    dense
                                                                    item-value="id"
                                                                    item-text="descripcion"
                                                                    @change="
                                                                        cambiarEstadoUsuario()
                                                                    "
                                                                ></v-select>
                                                            </v-col>
                                                            <v-col
                                                                cols="12"
                                                                md="4"
                                                            >
                                                                <v-btn
                                                                    @click="
                                                                        restablecerAcceso()
                                                                    "
                                                                    color="info"
                                                                    dark
                                                                    outlined
                                                                >
                                                                    <v-icon
                                                                        >mdi-lock-open-variant-outline</v-icon
                                                                    >Restablecer</v-btn
                                                                ></v-col
                                                            >
                                                        </v-row>
                                                        <v-row>
                                                            <v-col cols="12">
                                                                <v-switch
                                                                    hide-details
                                                                    dense
                                                                    v-model="
                                                                        model.ind_admin
                                                                    "
                                                                    label="¿El usuario es admin?"
                                                                    @change="
                                                                        update()
                                                                    "
                                                                ></v-switch>
                                                            </v-col>
                                                            <v-col cols="12">
                                                                <v-switch
                                                                    hide-details
                                                                    dense
                                                                    v-model="
                                                                        model.ind_mp
                                                                    "
                                                                    label="¿El usuario es Mesa de Partes?"
                                                                    @change="
                                                                        update()
                                                                    "
                                                                ></v-switch>
                                                            </v-col>
                                                            <v-col cols="12">
                                                                <v-switch
                                                                    hide-details
                                                                    dense
                                                                    v-model="
                                                                        model.ind_mp_total
                                                                    "
                                                                    label="¿Acceso total a Mesa de partes?"
                                                                    @change="
                                                                        update()
                                                                    "
                                                                ></v-switch>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row>
                                                            <v-col cols="12">
                                                                <v-list dense>
                                                                    <v-subheader
                                                                        >Opciones
                                                                        <v-select
                                                                            class="pl-3"
                                                                            hide-details
                                                                            v-model="
                                                                                model.perfil_id
                                                                            "
                                                                            :items="
                                                                                dataPerfiles
                                                                            "
                                                                            label="Perfil"
                                                                            outlined
                                                                            dense
                                                                            item-value="id"
                                                                            item-text="descripcion"
                                                                            @change="
                                                                                accesosByPerfil()
                                                                            "
                                                                        ></v-select
                                                                    ></v-subheader>

                                                                    <v-list-item-group
                                                                        color="primary"
                                                                    >
                                                                        <v-virtual-scroll
                                                                            :bench="
                                                                                benched
                                                                            "
                                                                            :items="
                                                                                dataOpciones
                                                                            "
                                                                            height="300"
                                                                            item-height="30"
                                                                        >
                                                                            <template
                                                                                v-slot:default="{
                                                                                    item,
                                                                                }"
                                                                            >
                                                                                <v-list-item
                                                                                    :key="
                                                                                        item.id
                                                                                    "
                                                                                    dense
                                                                                >
                                                                                    <v-list-item-action>
                                                                                        <v-checkbox
                                                                                            :value="
                                                                                                item.id
                                                                                            "
                                                                                            :key="
                                                                                                item.id
                                                                                            "
                                                                                            v-model="
                                                                                                dataOpcionesSeleccionados
                                                                                            "
                                                                                        ></v-checkbox>
                                                                                    </v-list-item-action>

                                                                                    <v-list-item-content
                                                                                        class="py-0"
                                                                                    >
                                                                                        <v-list-item-title>
                                                                                            {{
                                                                                                item.id
                                                                                            }}-
                                                                                            {{
                                                                                                item.descripcion
                                                                                            }}
                                                                                        </v-list-item-title>
                                                                                    </v-list-item-content>
                                                                                </v-list-item>
                                                                            </template>
                                                                        </v-virtual-scroll>
                                                                    </v-list-item-group>
                                                                </v-list>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row>
                                                            <v-col
                                                                cols="12"
                                                                md="6"
                                                            >
                                                                <v-btn
                                                                    @click="
                                                                        storeUpdateOpciones()
                                                                    "
                                                                    color="entidad"
                                                                    dark
                                                                    >GUARDAR
                                                                    MENU
                                                                </v-btn>
                                                            </v-col>
                                                        </v-row>
                                                    </v-col>
                                                </v-row>
                                            </v-form>
                                            <v-row>
                                                <v-col cols="12" md="6">
                                                    <v-btn
                                                        @click="update()"
                                                        color="success"
                                                        dark
                                                        >GRABAR</v-btn
                                                    >
                                                    <v-btn
                                                        @click="
                                                            $router.push({
                                                                name: 'app.sgd.empleado.list',
                                                            })
                                                        "
                                                        color="cancelar"
                                                        dark
                                                        >CANCELAR
                                                    </v-btn>
                                                </v-col>
                                            </v-row>
                                        </v-card-text>
                                    </v-card>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-tab-item>
                <v-tab-item key="2">
                    <v-card color="basil" flat>
                        <v-card-text>
                            <v-row>
                                <v-col
                                    cols="12"
                                    sm="10"
                                    class="pt-1"
                                    offset-sm="1"
                                >
                                    <v-card>
                                        <v-card-text class="pt-0">
                                            <v-row no-gutters class="py-2">
                                                <p
                                                    class="title font-weight-bold mb-0"
                                                >
                                                    Asignar dependencia(s) para
                                                    derivar
                                                </p>
                                            </v-row>
                                            <v-row no-gutters class="py-2">
                                                <v-col cols="12">
                                                    <v-alert
                                                        text
                                                        type="info"
                                                        elevation="2"
                                                    >
                                                        Primero habilite las
                                                        dependencia(s) en
                                                        "Acceso a la Información
                                                        en el SGD"
                                                    </v-alert>
                                                </v-col>
                                            </v-row>
                                            <v-form
                                                v-model="validForm"
                                                ref="formPermiso"
                                                lazy-validation
                                            >
                                                <v-row>
                                                    <v-col cols="12">
                                                        <v-row>
                                                            <v-col
                                                                cols="12"
                                                                md="4"
                                                            >
                                                                <v-text-field
                                                                    hide-details
                                                                    v-model="
                                                                        model.usuario
                                                                    "
                                                                    label="Usuario *"
                                                                    outlined
                                                                    dense
                                                                    :rules="
                                                                        validacion.rules
                                                                    "
                                                                    readonly
                                                                ></v-text-field>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row>
                                                            <v-col cols="12">
                                                                <v-list dense>
                                                                    <v-list-item-group
                                                                        color="primary"
                                                                    >
                                                                        <v-virtual-scroll
                                                                            :bench="
                                                                                benched
                                                                            "
                                                                            :items="
                                                                                dataPermisos
                                                                            "
                                                                            height="300"
                                                                            item-height="30"
                                                                        >
                                                                            <template
                                                                                v-slot:default="{
                                                                                    item,
                                                                                }"
                                                                            >
                                                                                <v-list-item
                                                                                    :key="
                                                                                        item.id
                                                                                    "
                                                                                    dense
                                                                                >
                                                                                    <v-list-item-action>
                                                                                        <v-checkbox
                                                                                            :value="
                                                                                                item.id
                                                                                            "
                                                                                            :key="
                                                                                                item.id
                                                                                            "
                                                                                            v-model="
                                                                                                dataDependenciasSeleccionados
                                                                                            "
                                                                                        ></v-checkbox>
                                                                                    </v-list-item-action>

                                                                                    <v-list-item-content
                                                                                        class="py-0"
                                                                                    >
                                                                                        <v-list-item-title>
                                                                                            {{
                                                                                                item.id
                                                                                            }}-
                                                                                            {{
                                                                                                item.descripcion
                                                                                            }}
                                                                                        </v-list-item-title>
                                                                                    </v-list-item-content>
                                                                                </v-list-item>
                                                                            </template>
                                                                        </v-virtual-scroll>
                                                                    </v-list-item-group>
                                                                </v-list>
                                                            </v-col>
                                                        </v-row>
                                                    </v-col>
                                                </v-row>
                                            </v-form>
                                            <v-row>
                                                <v-col cols="12" md="6">
                                                    <v-btn
                                                        @click="
                                                            storeUpdateDependenciaEmpleado()
                                                        "
                                                        color="success"
                                                        dark
                                                        >GRABAR</v-btn
                                                    >
                                                    <v-btn
                                                        @click="
                                                            $router.push({
                                                                name: 'app.sgd.empleado.list',
                                                            })
                                                        "
                                                        color="cancelar"
                                                        dark
                                                        >CANCELAR
                                                    </v-btn>
                                                </v-col>
                                            </v-row>
                                        </v-card-text>
                                    </v-card>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-tab-item>
            </v-tabs-items>
        </v-card-text>
    </v-card>
</template>

<script>
import { ValidacionService } from "@/pages/virtual/services/common/validacion.service";
import { ErrorService } from "@/pages/virtual/services/common/error.service";
import { SgdEmpleadoEstadoService } from "@/pages/virtual/services/app/sgd-empleado-estado.service";
import { SgdEmpleadoService } from "@/pages/virtual/services/app/sgd-empleado.service";
import { SgdDependenciaService } from "@/pages/virtual/services/app/sgd-dependencia.service";
import { SgdCargoService } from "@/pages/virtual/services/app//sgd-cargo.service";
import { SgdOpcionService } from "@/pages/virtual/services/app//sgd-opcion.service";
import { SgdUsuarioOpcionService } from "@/pages/virtual/services/app/sgd-usuario-opcion.service";
import { SgdUsuarioEstadoService } from "@/pages/virtual/services/app/sgd-usuario-estado.service";
import { SgdUsuarioService } from "@/pages/virtual/services/app/sgd-usuario.service";
import { SgdPerfilService } from "@/pages/virtual/services/app/sgd-perfil.service";
import { SgdUsuarioPermisoService } from "@/pages/virtual/services/app/sgd-usuario-permiso.service";
import { SgdEmpleadoDependenciaService } from "@/pages/virtual/services/app/sgd-empleado-dependencia.service";

export default {
    data() {
        return {
            validForm: false,
            model: {
                dni: null,
                estado_id: null,
                paterno: null,
                materno: null,
                nombres: null,
                email: null,
                cargo_id: null,
                dependencia_id: null,
                usuario: null,
            },
            validacion: ValidacionService,
            dataEmpleadoEstados: SgdEmpleadoEstadoService.index(),
            dataCargos: [],
            dataDependencias: [],
            dataOpciones: [],
            benched: 0,
            dataOpcionesSeleccionados: [],
            dataUsuarioEstados: SgdUsuarioEstadoService.index(),
            dataPerfiles: [],
            //
            tab: null,
            dependencia_id: null,
            dataPermisos: [],
            dataDependenciasSeleccionados: [],
        };
    },
    async created() {
        try {
            const dataDependencias = await SgdDependenciaService.index();
            this.dataDependencias = dataDependencias.data.data;

            const dataCargos = await SgdCargoService.index();
            this.dataCargos = dataCargos.data.data;

            const response = await SgdEmpleadoService.edit(
                this.$route.params.id
            );
            this.model = response.data.data;

            const dataOpciones = await SgdOpcionService.index();
            this.dataOpciones = dataOpciones.data.data;

            const dataPerfiles = await SgdPerfilService.index();
            this.dataPerfiles = dataPerfiles.data.data;

            const dataOpcionesSeleccionados =
                await SgdUsuarioOpcionService.index(this.model.usuario);
            this.dataOpcionesSeleccionados =
                dataOpcionesSeleccionados.data.data;

            const dataPermisos = await SgdUsuarioPermisoService.index(
                this.model.usuario
            );
            this.dataPermisos = dataPermisos.data.data;

            const dataDependenciasSeleccionados =
                await SgdEmpleadoDependenciaService.index(this.model.id);
            this.dataDependenciasSeleccionados =
                dataDependenciasSeleccionados.data.data;
        } catch (error) {
            this.$store.commit(
                "alert/setErrors",
                ErrorService.getToArray(error)
            );
        }
    },
    methods: {
        async update() {
            if (this.$refs.form.validate()) {
                try {
                    this.$store.commit("loader/setLoader", true);
                    await SgdEmpleadoService.update(this.model);
                    this.$store.commit("loader/setLoader", false);
                    this.$store.commit("snackbar/setSnackbar", true);
                } catch (error) {
                    this.$store.commit("loader/setLoader", false);
                    this.$store.commit(
                        "alert/setErrors",
                        ErrorService.getToArray(error)
                    );
                }
            }
        },
        async storeUpdateOpciones() {
            try {
                this.$store.commit("loader/setLoader", true);
                await SgdUsuarioOpcionService.store(
                    this.model.usuario,
                    this.dataOpcionesSeleccionados
                );
                this.$store.commit("loader/setLoader", false);
                this.$store.commit("snackbar/setSnackbar", true);
            } catch (error) {
                this.$store.commit("loader/setLoader", false);
                this.$store.commit(
                    "alert/setErrors",
                    ErrorService.getToArray(error)
                );
            }
        },
        async cambiarEstadoUsuario() {
            try {
                this.$store.commit("loader/setLoader", true);
                await SgdUsuarioService.cambiarEstadoUsuario(
                    this.model.usuario,
                    this.model
                );
                this.$store.commit("loader/setLoader", false);
                this.$store.commit("snackbar/setSnackbar", true);
            } catch (error) {
                this.$store.commit("loader/setLoader", false);
                this.$store.commit(
                    "alert/setErrors",
                    ErrorService.getToArray(error)
                );
            }
        },
        async restablecerAcceso() {
            try {
                this.$store.commit("loader/setLoader", true);
                await SgdUsuarioService.restablecerAcceso(this.model.usuario);
                this.$store.commit("loader/setLoader", false);
                this.$store.commit("snackbar/setSnackbar", true);
            } catch (error) {
                this.$store.commit("loader/setLoader", false);
                this.$store.commit(
                    "alert/setErrors",
                    ErrorService.getToArray(error)
                );
            }
        },

        async accesosByPerfil() {
            try {
                this.$store.commit("loader/setLoader", true);
                const response = await SgdPerfilService.accesosByPerfil(
                    this.model.perfil_id
                );
                this.dataOpcionesSeleccionados = response.data.data;
                this.$store.commit("loader/setLoader", false);
            } catch (error) {
                this.$store.commit("loader/setLoader", false);
                this.$store.commit(
                    "alert/setErrors",
                    ErrorService.getToArray(error)
                );
            }
        },
        async storeUpdateDependenciaEmpleado() {
            try {
                this.$store.commit("loader/setLoader", true);
                await SgdEmpleadoDependenciaService.store(
                    this.model.id,
                    this.dataDependenciasSeleccionados
                );
                this.$store.commit("loader/setLoader", false);
                this.$store.commit("snackbar/setSnackbar", true);
            } catch (error) {
                this.$store.commit("loader/setLoader", false);
                this.$store.commit(
                    "alert/setErrors",
                    ErrorService.getToArray(error)
                );
            }
        },
    },
};
</script>

<style lang="scss" scoped></style>
