<template>
  <div>
    <v-menu offset-y>
      <template v-slot:activator="{ on }">
        <v-btn dark icon v-on="on">
          <v-icon>mdi-dots-vertical</v-icon>
        </v-btn>
      </template>
      <v-card class="mx-auto" max-width="300" tile>
        <v-img max-height="150" max-width="500" :src="empresaLogo"></v-img>
        <v-col>
          <Avatar />
        </v-col>
        <v-list-item color="rgba(0, 0, 0, .4)">
          <v-list-item-content>
            <v-list-item-title class="title">{{ usuario }}</v-list-item-title>
            <v-list-item-subtitle>{{ empresa }}</v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
      </v-card>

      <v-list dense>
        <v-list-item @click="openColorDialog">
          <v-list-item-content>
            <v-list-item-title>
              <v-icon>mdi-format-color-fill</v-icon> Color de la entidad
            </v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-item @click="abrirModal">
          <v-list-item-content>
            <v-list-item-title>
              <v-icon>mdi-account-check</v-icon> Actualizar datos
            </v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item
          v-on:click.prevent="showModalCabiarPassword = true"
          v-show="true"
        >
          <v-list-item-title>
            <v-icon>mdi-lock</v-icon> Cambiar contraseña
          </v-list-item-title>
        </v-list-item>

        <v-list-item v-on:click.prevent="logout()">
          <v-list-item-title>
            <v-icon>mdi-logout</v-icon> Cerrar sesión
          </v-list-item-title>
        </v-list-item>
      </v-list>
    </v-menu>

    <v-dialog v-model="showModalCabiarPassword" max-width="500px" persistent>
      <change-password
        @close="showModalCabiarPassword = false"
      ></change-password>
    </v-dialog>

    <v-dialog v-model="colorDialog" persistent max-width="350">
      <v-card>
        <v-card-title>
          <v-icon>mdi-format-color-fill</v-icon> Color de la entidad
        </v-card-title>
        <v-card-text>
          <v-color-picker
            v-model="color"
            hide-inputs
            hide-canvas
            hide-sliders
            show-swatches
          ></v-color-picker>
        </v-card-text>
        <v-card-actions>
          <v-btn @click="colorDialog = false" color="primary" outlined
            >Cerrar</v-btn
          >
          <v-btn @click="resetearColor" color="primary" outlined
            >Resetear color</v-btn
          >
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog  v-model="showModalDatos"
            transition="dialog-top-transition"
            max-width="600"
            persistent
        >
            <v-card>
            <v-toolbar
            color="primary"
            dark
            > <v-icon left dark>mdi-account-check</v-icon> Actualizar datos
            <v-spacer></v-spacer>
            <v-toolbar-items>
                <v-btn icon dark @click="showModalDatos = false;resetValor();">
                <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-toolbar-items>

            </v-toolbar>
            <v-card-text>
              <v-row>
                <v-col cols="12" md="12" class="item-form my-0 align-self-lg-baseline mb-4">
                        <v-checkbox
                          v-model="notificarmeModel"
                          label="Deseo recibir notificaciones electrónicas a través de los siguientes medios"
                          dense
                          hide-details
                          @change="guardarNotificacion"
                        ></v-checkbox>
                    </v-col>
              </v-row>
              <v-stepper v-model="e1">
                <v-stepper-header>
                  <v-stepper-step
                    :complete="e1 > 1"
                    step="1"
                  >
                    Datos personales
                  </v-stepper-step>

                  <v-divider></v-divider>

                  <v-stepper-step
                    :complete="e1 > 2"
                    step="2"
                  >
                    Verificación de codigo
                  </v-stepper-step>
                </v-stepper-header>

                <v-stepper-items>
                  <v-stepper-content step="1">
                    <v-form
                        v-model="validForm"
                        ref="form"
                        lazy-validation
                        autocomplete="off">
                      <v-container>
                        <v-row no-gutters>
                          <v-col cols="12" md="6" class="item-form pl-1 my-0 align-self-lg-baseline">
                              <v-subheader>
                                  N° Celular:
                              </v-subheader>
                          </v-col>
                          <v-col cols="12" md="6" class="item-form pl-1 my-0 mb-sm-n2">
                              <v-text-field
                                  v-mask="'#########'"
                                  type="number"
                                  label="N° Celular"
                                  outlined
                                  dense
                                  clearable
                                  hide-details
                                  v-model="model.nro_celular"
                                  :rules="validacion.rules_celular"
                              >
                              </v-text-field>
                          </v-col>
                          <v-col cols="12" md="6" class="item-form pl-1 my-0 align-self-lg-baseline">
                              <v-subheader>
                                  Correo electrónico:
                              </v-subheader>
                          </v-col>
                          
                          <v-col cols="12" md="6" class="item-form pl-1 my-0 mb-sm-n2">
                              <v-text-field
                                  type="text"
                                  label="Correo electrónico"
                                  outlined
                                  dense
                                  clearable
                                  hide-details
                                  v-model="model.correo_electronico"
                                  :rules="validacion.rules_correo"
                              >
                              </v-text-field>
                          </v-col>
              
                      </v-row>
                      </v-container>
                      </v-form>


                    <v-btn
                      color="primary"
                      @click="e1 = 2;solicitarCodigo()"

                    >
                    Continuar
                    </v-btn>
                  </v-stepper-content>

                  <v-stepper-content step="2">
                    <v-row class="mb-4">
                      <v-col cols="12" md="8" class="item-form pl-1 my-0 align-self-lg-baseline">
                              <v-subheader>
                                  Ingrese código de verificación, enviado a su correo electrónico / celular (whatsapp)
                              </v-subheader>
                          </v-col>
                          <v-col cols="12" md="4" class="item-form pl-1 my-0 align-self-lg-baseline text-end">
                                <v-text-field
                                    type="text"
                                    label="Código de verificación"
                                    outlined
                                    dense
                                    clearable
                                    hide-details
                                    v-model="model.codigo_verificacion"
                                    :rules="validacion.rules_codigo"
                                >
                                </v-text-field>
                          </v-col>
                    </v-row>

                    <v-btn
                      color="primary"
                      @click="validarCodigo()"
                    >
                      Validar y guardar
                    </v-btn>
                    <v-btn text
                      @click="e1 = 1"
                    >
                      Regresar
                    </v-btn>
                  </v-stepper-content>
                </v-stepper-items>
              </v-stepper>

            </v-card-text>
            </v-card>
        </v-dialog>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

import { UserService } from "@/services/user.service";
import ChangePassword from "@/components/shared/User/ChangePassword";
import { environment } from "@/environment";
import { UtilService } from "@/services/util.service";
import Avatar from "./Avatar";
export default {
  components: {
    ChangePassword,
    Avatar,
  },

  data() {
    return {
      showModalCabiarPassword: false,
      valmodulos: null,
      colorDialog: false,
      showChangePhotoButton: false,
      showModalDatos: false,
      validForm: false,
      notificarmeModel: false,
      model: {
        nro_celular: "",
        correo_electronico: "",
        codigo_verificacion: "",
      },
      verificar: false,
      e1: 1,
      validacion: {
        rules_celular: [
          (v) => !!v || "Este campo es requerido",
          (v) => (v && v.length >= 9) || "Debe tener 9 dígitos",
        ],
        rules_correo: [
          (v) => !!v || "Este campo es requerido",
          (v) => /.+@.+\..+/.test(v) || "Correo electrónico inválido",
        ],
        rules_codigo: [
          (v) => !!v || "Este campo es requerido",
          (v) => (v && v.length >= 4) || "Debe tener 4 dígitos",
        ],
      },
    };
  },
  computed: {
    ...mapGetters({
      getProfile: "user/getProfile",
      getColor: "color/getColor"
    }),
    empresaLogo() {
      return this.getProfile.empresa_logo;
    },
    empresa() {
      return this.getProfile.empresa;
    },
    usuario() {
      return this.getProfile.usuario;
    },
    celular() {
      return this.getProfile.celular;
    },
    email() {
      return this.getProfile.email;
    },
    color: {
      get() {
        return this.getColor;
      },
      set(v) {
          this.$store.dispatch("color/changeColor", v, { root: true });
      },
    },
    notificarme() {
      return this.getProfile.notificarme;
    },
  },
  created() {
    this.model.nro_celular = this.celular;
    this.model.correo_electronico = this.email;
    this.notificarmeModel = this.notificarme;
  },
  methods: {
    async logout() {
      try {
        UtilService.showLoader();
        await UserService.logout();
        await UserService.clearAccesos();
        window.location.href = environment.baseUrl;

      } catch (error) {
        UtilService.showErrors(error);
      } finally {
        UtilService.hideLoader();
      }
    },
    openColorDialog() {
      this.colorDialog = true;
    },
    async validarCodigo() {
      try {
        if(this.model.codigo_verificacion == ""){
          this.$store.commit("snackbar/setSnackbar", {
            show: true,
            text: "Debe ingresar un código de verificación",
            color: "error",
          });
          return;
        }

        this.$store.commit("loader/setLoader", true);
        const response = await UserService.validarCodigo(this.model);
        if(response.status == 200){
          this.actualizarDatos();
          this.model.codigo_verificacion = "";
          this.verificar = false;
        }else{
          this.$store.commit("snackbar/setSnackbar", {
            show: true,
            text: "Código de verificación incorrecto",
            color: "error",
          });
        }
        
      } catch (error) {
        UtilService.showErrors(error);
      } finally {
        this.$store.commit("loader/setLoader", false);
      }
    },
    async actualizarDatos() {
      try {
        let self = this;

            if (self.$refs.form.validate()) {
              this.$store.commit("loader/setLoader", true);
              const response = await UserService.actualizarDatos(this.model);
              this.model.codigo_verificacion = "";
              this.verificar = false;

              this.showModalDatos = false;
              this.$store.commit("snackbar/setSnackbar", {
                show: true,
                text: "Datos actualizados correctamente",
                color: "success",
              });
            }
        
      } catch (error) {
        UtilService.showErrors(error);
      } finally {
        this.$store.commit("loader/setLoader", false);
      }
    },
    resetearColor() {
      this.$store.dispatch("color/resetColor");
    },
    async solicitarCodigo(){
      try {
        if(this.model.nro_celular == "" || this.model.correo_electronico == ""){
          this.$store.commit("snackbar/setSnackbar", {
            show: true,
            text: "Debe ingresar un número de celular y correo electrónico",
            color: "error",
          });
          this.e1 = 1;
          return;
        }
        this.$store.commit("loader/setLoader", true);
        
        const response = await UserService.solicitarCodigo(this.model);
        this.verificar = true;
        this.$store.commit("snackbar/setSnackbar", {
          show: true,
          text: "Código enviado correctamente",
          color: "success",
        });

      } catch (error) {
        UtilService.showErrors(error);
      } finally {
        this.$store.commit("loader/setLoader", false);
      }
    },
    async guardarNotificacion() {
      
      let valInt = this.notificarmeModel ? 1 : 0;
      const response = await UserService.actualizarNotificarme(
        { notificarme: valInt }
      );
      this.$store.commit("user/setNotificarme", this.notificarmeModel);
    },
    resetValor() {
      this.model.nro_celular = this.celular;
      this.model.correo_electronico = this.email;
      this.e1 = 1;
    },
    abrirModal() {
      this.showModalDatos = true;
      this.e1=1;
    },
  },
};
</script>

<style lang="scss" scoped></style>
