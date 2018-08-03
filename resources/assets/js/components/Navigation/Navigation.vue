<template>
    <v-container fluid v-if="$auth.ready()">
        <v-navigation-drawer :temporary="this.$vuetify.breakpoint.smAndDown" :clipped="clipped" v-model="drawer" app dark>
            <v-list two-line>
                <v-list-tile class="white--text" active-class="menu-active" v-for="(item, index) in menuItems" :key="index" :to="item.link">
                    <v-list-tile-action>
                        <v-icon x-large>{{ item.icon }}</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
            </v-list>
        </v-navigation-drawer>
        <v-toolbar dark fixed app :clipped-left="clipped">
            <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>

            <v-spacer></v-spacer>
            <v-toolbar-items>
                <v-btn flat>
                    <span class="mr-3">{{ `${$auth.user().last_name} ${$auth.user().first_name} ${$auth.user().mid_name}` }}</span>
                    <v-avatar
                        :size="40"
                        color="grey lighten-4" >
                        <img src="/images/no-avatar.png" alt="avatar">
                    </v-avatar>
                </v-btn>
            </v-toolbar-items>
            <v-btn class="ml-2" icon @click="logOut">
                <v-icon>exit_to_app</v-icon>
            </v-btn>
        </v-toolbar>
        <v-content>
            <slot></slot>
        </v-content>
    </v-container>
</template>

<script>
export default {
    data () {
        return {
            drawer: true,
            clipped: true,
            menuItems: []
        }
    },
    methods: {
        initMenuItems() {
            this.menuItems = [
                { title: 'Профиль', icon: 'mdi-account-box-outline', link: `/profile/${this.$auth.user().id}` },
                { title: 'Заказы', icon: 'mdi-account-box-outline', link: `/test` }
            ];
        },
        logOut() {
            this.$auth.logout();
        }
    },
    created() {
        this.initMenuItems();
    }
}
</script>

<style>
    .menu-active {
        color: #000 !important;
        background-color: #fff !important;
    }
</style>
