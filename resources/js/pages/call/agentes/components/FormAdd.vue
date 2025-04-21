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
                        v-model="model.agen_nombre"
                        label="Nombre del agente"
                        required
                        :rules="[validacion.ruleRequerido]"
                        outlined
                        dense
                        hide-details
                        ></v-text-field>
                    </v-col>

                    <v-col cols="6">
                        <v-select
                        v-model="model.plat_codigo"
                        :items="itemPlataforma"
                        label="Plataforma"
                        outlined
                        dense
                        hide-details
                        item-value="plat_codigo"
                        item-text="plat_nombre"
                        ></v-select>
                    </v-col>

                    <v-col cols="6">
                        <v-text-field
                        v-model="model.agen_api"
                        label="API Url"
                        required
                        outlined
                        dense
                        hide-details
                        ></v-text-field>
                    </v-col>

                    <v-col cols="6">
                        <v-text-field
                        v-model="model.agen_key"
                        label="API Key"
                        required
                        outlined
                        dense
                        hide-details
                        ></v-text-field>
                    </v-col>

                    <v-col cols="6">
                        <v-text-field
                        v-model="model.agen_pass"
                        label="API Password"
                        required
                        outlined
                        dense
                        hide-details
                        ></v-text-field>
                    </v-col>
                    <v-col cols="6">
                        <v-select
                        v-model="model.agen_estado"
                        :items="itemEstado"
                        label="Estado Agente"
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
import { AgenteService } from '../services/agente.service';
import { PlataformaService } from '@/pages/call/plataforma/services/plataforma.service';

export default {
    props: {
        item: {
            type: Object,
            default: () => ({})
        }
    },
    data() {
        return {
            title: 'Agregar Agente',
            valid: false,
            model: {
                agen_codigo: this.item.agen_codigo || null,
                agen_nombre: this.item.agen_nombre || '',
                plat_codigo: this.item.plat_codigo || '',
                agen_api: this.item.agen_api || '',
                agen_key: this.item.agen_key || '',
                agen_pass: this.item.agen_pass || '',
                agen_estado: this.item.agen_estado || 1,
            },
            itemRoles: [],
            itemEstado: [
                { value: 1, text: 'Activo' },
                { value: 0, text: 'Inactivo' },
            ],
            validacion: ValidacionService,
            itemPlataforma: [],
        };
    },
    mounted() {
        this.getPlataforma();
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
                    if (this.model.agen_codigo) {
                        await AgenteService.update(this.model)
                    } else {
                        const response = await AgenteService.store(this.model)
                    }
                    this.$emit('close');
                } catch (error) {
                    UtilService.showErrors(error);
                } finally {
                    UtilService.hideLoader();
                }
            }
        },
        async getPlataforma() {
            try {
                const response = await PlataformaService.index();
                this.itemPlataforma = response.data.data;
            } catch (error) {
                UtilService.showErrors(error);
            }
        },
    },

}
</script>

<style>

</style>