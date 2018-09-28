<template>
    <v-layout class="page" id="page-11">
        <appLeftImage image="/storage/image46.jpg" size="350% 101%" positionX="55%" />
        <appServiceData :data="data" />
    </v-layout>
</template>

<script>
import LeftImage from './../leftImage/LeftImage';
import ServiceData from './../serviceData/ServiceData';

export default {
    props: {
        price: {
            required:true
        }
    },
    computed: {
        data() {
            return {
                title: 'Патрулювання',
                data: [
                    { icon: '/storage/image47.png', text: 'Узгодження потенційно небезпечних територій' },
                    { icon: '/storage/image48.png', text: 'Здійснення патрулювання посівів' },
                    { icon: '/storage/image49.png', text: 'У разі виявлення порушників інформування служби безпеки господарства' },
                    { icon: '/storage/image50.png', text: 'Звіт про виконану роботу' }
                ],
                price: this.price || '0',
                listOffset: '65px',
                titleOffset: '70px',
                iconWidth: '9%',
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
