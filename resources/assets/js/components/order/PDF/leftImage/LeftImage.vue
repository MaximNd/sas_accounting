<template>
    <v-flex xs4 class="left-img" :style="styles"></v-flex>
</template>

<script>
export default {
    props: {
        image: {
            type: String,
            required: true
        },
        size: {
            type: String,
            required: false,
            default: '101%'
        },
        positionX: {
            type: String,
            required: false,
            default: '95%'
        }
    },
    data() {
        return {
            styles: {
                'background-image': `url(${this.image})`,
                'background-size': this.size,
                'background-position-x': this.positionX
            }
        };
    }
}
</script>

<style scoped>
    .left-img {
        background-position-y: 43%;
        position: relative;
        /* box-shadow: 14px 0px 39px -2px rgba(0, 0, 0, 0.66); */
    }

    .left-img::after {
        content: '';
        background: url('/storage/shadow.png');
        position: absolute;
        left: 378px;
        width: 23px;
        height: 808px;
    }
</style>
