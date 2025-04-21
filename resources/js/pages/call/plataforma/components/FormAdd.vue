<template>
    <CardComponent
        :title="title"
        @cancelar="cancelar"
        :hideClose="false"
        >
        <template v-slot:form>
            <v-form ref="form" v-model="valid" lazy-validation class="px-4">
                <v-row class="mb-0">
                    <v-col cols="12">
                        <v-text-field
                        v-model="model.plat_nombre"
                        label="Nombre del agente"
                        required
                        :rules="[validacion.ruleRequerido]"
                        outlined
                        dense
                        hide-details
                        ></v-text-field>
                    </v-col>
                    <v-col cols="6">
                        <v-text-field
                        v-model="model.plat_url"
                        label="Url plataforma"
                        required
                        outlined
                        dense
                        hide-details
                        ></v-text-field>
                    </v-col>
                    <v-col cols="6">
                        <v-select
                        v-model="model.plat_estado"
                        :items="itemEstado"
                        label="Estado plataforma"
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
import { PlataformaService } from '../services/plataforma.service';
export default {
    props: {
        item: {
            type: Object,
            default: () => ({})
        }
    },
    data() {
        return {
            title: 'Agregar plataforma',
            valid: false,
            model: {
                plat_codigo: this.item.plat_codigo || null,
                plat_nombre: this.item.plat_nombre || '',
                plat_url: this.item.plat_url || '',
                plat_estado: this.item.plat_estado || 1,
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
                    if (this.model.plat_codigo) {
                        await PlataformaService.update(this.model)
                    } else {
                        const response = await PlataformaService.store(this.model)
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