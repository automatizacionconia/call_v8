<template>
  <v-app dark :style="{ backgroundColor: backgroundColor }">
    <router-view></router-view>
    <alert></alert>
    <loader></loader>
    <snackbar></snackbar>
  </v-app>
</template>

<script>
import { mapGetters } from "vuex";
import Alert from "./../js/components/common/Alert";
import Loader from "./../js/components/common/Loader";
import Snackbar from "./../js/components/common/Snackbar";

export default {
  name: "App",
  components: {
    Alert,
    Loader,
    Snackbar,
  },
  computed: {
    ...mapGetters({
      backgroundColor: "color/getColorMain",
    }),
  },
};
</script>
