<template>
    <v-layout class="page bg-eng-project" column>
        <v-flex>
            <div class="title-eng-project">
                Інженерний проект
            </div>
        </v-flex>
        <v-flex>
            <appPricesTable
                :headers="headers"
                :data="tableData">
            </appPricesTable>
        </v-flex>
        <v-flex>
            <v-layout column align-center class="eng-project-prices">
                <v-flex class="installation-price">
                    <p>Монтаж обладнання: {{ installationPrice }} <span class="currency">₴</span></p>
                </v-flex>
                <v-flex class="transport-price">
                    <p>Транспортні витрати: {{ transportPrice }} <span class="currency">₴</span></p>
                </v-flex>
                <v-flex class="final-price">
                    <p>Всього: {{ finalPrice }} <span class="currency">₴</span></p>
                </v-flex>
            </v-layout>
        </v-flex>
        <div class="bottom-logo-eng-project">
            <img src="/storage/image4.png" alt="logo">
        </div>
    </v-layout>
</template>

<script>
import PricesTable from './../pricesTable/PricesTable';

export default {
    props: {
        gruppedEquipment: {
            type: Array,
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
        finalPrice: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
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
                { text: row.type, classes: 'text-xs-left' },
                { text: row.count },
                { text: row.price }
            ]);
        }
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

    .bg-eng-project .eng-project-prices .installation-price,
    .bg-eng-project .eng-project-prices .transport-price {
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
