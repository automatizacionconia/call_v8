<template>
  <v-container>
    <v-card class="pa-4">
      <v-card-title>📞 Historial de Llamadas - {{ item.clie_nombres }}</v-card-title>
      <v-divider></v-divider>

      <v-expansion-panels accordion class="mt-4">
        <v-expansion-panel 
          v-for="(llamada, index) in dataLlamadas" 
          :key="index"
        >
          <v-expansion-panel-header>
            <v-row align="center">
              <v-col cols="2" class="text-center">
                  <v-icon small>mdi-phone</v-icon>
              </v-col>
              <v-col cols="10">
                <strong>{{ llamada.date_start_format }}</strong>
                <div class="text-caption">Estado: 
                  <v-chip :color="getStatusColor(llamada.call_status)" small dark>
                    {{ llamada.call_status }}
                  </v-chip>
                </div>
              </v-col>
            </v-row>
          </v-expansion-panel-header>

          <v-expansion-panel-content>
            <v-card class="pa-4" outlined>
              <v-row>
                <v-col cols="6">
                  <v-icon small color="cyan">mdi-clock-outline</v-icon>
                  <strong> Duración:</strong> {{ formatDuracion(llamada.duration_ms) }}
                </v-col>
                <v-col cols="6">
                  <v-icon small color="lime">mdi-phone-forward</v-icon>
                  <strong> De:</strong> {{ llamada.from_number }} → {{ llamada.to_number }}
                </v-col>
                <v-col cols="12">
                  <v-icon small color="orange">mdi-comment-text-outline</v-icon>
                  <strong> Transcripción:</strong>
                  <p class="text-caption mt-1 grey--text">{{ llamada.transcript }}</p>
                </v-col>
                <v-col cols="12" class="text-center">
                  <audio 
                  ref="audio" 
                  :src="llamada.recording_url"
                  v-if="llamada.recording_url"
                  controls
                  ></audio>
                  <!-- <v-btn 
                    v-if="llamada.recording_url"
                    :color="llamada.call_status === 'ended' ? 'green' : 'red'"
                    dark
                    :href="llamada.recording_url" 
                    target="_blank"
                    elevation="2"
                    rounded
                  >
                    <v-icon left>mdi-download</v-icon>
                    <span class="text-caption">Descargar audio</span>  
                  
                  </v-btn> -->
                </v-col>
              </v-row>
            </v-card>
          </v-expansion-panel-content>
        </v-expansion-panel>
      </v-expansion-panels>
    </v-card>
  </v-container>
</template>
  
  <script>
  import { UtilService } from "@/services/util.service";
  import { CarteraService } from '../services/cartera.service';
  export default {
    props: {
      item: Object
    },
    data: () => ({
      dataLlamadas: [],
    }),
    methods: {
      async llamadasTelefono(item) {
        try {
            UtilService.showLoader();
            const response = await CarteraService.llamadasTelefono(item);
            this.dataLlamadas = response.data.data;
        }catch(error){
            UtilService.showErrors(error);
        }finally{
            UtilService.hideLoader();
        }
      },
      formatDuracion (duracion) {
        const minutos = Math.floor(duracion / 60000);
        const segundos = ((duracion % 60000) / 1000).toFixed(0);
        return `${minutos} min ${segundos} seg`;
      },
      getStatusColor (status) {
        switch (status) {
          case "ended": return "green";
          case "missed": return "red";
          case "ringing": return "orange";
          default: return "blue-grey";
        }
      }
    },
    mounted() {
      this.llamadasTelefono(this.item);
    },
    created() {
    },
  };
  </script>
  