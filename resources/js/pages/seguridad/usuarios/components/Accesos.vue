<template>
    <div>
        <CardComponent
        :title="title"
        @cancelar="cancelar"
        :hideClose="false"
        >
        <template v-slot:form>
            <v-card elevation="0">
                <v-card-title>
                    <v-row>
                        <v-col cols="12" md="12">
                            <v-text-field 
                            label="Buscar" v-model="search" 
                            append-icon="mdi-magnify" 
                            single-line 
                            hide-details
                            outlined
                            dense
                            ></v-text-field>
                        </v-col>
                    </v-row>
                </v-card-title>

                <v-card-text>
                    <v-treeview
                        :items="treeData"
                        item-key="opci_codigo"
                        item-text="opci_nombre"
                        :open="openNodes"
                        dense
                        :search="search"
                        item-children="children"
                        item-disabled="disabled"
                        @input="updateSelected"
                    >
                        <template v-slot:prepend="{ item }">
                        <v-checkbox
                            :input-value="isSelected(item)"
                            @change="() => toggleSelection(item)"
                            :disabled="item.disabled"
                            dense
                        ></v-checkbox>
                        </template>
                </v-treeview>
                </v-card-text>      
            </v-card>
        </template>

        <template v-slot:form_accion>
            <v-spacer></v-spacer>
            <v-btn color="error" text @click="cancelar">Cancelar</v-btn>
            <v-btn color="primary" @click="save"><v-icon>mdi-content-save</v-icon>Guardar cambios</v-btn>
        </template>
        </CardComponent>

    </div>
</template>
<script>
import { AccesosService } from '../services/accesos.service';
import { OpcionesService } from '../services/opciones.service';
import { UtilService } from "@/services/util.service";
export default {
    components: {
    },
    props: {
        usua_codigo: {
            type: Number,
            required: true
        },
    },
    data() {
        return {
            title: 'Accesos',
            benched: 10,
            dataOpciones: [],
            dataSelected: [],
            accesosUsuario: [],
            treeData: [],
            openNodes: [],
            search: '',
            checkbox: [],
            checkboxModel: {},
        }
    },
    async mounted() {
        await this.getOpciones();
        await this.getAccesosUsuario();
        this.initializeSelectedItems();
    },
    methods: {
        async getOpciones() {
            const response = await OpcionesService.allOpciones();
            this.treeData = response.data.data;
        },
        async getAccesosUsuario() {
            const response = await AccesosService.getAccesosUsuario(this.usua_codigo);
            this.accesosUsuario = response.data.data;

            this.accesosUsuario = this.accesosUsuario.map(item => item.opci_codigo);
        },
        initializeSelectedItems() {
        this.dataSelected = [...this.accesosUsuario];
        },
        isSelected(item) {
            return this.dataSelected.includes(item.opci_codigo);
        },
        toggleSelection(item) {
            const index = this.dataSelected.indexOf(item.opci_codigo);
            if (index > -1) {
                this.dataSelected.splice(index, 1);
            } else {
                this.dataSelected.push(item.opci_codigo);
            }
        },
        updateSelected(value) {
        },
        async save() {
            try {
                UtilService.showLoader();
                if(this.dataSelected.length>0) {
                    let data = {
                        usua_codigo: this.usua_codigo,
                        accesos: this.dataSelected
                    }
                    await AccesosService.store(data)
                }
                this.$emit('close');
            } catch (error) {
                UtilService.showErrors(error);
            } finally {
                UtilService.hideLoader();
            }
        },

        markUserAccess() {
            const markAccess = (items) => {
                items.forEach(item => {
                    this.$set(item, 'selected', this.accesosUsuario.some(acceso => acceso.opci_codigo === item.opci_codigo) ? item.opci_codigo : null);
                    if (item.children) {
                        markAccess(item.children);
                    }
                });
            };
            markAccess(this.treeData);
            this.$forceUpdate();
        },
        cancelar() {
            this.$emit('cancelarAccesos');
        },
    
    }
}
</script>