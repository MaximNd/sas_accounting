<template>
    <v-layout class="page" id="page-13">
        <appLeftImage image="/storage/image57.jpg" size="213%" positionX="40%" />
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
                title: 'Підрахунок всходів',
                data: [
                    { icon: '/storage/image52.png', text: 'Сканування частин полів (3-5га) на малих висотах - 20-30м' },
                    { icon: '/storage/image59.png', text: 'Створення ортофотоплану надвисокої роздільної здатності (0,5 см/пкс)' },
                    { icon: '/storage/image58.png', text: 'Аналіз та підрахунок кількості рослин' }
                ],
                price: this.price || '0',
                listOffset: '40px',
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
