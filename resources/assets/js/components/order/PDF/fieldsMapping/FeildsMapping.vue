<template>
    <v-layout class="page">
        <appLeftImage image="/storage/image22.jpeg" size="cover" positionX="75%" />
        <appServiceData :data="byDrones ? drones : physicalMeasure" />
    </v-layout>
</template>

<script>
import LeftImage from './../leftImage/LeftImage';
import ServiceData from './../serviceData/ServiceData';

export default {
    props: {
        price: {
            required: true
        },
        byDrones: {
            type: Boolean,
            required: true
        }
    },
    computed: {
        drones() {
            return {
                title: 'Картування полів',
                subtitle: 'Дронами',
                data: [
                    { icon: '/storage/image23.png', text: 'Обліт' },
                    { icon: '/storage/image24.png', text: 'Зшиття' },
                    { icon: '/storage/image25.png', text: 'Точкування' },
                    { icon: '/storage/image26.png', text: 'Результат' },
                    { icon: '/storage/image27.png', text: 'Точність 10 см' },
                    { icon: '/storage/image27.png', text: 'Створення ортофотоплану' },
                    { icon: '/storage/image28.png', text: 'Висока ціна' },
                    { icon: '/storage/image28.png', text: 'Мала швидкість обміру' }
                ],
                price: this.price || '0',
                coordinates: { left: '378px', top: '670px' },
                wrapperStyles: { fontSize: '20px', width: '200px', height: '70px', backgroundColor: '#009769' },
                priceStyles: { text: { 'font-size': '31px', 'margin-top': '20px' }, currency: { 'margin-left': '2px', 'margin-top': '12px', 'font-size': '26px' } }
            };
        },
        physicalMeasure() {
            return {
                title: 'Картування полів',
                subtitle: 'Фізичний обмір',
                data: [
                    { icon: '/storage/image23.png', text: 'Об\'їзд' },
                    { icon: '/storage/image25.png', text: 'Точкування' },
                    { icon: '/storage/image26.png', text: 'Результат' },
                    { icon: '/storage/image27.png', text: 'Швидка обробка результату' },
                    { icon: '/storage/image27.png', text: 'Низька ціна' },
                    { icon: '/storage/image28.png', text: 'Точність 15см' },
                    { icon: '/storage/image28.png', text: 'Неможливість обміру за наявності посівів' }
                ],
                price: this.price || '0',
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
