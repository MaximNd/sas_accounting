<template>
    <v-layout class="page bg-1c" column>
        <v-flex>
            <div class="title-1c">
                1C Інтеграція
            </div>
        </v-flex>
        <v-flex style="flex-grow:1;">
            <div class="price-1c-table">
                <table>
                    <thead>
                        <tr>
                            <th>Послуги</th>
                            <th>Ціна, $</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Інтеграція 1С і Cropio</td>
                            <td class="table-price">3 850$<br>(одноразово)</td>
                        </tr>
                        <tr>
                            <td>Інтеграція 1С і Cropio <br> з супроводом</td>
                            <td class="table-price">0,5$ <br> з га за рік</td>
                        </tr>
                        <tr>
                            <td>Година роботи програміста</td>
                            <td class="table-price">30$</td>
                        </tr>
                    </tbody>
                </table>
                <div class="notation">
                    <p>
                        Усі розрахунки проводимо в гривні, ціна вказана з урахуванням ПДВ.
                    </p>
                </div>
            </div>
        </v-flex>
        <div class="bottom-logo-1c">
            <img src="/storage/image4.png" alt="">
        </div>
    </v-layout>
</template>

<script>
export default {

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

    .bg-1c .price-1c-table table {
        color: #4D4D4D;
        margin: 0 auto;
        width: 75%;
    }

    .bg-1c .price-1c-table table tr th {
        background-color: #28B691;
        color: #fff;
        font-family: ProximaNovaBold;
        font-size: 28px;
        padding: 5px 10px;
    }

    .bg-1c .price-1c-table table tr:nth-child(odd) td {
        background-color: #E9E9E9;
    }

    .bg-1c .price-1c-table table tr:nth-child(even) td {
        background-color: #F2F2F2;
    }

    .bg-1c .price-1c-table table tr:first-child td {
        border: 2px solid #fff;
        border-top: 4px solid #fff;
        margin: 0;
    }

    .bg-1c .price-1c-table table tr td {
        border: 2px solid #fff;
        margin: 0;
    }

    .bg-1c .price-1c-table table tr:nth-child(1) th {
        border-left: 2px solid #fff;
        border-right: 2px solid #fff;
        margin: 0;
    }

    .bg-1c .price-1c-table table tr:nth-child(2) th {
        border-left: 4px solid #fff;
        margin: 0;
    }

    .bg-1c .price-1c-table table tr {
        margin: 0;
    }

    .bg-1c .price-1c-table table td {
        font-family: ProximaNovaBold;
        font-size: 28px;
        padding: 5px 10px;
    }

    .bg-1c .price-1c-table table td.table-price {
        text-align: center;
    }

    .bg-1c .price-1c-table .notation {
        font-family: ProximaNovaBold;
        margin: 0 auto;
        width: 75%;
        font-size: 19px;
        color: #949494;
    }

    .bg-1c .price-1c-table .notation p {
        margin-top: 10px;
        margin-left: 7px;
        margin-bottom: 0;
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
