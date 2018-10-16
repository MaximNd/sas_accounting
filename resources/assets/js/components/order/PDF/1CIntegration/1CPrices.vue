<template>
    <v-layout class="page bg-1c" column>
        <v-flex>
            <div class="title-1c">
                1C Інтеграція
            </div>
        </v-flex>
        <v-flex style="flex-grow:1;">
            <appPricesTable
                :headers="headers"
                :data="tableData">
            </appPricesTable>
        </v-flex>
        <div class="bottom-logo-1c">
            <img src="/storage/image4.png" alt="">
        </div>
    </v-layout>
</template>

<script>
import PricesTable from './../pricesTable/PricesTable';

export default {
    props: {
        prices: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            headers: ['Кількість га', 'Ціна, $']
        };
    },
    computed: {
        tableData() {
            return this.prices.map((pricesRow, index) => [
                { text: (index + 1 === this.prices.length) ? `${pricesRow.from}>` : `${pricesRow.from} - ${pricesRow.to}` },
                { text: pricesRow.price }
            ]);
        }
    },
    components: {
        appPricesTable: PricesTable
    }
}
</script>

<style scoped>
    .bg-1c {
        background-color: #fff;
    }

    .bg-1c .title-1c {
        font-family: ProximaNovaBlack;
        font-size: 40px;
        text-align: center;
        color: #4D4D4D;
        margin-top: 25px;
    }

    .bg-1c .bottom-logo-1c {
        display: flex;
        justify-content: flex-end;
        align-items: flex-end;
        flex-grow: 1;
    }

    .bg-1c .bottom-logo-1c img {
        margin-right: 10px;
        margin-bottom: 10px;
        width: 200px;
    }
</style>
