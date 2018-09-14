<template>
    <v-flex xs8 class="right-data">
        <appPrice
            v-if="data.price"
            :price="data.price"
            :coordinates="data.coordinates"
            :wrapperStyles="data.wrapperStyles"
            :priceStyles="data.priceStyles" />
        <v-layout column style="height: 100%;">
            <div class="right-data-title font-weight-bold" :style="{ 'margin-bottom': data.titleOffset || '0px' }">
                {{ data.title }}
            </div>
            <div class="data">
                <div
                    v-if="data.subtitle"
                    class="data-title"
                    :style="{ 'margin-left': grid ? '35px' : '0px', 'text-align': grid ? 'left' : 'center' }">
                    {{ data.subtitle }}
                </div>
                <ul v-if="!grid" class="data-list">
                    <li v-for="(item, index) in data.data" :key="`data-${index}`" :style="{ 'margin-bottom': data.listOffset || '26px' }">
                        <div class="icon" :style="{ width: data.iconWidth || '7%' }"><img :src="item.icon" alt="icon"></div>
                        <div class="text" :style="{ width: data.iconWidth ? `${100 - parseFloat(data.iconWidth)}%` : 'auto' }">
                            <p>{{ item.text }}</p>
                        </div>
                    </li>
                </ul>
                <v-container v-else fluid class="data-grid-list" grid-list-xl>
                    <v-layout wrap>
                        <v-flex xs3 v-for="(item, index) in data.data" :key="`data-${index}`">
                            <div class="item-data">
                                <div class="icon">
                                    <img :src="item.icon" alt="icon">
                                </div>
                                <div class="text">
                                    <p>{{ item.text }}</p>
                                </div>
                            </div>
                        </v-flex>
                    </v-layout>
                </v-container>
            </div>
            <div class="logo-bottom" :style="{ 'justify-content': withYara ? 'space-between' : 'flex-end' }">
                <img v-if="withYara" class="yara-logo" src="/storage/image82.png" alt="logo">
                <img class="sas-logo" src="/storage/image2.png" alt="logo">
            </div>
        </v-layout>
    </v-flex>
</template>

<script>
import Price from './../price/Price';

export default {
    props: {
        withYara: {
            type: Boolean,
            required: false,
            default: false
        },
        data: {
            type: Object,
            required: true
        },
        grid: {
            type: Boolean,
            required: false,
            default: false
        }
    },
    components: {
        appPrice: Price
    }
}
</script>

<style scoped>
    .right-data {
        height: 100%;
        background-color: #525252;
    }

    .right-data .right-data-title {
        font-family: ProximaNovaBlack;
        font-size: 40px;
        color: #fff;
        text-align: center;
        padding-top: 20px;
        padding-bottom: 10px;
    }

    .data .data-title {
        font-family: ProximaNovaBlack;
        font-size: 28px;
        color: #fff;
    }

    .data .data-list {
        padding: 0;
        margin: 0;
        margin-left: 50px;
        list-style: none;
    }

    .data-grid-list .item-data {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
    }

    .data-grid-list .item-data .icon {
        width: 75px;
    }

    .data .data-list li {
        display: flex;
        /* margin-bottom: 26px; */
    }

    .data .data-list .icon {
        display: flex;
        align-items: center;
        padding-left: 5px;
        padding-right: 5px;
    }

    .data .data-list .icon img,
    .data .data-grid-list .icon img {
        max-width: 100%;
    }

    .data .data-grid-list .text {
        font-family: ProximaNovaBold;
        font-size: 22px;
        color: #fff;
        text-align: center;
    }

    .data .data-list .text {
        padding-left: 30px;
        padding-right: 5px;
        font-family: ProximaNovaBold;
        font-size: 22px;
        color: #fff;
        display: flex;
        align-items: center;
    }

    .data .data-list .text p,
    .data .data-grid-list .text {
        margin: 0;
        padding: 0;
    }

    .logo-bottom {
        flex-grow: 1;
        display: flex;
        align-items: flex-end;
    }

    .logo-bottom img.sas-logo {
        margin-right: 20px;
        margin-bottom: 20px;
        height: 70px;
    }

    .logo-bottom img.yara-logo {
        margin-left: 20px;
        margin-bottom: 20px;
        width: 70px;
    }
</style>
