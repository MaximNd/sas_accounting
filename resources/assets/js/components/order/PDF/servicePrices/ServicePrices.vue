<template>
    <v-layout class="page bg-services" column>
        <v-flex class="service-prices-table">
            <appPricesTable
                :headers="headers"
                :data="tableData"
                :dollarDate="dollarDate">
            </appPricesTable>
            <div column align-center class="service-prices">
                <div class="final-price">
                    <p>Всього: {{ finalPrice }} <span class="currency">₴</span></p>
                </div>
            </div>
        </v-flex>
        <div class="bottom-logo-services">
            <img src="/storage/image4.png" alt="logo">
        </div>
    </v-layout>
</template>

<script>
import PricesTable from './../pricesTable/PricesTable';
import utils from './../../../../mixins/utils.js';
import formatter from 'accounting';

export default {
    mixins: [utils],
    props: {
        servicePrices: {
            type: Array,
            required: true
        },
        dollarRate: {
            type: Number,
            required: true
        },
        dollarDate: {
            type: String,
            required: false,
            default: ''
        }
    },
    data() {
        return {
            headers: [
                'Послуги',
                'Ціна, $'
            ]
        }
    },
    computed: {
        tableData() {
            return this.servicePrices.map(serviceData => [
                { text: serviceData.service.name, classes: 'text-xs-left small-text' },
                { text: serviceData.price, classes: 'small-text bold-text' }
            ]);
        },
        finalPrice() {
            const finalPrice =  this.servicePrices.reduce((price, serviceData) => this.addTwoFloats(price, serviceData.price), 0.0);
            const finalPriceUAH = this.multiplyTwoFloats(this.dollarRate, finalPrice);
            return formatter.formatMoney(finalPriceUAH, {
                symbol: '',
                precision: 2,
                thousand: ' ',
                format: {
                    pos : '%v%s',
                    zero: '%v%s'
                }
            });
        }
    },
    components: {
        appPricesTable: PricesTable
    }
}
</script>

<style scoped>
    .bg-services {
        background-color: #fff;
    }

    .bg-services .service-prices {
        margin-top: 50px;
        text-align: center;
    }

    .bg-services .service-prices-table {
        margin-top: 40px;
    }

    .bg-services .service-prices p {
        margin: 0;
        padding: 0;
    }

    .bg-services .service-prices .final-price {
        font-family: ProximaNova;
        font-size: 36px;
        color: rgb(77, 77, 77);
        font-weight: 600;
    }

    .bg-services .service-prices .final-price span.currency {
        font-family: ProximaNovaBlack;
        font-size: 38px;
        font-weight: bold;
    }

    .bg-services .bottom-logo-services {
        display: flex;
        justify-content: flex-end;
        align-items: flex-end;
        flex-grow: 1;
    }

    .bg-services .bottom-logo-services img {
        margin-right: 10px;
        margin-bottom: 10px;
        width: 200px;
    }
</style>
