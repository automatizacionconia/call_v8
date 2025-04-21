<template>
    <v-container>
      <v-row class="justify-center">
        <v-col cols="12" md="10">
          <v-row>
            <v-col cols="12">
              <v-card class="pa-5" elevation="3">
                <h2 class="font-weight-bold">
                  <v-icon left x-large>mdi-chart-bar</v-icon>
                  Dashboard de Llamadas</h2>
                <p class="text-subtitle-1">Resumen de llamadas de agentes</p>
              </v-card>
            </v-col>
          </v-row>
      
          <v-row>
            <v-col cols="12" md="3">
              <v-card class="pa-4" color="primary" dark>
                <h3>
                  <v-icon >mdi-phone</v-icon>
                  Total Llamadas</h3>
                <h1 class="text-h4">{{ totalCalls }}</h1>
              </v-card>
            </v-col>
      
            <v-col cols="12" md="3">
              <v-card class="pa-4" color="green darken-2" dark>
                <h3>
                  <v-icon >mdi-clock</v-icon>
                  Agentes activos</h3>
                <h1 class="text-h4">{{ agentesActivos }} IA</h1>
              </v-card>
            </v-col>
      
            <v-col cols="12" md="3">
              <v-card class="pa-4" color="blue darken-3" dark>
                <h3>
                  <v-icon >mdi-check-circle</v-icon>
                  Completadas</h3>
                <h1 class="text-h4">{{ completedCalls }}</h1>
              </v-card>
            </v-col>
      
            <v-col cols="12" md="3">
              <v-card class="pa-4" color="red darken-2" dark>
                <h3>
                  <v-icon >mdi-alert-circle</v-icon>
                  En Progreso</h3>
                <h1 class="text-h4">{{ ongoingCalls }}</h1>
              </v-card>
            </v-col>
          </v-row>
      
          <v-row>
            <v-col cols="12" md="6">
              <v-card class="pa-4">
                <h3 class="text-h6">
                  <v-icon >mdi-chart-bar</v-icon>
                  Llamadas por Estado</h3>
                <apexchart type="donut" :options="chartOptions" :series="callStatusData" width="500"></apexchart>
              </v-card>
            </v-col>
      
            <v-col cols="12" md="6">
              <v-card class="pa-4">
                <h3 class="text-h6">
                  <v-icon >mdi-calendar-clock</v-icon>Cantidad llamadas por semana</h3>
                <apexchart type="bar" :options="barChartOptions" :series="durationData" width="550"></apexchart>
              </v-card>
            </v-col>
          </v-row>
      
          <v-row>
            <v-col cols="12">
              <v-card class="pa-4">
                <h3 class="text-h6">
                  <v-icon >mdi-history</v-icon>
                  Últimas Llamadas</h3>
                <v-data-table :headers="headers" :items="recentCalls" class="elevation-1"></v-data-table>
              </v-card>
            </v-col>
          </v-row>
        </v-col>
      </v-row>
    </v-container>
  </template>
  
  <script>
  import { UtilService } from "@/services/util.service";
  import VueApexCharts from "vue-apexcharts";
  import { DashboardService } from "../services/dashboard.service";

  export default {
    components: {
      apexchart: VueApexCharts,
    },
    data() {
      return {
        totalCalls: 0,
        agentesActivos: 0,
        completedCalls: 0,
        ongoingCalls: 0,
  
        callStatusData: [],
        chartOptions: {
          chart: { type: "donut" },
          labels: [],
          colors: ["#4CAF50", "#FF9800", "#F44336"],
        },
  
        durationData: [
          {
            name: "Duración",
            data: [0, 0, 0, 0, 0, 0, 0], 
          },
        ],
        barChartOptions: {
          chart: { type: "bar" },
          xaxis: { categories: ["Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", "Dom"] },
          colors: ["#3F51B5"],
        },
  
        headers: [
          { text: "ID", value: "cart_codigo" },
          { text: "Agente", value: "agen_nombre" },
          { text: "Estado", value: "esta_nombre" },
          { text: "Grupo", value: "grup_nombre" },
        ],
        recentCalls: [],
      };
    },
    created() {
      this.getData();
    },
    methods: {
      async getData() {
            try {
                UtilService.showLoader();
                const response = await DashboardService.dashboard();
                this.totalCalls = response.data.data.total_carteras;
                this.completedCalls = response.data.data.total_completados;
                this.ongoingCalls = response.data.data.total_pendientes;
                this.recentCalls = response.data.data.detalle_carteras;
                this.agentesActivos = response.data.data.total_agentes;

                this.callStatusData = response.data.data.chart_status_values;
                this.chartOptions = {
                  ...this.chartOptions, 
                  labels: [...response.data.data.chart_status_labels]
                };
                
                this.durationData = [
                  {
                    name: "Cantidad",
                    data: [...response.data.data.cantidad_llamadas_values],
                  },
                ];
                // this.barChartOptions = {
                //   ...this.barChartOptions, 
                //   xaxis: {
                //     categories: [...response.data.data.cantidad_llamadas_labels],
                //   },
                // };

            }catch(error){
                UtilService.showErrors(error);
            }finally{
                UtilService.hideLoader();
            }
        },
    },
  };
  </script>
  
  <style scoped>
  .v-card {
    border-radius: 12px;
  }
  </style>
  