<template>
    <li class="list-item" :style="{ 'margin-bottom': isMain ? '8px' : '0px', 'width': isMain ? 'auto' : '50%' }">
        <div class="icon">
            <img :src="image" alt="icon">
        </div>
        <div class="list-item-data">
            <div class="name">{{ name }}</div>
            <div class="price">
                <span>Ціна:&nbsp;</span>
                <span class="price-price">{{ price }}</span>
                <span class="currency">$</span>
            </div>
        </div>
    </li>
</template>

<script>
export default {
    props: {
        image: {
            type: String,
            required: true
        },
        name: {
            type: String,
            required: true
        },
        price: {
            required: true
        },
        isMain: {
            type: Boolean,
            required: false,
            default: true
        }
    }
}
</script>

<style scoped>
    .list-item {
        display: flex;
        justify-content: flex-start;
    }

    .list-item .icon {
        width: 23%;
        margin-right: 8px;
    }

    .list-item .icon img {
        max-width: 100%;
    }

    .list-item .list-item-data {
        display: flex;
        flex-flow: column;
        justify-content: center;
        font-family: ProximaNova;
        font-size: 20px;
    }

    .list-item .list-item-data .name {
        font-family: ProximaNovaBlack;
    }

    .list-item .list-item-data .icon {
        margin-bottom: 6px;
    }

    .list-item .list-item-data .price {
        font-family: ProximaNova;
        display: flex;
        justify-content: flex-start;
        align-items: center;
    }

    .list-item .list-item-data .price-price,
    .list-item .list-item-data .currency {
        font-family: ProximaNovaBold;
    }

    .list-item .list-item-data .price span:nth-child(2) {
        font-size: 26px;
    }

    .list-item .list-item-data .price span:nth-child(3) {
        font-size: 22px;
        margin-top: -10px;
    }
</style>
