<template>
    <v-layout class="page">
        <appLeftImage image="/storage/image102.jpg" size="cover" />
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
                title: 'Інженерна служба',
                data: [
                    { icon: '/storage/image103.png', text: 'Установка та налаштування GPS-трекерів' },
                    { icon: '/storage/image104.png', text: 'Встановлення та заміна SIM-карт' },
                    { icon: '/storage/image105.png', text: 'Технічка підтримка (ремонт та обслуговування обладнання навігації, виїзд впродовж 72 год.)' }
                ],
                price: this.price || '0',
                listOffset: '20px',
                titleOffset: '60px',
                iconWidth: '10%',
                coordinates: { left: '179px', top: '670px' },
                wrapperStyles: { fontSize: '20px', width: '200px', height: '70px', backgroundColor: 'rgba(136, 207, 215, 0.84)' },
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
