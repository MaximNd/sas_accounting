<template>
    <div class="service-title-wrapper">
        <div class="service-title-content">
            <div class="service-title">
                <p :class="{'service-text': true, 'font-weight-bold': bold }" v-html="title">
                </p>
            </div>
            <div class="service-aside"></div>
            <div class="crosshair-vertical"></div>
            <div class="crosshair-horisontal"></div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        title: {
            type: String,
            required: true
        },
        bold: {
            type: Boolean,
            required: false,
            default: false
        }
    }
}
</script>


<style scoped>
    .service-title-wrapper {
        position: relative;
    }

    .service-title-wrapper .service-title-content {
        width: 648.38px;
        height: 368px;
        display: flex;
        font-family: Roboto;
        font-size: 64px;
        margin-top: 260px;
        margin-left: 60px;
    }

    .service-title-wrapper .service-title-content .service-title {
        width: 88%;
        background-color: rgba(13, 58, 97, 0.6);
        display: flex;
        justify-content: flex-start;
        align-items: center;
    }

    .service-title-wrapper .service-title-content .service-text {
        padding-left: 35px;
        color: #fff;
        line-height: 1.2;
        margin: 0;
    }

    .service-title-wrapper .service-title-content .service-aside {
        width: 12%;
        background-color: #0f3f65;
        height: inherit;
        opacity: 0.3;
    }

    .service-title-wrapper .service-title-content .crosshair-vertical {
        position: absolute;
        background-color: #fff;
        width: 3px;
        height: 43px;
        top: 542px;
        left: 628.8px;
    }

    .service-title-wrapper .service-title-content .crosshair-horisontal {
        position: absolute;
        background-color: #fff;
        width: 43px;
        height: 3px;
        top: 562px;
        left: 610px;
    }
</style>
