<template>
    <v-container fluid v-if="$auth.ready()">
        <v-navigation-drawer :width="navigationDrawerWidth" :clipped="!smAndDown" v-model="drawer" app dark>
            <v-list v-if="xsOnly">
                <v-list-tile avatar to="/profile" active-class="">
                    <v-list-tile-avatar>
                        <img style="object-fit: cover;width: 40px;height: 40px;" :src="`/storage/${$auth.user().image}`" alt="avatar">
                    </v-list-tile-avatar>
                    <v-list-tile-content>
                        <v-list-tile-title>
                            {{ `${$auth.user().last_name} ${$auth.user().first_name} ${$auth.user().mid_name}` }}
                        </v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
            </v-list>
            <v-divider></v-divider>
            <v-list two-line dense>
                <v-list-tile class="white--text" active-class="menu-active" v-for="(item, index) in menuItems" :key="index" :to="item.link">
                    <v-list-tile-action
                        :style="{
                            'font-size': $vuetify.breakpoint.lgAndDown ? '30px !important' : false
                        }">
                        <v-icon
                            :large="$vuetify.breakpoint.lgAndDown"
                            :x-large="$vuetify.breakpoint.xlOnly">{{ item.icon }}</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content
                        :style="{
                            'font-size': $vuetify.breakpoint.lgAndDown ? '12px' : '15px',
                            'margin-left': $vuetify.breakpoint.lgAndDown ? false : '10px'
                        }">
                        <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
            </v-list>
        </v-navigation-drawer>
        <v-toolbar dark fixed app :clipped-left="!smAndDown">
            <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>

            <v-spacer></v-spacer>
            <v-toolbar-items v-if="!xsOnly">
                <v-btn flat to="/profile" active-class="">
                    <span style="font-size:12px !important;" class="mr-3">{{ `${$auth.user().last_name} ${$auth.user().first_name} ${$auth.user().mid_name}` }}</span>
                    <v-avatar
                        :size="38"
                        color="grey lighten-4" >
                        <img style="object-fit: cover;width: 38px;height: 38px;" :src="`/storage/${$auth.user().image}`" alt="avatar">
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
    computed: {
        xsOnly() {
            return this.$vuetify.breakpoint.xsOnly;
        },
        smAndDown() {
            return this.$vuetify.breakpoint.smAndDown;
        },
        navigationDrawerWidth() {
            if (this.$vuetify.breakpoint.lgOnly) {
                return 240;
            }
            return 300;
        }
    },
    methods: {
        initMenuItems() {
            this.menuItems = [
                { title: 'Профиль', icon: 'portrait', link: `/profile` },
                { title: 'Заказы', icon: 'event', link: `/orders` },
                { title: 'Создать заказ', icon: 'border_color', link: '/create-order' },
                { title: 'Сотрудники', icon: 'account_circle', link: '/users' },
                { title: 'Клиенты', icon: 'work', link: '/clients' },
                { title: 'Прайслист', icon: 'assignment', link: '/price-list' },
                { title: 'История заказов', icon: 'restore', link: '/orders-history' },
                { title: 'История прайслиста', icon: 'restore', link: '/price-list-history' }
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
