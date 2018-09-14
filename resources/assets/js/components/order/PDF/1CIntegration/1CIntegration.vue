<template>
    <v-layout class="page">
        <appLeftImage image="/storage/image89.jpeg" size="300% 101%" positionX="54%" />
        <appServiceData :data="data" grid />
    </v-layout>
</template>

<script>
import LeftImage from './../leftImage/LeftImage';
import ServiceData from './../serviceData/ServiceData';

export default {
    data() {
        return {
            data: {
                title: '1С інтеграція',
                subtitle: 'Система Cropio має можливість двосторонньої інтеграції даних з 1С',
                data: [
                    { icon: '/storage/image90.png', text: 'КУЛЬТУРИ' },
                    { icon: '/storage/image91.png', text: 'НАСІННЯ' },
                    { icon: '/storage/image92.png', text: 'ДОБРИВА' },
                    { icon: '/storage/image93.png', text: 'ХІМІКАТИ' },
                    { icon: '/storage/image94.png', text: 'АГРООПЕРАЦІЇ' },
                    { icon: '/storage/image95.png', text: 'ЗВІТИ ОГЛЯДУ ПОЛІВ' },
                    { icon: '/storage/image96.png', text: 'МАШИНИ І ОБЛАДНАННЯ' },
                    { icon: '/storage/image97.png', text: 'ЗАВДАННЯ МАШИН' }
                ],
                listOffset: '20px',
                titleOffset: '60px'
            }
        };
    },
    components: {
        appLeftImage: LeftImage,
        appServiceData: ServiceData
    }
}
</script>
