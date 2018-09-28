<template>
    <v-layout class="page" id="page-22">
        <appLeftImage image="/storage/image98.jpg" size="350% 101%" positionX="3%" />
        <v-flex xs8 class="optional-service-data">
            <appPrice
                v-if="optionalService.price"
                :price="optionalService.price"
                :coordinates="coordinates"
                :wrapperStyles="wrapperStyles"
                :priceStyles="priceStyles" />
            <v-layout column style="height: 100%;">
                <div class="optional-service-title font-weight-bold">
                    {{ optionalService.name }}
                </div>
                <div class="optional-service-comment">
                    {{ optionalService.comment }}
                </div>
                <div class="logo-bottom">
                    <img class="sas-logo" src="/storage/image2.png" alt="logo">
                </div>
            </v-layout>
        </v-flex>
    </v-layout>
</template>

<script>
import LeftImage from './../leftImage/LeftImage';
import Price from './../price/Price';

export default {
    props: {
        optionalService: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            coordinates: { left: '378px', top: '670px' },
            wrapperStyles: { fontSize: '20px', width: '200px', height: '70px', backgroundColor: '#009769' },
            priceStyles: { text: { 'font-size': '31px', 'margin-top': '20px' }, currency: { 'margin-left': '2px', 'margin-top': '12px', 'font-size': '26px' } }
        };
    },
    components: {
        appLeftImage: LeftImage,
        appPrice: Price
    }
}
</script>

<style scoped>
    .optional-service-data {
        height: 100%;
        background-color: #525252;
    }

    .optional-service-data .optional-service-title {
        font-family: ProximaNovaBlack;
        font-size: 40px;
        color: #fff;
        text-align: center;
        padding-top: 20px;
        padding-bottom: 10px;
    }

    .optional-service-data .optional-service-comment {
        font-family: ProximaNovaBlack;
        font-size: 24px;
        color: #fff;
        padding-left: 30px;
        padding-top: 20px;
    }

    .logo-bottom {
        flex-grow: 1;
        display: flex;
        align-items: flex-end;
        justify-content: flex-end;
    }

    .logo-bottom img.sas-logo {
        margin-right: 20px;
        margin-bottom: 20px;
        height: 70px;
    }

    .logo-bottom img.yara-logo {
        margin-left: 20px;
        margin-bottom: 20px;
    }
</style>
