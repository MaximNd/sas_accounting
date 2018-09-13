<template>
    <v-layout class="page" style="background-color: #fff;">
        <appLeftImage :image="data[page].image" :size="data[page].imageSize" :positionX="data[page].imageX" :positionY="data[page].imageY" />
        <v-flex xs8>
            <v-layout column>
                <v-flex>
                    <v-layout column>
                        <v-flex>
                            <div :style="{ 'margin-top': data[page].titleOffset }" class="aero-data-title font-weight-medium">{{ data[page].data[0].title }}</div>
                        </v-flex>
                        <v-flex>
                            <div class="aero-data-img">
                                <img :src="data[page].data[0].image" alt="img">
                            </div>
                        </v-flex>
                        <v-flex>
                            <div>
                                <span
                                    v-for="(seasonsData, index1) in data[page].data[0].seasons"
                                    :key="`seasons-0-${page}-${index1}`"
                                    class="seasons"
                                    :style="{ 'margin-left': seasonsData.offset }">
                                    <template v-for="season in seasonsData.data">
                                        {{ season }}<template v-for="_ in spacesTimes">&nbsp;</template>
                                    </template>
                                </span>
                            </div>
                            <div style="display: flex;">
                                <div class="durability-data" v-for="(durabilityData, index) in data[page].data[0].durability" :key="`durability-0-${page}-${index}`">
                                    <div class="drone-durability" :style="{ 'margin-left': durabilityData.offset, 'width': durabilityData.width }"></div>
                                    <div class="drones">
                                        <img
                                            :style="{ 'margin-left': durabilityData.dronesOffset || durabilityData.offset }"
                                            :src="durabilityData.drones === 1 ? '/storage/image-drone.png' : '/storage/image-drones.png' "
                                            alt="drone">
                                    </div>
                                </div>
                            </div>
                        </v-flex>
                    </v-layout>
                </v-flex>
                <v-flex>
                    <v-layout column>
                        <v-flex>
                            <div :style="{ 'margin-top': data[page].titleOffset }" class="aero-data-title font-weight-medium">{{ data[page].data[1].title }}</div>
                        </v-flex>
                        <v-flex>
                            <div class="aero-data-img">
                                <img :src="data[page].data[1].image" alt="img">
                            </div>
                        </v-flex>
                        <v-flex>
                            <div>
                                <span
                                    v-for="(seasonsData, index1) in data[page].data[1].seasons"
                                    :key="`seasons-1-${page}-${index1}`"
                                    class="seasons"
                                    :style="{ 'margin-left': seasonsData.offset }">
                                    <template v-for="season in seasonsData.data">
                                        {{ season }}<template v-for="_ in spacesTimes">&nbsp;</template>
                                    </template>
                                </span>
                            </div>
                            <div style="display: flex;">
                                <div class="durability-data" v-for="(durabilityData, index) in data[page].data[1].durability" :key="`durability-1-${page}-${index}`">
                                    <div class="drone-durability" :style="{ 'margin-left': durabilityData.offset, 'width': durabilityData.width }"></div>
                                    <div class="drones">
                                        <img
                                            :style="{ 'margin-left': durabilityData.dronesOffset || durabilityData.offset }"
                                            :src="durabilityData.drones === 1 ? '/storage/image-drone.png' : '/storage/image-drones.png'"
                                            alt="drone">
                                    </div>
                                </div>
                            </div>
                        </v-flex>
                    </v-layout>
                </v-flex>
            </v-layout>
            <div class="aero-bottom-logo">
                <img src="/storage/image4.png" alt="logo">
            </div>
        </v-flex>
    </v-layout>
</template>

<script>
import LeftImage from './../leftImage/LeftImage';
import ServiceData from './../serviceData/ServiceData';

export default {
    props: {
        page: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            data: {
                first: {
                    image: '/storage/image65.jpg',
                    imageSize: '185% 101%',
                    imageX: '29%',
                    imageY: '75%',
                    titleOffset: '25px',
                    data: [
                        {
                            title: 'Озима пшениця',
                            image: '/storage/image61.png',
                            seasons: [{ offset: '56px', data: ['Жовт.', 'Листоп.'] }, { offset: '116px', data: ['Берез.', 'Квіт.', 'Трав.'] }],
                            durability: [{ offset: '65px', width: '100px', drones: 1 }, { offset: '142px', width: '145px', drones: 1 }]
                        },
                        {
                            title: 'Ріпак',
                            image: '/storage/image63.png',
                            seasons: [{ offset: '40px', data: ['Жовт.', 'Листоп.'] }, { offset: '226px', data: ['Берез.', 'Квіт.', 'Трав.'] }],
                            durability: [{ offset: '48px', width: '100px', drones: 1 }, { offset: '254px', width: '145px', drones: 1 }]
                        }
                    ]
                },
                second: {
                    image: '/storage/image71.jpg',
                    imageSize: '320% 101%',
                    imageX: '66%',
                    imageY: '75%',
                    titleOffset: '10px',
                    data: [
                        {
                            title: 'Кукурудза',
                            image: '/storage/image67_.png',
                            seasons: [{ offset: '135px', data: ['Квіт.', 'Трав.', 'Черв.', 'Лип.'] }],
                            durability: [{ dronesOffset: '130px', offset: '130px', width: '232px', drones: 2 }]
                        },
                        {
                            title: 'Соняшник',
                            image: '/storage/image66_.png',
                            seasons: [{ offset: '129px', data: ['Трав.', 'Черв.', 'Лип.'] }],
                            durability: [{ dronesOffset: '118px', offset: '128px', width: '169px', drones: 2 }]
                        }
                    ]
                }
            }
        };
    },
    computed: {
        spacesTimes() {
            return this.page === 'first' ? 1 : 3;
        }
    },
    components: {
        appLeftImage: LeftImage,
        appServiceData: ServiceData
    }
}
</script>

<style scoped>
    .aero-data-title {
        font-family: Roboto;
        font-size: 40px;
        text-align: center;
    }

    .aero-data-img img {
        max-width: 91%;
    }

    .seasons {
        font-family: Roboto;
        font-size: 18px;
    }

    .durability-data .drone-durability {
        height: 30px;
        border-left: 1.8px solid #000;
        border-bottom: 1.8px solid #000;
        border-right: 1.8px solid #000;
    }

    .durability-data .drones {
        margin-top: 10px;
        display: flex;
        justify-content: center;
    }

    .durability-data .drones img {
        max-width: 100%;
    }

    .aero-bottom-logo {
        position: absolute;
        right: 0;
        bottom: 0;
    }

    .aero-bottom-logo img {
        margin-right: 10px;
        margin-bottom: 10px;
        width: 200px;
    }

</style>
