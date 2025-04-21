<template>
  <v-dialog v-model="showOrHideAlert" max-width="30%" persistent>
    <v-card>
      <v-card-title class="color-entidad grey lighten-2" primary-title>
        ¡Atenci&oacute;n!
      </v-card-title>

      <v-card-text>
        <div v-if="getErrors">
          <ul v-for="(item, i) in getErrors" :key="i">
            <li>{{ item }}</li>
          </ul>
        </div>
      </v-card-text>

      <v-divider></v-divider>

      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="entidad" text @click="showOrHideAlert = !showOrHideAlert"
          >Ok</v-btn
        >
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters({
      getAlert: "alert/getAlert",
      getErrors: "alert/getErrors",
    }),
    showOrHideAlert: {
      get() {
        return this.getAlert;
      },
      set(value) {
        this.$store.commit("alert/setAlert", value);
      },
    },
  },
};
</script>

<style lang="scss" scoped></style>
