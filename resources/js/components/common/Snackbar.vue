<template>
  <v-snackbar
    v-model="showOrHideSnackbar"
    :bottom="false"
    :left="false"
    :multi-line="true"
    :right="true"
    :timeout="5000"
    :top="true"
    :vertical="false"
    color=""
  >
    !Su operación se ha realizado con exíto!
    <v-btn dark text @click.prevent="showOrHideSnackbar = !showOrHideSnackbar"
      >Cerrar</v-btn
    >
  </v-snackbar>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters({
      getSnackbar: "snackbar/getSnackbar",
    }),
    showOrHideSnackbar: {
      get() {
        return this.getSnackbar;
      },
      set(value) {
        this.$store.commit("snackbar/setSnackbar", value);
      },
    },
  },
};
</script>

<style lang="scss" scoped></style>
