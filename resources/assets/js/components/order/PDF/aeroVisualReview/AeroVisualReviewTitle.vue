<template>
    <v-layout class="page" id="page-14" wrap>
        <appServiceTitle title="Аеровізуальний огляд" bold />
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
    #page-14 {
        background-image: url('/storage/image60.png');
        background-size: 141% 101%;
        background-position-x: 60%;
    }
</style>
