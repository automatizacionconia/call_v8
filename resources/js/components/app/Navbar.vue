<template>
  <v-navigation-drawer
    :value="toggledDrawerState"
    @input="handleDrawerToggle"
    app
    
    :width="300"
  >
  <!-- clipped -->
    <v-row class="fill-height" no-gutters>
      
      <navbar-lista />
        
    </v-row>
  </v-navigation-drawer>
</template>
<script>
import { mapGetters } from "vuex";
import NavbarLista from "./NavbarLista.vue";

export default {
  components: {
    NavbarLista,
  },
  data: () => ({
    innerDrawerVisible: true,
  }),
  computed: {
    ...mapGetters({
      getDrawer: "app/getDrawer",
      getLeyendaSelected: "navbar/getLeyendaSelected",
      getArrayPermisos: "navbar/getArrayPermisos",
      getArraySubSistema: "navbar/getArraySubSistema",
      getSelectedCategoria: "navbar/getSelectedCategoria",
      menus: "navbar/menus",
    }),
    toggledDrawerState: {
      get() {
        return this.getDrawer;
      },
      set(value) {
        if (value !== this.getDrawer) {
          this.$store.commit("app/setDrawer", value);
        }
      },
    },

  },
  methods: {

    updateMenus() {
        const menus = this.menus(this.getLeyendaSelected);
        this.$store.commit("navbar/setSelectedMenu", menus);
        if (menus.length > 0) {
          if (menus[0].opci_href && menus[0].opci_href !== this.$route.path)
              this.$router.push({ path: menus[0].opci_href });
        } else {
            console.warn("No se encontraron menús para el subsistema seleccionado");
        }
    },
    handleDrawerToggle(value) {
      // this.$store.commit("app/setDrawer", value);
    },
  },
  watch: {
    toggledDrawerState(newValue) {
      if (newValue !== this.innerDrawerVisible) {
        this.innerDrawerVisible = newValue;
      }
    },
  },
};
</script>
<style scoped>
.bg-navbar {
  background-color: #01579B !important;
}
.bg-navbar .primary--text {
  color: #afafaf !important;
}
</style>