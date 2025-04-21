<template>
    <v-card elevation="1">
        <v-card-title class="pt-2 pb-0 primary--text subtitle-1 font-weight-bold">{{ title }}</v-card-title>
        <v-card-text class="pb-2">
            <v-row no-gutters>
                
                <v-col cols="12" md="4">
                    <filter-component-v-1 :baseFilters="baseFilters" :showMasFiltros="true" />
                </v-col>
                <slot name="filterCustom"></slot>
            </v-row>
        </v-card-text>
    </v-card>
</template>

<script>
export default {
    props: ["title", "baseFilters"],
};
</script>

<style lang="scss" scoped></style>
