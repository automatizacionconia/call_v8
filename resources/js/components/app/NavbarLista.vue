<template>
  <v-list class="grow bg-navbar" dense nav dark>
    <v-list-item class="px-2">
      <v-img
        max-height="50"
        max-width="230"
        :src="logo"
        transition="scale-transition"
      ></v-img>
      </v-list-item>
      <v-divider></v-divider>

    <selectdSistema />
    
    <v-divider></v-divider>

    <template v-if="getArraySubSistema && getArraySubSistema.length > 0">
      <div
        v-for="(leyenda, index) in getArraySubSistema"
        :key="index"
      >
        <!-- <v-list-item><v-chip color="success" class="ma-2" small><v-icon left>mdi-access-point</v-icon>{{ leyenda.opci_nombre }}</v-chip></v-list-item> -->

        <v-divider></v-divider>

        <v-list-group
          v-for="(nav_list, groupIndex) in leyenda.subopciones"
          :key="groupIndex"
          :append-icon="nav_list.subopciones.length > 0 ? undefined : ''"
          color="accent"
          no-action
          :value="nav_list.subopciones.length > 0 ? isActiveGroup(nav_list) : undefined"
        >
          <template v-slot:activator>
            <v-list-item
              :to="
                nav_list.subopciones.length === 0
                  ? { path: nav_list.opci_href }
                  : undefined
              "
              :class="{
                'v-list-item--active':
                  isActiveItem(nav_list) && nav_list.subopciones.length === 0,
              }"
              link
            >
              <v-list-item-icon>
                <v-icon>{{ nav_list.opci_icon ?? "mdi-chevron-right" }}</v-icon>
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title>{{ nav_list.opci_nombre }}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </template>

          <v-list-item
            v-for="(list, itemIndex) in nav_list.subopciones"
            :key="`${groupIndex}-${itemIndex}`"
            link
            :to="{ path: list.opci_href }"
            exact
            exact-active-class="v-list-item--active"
          >
            <v-list-item-content>
              <v-list-item-title>
                <v-icon>{{
                  list.opci_icon ?? "mdi-subdirectory-arrow-right"
                }}</v-icon>
                {{ list.opci_nombre }}
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-group>
      </div>
    </template>
    <template v-else>
      <v-list-item>No sub-systems available</v-list-item>
    </template>
  </v-list>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import selectdSistema from "./SelectedSistema.vue";
import { environment } from "@/environment";
export default {
  components: {
    selectdSistema,
  },
  data: () => ({
    miniVariant: true,
    innerDrawerVisible: true,
    togleMenus: true,
    itemLeyendas: [],
    nav_lists: [],
    items: [],
    activeMenus: {},
    environment: environment,
  }),
  computed: {
    ...mapGetters({
      getSelectSistema: "navbar/getSelectSistema",
      getArrayPermisos: "navbar/getArrayPermisos",
      getArraySubSistema: "navbar/getArraySubSistema",
    }),
    isActiveGroup() {
      return (nav_list) =>
        nav_list.subopciones.some((list) => list.opci_href === this.$route.path);
    },
    isActiveItem() {
  return (list) => decodeURIComponent(list.opci_href) === decodeURIComponent(this.$route.path);
},
    logo() {
        return `${environment.baseUrl}/public/img/logo-dark.png`;
    },
  },
  methods: {
    handleNavigation(href) {
      if (href && href !== this.$route.path) {
        this.$router.push({ path: href });
      }
    },
  },
};
</script>

<style>
.v-list-group__header.v-list-item--link:hover::before {
  opacity: 0.08;
}

/* Mantiene solo el hover del v-list-item dentro del activator */
.v-list-group__header .v-list-item:hover::before {
  opacity: 0 !important;
}
</style>