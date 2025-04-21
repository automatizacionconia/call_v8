<template>
    <div>
      <!-- Tabs -->
      <v-tabs v-model="tab" color="entidad" grow>
        <v-tab v-for="(item, index) in tabs" :key="index">
          {{ item.label }}
        </v-tab>
      </v-tabs>
  
      <v-tabs-items v-model="tab">
        <v-tab-item v-for="(item, index) in tabs" :key="index">
          <component :is="item.component" />
        </v-tab-item>
      </v-tabs-items>
    </div>
  </template>
  
  <script>
  import Individual from "./Individual.vue";
  import Masivo from "./Masivo.vue";
  
  export default {
    data() {
      return {
        tab: 0, // Index del tab seleccionado
        tabs: [
          { label: "Individual", component: "Individual" },
          { label: "Masivo", component: "Masivo" },
        ],
      };
    },
    components: {
      Individual,
      Masivo,
    },
  };
  </script>
  
  <style scoped></style>
  