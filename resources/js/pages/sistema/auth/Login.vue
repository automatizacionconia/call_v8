<template>
        <v-container fluid class="fill-height pa-0">
            <v-row no-gutters class="justify-center">
                <v-col cols="12" md="4" class="align-center login">
                    <div class="pa-12 login-form-container">
                        <div class="text-center mb-4">
                            <v-img
                            :src="logo"
                            max-height="50"
                            contain
                            class="mb-4 mx-auto"
                            ></v-img>
                            <h1 class="text-h5 font-weight-bold mb-2">¡Bienvenido de nuevo!</h1>
                            <p class="text-subtitle-1 grey--text text--lighten-1">Inicie sesión en su cuenta</p>
                        </div>
                        <v-form v-model="valid" ref="form" lazy-validation @submit.prevent="login">
                            <v-text-field
                                v-model="auth.username"
                                label="Usuario"
                                prepend-inner-icon="mdi-email"
                                required
                                outlined
                                dense
                                hide-details
                                class="mb-4"
                                :rules="rules"
                            ></v-text-field>
                            <v-text-field
                                v-model="auth.password"
                                label="Password"
                                prepend-inner-icon="mdi-lock"
                                :type="showPassword ? 'text' : 'password'"
                                :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                                @click:append="showPassword = !showPassword"
                                required
                                outlined
                                dense
                                hide-details
                                class="mb-2"
                                :rules="rules"
                            ></v-text-field>
                            <div class="d-flex justify-space-between align-center mb-6">
                            <v-btn 
                                text 
                                small 
                                color="primary"
                                :to="{ name: 'app.recuperar' }"
                                >
                                ¿Olvidó la contraseña? 
                            </v-btn>
                            </div>
                            <v-btn
                                color="primary"
                                block
                                x-large
                                type="submit"
                                height="56"
                                class="font-weight-bold"
                            >
                            INICIAR SESIÓN
                            </v-btn>
                        </v-form>
                    </div>
                </v-col>
            </v-row>
        </v-container>
</template>

<script>
import Ls from "@/services/ls";
import { environment } from "@/environment";
import { UserService } from "@/services/user.service";
import { UtilService } from "@/services/util.service";

import { mapGetters, mapActions } from "vuex";
export default {
    name: "Login",
    data() {
        return {
            rules: [(v) => !!v || "Campo requerido."],
            valid: false,
            showPassword: false,
            auth: {
                username: null,
                password: null,
            },
            entidades: [],
            rightSideStyle: {
                minHeight: '100vh'
            },
        }
    },
    async created() {

    },
    computed: {
        ...mapGetters({
            getColorEntidad: "color/getColorEntidad",
        }),
        icon() {
            return this.password_visible ? "mdi-eye" : "mdi-eye-off";
        },
        logo() {
            return `${environment.baseUrl}/public/img/logo-light.png`;
        },
    },
    methods: {
        ...mapActions({
            getParametrosGeneral: "parametro/getParametrosGeneral",
        }),
        async login() {
            if (this.$refs.form.validate()) {
                try {
                    UtilService.showLoader();
                    const loginResponse = await UserService.login(this.auth);

                    Ls.set("access_token", loginResponse.data.access_token);
                    Ls.set("claims", loginResponse.data.empresa[0].encryp);
                    
                    this.$store.commit("user/setProfile", loginResponse.data.user);
                    this.$store.commit("navbar/setArrayPermisos",loginResponse.data.permisos);
                    this.$store.dispatch("color/loadColor");

                    //this.$router.push({ name: "app.home" });

                    const firstValidRoute = this.findFirstValidRoute(loginResponse.data.permisos);
                    if (firstValidRoute) {
                        this.$router.push(firstValidRoute);
                    } else {
                        this.$router.push({ name: "error.403" }); // O una página de error
                    }

                } catch (error) {
                    UtilService.showErrors(error);
                } finally {
                    UtilService.hideLoader();
                }
            }
        },
        findFirstValidRoute(permisos) {
            for (const opcion of permisos) {
                if (opcion.opci_href) {
                    return opcion.opci_href; // Si tiene un href válido, retornamos la ruta
                }

                if (opcion.subopciones && opcion.subopciones.length > 0) {
                    const subRuta = this.findFirstValidRoute(opcion.subopciones);
                    if (subRuta) {
                        return subRuta; 
                    }
                }
            }
            return null;
        },
    },
};
</script>

<style scoped>
.bg-image {
    background-repeat: no-repeat;
    background-position: center center;
    background-attachment: fixed;

    background-size: cover;
}


.left-content {
    background-color: #f0f0f0;
}

.right-content {
    background-color: #ffffff;
}
.texto-recupera {
    font-size: 14px;
}
@media screen and (max-width: 1150px) {
    .responsive-left {
        display: none;
    }
    .flex.sm3 {
        flex-basis: 100%;
        max-width: 100%;
    }
}
.bg-menu{
    background-color: rgb(17 68 121);
}
.login {
    border: solid white 3px;
    box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
    padding: 1px;
    margin-top: 20px;
    border-radius: 5px;
}
.container-login{
    padding: 0px;
}
.card-servicios {
  transition: all 0.3s ease-in-out;
}

.card-servicios:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 20px rgba(0, 0, 0, 0.1);
}
.login-form-container {
    width: 100%;
}
</style>
