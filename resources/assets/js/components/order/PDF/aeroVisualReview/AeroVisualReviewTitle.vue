<template>
    <v-layout class="page" id="page-14" wrap>
        <appServiceTitle title="Аеровізуальний огляд" bold />
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
    #page-14 {
        background-image: url('/storage/image60.png');
        background-size: 141% 101%;
        background-position-x: 60%;
    }
</style>
