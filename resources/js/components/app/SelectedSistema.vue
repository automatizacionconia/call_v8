<template>
  <v-select
          v-model="selectSistema"
          :items="getArrayPermisos"
          item-text="opci_nombre"
          item-value="opci_codigo"
          label="Sistema"
          dense
          outlined
          hide-details
          class="mt-3 ma-2"
          style="width: 260px;"
          @change="selectOpcion"
          color="white"
        >
          <template v-slot:selection="{ item }">
            <v-icon class="mr-2">{{ item.opci_icon }}</v-icon>
            {{ item.opci_nombre.substring(0, 15) }}
          </template>
          <template v-slot:item="{ item, attrs }">
          <div v-bind="attrs" class="d-flex align-center">
            <v-icon class="mr-2">{{ item.opci_icon }}</v-icon>
            {{ item.opci_nombre }}
          </div>
        </template>
      </v-select>
</template>

<script>
import { mapGetters, mapMutations, mapActions} from "vuex";

export default {
  data: () => ({
  }),
  computed: {
    ...mapGetters({
        getDrawer: "app/getDrawer",
        getProfile: "user/getProfile",
        getModoOscuro: "app/getModoOscuro",
        getArrayPermisos: "navbar/getArrayPermisos",
        getSelectSistema: "navbar/getSelectSistema",
      }),
    selectSistema: {
            get() {
                return this.getSelectSistema;
            },
            set(value) {
                this.setSelectSistema(value);
            },
    },
  },
  async created() {
    //Si al inicio no tiene valor le asignamos el primer valor
    if (!this.getSelectSistema && this.getArrayPermisos.length > 0) {
      this.$store.commit("navbar/setSelectSistema", this.getArrayPermisos[0].opci_codigo);
      await this.subSistemasMenu();
    }
  },
  methods: {
    ...mapMutations({
        setSelectSistema: "navbar/setSelectSistema",
    }),
    async selectOpcion() {
        await this.subSistemasMenu();
    },
    async subSistemasMenu() {

        // var subSistemas = this.getArrayPermisos.find((permiso) => parseInt(permiso.opci_codigo) === this.getSelectSistema);
        // this.$store.commit("navbar/setArraySubSistema", subSistemas.subopciones);
        // if(subSistemas.subopciones.length > 0) {
        //     console.log("subSistemas", subSistemas.subopciones[0].subopciones[0]);
        //     if (subSistemas.subopciones[0].opci_href !== this.$route.path){
        //         // this.$router.push({ path: subSistemas.subopciones[0].subopciones[0].opci_href });
        //     }
        // }


        if (this.getArrayPermisos.length === 0) return;

        const subSistemas = this.getArrayPermisos.find((permiso) => parseInt(permiso.opci_codigo) === this.getSelectSistema);
        
        if (subSistemas) {
          // Safely commit the subopciones
          this.$store.commit("navbar/setArraySubSistema", subSistemas.subopciones || []);

          // Optional: Navigate to first sub-option if exists
          if (subSistemas.subopciones && subSistemas.subopciones.length > 0) {
            const firstSubOption = subSistemas.subopciones[0];
            if (firstSubOption.opci_href !== this.$route.path) {
              // this.$router.push({ path: firstSubOption.opci_href });
            }
          }
        }

    },
  },
}
</script>

<style>

</style>