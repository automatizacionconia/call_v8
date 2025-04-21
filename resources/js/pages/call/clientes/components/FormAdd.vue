<template>
    <CardComponent
        :title="title"
        @cancelar="cancelar"
        :hideClose="false"
        >
        <template v-slot:form>
            <v-form ref="form" v-model="valid" lazy-validation class="pa-3">
                <v-row class="mb-0">

                    <v-col cols="6">
                        <v-text-field
                        v-model="model.clie_documento"
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
                        v-model="model.clie_nombres"
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
                        v-model="model.clie_paterno"
                        label="Apellido Paterno"
                        required
                        outlined
                        dense
                        hide-details
                        ></v-text-field>
                    </v-col>

                    <v-col cols="6">
                        <v-text-field
                        v-model="model.clie_materno"
                        label="Apellido Materno"
                        required
                        outlined
                        dense
                        hide-details
                        ></v-text-field>
                    </v-col>

                    <v-col cols="6">
                        <v-text-field
                        v-model="model.clie_celular"
                        maxlength="12"
                        label="Celular"
                        outlined
                        dense
                        hide-details
                        :rules="[validacion.ruleRequerido]"
                        ></v-text-field>
                    </v-col>

                    <v-col cols="6">
                        <v-text-field
                        v-model="model.clie_deuda"
                        label="Monto"
                        rows="1"
                        outlined
                        dense
                        hide-details
                        type="number"
                        :rules="[validacion.ruleRequerido]"
                        ></v-text-field>
                    </v-col>

                    <v-col cols="6">
                        <v-text-field
                        v-model="model.clie_suscriptor"
                        label="Suscriptor"
                        outlined
                        dense
                        hide-details
                        ></v-text-field>
                    </v-col>
                    <v-col cols="6">
                        <v-text-field
                        v-model="model.clie_cuenta"
                        label="Cuenta"
                        outlined
                        dense
                        hide-details
                        ></v-text-field>
                    </v-col>
                    <v-col cols="6">
                        <v-text-field
                        v-model="model.clie_cedula"
                        label="Cedula"
                        outlined
                        dense
                        hide-details
                        ></v-text-field>
                    </v-col>

                    <v-col cols="12">
                        <v-textarea
                        v-model="model.clie_detadeuda"
                        label="Detalle Deuda"
                        rows="2"
                        outlined
                        dense
                        hide-details
                        ></v-textarea>
                    </v-col>

                </v-row>
                <v-divider></v-divider>
                <v-row class="mt-2">
                    <v-col cols="6">
                        <v-select
                        v-model="model.clie_estado"
                        :items="itemEstado"
                        label="Estado Cliente"
                        outlined
                        dense
                        hide-details
                        ></v-select>
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
import { UtilService } from "@/services/util.service";
import { ClienteService } from '../services/cliente.service';

export default {
    props: {
        item: {
            type: Object,
            default: () => ({})
        }
    },
    data() {
        return {
            title: 'Agregar Cliente',
            valid: false,
            model: {
                clie_codigo: this.item.clie_codigo || null,
                clie_documento: this.item.clie_documento || '',
                clie_nombres: this.item.clie_nombres || '',
                clie_paterno: this.item.clie_paterno || '',
                clie_materno: this.item.clie_materno || '',
                clie_celular: this.item.clie_celular || '',
                clie_deuda: this.item.clie_deuda || '',
                clie_suscriptor: this.item.clie_suscriptor || '',
                clie_cuenta: this.item.clie_cuenta || '',
                clie_cedula: this.item.clie_cedula || '',
                clie_detadeuda: this.item.clie_detadeuda || '',
                clie_estado: this.item.clie_estado || 1,
            },
            itemRoles: [],
            itemEstado: [
                { value: 1, text: 'Activo' },
                { value: 0, text: 'Inactivo' },
            ],
            validacion: ValidacionService,
        };
    },
    methods: {
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
                    if (this.model.clie_codigo) {
                        await ClienteService.update(this.model)
                    } else {
                        const response = await ClienteService.store(this.model)
                        this.model.clie_codigo = response.data.data.clie_codigo;
                    }
                    this.$emit('close');
                } catch (error) {
                    UtilService.showErrors(error);
                } finally {
                    UtilService.hideLoader();
                }
            }
        },
    },

}
</script>

<style>

</style>