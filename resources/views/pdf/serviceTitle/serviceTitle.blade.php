<div class="service-title-wrapper">
    <div class="service-title-content">
        <div class="service-title">
            <div class="service-text" style="{{ $styles or '' }}">
                {!! $title !!}
            </div>
        </div>
        <div class="service-aside"></div>
        <div class="crosshair-vertical"></div>
        <div class="crosshair-horisontal"></div>
    </div>
</div>

<style>
    .service-title-wrapper {
        position: relative;
    }

    .service-title-wrapper .service-title-content {
        width: 648.38px;
        height: 368px;
        /*display: flex;*/
        font-family: ProximaNovaBlack;
        font-size: 64px;
        margin-top: 330px;
        margin-left: 60px;
    }

    .service-title-wrapper .service-title-content .service-title {
        display: inline-block;
        width: 570.56px;
        height: 368px;
        background-color: rgba(13, 58, 97, 0.6);
    }

    .service-title-wrapper .service-title-content .service-text {
        position: relative;
        padding-left: 35px;
        color: #fff;
        line-height: 50px;
        vertical-align: middle;
        margin: 0;
    }

    .service-title-wrapper .service-title-content .service-aside {
        display: inline-block;
        width: 77.8px;
        height: 368px;
        margin-left: -15px;
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