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

    .bg-primary {
        width: 100%;
        height: 100vh;
        background: rgb(8,54,94);
        background: linear-gradient(40deg, rgba(8,54,94,1) 0%, rgba(32,100,151,1) 100%);
        background-size: cover;
    }

</style>
