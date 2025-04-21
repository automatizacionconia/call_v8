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
                            <v-select
                                v-model="model.opci_tipo"
                                :items="itemTipo"
                                :rules="rules"
                                label="Tipo opción"
                                required
                                outlined
                                dense
                                hide-details
                                @change="getMenus"
                            ></v-select>
                        </v-col>
                        <v-col cols="12" sm="6">
                            <v-select
                                v-model="model.opci_sub_codigo"
                                :items="itemSubMenu"
                                label="Dentro de opción"
                                outlined
                                dense
                                hide-details
                                item-value="opci_codigo"
                                item-text="opci_nombre"
                            ></v-select>
                        </v-col>
                        <v-col cols="12" sm="6">
                            <v-text-field
                                v-model="model.opci_nombre"
                                :rules="rules"
                                label="Nombre opción"
                                required
                                outlined
                                dense
                                hide-details
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6">
                            <v-text-field
                                v-model="model.opci_sub_nombre"
                                label="Sub nombre"
                                outlined
                                dense
                                hide-details
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6">
                            <v-text-field
                                v-model="model.opci_icon"
                                label="Icono"
                                outlined
                                dense
                                hide-details
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6">
                            <v-text-field
                                v-model="model.opci_href"
                                label="Ruta"
                                outlined
                                dense
                                hide-details
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6">
                            <v-text-field
                                v-model="model.opci_order"
                                :rules="rules"
                                label="N° Orden"
                                required
                                outlined
                                dense
                                hide-details
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6">
                            <v-select
                                v-model="model.opci_estado"
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
import { OpcionesService } from "@/pages/seguridad/opciones/services/opciones.service";
import { estados } from "@/services/estado.service";
export default {
    props: {
        item: {
            type: Object,
            default: () => ({})
        }
    },
    data: () => ({
        valid: false,
        title: "Formulario de Opciones",
        model: {
            opci_codigo: null,
            opci_estado: null,
            opci_href: null,
            opci_icon: null,
            opci_icon_notifica: null,
            opci_nombre: null,
            opci_order: null,
            opci_sub_codigo: null,
            opci_sub_nombre: null,
            opci_tipo: null,
        },
        rules: [(v) => !!v || "* Campo obligatorio"],
        itemTipo: [
            { text: "Menú Categoria", value: 1 },
            { text: "Leyenda", value: 2 },
            { text: "Menú", value: 3 },
            { text: "Submenú", value: 4 },
            { text: "Opción", value: 5 },
        ],
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
        async getMenus() {
            UtilService.showLoader();
            try {
                
                let model ={
                    opci_tipo: this.model.opci_tipo -1
                }
                const response = await OpcionesService.getMenus(model);
                this.itemSubMenu = response.data.data;
            } catch (error) {
                UtilService.showErrors(error);
            } finally {
                UtilService.hideLoader();
            }
        },
        async save() {
            
            if (this.$refs.form.validate()) {
                UtilService.showLoader();
                try {
                    if (this.model.opci_codigo) {
                        await OpcionesService.update(this.model)
                    } else {
                        await OpcionesService.store(this.model)
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