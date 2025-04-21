<template>
  <v-app id="inspire">
    <!-- <Announcement v-if="showAnnouncement" @close="showAnnouncement = false"></Announcement> -->
    <v-main>
      <Header :toggledDrawerState="toggledDrawerState" @toggle-drawer="toggleDrawer"></Header>
      <Navbar :toggledDrawerState="toggledDrawerState"></Navbar>
    
      <transition name="fade">
        <div class="px-2 py-2">
          <router-view></router-view>
        </div>
      </transition>
    </v-main>
    <Footer></Footer>
  </v-app>
</template>

<script>
import Navbar from "@/components/app/Navbar.vue";
import Header from "@/components/app/Header.vue";
import Footer from "@/components/app/Footer.vue";
import Announcement from "@/components/app/Announcement.vue";

export default {
  components: {
    Navbar,
    Header,
    Footer,
    Announcement
  },
  data: () => ({
    showAnnouncement: true,
    toggledDrawerState: false
  }),
  methods: {
    toggleDrawer() {
      this.toggledDrawerState = !this.toggledDrawerState;
    }
  }
};
</script>