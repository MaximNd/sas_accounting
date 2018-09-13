<template>
    <v-layout class="page" id="page-9" wrap>
        <appServiceTitle title="GPS <br>моніторинг" bold />
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
    #page-9 {
        background-image: url('/storage/image35.jpg');
        background-size: 102% 101%;
        background-position-x: 100%;
    }
</style>
