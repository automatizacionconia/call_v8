<template>
  <v-card>
    <v-card-title class="headline grey lighten-2" primary-title
      >Cambiar contraseña</v-card-title
    >
    <v-card-text>
      <v-form v-model="validForm" ref="form" lazy-validation>
        <v-container grid-list-md>
          <v-layout row wrap>
            <v-flex xs12>
              <strong>Seguridad de la contraseña:</strong><br />
              Usa al menos 8 caracteres. No uses una contraseña de otro sitio ni
              algo demasiado obvio.
            </v-flex>
            <v-flex xs12>
              <v-text-field
                v-model="model.password"
                label="Contraseña nueva"
                :append-icon="icon"
                @click:append="() => (password_visible = !password_visible)"
                :type="!password_visible ? 'password' : 'text'"
                :rules="rules"
                outlined
                hide-details
              >
              </v-text-field>
            </v-flex>
            <v-flex xs12>
              <v-text-field
                v-model="model.password_confirmation"
                label="Confirma la nueva contraseña"
                :append-icon="icon"
                @click:append="() => (password_visible = !password_visible)"
                :type="!password_visible ? 'password' : 'text'"
                :rules="[passwordConfirmationRule]"
                outlined
                hide-details
              >
              </v-text-field>
            </v-flex>
          </v-layout>
        </v-container>
      </v-form>
    </v-card-text>

    <v-divider></v-divider>

    <v-card-actions class="text-right">
      <v-btn color="entidad" dark @click="cambiarPassword()"
        >Cambiar la contraseña</v-btn
      >
      <v-btn depressed outlined @click="close()">Cancelar</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import { UserService } from "@/services/user.service";
// import { ErrorService } from "@/services/common/error.service";
import { environment } from "@/environment";

export default {
  data() {
    return {
      rules: [(v) => !!v || "Campo reqerido."],
      environment: environment,
      validForm: false,
      model: {
        password: null,
        password_confirmation: null,
      },
      password_visible: false,
    };
  },
  computed: {
    icon() {
      return this.password_visible ? "mdi-eye" : "mdi-eye-off";
    },
    passwordConfirmationRule() {
      return () =>
        this.model.password === this.model.password_confirmation ||
        "La contraseña debe coincidir.";
    },
  },
  methods: {
    async cambiarPassword() {
      if (this.$refs.form.validate()) {
        try {
          //   this.$store.commit("loader/setLoader", true);
          await UserService.changePassword(this.model);
          await UserService.logout();
          await UserService.clearAccesos();
          //   this.$store.commit("loader/setLoader", false);
          //   this.$store.commit("snackbar/setSnackbar", true);
          window.location.href = environment.APP_URL;
        } catch (error) {
          //   this.$store.commit("loader/setLoader", false);
          //   this.$store.commit("alert/setErrors", ErrorService.getToArray(error));
        }
      }
    },
    close() {
      this.$emit("close");
    },
  },
};
</script>

<style lang="scss" scoped></style>
