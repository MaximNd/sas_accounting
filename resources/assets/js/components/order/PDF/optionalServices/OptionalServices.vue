<template>
    <v-layout class="page" id="page-22">
        <appLeftImage image="/storage/image98.jpg" size="350% 101%" positionX="3%" />
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
                data: [
                    // { icon: '/storage/image47.png', text: 'Узгодження потенційно небезпечних територій' },
                    // { icon: '/storage/image48.png', text: 'Здійснення патрулювання посівів' },
                    // { icon: '/storage/image49.png', text: 'У разі виявлення порушників інформування служби безпеки господарства' },
                    // { icon: '/storage/image50.png', text: 'Звіт про виконану роботу' }
                ],
                listOffset: '65px'
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
