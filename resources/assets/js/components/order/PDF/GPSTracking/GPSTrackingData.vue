<template>
    <v-layout class="page gps-data-bg" column>
        <v-flex>
            <div class="gps-data-title">GPS - моніторинг</div>
        </v-flex>
        <v-flex>
            <v-layout wrap>
                <v-flex xs5>
                    <ul class="main-data-list">
                        <appListItem
                            v-for="(equipmentItem, index) in mainList"
                            :key="`equimnet-item-${index}`"
                            :image="equipmentItem.image"
                            :name="equipmentItem.name"
                            :price="equipmentItem.price" />
                    </ul>
                </v-flex>
                <v-flex xs7>
                    <v-layout column>
                        <v-flex>
                            <v-layout column class="transport-container">
                                <v-flex style="flex-grow: 1;">
                                    <div class="transport-image">
                                        <img :src="transportImage" alt="transport">
                                    </div>
                                </v-flex>
                                <v-flex style="flex-grow: 2;" d-flex justify-center align-center>
                                    <p class="transport-name">{{ transportName }}</p>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                        <v-flex>
                            <ul class="secondary-data-list">
                                <appListItem
                                    v-for="(equipmentItem, index) in secondaryList"
                                    :key="`equimnet-item-${index}`"
                                    :image="equipmentItem.image"
                                    :name="equipmentItem.name"
                                    :price="equipmentItem.price"
                                    :isMain="false" />
                            </ul>
                        </v-flex>
                    </v-layout>
                </v-flex>
            </v-layout>
        </v-flex>
        <div class="gps-data-bottom-logo">
            <appPrice
            :coordinates="{ left: '0px', top: '728px' }"
            :price="price"
            text="Всього"
            :wrapperStyles="{ justifyContent: 'flex-end', fontSize: '20px', width: '380px', height: '60px', backgroundColor: '#00b881' }"
            :priceStyles="{ text: { 'font-size': '34px', 'margin-top': '13px' }, currency: { 'margin-right': '25px', 'margin-left': '2px', 'margin-top': '7px', 'font-size': '28px' } }" />
            <img src="/storage/image4.png" alt="logo">
        </div>
    </v-layout>
</template>

<script>
import ListItem from './listItem/ListItem';
import Price from './../price/Price';
import utils from './../../../../mixins/utils.js';

export default {
    mixins: [utils],
    props: {
        equipment: {
            type: Array,
            required: true
        },
        transportImage: {
            type: String,
            required: true
        },
        transportName: {
            type: String,
            required: true
        }
    },
    computed: {
        price() {
            return this.equipment.reduce((price, row) => (this.addTwoFloats(price, row.price)), 0.0);
        },
        mainList() {
            return this.equipment.slice(0, 7);
        },
        secondaryList() {
            return this.equipment.slice(7);
        }
    },
    components: {
        appListItem: ListItem,
        appPrice: Price
    }
}
</script>

<style scoped>
    .gps-data-bg {
        background-color: #fff;
    }

    .gps-data-title {
        width: 100%;
        font-family: ProximaNovaBlack !important;
        font-size: 49px !important;
        text-align: center;
        margin-top: 40px;
        margin-bottom: -10px;
        color: rgb(77, 77, 77);
        /* color: #00b881; */
    }

    .main-data-list {
        height: 100%;
        padding: 0;
        margin: 0;
        list-style: none;
        margin-left: 40px;
    }

    .secondary-data-list {
        padding: 0;
        margin: 0;
        list-style: none;
        display: flex;
        justify-content: flex-start;
    }

    .transport-container {
        height: 500px;
    }

    .transport-image {
        height: 80%;
        width: 80%;
        margin: 0 auto;
    }

    .transport-image img {
        max-width: 100%;
        max-height: 80%;
        display: block;
    }

    .transport-name {
        font-family: ProximaNovaBlack;
        text-align: center;
        font-size: 32px;
        margin-bottom: 0px;
    }

    .gps-data-bottom-logo {
        display: flex;
        justify-content: flex-end;
        align-items: flex-end;
        flex-grow: 1;
    }

    .gps-data-bottom-logo img {
        margin-right: 10px;
        margin-bottom: 10px;
        width: 200px;
    }

</style>
