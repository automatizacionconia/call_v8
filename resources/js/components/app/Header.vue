<template>
    <div>
      <!-- clipped-left -->
      <v-app-bar app color="primary" dark elevation="2">
        <v-app-bar-nav-icon @click.stop="toggledDrawerState = !toggledDrawerState">
          <v-icon>{{ toggledDrawerState ? 'mdi-close' : 'mdi-menu' }}</v-icon>
        </v-app-bar-nav-icon>

        <div class="d-flex align-center" v-if="!toggledDrawerState">
          <v-img alt="Vuetify Logo" class="shrink mr-2" contain 
          :src="logoIcon" transition="scale-transition" width="50" />
        </div>

        <v-toolbar-title>{{ appName }}</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items>
  
          <v-flex class="d-flex align-center">
            <v-btn icon @click="toggleTheme">
              <v-icon>{{ getModoOscuro ? 'mdi-white-balance-sunny' : 'mdi-weather-night' }}</v-icon>
            </v-btn>
  
            <!-- Menu notificacion -->
  
          </v-flex>
  
          <v-menu offset-y
          max-width="300px"
          >
            <template v-slot:activator="{on}">
                <v-list-item two-line v-on="on" style="width: 300px;">
                  <v-list-item-avatar>
                    <v-img :src="logoUser" transition="scale-transition"  size="30"></v-img>
                  </v-list-item-avatar>

                  <v-list-item-content>
                    <v-list-item-title>{{ usuario }}</v-list-item-title>
                    <v-list-item-subtitle>{{ perfil }}</v-list-item-subtitle>
                  </v-list-item-content>
              </v-list-item>
            </template>

            <v-list dense>
              <v-subheader>Accesos directos</v-subheader>
              <v-list-item-group
                v-model="selectedSoporte"
                color="primary"
              >

                  <v-list-item
                  v-on:click.prevent="showModalCabiarPassword = true"
                  v-show="true"
                  >
                    <v-list-item-icon>
                      <v-icon>mdi-lock</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                      <v-list-item-title>
                        Cambiar contraseña
                      </v-list-item-title>
                    </v-list-item-content>
                  </v-list-item>

                  <v-list-item v-on:click.prevent="logout()">
                    <v-list-item-icon>
                      <v-icon>mdi-logout</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                      <v-list-item-title>
                        Cerrar sesión
                      </v-list-item-title>
                    </v-list-item-content>
                  </v-list-item>

              </v-list-item-group>
            </v-list>
  
          </v-menu>
          <v-dialog v-model="showModalCabiarPassword" max-width="500px" persistent>
            <change-password
              @close="showModalCabiarPassword = false"
            ></change-password>
        </v-dialog>

        </v-toolbar-items>
      </v-app-bar>
  
    </div>
  </template>
  <script>
  import { mapGetters, mapMutations, mapActions } from "vuex";
  import { environment } from "@/environment";
  import { UserService } from "@/services/user.service";
  import { UtilService } from "@/services/util.service";
  import ChangePassword from "@/components/shared/User/ChangePassword";

  export default {
    components: {
      ChangePassword,
    },
    data: () => ({
      environment: environment,
      selectedSoporte:null,
      showModalCabiarPassword: false,
    }),
    computed: {
      ...mapGetters({
        getDrawer: "app/getDrawer",
        getProfile: "user/getProfile",
        getModoOscuro: "app/getModoOscuro",
        getArrayPermisos: "navbar/getArrayPermisos",
        getSelectSistema: "navbar/getSelectSistema",
        getLeyendaSelected: "navbar/getLeyendaSelected",
      }),
      ...mapGetters("navbar", ["menus"]),
      toggledDrawerState: {
        get() {
            return this.getDrawer;
        },
        set(value) {
            this.$store.commit("app/setDrawer", value);
        },
      },
      appName() {
          return environment.appName;
      },
      usuario() {
        return this.getProfile.PERS_NOMBRES_COMPLETO;
      },
      perfil() {
        return this.getProfile.PERF_NOMBRE;
      },
      unreadList() {
        return this.notifications.filter(n => !n.read);
      },
      readList() {
        return this.notifications.filter(n => n.read);
      },
      unreadNotifications() {
        return this.unreadList.length;
      },
      logoIcon() {
        return `${environment.baseUrl}/public/img/logo-icon.png`;
      },
      logoUser() {
        return `${environment.baseUrl}/public/img/persona.png`;
      },
    },
    methods: {
      ...mapMutations({
            setModoOscuro: "app/setModoOscuro",
            setSelectSistema: "navbar/setSelectSistema",
      }),
      ...mapActions("header", ["setSelectSistema"]),
      toggleTheme() {
        const nuevoEstado = !this.getModoOscuro;
        this.setModoOscuro(nuevoEstado);
        this.$vuetify.theme.dark = nuevoEstado;
      },
      async logout() {
        try {
          UtilService.showLoader();
          await UserService.logout();
          await UserService.clearAccesos();
          this.$store.dispatch('navbar/clearData');
          window.location.href = environment.baseUrl;

        } catch (error) {
          UtilService.showErrors(error);
        } finally {
          UtilService.hideLoader();
        }
      },
    },
    created() {
        this.$vuetify.theme.dark = this.getModoOscuro;
    },
  }
  </script>
  <style scoped>
  .vibrate {
    animation: vibrate 0.3s ease infinite;
  }
  
  @keyframes vibrate {
    0% { transform: translate(0px, 0px); }
    25% { transform: translate(2px, 2px); }
    50% { transform: translate(0px, 2px); }
    75% { transform: translate(2px, 0px); }
    100% { transform: translate(0px, 0px); }
  }
  </style>