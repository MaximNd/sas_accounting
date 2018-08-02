<template>
    <v-container fluid>
        <v-navigation-drawer :temporary="this.$vuetify.breakpoint.smAndDown" :clipped="clipped" v-model="drawer" app dark>
            <v-list>
                <!-- <v-divider></v-divider> -->
                <v-list-tile v-for="(item, index) in menuItems" :key="index" :to="item.link">
                    <v-list-tile-action>
                        <v-icon x-large light>{{ item.icon }}</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
            </v-list>
        </v-navigation-drawer>
        <v-toolbar dark fixed app :clipped-left="clipped">
            <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
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

        }
    },
    created() {
        console.log(this.$auth.user().last_name);
    }
}
</script>
