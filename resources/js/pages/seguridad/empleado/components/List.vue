<template>
    <div>
        <v-card>
            <v-card-text>
                <v-row no-gutters>
                    <v-col cols="6">
                        <v-btn
                            class="entidad"
                            dark
                            :to="{ name: 'app.sgd.empleado.create' }"
                        >
                            Nuevo empleado
                            <v-icon right dark>mdi-file-plus-outline</v-icon>
                        </v-btn>
                    </v-col>
                    <v-col cols="6" class="d-flex justify-end">
                        <v-btn @click="exportar()" color="green" dark>
                            exportar
                            <v-icon right dark>mdi-file-excel</v-icon>
                        </v-btn>
                    </v-col>
                </v-row>

                <v-row class="pt-3">
                    <v-col cols="12" sm="4">
                        <v-text-field
                            hide-details
                            clearable
                            dense
                            outlined
                            label="Ingrese algún dato de busqueda"
                            v-model="dataFilters.dato"
                            autocomplete="off"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4" class="pl-1">
                        <v-autocomplete
                            hide-details
                            v-model="dataFilters.dependencia_id"
                            :items="dataDependencias"
                            item-text="descripcion"
                            item-value="id"
                            label="Dependencia"
                            outlined
                            dense
                            clearable
                        >
                        </v-autocomplete>
                    </v-col>
                    <v-col cols="12" md="2">
                        <v-select
                            clearable
                            hide-details
                            v-model="dataFilters.estado_id"
                            :items="dataEstados"
                            label="Estado"
                            item-value="id"
                            item-text="descripcion"
                            outlined
                            dense
                        >
                        </v-select>
                    </v-col>
                    <v-col cols="12" sm="2">
                        <v-btn color="entidad" dark @click="buscar()"
                            >Buscar</v-btn
                        >
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>

        <v-data-table
            class="elevation-1 mt-2"
            dense
            :headers="headers"
            :loading="loading"
            :items="data"
            :server-items-length="total"
            :options.sync="options"
            :footer-props="footerProps"
            :items-per-page="itemsPerPage"
        >
            <template v-slot:item.accion="{ item }">
                <v-btn
                    text
                    small
                    color="entidad"
                    :to="{
                        name: 'app.sgd.empleado.edit',
                        params: { id: item.id },
                    }"
                >
                    <v-icon>mdi-square-edit-outline</v-icon> EDITAR
                </v-btn>
            </template>

            <template v-slot:item.estado_empleado="{ item }">
                <v-chip
                    small
                    dark
                    :color="item.estado_empleado_id ? 'green' : 'red'"
                >
                    {{ item.estado_empleado }}
                </v-chip>
            </template>
            <template v-slot:item.estado_usuario="{ item }">
                <v-chip
                    small
                    dark
                    :color="item.estado_usuario == 'Activo' ? 'green' : 'red'"
                >
                    {{ item.estado_usuario }}
                </v-chip>
            </template>
        </v-data-table>
    </div>
</template>

<script>
import { SgdEmpleadoService } from "@/pages/virtual/services/app/sgd-empleado.service";
import {
    FooterProps,
    ItemsPerPage,
} from "@/pages/virtual/services/common/paginado.service";
import { ErrorService } from "@/pages/virtual/services/common/error.service";
import { SgdEmpleadoEstadoService } from "@/pages/virtual/services/app//sgd-empleado-estado.service";
import { SgdDependenciaService } from "@/pages/virtual/services/app/sgd-dependencia.service";
import { environment } from "@/pages/environments";

export default {
    data() {
        return {
            loading: false,
            headers: [
                {
                    text: "ACCIONES",
                    align: "start",
                    sortable: false,
                    value: "accion",
                },
                { text: "CODIDO", value: "id", sortable: false },
                { text: "DNI", value: "dni", sortable: false },
                { text: "PATERNO", value: "paterno", sortable: false },
                { text: "MATERNO", value: "materno", sortable: false },
                { text: "NOMBRES", value: "nombres", sortable: false },
                { text: "DEPENDENCIA", value: "dependencia", sortable: false },
                { text: "CARGO", value: "cargo", sortable: false },
                {
                    text: "ESTADO EMP.",
                    value: "estado_empleado",
                    sortable: false,
                },
                { text: "USUARIO", value: "usuario", sortable: false },
                {
                    text: "ESTADO USU.",
                    value: "estado_usuario",
                    sortable: false,
                },
                {
                    text: "AUTH",
                    value: "tipo_autenticacion",
                    sortable: false,
                },
            ],
            footerProps: FooterProps,
            itemsPerPage: ItemsPerPage,
            options: {},
            data: [],
            total: 0,
            dataFilters: {
                dato: null,
                estado_id: null,
                dependencia_id: null,
            },
            dataEstados: SgdEmpleadoEstadoService.index(),
            dataDependencias: [],
            environment: environment,
        };
    },
    async created() {
        this.dataFilters.per_page = this.itemsPerPage;

        const response = await SgdDependenciaService.index();
        this.dataDependencias = response.data.data;
    },
    methods: {
        buscar() {
            this.dataFilters.page = 1;
            if (this.options.page == 1) {
                this.getDataApi();
            }
            this.options.page = 1;
        },
        updateOptions() {
            this.dataFilters.page = this.options.page;
            this.dataFilters.per_page = this.options.itemsPerPage;
            this.getDataApi();
        },
        async getDataApi() {
            try {
                this.loading = true;
                const response = await SgdEmpleadoService.index(
                    this.dataFilters
                );
                this.total = response.data.meta.total;
                this.data = response.data.data;
                this.loading = false;
            } catch (error) {
                this.loading = false;
                this.$store.commit(
                    "alert/setErrors",
                    ErrorService.getToArray(error)
                );
            }
        },
        exportar() {
            const URL = this.environment.API_URL;
            let dependencia_id = this.dataFilters.dependencia_id;
            let estado_id = this.dataFilters.estado_id;

            window.open(
                `${URL}/virtual/reporte/report1/exportar?dependencia_id=${dependencia_id}&estado_id=${estado_id}`
            );
        },
    },
    watch: {
        options: {
            handler() {
                this.updateOptions();
            },
            deep: false,
        },
    },
};
</script>

<style scoped></style>
