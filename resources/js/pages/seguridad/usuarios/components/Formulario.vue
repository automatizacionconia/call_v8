<template>
    <CardComponent
        :title="title"
        @cancelar="cancelar"
        :hideClose="false"
        >
        <template v-slot:form>
            <v-form ref="form" v-model="valid" lazy-validation>
                <v-row class="mb-0">
                    <v-col cols="6">
                        <v-select
                        v-model="model.empr_codigo"
                        :items="Dataempresas"
                        label="Empresa"
                        item-value="empr_codigo"
                        item-text="empr_nombre"
                        required
                        outlined
                        dense
                        hide-details
                        :rules="[validacion.ruleRequerido]"
                        ></v-select>
                    </v-col>
                    <v-col cols="6">
                    <v-autocomplete
                        v-model="model.usua_pais"
                        :items="datPais"
                        dense
                        outlined
                        label="Pais"
                        item-value="pais_codigo"
                        item-text="pais_nombre"
                        hide-details
                    ></v-autocomplete>
                    </v-col>
                    <v-col cols="6">
                        <v-select
                        v-model="model.pers_tipodoc"
                        :items="tipoDocumentos"
                        label="Tipo de Documento"
                        required
                        :rules="[validacion.ruleRequerido]"
                        outlined
                        dense
                        hide-details
                        ></v-select>
                    </v-col>

                    <v-col cols="6">
                        <v-text-field
                        v-model="model.pers_documento"
                        label="N° Documento"
                        maxlength="8"
                        required
                        :rules="[validacion.ruleRequerido]"
                        outlined
                        dense
                        hide-details
                        ></v-text-field>
                    </v-col>

                    <v-col cols="12">
                        <v-text-field
                        v-model="model.pers_nombre"
                        label="Nombres"
                        required
                        :rules="[validacion.ruleRequerido]"
                        outlined
                        dense
                        hide-details
                        ></v-text-field>
                    </v-col>

                    <v-col cols="6">
                        <v-text-field
                        v-model="model.pers_apaterno"
                        label="Apellido Paterno"
                        required
                        outlined
                        dense
                        hide-details
                        :rules="[validacion.ruleRequerido]"
                        ></v-text-field>
                    </v-col>

                    <v-col cols="6">
                        <v-text-field
                        v-model="model.pers_amaterno"
                        label="Apellido Materno"
                        required
                        outlined
                        dense
                        hide-details
                        ></v-text-field>
                    </v-col>

                    <v-col cols="6">
                        <v-select
                        v-model="model.pers_sexo"
                        :items="sexos"
                        label="Sexo"
                        required
                        outlined
                        dense
                        hide-details
                        ></v-select>
                    </v-col>

                    <v-col cols="6">
                        <v-text-field
                        v-model="model.pers_correo"
                        label="Correo Electrónico"
                        outlined
                        dense
                        hide-details
                        type="email"
                        :rules="[validacion.ruleEmail, validacion.ruleRequerido]"
                        ></v-text-field>
                    </v-col>

                    <v-col cols="6">
                        <v-text-field
                        v-model="model.pers_celular"
                        label="N° Celular"
                        maxlength="9"
                        outlined
                        dense
                        hide-details
                        :rules="[validacion.ruleRequerido]"
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-divider></v-divider>
                <v-row class="mt-2">
                    <v-col cols="6">
                        <v-select
                        v-model="model.perf_codigo"
                        :items="itemRoles"
                        label="Rol de Usuario"
                        item-value="perf_codigo"
                        item-text="perf_nombre"
                        required
                        outlined
                        dense
                        hide-details
                        :rules="[validacion.ruleRequerido]"
                        ></v-select>
                    </v-col>
                    <v-col cols="6">
                        <v-select
                        v-model="model.usua_estado"
                        :items="itemEstado"
                        label="Estado Usuario"
                        outlined
                        dense
                        hide-details
                        ></v-select>
                    </v-col>
                    <v-col cols="6">
                        <v-text-field
                        v-model="model.usua_password"
                        label="Contraseña"
                        outlined
                        dense
                        hide-details
                        type="password"
                        :rules="model.usua_codigo ? [] : [validacion.ruleRequerido]"
                        ></v-text-field>
                    </v-col>
                </v-row>
            </v-form>
        </template>
        <template v-slot:form_accion>
            <v-spacer></v-spacer>
            <v-btn color="error" text @click="cancelar" rounded>Cancelar</v-btn>
            <v-btn color="primary" @click="save" :disabled="!valid" rounded>Guardar información</v-btn>
        </template>
        </CardComponent>
    
</template>

<script>
import { ValidacionService } from '@/services/validacion.service';
import { RolesService } from "@/pages/seguridad/roles/services/roles.service";
import { UtilService } from "@/services/util.service";
import { UsuariosService } from "@/pages/seguridad/usuarios/services/usuarios.service";
import { PersonasService } from "@/pages/seguridad/usuarios/services/personas.service";
import { PaisService } from "@/pages/seguridad/usuarios/services/pais.service";
import { estados } from "@/services/estado.service";
import { EmpresasService } from "@/pages/seguridad/empresas/services/empresas.service";
export default {
    props: {
        item: {
            type: Object,
            default: () => ({})
        }
    },
    data() {
        return {
            valid: false,
            title: "Formulario de Usuario",
            model: {
                empr_codigo: null,
                pers_codigo: '',
                pers_tipodoc: '',
                pers_documento: '',
                pers_nombre: '',
                pers_apaterno: '',
                pers_amaterno: '',
                pers_sexo: '',
                pers_fecnaci: '',
                pers_correo: '',
                pers_celular: '',
                perf_codigo: '',
                usua_pais: null,
                usua_codigo: '',
                usua_username: '',
                usua_password: '',
                usua_estado: '',
            },
            validacion: ValidacionService,
            tipoDocumentos: [
                { text: 'DNI', value: '1' },
                { text: 'Carnet de Extranjería', value: '2' },
                { text: 'Pasaporte', value: '3' },
            ],
            sexos: [
                { text: 'Masculino', value: 'M' },
                { text: 'Femenino', value: 'F' },
            ],
            itemRoles: [],
            itemEstado: estados,
            Dataempresas: [],
            datPais: [],
        };
    },
    created() {
        this.model = { ...this.item };

    },
    mounted() {
        this.listarRoles();
        this.empresas();
        this.pais();
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
        limpiarDatos() {
            this.$refs.frmModal.reset();
        },
        cancelar() {
            this.$emit('cancelar');
        },
        close() {
            this.$emit('close');
        },
        async save() {
            if (this.$refs.form.validate()) {
                UtilService.showLoader();
                try {
                    if (this.model.pers_codigo) {
                        await PersonasService.update(this.model)
                        await UsuariosService.update(this.model)
                    } else {
                        const response = await PersonasService.store(this.model)
                        this.model.pers_codigo = response.data.data.pers_codigo;
                        await UsuariosService.store(this.model)
                    }
                    this.$emit('close');
                } catch (error) {
                    UtilService.showErrors(error);
                } finally {
                    UtilService.hideLoader();
                }
            }
        },
        async empresas() {
            UtilService.showLoader();
            try {
                const response = await EmpresasService.index();
                this.Dataempresas = response.data.data;
            } catch (error) {
                UtilService.showErrors(error);
            } finally {
                UtilService.hideLoader();
            }
        },
        async pais() {
            UtilService.showLoader();
            try {
                const response = await PaisService.index();
                this.datPais = response.data.data;
            } catch (error) {
                UtilService.showErrors(error);
            } finally {
                UtilService.hideLoader();
            }
        },
    },
    watch: {
        'model.pers_correo': function (val) {
            this.model.usua_username = val;
        }
    }
  };
</script>
