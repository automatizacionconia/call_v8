<template>
    <v-main class="bg-menu">
        <v-container fill-height>
            <v-row align-center justify-center>
                <v-col
                    cols="12"
                    md="4"
                    offset-md="4"
                    class="d-flex justify-center"
                >
                    <v-card
                        :style="{
                            width: height,
                        }"
                        class="card-login"
                    >
                        <v-card-title class="text-center justify-center primary" style="padding: 2px 3px 8px 3px;color: #fff;">
                            <img
                                :src="logo"
                                alt=""
                                width="50%"
                                
                            />
                        </v-card-title>
                        <v-card-text class="pa-5 text-center">
                            <h1 class="text-h5 warning--text font-weight-bold">
                                <v-icon color="warning">mdi-alert</v-icon> Estimado usuario, el sistema se encuentra en mantenimiento, por favor intente más tarde.
                            </h1>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-main>
</template>
<script>

import { environment } from "@/environment";
import { mapGetters, mapActions } from "vuex";
export default {
    name: "Mantenimiento",
    data() {
        return {
            rules: [(v) => !!v || "Campo requerido."],
        };
    },
    async created() {
        await this.getParametrosGeneral();
    },
    computed: {
        ...mapGetters({
            getColorEntidad: "color/getColorEntidad",
        }),
        icon() {
            return this.password_visible ? "mdi-eye" : "mdi-eye-off";
        },
        fondo() {
            return `${environment.baseUrl}/public/img/fondo-menu.jpg`;
        },
        version() {
            return environment.version;
        },
        logo() {
            return `${environment.baseUrl}/public/img/logo.png`;
        },
        height() {
            return "100%";
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
.left-content,
.right-content {
    height: 100vh;
    display: flex;
    align-items: center;
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
.card-login {
    border: solid white 3px;
    box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
    padding: 1px;
    margin-top: 20px;
}
</style>