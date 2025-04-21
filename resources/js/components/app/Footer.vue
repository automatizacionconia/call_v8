<template>
    <v-footer>
      <v-col class="text-center">
        Copyright <a href="https://www.linkedin.com/in/juctan/" target="_blank">©</a> {{ year }} {{ appName }}
      </v-col>
    </v-footer>
</template>

<script>
import { mapGetters } from "vuex";
import { environment } from "@/environment";
export default {
    data() {
        return {
            year: null,
        };
    },
    mounted() {
        const d = new Date();
        this.year = d.getFullYear();
    },
    computed: {
        ...mapGetters({}),
        appName() {
            return environment.appName;
        },
        version() {
            return environment.version;
        },
    },
};
</script>

<style lang="scss" scoped></style>
