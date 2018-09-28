<template>
    <v-layout class="page" id="page-3" wrap>
        <appServiceTitle title="Підключення <br> до платформи SASAGRO.COM" />
        <appPrice
        :price="price"
        :coordinates="{ left: 0, top: '678px' }"
        :wrapperStyles="{ fontSize: '36px', width: '338px', height: '88px', backgroundColor: '#009769' }"
        :priceStyles="{ text: { 'font-size': '44px', 'margin-top': '20px' }, currency: { 'margin-top': '12px' } }" />
    </v-layout>
</template>


<script>
import ServiceTitle from './../serviceTitle/ServiceTitle';
import Price from './../price/Price';

export default {
    props: {
        price: {
            required: true
        }
    },
    components: {
        appServiceTitle: ServiceTitle,
        appPrice: Price
    }
}
</script>

<style scoped>
    #page-3 {
        background-image: url('/storage/image12_.jpg');
        background-size: 102% 101%;
        background-position-x: 100%;
    }
</style>
