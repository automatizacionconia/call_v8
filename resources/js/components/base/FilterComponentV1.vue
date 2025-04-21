<template>
    <v-menu
      v-model="menu"
      :close-on-content-click="false"
      :max-width="widthFiltro"
      offset-y
    >
      <template v-slot:activator="{ on, attrs }">
        <v-text-field
            v-on="on"
            v-bind="attrs"
            icon
            dense
            :label="`Buscar`"
            v-model="inputFilter"
            clearable
            solo
            ref="filterInput"
            @blur="handleBlur"
            @keydown.enter="generaFiltroDigitado()"
            prepend-icon="mdi-filter-variant"
            @click:prepend="menu = true"
            @click:append-outer="search()"
            hide-details
            class="me-2"
        >
            <template v-slot:prepend-inner>
                <v-chip
                    v-for="(chip, index) in chips"
                    :key="index"
                    close
                    @click:close="removeChip(index)"
                    small
                >
                    <span>{{ chip.propiedad_name }}: </span
                    ><span class="font-weight-bold">{{ chip.propiedad_value }}</span>
                </v-chip>
            </template>
        </v-text-field>
      </template>

        <v-card class="mx-auto">
        <v-card-text>
            <v-row>
            <v-col cols="12" md="12">
                <v-list dense>
                <v-subheader>Filtros</v-subheader>
                <v-list-item-group color="primary" v-model="selectedItem">
                    <v-list-item
                    v-for="(item, i) in filtrosPorAplicar"
                    :key="i"
                    dense
                    @click="createChip(item)"
                    >
                    <v-list-item-content>
                        <v-list-item-title>
                        <span
                            class="entidad--text"
                            v-if="item.filtertabledefault"
                            >{{ item.text }}</span
                        >
                        <span v-else>{{ item.text }}</span>
                        </v-list-item-title>
                    </v-list-item-content>
                    </v-list-item>
                </v-list-item-group>
                </v-list>
            </v-col>
            
            </v-row>
        </v-card-text>
        </v-card>
    </v-menu>
</template>

<script>
  import { mapGetters, mapActions } from "vuex";
  export default {
    props: ["baseFilters", "showEstado"],
    components: {
    },
    data() {
      return {
        menu: false,
        inputFilter: "",
        filtrosDigitables: [],
        filtrosDefault: [],
        chips: [],
        chip: {
            propiedad_name: null,
            propiedad_value: null,
            key: null,
            value: null,
        },
        filtroPropiedadActivo: false,
        showMasFiltros: false,
        widthDefault: 500,
        selectedItem: 0,
      };
    },
    created() {
      const elementosDigitables = this.baseFilters.filter(
        (item) => item.filtertable == true
      );
      this.filtrosDigitables = elementosDigitables;
  
      const elementosFiltrosDefault = this.baseFilters.filter(
        (item) => item.filtertabledefault == true
      );
      this.filtrosDefault = elementosFiltrosDefault;

    },
    computed: {
      ...mapGetters({
        getFilters: "filter/getFilters",
      }),
      filters: {
        get() {
          return this.getFilters;
        },
        set: function (val) {
          this.$store.commit("filter/setFilters", val);
        },
      },
      filtrosPorAplicar() {
        const data = this.filtrosDigitables.filter(
          (item) => !this.chips.some((chip) => chip.key === item.value)
        );
  
        return data.sort((a, b) => {
          if (a.filtertabledefault && !b.filtertabledefault) {
            return -1;
          } else if (!a.filtertabledefault && b.filtertabledefault) {
            return 1;
          } else {
            return 0;
          }
        });
      },
      filtroDefault() {
        return this.filtrosDefault[0];
      },
      widthFiltro() {
        return this.showMasFiltros ? this.widthDefault : this.widthDefault / 2;
      },
      iconMasFiltros() {
        return this.showMasFiltros ? "mdi-chevron-left" : "mdi-chevron-right";
      },
      generarFiltrosBack() {
        let param_transform = this.chips.map((item) => {
          let par = item.key;
          let val = item.value;
          return { [par]: val };
        });
  
        const params = param_transform.reduce((acc, obj) => {
          for (let key in obj) {
            if (Object.prototype.hasOwnProperty.call(obj, key)) {
              acc[key] = obj[key];
            }
          }
          return acc;
        }, {});
  
        return params;
      },
    },
    methods: {
      ...mapActions({
        search: "filter/search",
      }),
      aplicarFiltros() {
        var filters = this.generarFiltrosBack;
        this.filters = filters;
      },
      
      generaFiltroDigitado() {
        if (this.inputFilter != "") {
          this.menu = false;
          const parts = this.inputFilter.split(":");
          if (
            this.inputFilter != "" &&
            this.inputFilter.includes(":") &&
            parts[1].trim() !== ""
          ) {
            this.setChip(
              `${parts[0].trim()}`,
              `${parts[1].trim()}`,
              this.selectedPropiedades.value,
              `${parts[1].trim()}`
            );
            this.inputFilter = "";
            this.aplicarFiltros();
  
            this.$nextTick(() => {
              this.$refs.filterInput.focus();
            });
  
            this.filtroPropiedadActivo = false;
          } else {
            if (!this.filtroPropiedadActivo) {
              this.aplicarFiltrosDefault();
            } else {
              this.inputFilter = "";
              this.filtroPropiedadActivo = false;
            }
          }
        }
      },
      handleBlur() {
        this.generaFiltroDigitado();
        this.selectedItem = 0;
      },
      createChip(item) {
        this.filtroPropiedadActivo = true;
        this.selectedPropiedades = item;
        this.inputFilter = "";
        if (this.inputFilter == "") {
          this.inputFilter = `${this.selectedPropiedades.text}:`;
          this.menu = false;
        }
        this.$nextTick(() => {
          this.$refs.filterInput.focus();
        });
      },
      handleSuggestionsClick(event) {
        event.stopPropagation();
      },
      aplicarFiltrosDefault() {
        if (this.filtrosDefault.length == 1) {
          this.eliminarItem(
            this.chips,
            this.chips,
            this.filtroDefault.value,
            "key"
          );
  
          this.filtrosDefault.forEach((element) => {
            this.setChip(
              element.text,
              this.inputFilter,
              element.value,
              this.inputFilter
            );
          });
          this.inputFilter = "";
          this.aplicarFiltros();
        }
        this.inputFilter = "";
      },
      setChip(propiedad_name, propiedad_value, key, value) {
        const chip = {
          propiedad_name: `${propiedad_name}`,
          propiedad_value: `${propiedad_value}`,
          key: key,
          value: value,
        };
        this.chips.push(chip);
      },
      removeChip(index) {
        const self = this;
        const item = this.chips[index];
        this.eliminarItem(this.chips, this.chips, item.key, "key");  
        this.aplicarFiltros();
      },
  
      eliminarItem(arrayBusqueda, arrayEliminar, key, by) {
        let itemBuscado = null;
        if (by == "key") {
          itemBuscado = arrayBusqueda.find((item) => item.key == key);
        }
        if (by == "value") {
          itemBuscado = arrayBusqueda.find((item) => item.value == key);
        }
        if (itemBuscado) {
          this.elminarItemByIndex(arrayEliminar, itemBuscado);
        }
      },
      elminarItemByIndex(array, item) {
        let index = array.indexOf(item);
        array.splice(index, 1);
      },
    },
  };
  </script>
  
  <style scoped>
  .list-group {
    display: flex;
    flex-direction: column;
    padding-left: 0;
    margin-bottom: 0;
  }
  .list-group-item {
    position: relative;
    display: block;
    text-align: left;
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
  }
  
  .chips-container {
    display: flex;
    flex-wrap: wrap;
  }
  
  .chip {
    background-color: #ddd;
    border-radius: 13px;
    padding: 4px 8px;
    margin: 4px;
    display: flex;
    align-items: center;
    font-size: 15px;
  }
  
  .close-btn {
    cursor: pointer;
    margin-left: 4px;
    font-weight: bold;
    background: #3b3636;
    border-radius: 15px;
    padding: 0 6px 1px;
    font-size: 11px;
    color: #fff;
  }
  .ui-widget {
    background: #fff;
  }
  </style>
  