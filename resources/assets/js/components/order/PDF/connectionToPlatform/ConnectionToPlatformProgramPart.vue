<template>
    <v-layout class="page" id="page-4">
        <appLeftImage image="/storage/image20____.jpg" size="102%" positionX="55%" />
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
                title: 'Програмна частина',
                data: [
                    { icon: '/storage/image13.png', html: 'Внесення <span style="font-family: ProximaNovaBold; font-size: 22px">електронної карти полів</span> <br> до системи Cropio' },
                    { icon: '/storage/image17.png', html: 'Підключення модулю <span style="font-family: ProximaNovaBold; font-size: 22px">GPS-моніторингу</span>' },
                    { icon: '/storage/image14.png', html: 'Проведення <span style="font-family: ProximaNovaBold; font-size: 22px">тренінгів для персоналу</span> <br> по користуванню Системою' },
                    { icon: '/storage/image15.png', html: 'Надання <span style="font-family: ProximaNovaBold; font-size: 22px">космічних знімків</span> з низькою <br> та високою роздільною здатністю' },
                    { icon: '/storage/image18.png', html: 'Надання <span style="font-family: ProximaNovaBold; font-size: 22px">аналітичної інформації</span> щодо вегетації, вологості <br> ґрунту, температури повітря та ґрунту, накопичених та щоденних опадів з 2002 року' },
                    { icon: '/storage/image19.png', html: '<span style="font-family: ProximaNovaBold; font-size: 22px">Можливість</span> планування агроробіт, ведення історії поля та <br> управління використанням ТМЦ' },
                    { icon: '/storage/image16.png', html: '<span style="font-family: ProximaNovaBold; font-size: 22px">Прогнозування</span> врожайності' }
                ],
                iconWidth: '9%',
                listMarginLeft: '20px'
            }
        };
    },
    components: {
        appLeftImage: LeftImage,
        appServiceData: ServiceData
    }
}
</script>
