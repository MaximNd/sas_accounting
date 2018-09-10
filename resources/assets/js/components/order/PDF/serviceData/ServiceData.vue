<template>
    <v-flex xs8 class="right-data">
        <appPrice
        :price="data.price"
        :coordinates="data.coordinates"
        :wrapperStyles="data.wrapperStyles" 
        :priceStyles="data.priceStyles" />
        <v-layout column style="height: 100%;">
            <div class="right-data-title font-weight-bold">
                Картування полів
            </div>
            <div class="data">
                <div class="data-title">{{ data.title }}</div>
                <ul class="data-list">
                    <li v-for="(item, index) in data.data" :key="`data-${index}`">
                        <div class="icon"><img :src="item.icon" alt="icon"></div>
                        <div class="text">
                            <p>{{ item.text }}</p>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="logo-bottom">
                <img src="/storage/image2.png" alt="logo">
            </div>
        </v-layout>
    </v-flex>
</template>

<script>
import Price from './../price/Price';

export default {
    props: {
        data: {
            type: Object,
            required: true
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
        font-family: Roboto;
        font-size: 40px;
        color: #fff;
        text-align: center;
        padding-top: 20px;
        padding-bottom: 10px;
    }

    .data .data-title {
        font-family: Roboto;
        font-size: 28px;
        color: #fff;
        text-align: center;
    }

    .data .data-list {
        padding: 0;
        margin: 0;
        margin-left: 50px;
        list-style: none;
    }

    .data .data-list li {
        display: flex;
        margin-bottom: 26px;
    }

    .data .data-list .icon {
        display: flex;
        align-items: center;
        width: 7%;
        padding-left: 5px;
        padding-right: 5px;
    }

    .data .data-list .icon img {
        max-width: 100%;
    }

    .data .data-list .text {
        width: 93%;
        padding-left: 30px;
        padding-right: 5px;
        font-family: Roboto;
        font-size: 22px;
        color: #fff;
        display: flex;
        align-items: center;
    }

    .data .data-list .text p {
        margin: 0;
        padding: 0;
    }

    .logo-bottom {
        flex-grow: 1;
        display: flex;
        justify-content: flex-end;
        align-items: flex-end;
    }

    .logo-bottom img {
        margin-right: 20px;
        margin-bottom: 20px;
        height: 70px;
    }
</style>
