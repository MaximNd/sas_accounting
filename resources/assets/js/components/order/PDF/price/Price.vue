<template>
    <div class="price-wrapper" :style="priceWrapperStyle">
        <span :style="priceStyles.text" class="price-text">Ціна&nbsp;</span>
        <span :style="priceStyles.text" class="price font-weight-bold">{{ price }}</span>
        <span :style="priceStyles.currency" class="price-currency font-weight-bold">$</span>
    </div>
</template>

<script>
export default {
    props: {
        price: {
            type: Number,
            required: true
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
                'background-color': this.wrapperStyles.backgroundColor
            }
        };
    }
}
</script>

<style scoped>
    .price-wrapper {
        position: absolute;
        color: white;
        font-family: Roboto;
        text-align: center;
        display: flex;
        justify-content: center;
    }

    .price-wrapper .price-text,
    .price-wrapper .price {
        /* display: inline-block; */
        font-family: Roboto;
    }

    .price-wrapper .price-currency {
        /* display: inline-block; */

        /* position: absolute; */
    }
</style>
