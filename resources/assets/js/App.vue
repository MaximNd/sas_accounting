<template>
  <v-app v-if="$auth.ready() && loaded">
    <template v-if="$auth.check()">
        <appNavigation>
            <router-view :key="$route.fullPath"></router-view>
        </appNavigation>
    </template>
    <template v-else>
        <router-view :key="$route.fullPath"></router-view>
    </template>
  </v-app>
</template>

<script>
import Navigation from './components/Navigation/Navigation';

export default {
    data() {
        return {
            loaded: false
        };
    },
    created() {
        this.$auth.ready(() => {
        this.loaded = true;
        //   this.$store.dispatch('fetchUser')
        //     .then(() => {
        //       this.loaded = true;
        //     })
        //     .catch(() => {
        //       this.$router.push({ name: 'login' })
        //       this.loaded = true;
        //     });
        });
    },
    components: {
        appNavigation: Navigation
    }
}

</script>


<style>



</style>
