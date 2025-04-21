<template>
    <v-list-item>
      <v-checkbox
        :label="item.opci_nombre"
        v-model="localCheckbox[item.opci_codigo]"
        @change="onCheckboxChange"
        :disabled="item.disabled"
      ></v-checkbox>
      <v-list v-if="item.children && item.children.length" dense>
        <nested-checkbox
          v-for="child in item.children"
          :key="child.opci_codigo"
          :item="child"
          v-model="localCheckbox"
          @change="onCheckboxChange"
        />
      </v-list>
    </v-list-item>
  </template>
  
  <script>
  export default {
    name: 'NestedCheckbox',
    props: {
      item: {
        type: Object,
        required: true,
      },
      value: {
        type: [Object, Array],
        required: true,
      },
    },
    data() {
      return {
        localCheckbox: this.value,
      };
    },
    methods: {
      onCheckboxChange() {
        this.$emit('input', this.localCheckbox);
        this.$emit('change', this.item);
      },
    },
    watch: {
      value: {
        deep: true,
        handler(newVal) {
          this.localCheckbox = newVal;
        },
      },
    },
  };
  </script>
  
  <style scoped>
  .v-list-item {
    margin-left: 16px; /* Indentación para simular la jerarquía */
  }
  </style>
  