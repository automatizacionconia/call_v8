<template>
  <v-overlay :value="getLoader">
    <v-dialog v-model="getLoader" persistent width="300">
      <v-card dark>
        <v-card-text>
          Por favor espere...
          <v-progress-linear
            indeterminate
            color="white"
            class="mb-0"
          ></v-progress-linear>
        </v-card-text>
      </v-card>
    </v-dialog>
  </v-overlay>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters({
      getLoader: "loader/getLoader",
    }),
  },
};
</script>

<style lang="scss" scoped></style>
