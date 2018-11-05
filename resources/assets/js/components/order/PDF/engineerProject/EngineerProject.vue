<template>
    <v-layout class="page bg-eng-project" column>
        <v-flex>
            <div class="title-eng-project">
                Інженерний проект
            </div>
        </v-flex>
        <v-flex :d-flex="!showPrices" :align-center="!showPrices" :style="{ 'flex-grow': showPrices ? false : 1 }">
            <appPricesTable
                :headers="headers"
                :data="tableData"
                :dollarDate="dollarDate">
            </appPricesTable>
            <div v-if="showPrices" class="eng-project-prices" :style="{'margin-top': gruppedEquipment.length <= 10 ? '40px': '15px' }">
                <div class="days-price">
                    <p>Відрядні: {{ formattedPriceForDays }} <span class="currency">₴</span></p>
                </div>
                <div class="equipment-price">
                    <p>Обладнання: {{ formattedEquipmentPrice }} <span class="currency">₴</span></p>
                </div>
                <div class="installation-price">
                    <p>Монтаж обладнання: {{ formattedInstallationPrice }} <span class="currency">₴</span></p>
                </div>
                <div class="transport-price">
                    <p>Транспортні витрати: {{ formattedTransportPrice }} <span class="currency">₴</span></p>
                </div>
                <div class="final-price">
                    <p>Всього: {{ formattedFinalPrice }} <span class="currency">₴</span></p>
                </div>
            </div>
        </v-flex>
        <v-flex>

        </v-flex>
        <div class="bottom-logo-eng-project">
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
        showPrices: {
            type: Boolean,
            required: false,
            default: false
        },
        gruppedEquipment: {
            type: Array,
            required: true
        },
        equipmentPrice: {
            type: Number,
            required: true
        },
        installationPrice: {
            type: Number,
            required: true
        },
        transportPrice: {
            type: Number,
            required: true
        },
        priceForDays: {
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
            formatterSettings: {
                symbol: '',
                precision: 2,
                thousand: ' ',
                format: {
                    pos : '%v%s',
                    zero: '%v%s'
                }
            },
            headers: [
                'Тип',
                'шт.',
                'Ціна, $'
            ]
        };
    },
    computed: {
        tableData() {
            return this.gruppedEquipment.map(row => [
                { text: row.type, classes: 'text-xs-left small-text bold-text' },
                { text: row.count, classes: 'small-text bold-text' },
                { text: row.price, classes: 'small-text bold-text' }
            ]);
        },
        formattedEquipmentPrice() {
            return formatter.formatMoney(this.equipmentPrice, this.formatterSettings);
        },
        formattedInstallationPrice() {
            return formatter.formatMoney(this.installationPrice, this.formatterSettings);
        },
        formattedTransportPrice() {
            return formatter.formatMoney(this.transportPrice, this.formatterSettings);
        },
        formattedPriceForDays() {
            return formatter.formatMoney(this.priceForDays, this.formatterSettings);
        },
        formattedFinalPrice() {
            const finalPrice = this.addTwoFloats(this.addTwoFloats(this.equipmentPrice, this.priceForDays), this.addTwoFloats(this.installationPrice, this.transportPrice));
            return formatter.formatMoney(finalPrice, this.formatterSettings);
        },

    },
    components: {
        appPricesTable: PricesTable
    }
}
</script>

<style scoped>
    .bg-eng-project {
        background-color: #fff;
    }

    .bg-eng-project .title-eng-project {
        font-family: ProximaNovaBlack;
        font-size: 40px;
        text-align: center;
        color: #4D4D4D;
        margin-top: 25px;
    }

    .bg-eng-project .eng-project-prices {
        text-align: center;
    }

    .bg-eng-project .eng-project-prices p {
        margin: 0;
        padding: 0;
    }

    .bg-eng-project .eng-project-prices span.currency {
        font-family: ProximaNovaBlack;
        font-size: 30px;
        font-weight: bold;
    }

    .bg-eng-project .eng-project-prices .eng-project-prices .final-price span.currency {
        font-family: ProximaNovaBlack;
        font-size: 38px;
        font-weight: bold;
    }

    .bg-eng-project .eng-project-prices .equipment-price,
    .bg-eng-project .eng-project-prices .installation-price,
    .bg-eng-project .eng-project-prices .transport-price,
    .bg-eng-project .eng-project-prices .days-price {
        font-family: ProximaNova;
        font-size: 28px;
        color: rgb(77, 77, 77);
        margin-bottom: 10px;
    }

    .bg-eng-project .eng-project-prices .final-price {
        font-family: ProximaNova;
        font-size: 36px;
        color: rgb(77, 77, 77);
        font-weight: 600;
    }

    .bg-eng-project .bottom-logo-eng-project {
        display: flex;
        justify-content: flex-end;
        align-items: flex-end;
        flex-grow: 1;
    }

    .bg-eng-project .bottom-logo-eng-project img {
        margin-right: 10px;
        margin-bottom: 10px;
        width: 200px;
    }
</style>
