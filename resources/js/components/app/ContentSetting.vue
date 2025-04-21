<template>
    <div>
        <v-list-item>
            <v-list-item-content>
            <v-list-item-title class="text-h6">
                Configuración
            </v-list-item-title>
            <v-list-item-subtitle>
                Secciones
            </v-list-item-subtitle>
            </v-list-item-content>
            <v-spacer></v-spacer>
            <v-btn icon @click="close"><v-icon>mdi-window-close</v-icon></v-btn>
        </v-list-item>
        <v-divider></v-divider>

        <v-list dense>
            <v-list-item three-line>
            <v-list-item-content>
                <v-list-item-title>Temas</v-list-item-title>
                <v-list-item-subtitle>Personalice su experiencia navegando con temas claros y oscuros
                </v-list-item-subtitle>
            </v-list-item-content>
            </v-list-item>
            <v-list-item>
                <v-btn-toggle v-model="theme" mandatory>
                    <v-btn value="light"><v-icon>mdi-white-balance-sunny</v-icon>Claro</v-btn>
                    <v-btn value="dark"><v-icon>mdi-weather-night</v-icon>Oscuro</v-btn>
                </v-btn-toggle>
            </v-list-item>
        </v-list>
    </div>
</template>
<script>
export default {
    data() {
        return {
            theme: "light",
            drawerSetting: false,
        };
    },
    methods: {
        close() {
            this.drawerSetting = false;
        },
    },
    watch: {
        theme(val) {
            if (val === "dark") {
                this.$vuetify.theme.dark = true;
            } else {
                this.$vuetify.theme.dark = false;
            }
        },
    },
};
</script>