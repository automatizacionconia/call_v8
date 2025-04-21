<template>
    <v-card flat color="basil">
        <v-card-text class="py-1">
            <v-row>
                <v-col cols="12" md="6" offset-md="3" class="pt-1">
                    <v-card>
                        <v-card-text class="pt-0">
                            <v-row no-gutters class="py-2">
                                <p class="title font-weight-bold mb-0">
                                    Registrar empleado
                                </p>
                            </v-row>
                            <v-form
                                v-model="validForm"
                                ref="form"
                                lazy-validation
                            >
                                <v-row>
                                    <v-col col="12" md="6">
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
                                        <v-row>
                                            <v-col cols="12" md="6">
                                                <v-text-field
                                                    v-model="model.dni"
                                                    label="DNI *"
                                                    outlined
                                                    dense
                                                    :rules="validacion.rules"
                                                    @keyup.enter="validar()"
                                                    maxlength="8"
                                                    counter
                                                >
                                                </v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col cols="12" md="6">
                                                <v-text-field
                                                    hide-details
                                                    v-model="model.paterno"
                                                    label="Paterno *"
                                                    outlined
                                                    dense
                                                    readonly
                                                    :rules="validacion.rules"
                                                >
                                                </v-text-field>
                                            </v-col>
                                            <v-col cols="12" md="6">
                                                <v-text-field
                                                    hide-details
                                                    v-model="model.materno"
                                                    label="Materno *"
                                                    outlined
                                                    dense
                                                    readonly
                                                    :rules="validacion.rules"
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col cols="12">
                                                <v-text-field
                                                    hide-details
                                                    v-model="model.nombres"
                                                    label="Nombres *"
                                                    outlined
                                                    dense
                                                    readonly
                                                    :rules="validacion.rules"
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col cols="12" class="py-0">
                                                <v-radio-group
                                                    hide-details
                                                    v-model="model.ind_sexo"
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
                                                    v-model="model.email"
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
                                                    v-model="model.cargo_id"
                                                    :items="dataCargos"
                                                    label="Cargo *"
                                                    outlined
                                                    dense
                                                    item-value="id"
                                                    item-text="descripcion"
                                                    :rules="validacion.rules"
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
                                                    :items="dataDependencias"
                                                    label="Dependencia *"
                                                    outlined
                                                    dense
                                                    item-value="id"
                                                    item-text="descripcion"
                                                    :rules="validacion.rules"
                                                ></v-autocomplete>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col cols="12" md="4">
                                                <v-select
                                                    hide-details
                                                    v-model="model.estado_id"
                                                    :items="dataEstados"
                                                    label="Estado *"
                                                    outlined
                                                    dense
                                                    item-value="id"
                                                    item-text="descripcion"
                                                ></v-select>
                                            </v-col>
                                        </v-row>
                                    </v-col>

                                    <v-divider vertical></v-divider>

                                    <v-col cols="12" md="6">
                                        <v-row>
                                            <v-col cols="12" md="6">
                                                <v-text-field
                                                    hide-details
                                                    v-model="model.usuario"
                                                    label="Usuario *"
                                                    outlined
                                                    dense
                                                    :rules="validacion.rules"
                                                ></v-text-field>
                                            </v-col>
                                            <!-- <v-col cols="12" md="6">
                                                <v-btn
                                                    @click="
                                                        buscarUsuarioDisponible()
                                                    "
                                                    color="success"
                                                    dark
                                                    outlined
                                                    >Buscar usuario</v-btn
                                                >
                                            </v-col> -->
                                        </v-row>
                                        <v-row>
                                            <v-col cols="12">
                                                <v-select
                                                    hide-details
                                                    v-model="
                                                        model.tipo_autenticacion
                                                    "
                                                    :items="
                                                        dataTipoAutenticacion
                                                    "
                                                    label="Autenticacion *"
                                                    outlined
                                                    dense
                                                    item-value="id"
                                                    item-text="descripcion"
                                                ></v-select>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col cols="12">
                                                <v-switch
                                                    hide-details
                                                    dense
                                                    v-model="model.ind_admin"
                                                    label="¿El usuario es admin?"
                                                ></v-switch>
                                            </v-col>
                                            <v-col cols="12">
                                                <v-switch
                                                    hide-details
                                                    dense
                                                    v-model="model.ind_mp"
                                                    label="¿El usuario es Mesa de Partes?"
                                                ></v-switch>
                                            </v-col>
                                            <v-col cols="12">
                                                <v-switch
                                                    hide-details
                                                    dense
                                                    v-model="model.ind_mp_total"
                                                    label="¿Acceso total a Mesa de partes?"
                                                ></v-switch>
                                            </v-col>
                                        </v-row>
                                    </v-col>
                                </v-row>
                            </v-form>
                            <v-row>
                                <v-col cols="12">
                                    <v-btn @click="store()" color="success" dark
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
</template>

<script>
import { ValidacionService } from "@/pages/virtual/services/common/validacion.service";
import { ErrorService } from "@/pages/virtual/services/common/error.service";
import { SgdEmpleadoEstadoService } from "@/pages/virtual/services/app//sgd-empleado-estado.service";
import { SgdEmpleadoService } from "@/pages/virtual/services/app//sgd-empleado.service";
import { SgdDependenciaService } from "@/pages/virtual/services/app//sgd-dependencia.service";
import { SgdCargoService } from "@/pages/virtual/services/app/sgd-cargo.service";

export default {
    data() {
        return {
            validForm: false,
            validForm1: false,
            model: {
                dni: null,
                estado_id: 1,
                paterno: null,
                materno: null,
                nombres: null,
                email: null,
                cargo_id: null,
                dependencia_id: null,
                usuario: null,
                ind_admin: null,
                ind_mp: null,
                ind_mp_total: null,
                ind_sexo: null,
                tipo_autenticacion: 0,
            },
            validacion: ValidacionService,
            dataEstados: SgdEmpleadoEstadoService.index(),
            dataCargos: [],
            dataDependencias: [],
            dataTipoAutenticacion: [
                { id: 0, descripcion: "Contraseña del SGD" },
                { id: 1, descripcion: "Active Directory" },
            ],
        };
    },
    async created() {
        try {
            const dataDependencias = await SgdDependenciaService.index();
            this.dataDependencias = dataDependencias.data.data;

            const dataCargos = await SgdCargoService.index();
            this.dataCargos = dataCargos.data.data;
        } catch (error) {
            this.$store.commit(
                "alert/setErrors",
                ErrorService.getToArray(error)
            );
        }
    },
    methods: {
        async validar() {
            if (this.model.dni) {
                this.clear();
                try {
                    this.$store.commit("loader/setLoader", true);
                    const data = {
                        dni: this.model.dni,
                    };
                    const datosCiudadano = await SgdEmpleadoService.validar(
                        data
                    );
                    this.model.paterno = datosCiudadano.data.data.paterno;
                    this.model.materno = datosCiudadano.data.data.materno;
                    this.model.nombres = datosCiudadano.data.data.nombres;
                    this.model.usuario = datosCiudadano.data.data.usuario;

                    this.$store.commit("loader/setLoader", false);
                } catch (error) {
                    this.$store.commit("loader/setLoader", false);
                    this.$store.commit(
                        "alert/setErrors",
                        ErrorService.getToArray(error)
                    );
                }
            }
        },
        async store() {
            if (this.$refs.form.validate()) {
                try {
                    this.$store.commit("loader/setLoader", true);
                    const response = await SgdEmpleadoService.store(this.model);
                    this.$store.commit("loader/setLoader", false);
                    this.$store.commit("snackbar/setSnackbar", true);
                    this.$router.push({
                        name: "app.sgd.empleado.edit",
                        params: {
                            id: response.data.data.CEMP_CODEMP,
                        },
                    });
                } catch (error) {
                    this.$store.commit("loader/setLoader", false);
                    this.$store.commit(
                        "alert/setErrors",
                        ErrorService.getToArray(error)
                    );
                }
            }
        },
        buscarUsuarioDisponible() {},
        clear() {
            this.model.estado_id = 1;
            this.model.paterno = null;
            this.model.materno = null;
            this.model.nombres = null;
            this.model.email = null;
            this.model.cargo_id = null;
            this.model.dependencia_id = null;
            this.model.ind_sexo = null;
            this.model.usuario = null;
            this.model.tipo_autenticacion = 0;
            this.model.ind_admin = null;
            this.model.ind_mp = null;
            this.model.ind_mp_total = null;
        },
    },
};
</script>

<style lang="scss" scoped></style>
