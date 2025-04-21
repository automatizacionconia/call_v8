<template>
    <v-container fluid>
      <v-row>
        <v-col v-for="(stat, index) in stats" :key="index" cols="12" sm="6" md="3">
          <v-card elevation="2" class="pa-4">
            <div class="d-flex align-center mb-2">
              <v-icon :color="stat.iconColor" class="mr-2">{{ stat.icon }}</v-icon>
              <span class="caption grey--text">{{ stat.title }}</span>
            </div>
            <v-card-text class="pa-0">
              <div class="d-flex justify-space-between align-center">
                <div>
                  <div class="text-h5 font-weight-bold">{{ stat.value }}</div>
                  <div class="caption grey--text">vs last month: {{ stat.lastMonth }}</div>
                </div>
                <v-chip
                  :color="stat.change >= 0 ? 'success' : 'error'"
                  text-color="white"
                  small
                  class="font-weight-bold"
                >
                  {{ stat.change >= 0 ? '+' : '' }}{{ stat.change }}%
                </v-chip>
              </div>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </template>
  
  <script>
  export default {
    data() {
      return {
        stats: [
          {
            title: 'Active Sales',
            value: '$5,762 USD',
            lastMonth: '$4,712 USD',
            change: 2.65,
            icon: 'mdi-currency-usd',
            iconColor: 'primary',
          },
          {
            title: 'Revenue Sales',
            value: '$90,000 USD',
            lastMonth: '$77,000 USD',
            change: -6.25,
            icon: 'mdi-chart-line',
            iconColor: 'info',
          },
          {
            title: 'New Sales',
            value: '$2,400 USD',
            lastMonth: '$1,620 USD',
            change: 30.25,
            icon: 'mdi-tag-plus',
            iconColor: 'success',
          },
          {
            title: 'Total Sales',
            value: '$2,500 USD',
            lastMonth: '$2,900 USD',
            change: -8.40,
            icon: 'mdi-calculator',
            iconColor: 'warning',
          },
        ],
      };
    },
  };
  </script>
  
  <style scoped>
  .v-card {
    transition: all 0.3s;
  }
  .v-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.1) !important;
  }
  </style>