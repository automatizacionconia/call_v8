<template>
  <v-menu
        v-model="notificationsMenu"
        :close-on-content-click="false"
        offset-y
        max-width="400px"
        transition="slide-y-transition"
    >
        <template v-slot:activator="{ on, attrs }">
        <v-btn icon v-bind="attrs" v-on="on">
            <template v-if="unreadNotifications > 0">
            <v-badge color="red" :content="unreadNotifications">
                <v-icon>mdi-bell-ring-outline</v-icon>
            </v-badge>
            </template>
            <template v-else>
            <v-icon>mdi-bell-ring-outline</v-icon>
            </template>
        </v-btn>
        </template>

        <v-card>
        <v-toolbar flat color="primary" dark>
            <v-toolbar-title>Notifications</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn icon @click="notificationsMenu = false">
            <v-icon>mdi-close</v-icon>
            </v-btn>
        </v-toolbar>

        <v-list dense>
            <v-subheader>No leído</v-subheader>
            <v-divider></v-divider>
            <v-list-item
            v-for="(notification, index) in unreadList"
            :key="index"
            @click="markAsRead(index)"
            >
            <v-list-item-avatar>
                <v-icon>{{ notification.icon }}</v-icon>
            </v-list-item-avatar>
            <v-list-item-content>
                <v-list-item-title>{{ notification.title }}</v-list-item-title>
                <v-list-item-subtitle>{{ notification.content }}</v-list-item-subtitle>
                <v-list-item-subtitle class="text--secondary">{{ notification.date }}</v-list-item-subtitle>
            </v-list-item-content>
            </v-list-item>

            <v-subheader>Leídos</v-subheader>
            <v-divider></v-divider>
            <v-list-item
            v-for="(notification, index) in readList"
            :key="index"
            >
            <v-list-item-avatar>
                <v-icon>{{ notification.icon }}</v-icon>
            </v-list-item-avatar>
            <v-list-item-content>
                <v-list-item-title>{{ notification.title }}</v-list-item-title>
                <v-list-item-subtitle>{{ notification.content }}</v-list-item-subtitle>
                <v-list-item-subtitle class="text--secondary">{{ notification.date }}</v-list-item-subtitle>
            </v-list-item-content>
            </v-list-item>
        </v-list>
        </v-card>
    </v-menu>
</template>

<script>
export default {
    data() {
        return {
            notificationsMenu: false,
            notifications: [
                {
                    title: 'Notification 1',
                    content: 'Content 1',
                    date: '2021-01-01',
                    icon: 'mdi-account'
                },
                {
                    title: 'Notification 2',
                    content: 'Content 2',
                    date: '2021-01-02',
                    icon: 'mdi-account'
                },
                {
                    title: 'Notification 3',
                    content: 'Content 3',
                    date: '2021-01-03',
                    icon: 'mdi-account'
                },
                {
                    title: 'Notification 4',
                    content: 'Content 4',
                    date: '2021-01-04',
                    icon: 'mdi-account'
                },
                {
                    title: 'Notification 5',
                    content: 'Content 5',
                    date: '2021-01-05',
                    icon: 'mdi-account'
                },
            ],
            unreadList: [],
            readList: []
        }
    },
}
</script>

<style>

</style>