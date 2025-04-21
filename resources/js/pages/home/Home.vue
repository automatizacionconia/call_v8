<template>
  <div>
      <Dashboard></Dashboard>
      <!-- <v-row>
          <v-col>
              <stats-dashboard-cards></stats-dashboard-cards>
          </v-col>
      </v-row> -->
  </div>
</template>

<script>
import StatsDashboardCards from '@/pages/home/StatsDashboardCards.vue';
import Dashboard from './components/Dashboard.vue';
export default {
  components: {
      StatsDashboardCards,
      Dashboard
  },
  data: () => ({
  }),
  created(){
  }
}

</script>