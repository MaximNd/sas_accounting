<template>
    <v-layout class="page">
        <appLeftImage image="/storage/image84.jpg" size="300% 101%" positionX="35%" />
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
                title: 'Хімічний аналіз ґрунтів',
                data: [
                    { icon: '/storage/image85.png', text: 'Вимірювання твердості ґрунту на різних глибинах (до 45см)' },
                    { icon: '/storage/image86.png', text: 'Прив\'язка GPS кординат до кожного виміру' },
                    { icon: '/storage/image87.png', text: 'Відправка даних на сервер через GSM ' },
                    { icon: '/storage/image88.png', text: 'Візуалізація карти щільності в Cropio' }
                ],
                price: this.price || '0',
                listOffset: '20px',
                titleOffset: '60px',
                iconWidth: '9%',
                coordinates: { left: '179px', top: '670px' },
                wrapperStyles: { fontSize: '20px', width: '200px', height: '70px', backgroundColor: 'rgba(205, 180, 56, 0.84)' },
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
