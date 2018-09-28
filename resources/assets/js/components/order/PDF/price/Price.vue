<template>
    <div class="price-wrapper" :style="priceWrapperStyle">
        <span :style="priceStyles.text" class="price-text">{{ text }}&nbsp;</span>
        <span :style="priceStyles.text" class="price font-weight-bold">{{ price }}</span>
        <span :style="priceStyles.currency" class="price-currency font-weight-bold">$</span>
    </div>
</template>

<script>
export default {
    props: {
        price: {
            required: true
        },
        text: {
            type: String,
            required: false,
            default: 'Ціна'
        },
        coordinates: {
            type: Object,
            required: true
        },
        wrapperStyles: {
            type: Object,
            required: true
        },
        priceStyles: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            priceWrapperStyle: {
                left: this.coordinates.left,
                top: this.coordinates.top,
                'font-size': this.wrapperStyles.fontSize,
                width: this.wrapperStyles.width,
                height: this.wrapperStyles.height,
                'background-color': this.wrapperStyles.backgroundColor,
                'justify-content': this.wrapperStyles.justifyContent || 'center'
            }
        };
    }
}
</script>

<style scoped>
    .price-wrapper {
        position: absolute;
        color: white;
        font-family: ProximaNova;
        text-align: center;
        display: flex;
    }

    .price-wrapper .price-text {
        font-family: ProximaNova;
    }

    .price-wrapper .price {
        font-family: ProximaNovaBlack;
    }

    .price-wrapper .price-currency {
        font-family: ProximaNovaBold;
    }
</style>
