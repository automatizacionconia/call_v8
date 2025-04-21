<template>
  <div>
    <v-text-field
      readonly
      v-model="descripcion"
      :label="label"
      outlined
      dense
      append-outer-icon="mdi-text-search"
      @click:append-outer="dialog = true"
    ></v-text-field>

    <v-dialog
      v-model="dialog"
      max-width="90%"
      persistent
      :width="$vuetify.breakpoint.mobile ? '90%' : '60%'"
    >
      <v-card>
        <v-toolbar dense dark color="entidad">
          <v-toolbar-title>UBIGEO</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-btn icon dark @click="dialog = false">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-toolbar>

        <v-card-text>
          <v-row class="pt-5">
            <v-col cols="12" sm="6">
              <v-text-field
                dense
                outlined
                label="DEPARTAMENTO / PROVINCIA / DISTRITO"
                v-model="filters.dato"
                clearable
              ></v-text-field>
            </v-col>
            <v-col cols="12" sm="5" class="ml-1">
              <v-btn @click="index()" dense class="entidad" dark>
                <v-icon left>mdi-magnify</v-icon>
                Buscar
              </v-btn>
            </v-col>
          </v-row>
          <v-data-table
            class="elevation-0"
            dense
            :headers="headers"
            :loading="loading"
            :items="data"
            :server-items-length="total"
            :options.sync="options"
            :footer-props="FooterProps"
            :items-per-page="ItemsPerPage"
          >
            <template v-slot:item.acciones="{ headers, item }">
              <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                  <v-btn
                    text
                    small
                    v-on="on"
                    color="entidad"
                    dark
                    @click="setUbigeo(item)"
                  >
                    <v-icon left>mdi-check-bold</v-icon>
                    Seleccionar
                  </v-btn>
                </template>
                <span>Seleccionar</span>
              </v-tooltip>
            </template>
          </v-data-table>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import { UbigeoService } from "./services/ubigeo.service.js";
import { UtilService } from "@/services/util.service";
export default {
  props: ["label", "codUbigeo"],
  data() {
    return {
      headers: [
        {
          text: "Acciones",
          value: "acciones",
          sortable: false,
          width: 20,
        },
        {
          text: "DEPARTAMENTO",
          value: "desDpto",
          sortable: false,
          width: 20,
        },
        {
          text: "PROVINCIA",
          value: "desProvi",
          sortable: false,
          width: 250,
        },
        {
          text: "DISTRITO",
          value: "desDistri",
          sortable: false,
          width: 50,
        },
      ],
      FooterProps: { "items-per-page-options": [10, 20, 50] },
      ItemsPerPage: 10,
      options: {},
      loading: false,
      total: 0,
      data: [],

      filters: {
        page: 1,
        perPage: 10,
        dato: "",
      },
      dialog: false,
      item: {
        desDpto: "",
        desProvi: "",
        desDistri: "",
      },
    };
  },
  computed: {
    descripcion() {
      if (this.item.desDistri) {
        return `${this.item.desDpto} / ${this.item.desProvi} / ${this.item.desDistri}`;
      }
      return "";
    },
  },
  async created() {
    if (this.codUbigeo) {
      this.show(this.codUbigeo);
    }
  },
  methods: {
    index() {
      this.filters.page = 1;
      if (this.options.page == 1) {
        this.getDataApi();
      }
      this.options.page = 1;
    },
    updateOptions() {
      this.filters.page = this.options.page;
      this.filters.perPage = this.options.itemsPerPage;
      this.getDataApi();
    },
    async getDataApi() {
      this.loading = true;
      try {
        const resposnse = await UbigeoService.index(this.filters);
        this.total = resposnse.data.meta.total;
        this.data = resposnse.data.data;
      } catch (e) {
        UtilService.showErrors(e);
      } finally {
        this.loading = false;
      }
    },
    setUbigeo(item) {
      this.item = item;
      this.$emit("setUbigeo", item);
      this.dialog = false;
    },
    async show(codUbigeo) {
      try {
        const response = await UbigeoService.show(codUbigeo);
        this.item = response.data.data;
      } catch (e) {
        UtilService.showErrors(e);
      }
    },
  },
  watch: {
    options: {
      handler() {
        this.updateOptions();
      },
      deep: false,
    },
    codUbigeo() {
      if (this.codUbigeo) {
        this.show(this.codUbigeo);
      }
    },
  },
};
</script>

<style scoped></style>
