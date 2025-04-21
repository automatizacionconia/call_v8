<template>
  <div>
    <v-col cols="12" class="d-inline-flex align-center px-0 py-0">
      <v-menu
        v-model="menu"
        :close-on-content-click="false"
        :nudge-width="400"
        offset-y
        max-width="150%"
      >
        <template v-slot:activator="{ on, attrs }">
          <v-text-field
            icon
            v-on="on"
            dense
            :label="`Buscar`"
            v-model="inputFilter"
            clearable
            solo
            ref="filterInput"
            @blur="handleBlur"
            @keydown.enter="accionFilters"
            prepend-icon="mdi-filter-variant"
            append-outer-icon="mdi-magnify"
            @click:prepend="menu = true"
            @click:append-outer="setFilters"
            hide-details
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
                ><span class="font-weight-bold">{{ chip.propiedad_text }}</span>
              </v-chip>
            </template>
          </v-text-field>
        </template>

        <v-card>
          <v-card-text>
            <v-row>
              <v-col cols="12">
                <v-list dense>
                  <v-subheader>Porpiedades</v-subheader>
                  <v-list-item-group color="primary">
                    <v-list-item
                      v-for="(item, i) in itemsPropiedades"
                      :key="i"
                      dense
                      @click="getPropiedad(item)"
                    >
                      <v-list-item-content>
                        <v-list-item-title
                          v-text="item.text"
                        ></v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                  </v-list-item-group>
                </v-list>
              </v-col>
            </v-row>
            <v-divider></v-divider>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>

            <v-btn text @click="menu = false" color="error"> Cancelar </v-btn>
          </v-card-actions>
        </v-card>
      </v-menu>
    </v-col>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  props: ["baseFilters"],
  components: {},
  data() {
    return {
      menu: false,
      inputFilter: "",
      suggestionsVisible: false,
      itemsPropiedades: [],
      selectedItems: [],
      nextId: 1,
      chips: [],
    };
  },
  created() {
    const elementosTrue = this.baseFilters.filter(
      (item) => item.filtertable == true
    );
    this.itemsPropiedades = elementosTrue;
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
  },
  methods: {
    setFilters() {
      let param_transform = this.chips.map((item) => {
        let par = item.propiedad_value;
        let val = item.propiedad_text;
        return { [par]: val };
      });

      var filters = this.convertirAQueryString(param_transform);
      //console.log("setFilters=>", filters);
      this.filters = filters;
    },
    accionFilters() {
      if (this.inputFilter != "") {
        this.menu = false;
        const parts = this.inputFilter.split(":");
        if (
          this.inputFilter != "" &&
          this.inputFilter.includes(":") &&
          parts[1].trim() !== ""
        ) {
          const newItem = {
            propiedad_text: `${parts[1].trim()}`,
            propiedad_value: this.selectedPropiedades.value,
            propiedad_name: this.selectedPropiedades.text,
            propiedad_chip: `${this.inputFilter}`,
          };
          this.chips.push(newItem);

          this.inputFilter = "";

          this.$nextTick(() => {
            this.$refs.filterInput.focus();
          });

          this.setFilters();
          // setTimeout(() => {
          //   this.menu = true;
          // }, 200);

          return;
        } else {
          this.inputFilter = "";
          console.log(
            "Las consultas de filtro con claves deben tener un valor"
          );
        }
      }
    },
    handleBlur() {
      //console.log("handleBlur");
      this.accionFilters();
      setTimeout(() => {
        this.menu = false;
      }, 200);
    },
    getPropiedad(item) {
      this.selectedPropiedades = item;
      //console.log("enter", this.inputFilter);
      this.inputFilter = "";
      if (this.inputFilter == "") {
        this.inputFilter = `${this.selectedPropiedades.text}:`;
      }

      this.$nextTick(() => {
        this.$refs.filterInput.focus();
      });
    },
    removeSelectedItem(itemId) {
      this.selectedItems = this.selectedItems.filter(
        (item) => item.value !== itemId
      );
    },
    handleSuggestionsClick(event) {
      event.stopPropagation();
    },
    removeChip(index) {
      this.chips.splice(index, 1);
      this.setFilters();
    },
    convertirAQueryString(parametros) {
      const params = parametros.reduce((acc, obj) => {
        for (let key in obj) {
          if (Object.prototype.hasOwnProperty.call(obj, key)) {
            acc[key] = obj[key];
          }
        }
        return acc;
      }, {});

      return params;
      // return parametros
      //     .map((objeto) => {
      //         const clave = Object.keys(objeto)[0];
      //         const valor = objeto[clave];
      //         return `${encodeURIComponent(clave)}=${encodeURIComponent(
      //             valor
      //         )}`;
      //     })
      //     .join("&");
    },
  },
  watch: {},
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
