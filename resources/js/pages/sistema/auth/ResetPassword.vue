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
                        <h1 class="text-h5 font-weight-bold mb-2">Recuperar Contraseña</h1>
                        <p class="text-subtitle-1 grey--text text--lighten-1">
                            Ingrese su correo electrónico para recuperar su contraseña
                        </p>
                    </div>
                    <v-form v-model="valid" ref="form" lazy-validation @submit.prevent="recuperar">
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
                        <div class="d-flex justify-space-between align-center mb-6">
                        <v-btn 
                            text 
                            small 
                            color="primary"
                            :to="{ name: 'login' }"
                            >
                            Ya recordé mi contraseña
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
                        Recuperar contraseña
                        </v-btn>
                    </v-form>
                </div>
            </v-col>
        </v-row>

        <v-dialog v-model="showSuccess" persistent width="600">
            <v-alert  border="left" color="entidad" prominent type="success" class="mb-0">
                <v-row align="center">
                    <v-col class="grow">
                        Se ha enviado su usuario y contraseña al correo <strong>
                            {{ auth.username }}</strong>
                    </v-col>
                    <v-col class="shrink">                        
                        <router-link :to="{ name: 'login' }"><v-btn>Ingresar</v-btn></router-link>
                    </v-col>
                </v-row>
            </v-alert>
        </v-dialog>  

    </v-container>
</template>

<script>
import Ls from "@/services/ls";
import { environment } from "@/environment";
import { UserService } from "@/services/user.service";
import { UtilService } from "@/services/util.service";

import { mapGetters, mapActions } from "vuex";
export default {
name: "Recuperar",
data() {
    return {
        rules: [(v) => !!v || "Campo requerido."],
        valid: false,
        auth: {
            username: null,
        },
        entidades: [],
        rightSideStyle: {
            minHeight: '100vh'
        },
        showSuccess: false,
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
    async recuperar() {
        if (this.$refs.form.validate()) {
            try {
                UtilService.showLoader();
                const recuperar = await UserService.resetPassword(this.auth);
                this.showSuccess = true;
                this.auth.username = null;
            } catch (error) {
                UtilService.showErrors(error);
            } finally {
                UtilService.hideLoader();
            }
        }
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
