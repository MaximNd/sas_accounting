<template>
    <v-layout class="page bg-mapper" justify-center>
        <img src="/storage/image76.png" alt="image">
        <div class="sas-mapper-title">SAS Mapper</div>
        <div class="icon map">
            <img src="/storage/image72.png" alt="icon">
        </div>
        <div class="icon ndvi">
            <img src="/storage/image75.png" alt="icon">
        </div>
        <div class="icon seedCalc">
            <img src="/storage/image74.png" alt="icon">
        </div>
        <div class="icon pictures">
            <img src="/storage/image73.png" alt="icon">
        </div>
        <div class="name map-name font-weight-bold">
            <p>Картування</p>
        </div>
        <div class="name ndvi-name font-weight-bold">
            <p>NDVI</p>
        </div>
        <div class="name seedCalc-name font-weight-bold">
            <p>Підрахунок<br>всходів</p>
        </div>
        <div class="name pictures-name font-weight-bold">
            <p>Зшиття<br>знімків</p>
        </div>
        <appPrice
            :price="1.8"
            :coordinates="{ left: '78px', top: '670px' }"
            :wrapperStyles="{ fontSize: '18px', width: '200px', height: '60px', backgroundColor: '#00aa77' }"
            :priceStyles="{ text: { 'font-size': '29px', 'margin-top': '14px' }, currency: { 'margin-left': '2px', 'margin-top': '8px', 'font-size': '24px' } }" />
        <div class="logo"><img src="/storage/image2.png" alt="logo"></div>
    </v-layout>
</template>

<script>
import Price from './../price/Price';

export default {
    components: {
        appPrice: Price
    }
}
</script>

<style scoped>
    .bg-mapper {
        background-color: #525252;
    }

    .bg-mapper .icon,
    .bg-mapper .name,
    .bg-mapper .logo,
    .bg-mapper .sas-mapper-title {
        position: absolute;
    }

    .bg-mapper .sas-mapper-title {
        font-family: ProximaNovaBlack;
        font-size: 44px;
        color: #fff;
        left: 460px;
        top: 10px;
    }

    .bg-mapper .icon {
        width: 100px
    }

    .bg-mapper .map {
        width: 97px;
        left: 528px;
        top: 140px;
    }

    .bg-mapper .ndvi {
        width: 82px;
        left: 750px;
        top: 364px;
    }

    .bg-mapper .seedCalc {
        width: 82px;
        left: 528px;
        top: 571px;
    }

    .bg-mapper .pictures {
        left: 300px;
        top: 350px;
    }

    .bg-mapper .icon img {
        max-width: 100%;
    }

    .bg-mapper .name {
        font-family: ProximaNovaBold;
        font-size: 28px;
        color: #fff;
    }

    .bg-mapper .map-name {
        left: 342px;
        top: 216px;
    }

    .bg-mapper .ndvi-name {
        left: 717px;
        top: 270px;
    }

    .bg-mapper .seedCalc-name {
        left: 660px;
        top: 540px;
    }

    .bg-mapper .pictures-name {
        left: 347px;
        top: 490px;
    }

    .bg-mapper .logo {
        position: absolute;
        right: 0;
        bottom: 0;
    }

    .bg-mapper .logo img {
        margin-right: 20px;
        margin-bottom: 20px;
        width: 300px;
    }

</style>
