<template>
    <div>
        <CardComponent
        :title="title"
        @cancelar="cancelar"
        :hideClose="false"
        >
        <template v-slot:form>
            <v-form ref="form" v-model="valid" lazy-validation>
                <v-container>
                    <v-row>
                        <v-col cols="12" sm="6">
                            <v-text-field
                                v-model="model.empr_ruc"
                                label="RUC"
                                outlined
                                dense
                                hide-details
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="12">
                            <v-text-field
                                v-model="model.empr_nombre"
                                :rules="[validacion.ruleRequerido]"
                                label="Nombre"
                                required
                                outlined
                                dense
                                hide-details
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6">
                            <v-select
                                v-model="model.empr_estado"
                                :items="itemEstado"
                                label="Estado"
                                required
                                outlined
                                dense
                                hide-details
                            ></v-select>
                        </v-col>
                    </v-row>
                </v-container>
            </v-form>
        </template>
        <template v-slot:form_accion>
            <v-spacer></v-spacer>
            <v-btn color="error" text @click="cancelar" rounded>Cancelar</v-btn>
            <v-btn color="primary" @click="save" :disabled="!valid" rounded>Guardar información</v-btn>
        </template>
        </CardComponent>
    </div>
</template>
<script>
import { UtilService } from "@/services/util.service";
import { EmpresasService } from "@/pages/seguridad/empresas/services/empresas.service";
import { estados } from "@/services/estado.service";
import { ValidacionService } from '@/services/validacion.service';

export default {
    props: {
        item: {
            type: Object,
            default: () => ({})
        }
    },
    data: () => ({
        valid: false,
        title: "Formulario de empresa",
        model: {
            empr_codigo: null,
            empr_nombre: null,
            empr_ruc: null,
            empr_estado: 1,
        },
        validacion: ValidacionService,
        itemSubMenu:[],
        itemEstado: estados,
    }),
    created() {
        this.model = { ...this.item };
    },
    methods: {
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
                    if (this.model.empr_codigo) {
                        await EmpresasService.update(this.model)
                    } else {
                        await EmpresasService.store(this.model)
                    }
                    this.$emit('close');
                } catch (error) {
                    UtilService.showErrors(error);
                } finally {
                    UtilService.hideLoader();
                }
            }
        }
    }
}
</script>