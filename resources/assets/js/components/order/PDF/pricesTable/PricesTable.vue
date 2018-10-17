<template>
    <div class="prices-table">
        <table>
            <thead>
                <tr>
                    <th v-for="(text, index) in headers" :key="`th-${index}`" class="text-xs-center">
                        {{ text }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row, rowIndex) in data" :key="`row-${rowIndex}`">
                    <td v-for="(col, colIndex) in row" :key="`col-${colIndex}`" :class="col.classes">
                        {{ col.text }}
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="notation">
            <p>
                Усі розрахунки проводимо в гривні, ціна вказана з урахуванням ПДВ.
            </p>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        headers: {
            type: Array,
            required: true
        },
        data: {
            type: Array,
            required: true
        }
    }
}
</script>

<style scoped>
    .prices-table table {
        color: #4D4D4D;
        margin: 0 auto;
        width: 75%;
    }

    .prices-table table tr th {
        background-color: #28B691;
        color: #fff;
        font-family: ProximaNovaBold;
        font-size: 28px;
        padding: 5px 10px;
    }

    .prices-table table tr:nth-child(odd) td {
        background-color: #E9E9E9;
    }

    .prices-table table tr:nth-child(even) td {
        background-color: #F2F2F2;
    }

    .prices-table table tr:first-child td {
        border: 2px solid #fff;
        border-top: 4px solid #fff;
        margin: 0;
    }

    .prices-table table tr td {
        border: 2px solid #fff;
        margin: 0;
    }

    .prices-table table tr:nth-child(1) th {
        border-left: 2px solid #fff;
        border-right: 2px solid #fff;
        margin: 0;
    }

    .prices-table table tr:nth-child(2) th {
        border-left: 4px solid #fff;
        margin: 0;
    }

    .prices-table table tr {
        margin: 0;
    }

    .prices-table table tr td {
        font-family: ProximaNovaBold;
        font-size: 28px;
        padding: 5px 10px;
        text-align: center;
    }

    .prices-table table tr td.small-text {
        font-family: ProximaNova;
        font-size: 20px;
        font-weight: 600;
        padding: 3px 8px;
    }

    .prices-table table tr td.bold-text {
        font-family: ProximaNovaBold;
    }

    .prices-table .notation {
        font-family: ProximaNovaBold;
        margin: 0 auto;
        width: 75%;
        font-size: 19px;
        color: #949494;
    }

    .prices-table .notation p {
        margin-top: 10px;
        margin-left: 7px;
        margin-bottom: 0;
    }
</style>
