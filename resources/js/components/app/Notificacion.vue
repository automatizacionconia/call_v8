
<template>
    <div class="notificaciones-container">
      <v-btn
        elevation="5"
        small
        fab
        icon
        @click="drawerNotificacion = !drawerNotificacion"
      >
        <v-badge
          color="red"
          :content="notificacionesNoLeidas.toString()"
          :value="notificacionesNoLeidas > 0"
        >
          <v-icon :class="{'vibrate': notificacionesNoLeidas > 0}">
            mdi-bell-ring-outline
          </v-icon>
        </v-badge>
      </v-btn>
  
      <v-navigation-drawer
        v-model="drawerNotificacion"
        fixed
        right
        temporary
        width="400"
        class="notificaciones-drawer"
        :style="{ height: '100vh', top: '0', zIndex: 9999 }"
        style="z-index: 9999;"
        light
      >
        <v-toolbar color="primary" dark class="notificaciones-header" flat>
          <v-avatar size="32" class="mr-2">
            <v-icon>mdi-bell</v-icon>
          </v-avatar>
          <v-toolbar-title>Notificaciones</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-btn icon @click="drawerNotificacion = false">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-toolbar>
  
        <v-list class="notificaciones-list" dense>
          <v-list-item
            v-for="(item, index) in to5notificaciones"
            :key="item.COD_NOTIFICACION + '-' + index"
            @click="marcarLeidoNotificacion(item)"
            class="notificacion-item"
            :class="{'notificacion-no-leido': item.LEIDO == 0}"
          >
            <v-list-item-content>
              <v-list-item-title class="font-weight-bold">{{ item.TITULO }}</v-list-item-title>
              <v-list-item-subtitle class="text-wrap mt-1">
                {{ item.DES_CONTENIDO }}
              </v-list-item-subtitle>
              <v-list-item-subtitle class="text-caption mt-1">
                {{ formatDate(item.FEC_NOTIFICA) }}
              </v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
        </v-list>
  
        <template v-slot:append>
          <v-divider></v-divider>
          <v-card-actions class="justify-center pa-4">
            <v-btn text color="primary" >
              Ver todas las notificaciones
            </v-btn>
          </v-card-actions>
        </template>
      </v-navigation-drawer>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
    data() {
        return {
            selectedItems: [],
            searchMenu:[],
            notifiaciones:{},
            drawerNotificacion: false,
        }
    },
    created() {
    },
    mounted() {
        this.notifiaciones = this.getNotificacion.filter(x=>x.LEIDO==0);
    },
    computed: {
        ...mapGetters({
            getNotificacion: "user/getNotificacion",
            getarraycurrentMenu: "nabvar/getarraycurrentMenu",
            getarraycurrentMenuOrigen:"nabvar/getarraycurrentMenuOrigen",
            getProfile: "user/getProfile",
        }),
        to5notificaciones() {
            let data = this.getNotificacion.filter(x=>x.LEIDO==0);
            data.sort((a, b) => new Date(b.FEC_NOTIFICA) - new Date(a.FEC_NOTIFICA));
            return data.slice(0, 5);
        },
        notificacionesNoLeidas() {
            const notificacionesNoLeidas = this.getNotificacion.filter(item => item.LEIDO === 0);
            return notificacionesNoLeidas.length;
        },
    },
    methods: {
        ...mapActions({
            initializeSocket: 'websocket/initializeSocket'
        }),
        async marcarLeidoNotificacion(item) {
            const params = {
                COD_NOTIFICACION: item.COD_NOTIFICACION,
            };
            if(item.LEIDO==0){
                let response = await axios.post(`api/notificacion/marcar-leido`, params);
                if(response.data.status){
                    var data = this.getNotificacion;

                    const index = data.findIndex(items => items.COD_NOTIFICACION === item.COD_NOTIFICACION);
                    if (index !== -1) {
                        data[index].LEIDO = 1;
                        this.$store.commit("user/setNotificacion", data);
                        setTimeout(() => {
                            this.$root.$emit('ws-casilla-leido', item);
                        }, 800);
                    }
                }
            }
        },
        formatDate(date) {
            return moment(date).format('DD/MM/YYYY hh:mm A');
        },
    }
};
</script>

<style scoped>
    .notificacion-leido{
        background-color: #63687726!important;
    }
    .vibrate {
        animation: vibrate-animation 0.5s infinite alternate;
    }

    @keyframes vibrate-animation {
        from {
            transform: rotate(-10deg);
        }
        to {
            transform: rotate(10deg);
        }
    }

.notificaciones-drawer {
    display: flex;
    flex-direction: column;
    box-shadow: none !important;
    z-index: 5 !important;
}
.notificacion-item{
    margin: 15px;
    border: 1px solid #bcbbbb;
    border-radius: 5px;
}
.notificacion-no-leido{
    background-color: #f5f5f5;
}
</style>
