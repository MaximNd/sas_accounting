<template>
    <v-layout class="page">
        <appLeftImage image="/storage/image77.jpeg" size="300% 101%" positionX="54%" />
        <appServiceData :data="data" withYara />
    </v-layout>
</template>

<script>
import LeftImage from './../leftImage/LeftImage';
import ServiceData from './../serviceData/ServiceData';

export default {
    data() {
        return {
            data: {
                title: 'Хімічний аналіз ґрунтів',
                data: [
                    { icon: '/storage/image78.png', text: 'Відбір проб' },
                    { icon: '/storage/image80.png', text: 'Доставка' },
                    { icon: '/storage/image79.png', text: 'Тестування' },
                    { icon: '/storage/image81.png', text: 'Рекомендації' },
                    { icon: '/storage/image83.png', text: 'Візуалізація' }
                ],
                price: 5,
                listOffset: '20px',
                titleOffset: '60px',
                iconWidth: '9%',
                coordinates: { left: '178px', top: '670px' },
                wrapperStyles: { fontSize: '20px', width: '200px', height: '70px', backgroundColor: 'rgba(205, 180, 56, 0.84)' },
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
