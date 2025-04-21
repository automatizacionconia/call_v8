<template>
    <div>
        <v-card>
            <v-toolbar
            dense
            color="primary"
            dark
            elevation="0"
            >
            <v-toolbar-title>{{ title }}</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn icon @click="cancelar" small>
                <v-icon>mdi-close</v-icon>
            </v-btn>
            </v-toolbar>
            <v-card-text>
                <slot name="form"></slot>
            </v-card-text>
            <v-card-actions>
                <slot name="form_accion"></slot>
            </v-card-actions>
        </v-card>
    </div>
</template>
<script>
export default {
    props: ["title","hideClose"],
    methods: {
        cancelar() {
            this.$emit("cancelar");
        },
    },
};
</script>