<template>
    <v-layout class="page" id="page-12">
        <appLeftImage image="/storage/image51.jpg" size="101%" positionX="60%" positionY="61%" />
        <appServiceData :data="data" />
    </v-layout>
</template>

<script>
import LeftImage from './../leftImage/LeftImage';
import ServiceData from './../serviceData/ServiceData';

export default {
    props: {
        price: {
            required: true
        }
    },
    computed: {
        data() {
            return {
                title: 'NDVI',
                data: [
                    { icon: '/storage/image52.png', text: 'Cканування полів' },
                    { icon: '/storage/image54.png', text: 'Обробка знімків та сворення ортофотопланів  полів' },
                    { icon: '/storage/image55.png', text: 'Розрахунок індексів вегетайції' },
                    { icon: '/storage/image53.png', text: 'Завантаження готового матеріалу в систему Cropio' }
                ],
                price: this.price || '0',
                listOffset: '45px',
                titleOffset: '80px',
                iconWidth: '10%',
                coordinates: { left: '378px', top: '670px' },
                wrapperStyles: { fontSize: '20px', width: '200px', height: '70px', backgroundColor: '#009769' },
                priceStyles: { text: { 'font-size': '31px', 'margin-top': '20px' }, currency: { 'margin-left': '2px', 'margin-top': '12px', 'font-size': '26px' } }
            };
        }
    },
    components: {
        appLeftImage: LeftImage,
        appServiceData: ServiceData
    }
}
</script>

<style scoped>

</style>
