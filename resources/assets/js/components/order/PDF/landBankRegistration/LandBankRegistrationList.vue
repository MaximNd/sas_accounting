<template>
    <v-layout class="page" id="page-5">
        <appLeftImage image="/storage/image31.jpeg" size="cover" positionX="75%" />
        <appServiceData :data="data" />
    </v-layout>
</template>

<script>
import LeftImage from './../leftImage/LeftImage';
import ServiceData from './../serviceData/ServiceData';

export default {
    data() {
        return {
            data: {
                title: 'Облік земельного банку',
                data: [
                    { icon: '/storage/image32.png', text: 'Створення векторного (цифрового) шару' },
                    { icon: '/storage/image34.png', text: 'Тренінги по роботі з модулем' },
                    { icon: '/storage/image33.png', text: 'Початкове налаштування системи' }
                ],
                price: 0.6,
                listOffset: '65px',
                titleOffset: '70px',
                iconWidth: '9%',
                coordinates: { left: '378px', top: '670px' },
                wrapperStyles: { fontSize: '20px', width: '200px', height: '70px', backgroundColor: '#009769' },
                priceStyles: { text: { 'font-size': '31px', 'margin-top': '20px' }, currency: { 'margin-left': '2px', 'margin-top': '12px', 'font-size': '26px' } }
            }
        };
    },
    components: {
        appLeftImage: LeftImage,
        appServiceData: ServiceData
    }
}
</script>

<style scoped>

</style>
