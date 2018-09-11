<template>
    <v-layout class="page" id="page-7" wrap>
        <appServiceTitle title="Облік земельного банку" bold />
    </v-layout>
</template>


<script>
import ServiceTitle from './../serviceTitle/ServiceTitle';
import Price from './../price/Price';

export default {
    components: {
        appServiceTitle: ServiceTitle,
        appPrice: Price
    }
}
</script>

<style scoped>
    #page-7 {
        background-image: url('/storage/image30.jpg');
        background-size: 102% 101%;
        background-position-x: 100%;
    }
</style>
