<template>
    <div>
        <v-card class="pa-2">
            <v-card-title class="text-h5">
            {{ titulo }}
            </v-card-title>
            <v-card-text>
            {{ descripcion }}
            </v-card-text>
            <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
                color="primary darken-1"
                text
                rounded
                @click="cancelar()"
            >Cancelar
            </v-btn>

            <v-btn
                color="error darken-1"
                rounded
                @click="eliminarRegistro()"
            >Eliminar el registro
            </v-btn>
            </v-card-actions>
        </v-card>
    </div>
</template>
<script>
export default {
    props: {
        titulo: {
            type: String,
            default: "¿Eliminar registro?",
        },
        descripcion: {
            type: String,
            default: "Esta acción no se puede deshacer. ¿Estás seguro de que quieres eliminar?",
        },
    },
    methods: {
        eliminarRegistro() {
            this.$emit("eliminarRegistro");
        },
        cancelar() {
            this.$emit("cancelarEliminar");
        },
    },
};
</script>