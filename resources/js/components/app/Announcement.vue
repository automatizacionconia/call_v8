<template>
    <v-system-bar color="primary" dark height="auto" class="px-4 py-2">
      <v-row align="center" no-gutters>
        <v-col cols="auto" class="mr-3">
          <v-avatar size="32">
            <v-img src="https://i.pravatar.cc/30" alt="Vuetify Logo"></v-img>
          </v-avatar>
        </v-col>
        <v-col>
          <span class="text-body-1 font-weight-medium">Vuetify - State of the Union 2024</span>
          <br>
          <span class="text-caption">Catch up on the journey, new features, and future plans for Vuetify, including our roadmap and community highlights. Let's build the next chapter together!</span>
        </v-col>
        <v-col cols="auto">
          <v-btn color="white" outlined small @click="$emit('close')">
            Learn More
            <v-icon right small>mdi-open-in-new</v-icon>
          </v-btn>
        </v-col>
      </v-row>
    </v-system-bar>
  </template>
  
  <script>
  export default {
    name: 'Announcement'
  }
  </script>