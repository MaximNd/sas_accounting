<div id="optional-service" class="page">
    @include('pdf.leftImage.leftImage', ['image' => '/storage/image98_s.jpg'])
    @php
        $str_price = strval($optionalService['price']);
        $margin_left = 20;
        $width = 200;
        switch (strlen($str_price)) {
            case 1:
                $margin_left = 47;
                break;
            case 2:
                $margin_left = 37;
                break;
            case 3:
                $margin_left = 27;
                break;
            case 4:
                $margin_left = 17;
                break;
            case 5:
                $margin_left = 27;
                $width = 250;
                break;
            case 6:
                $margin_left = 23;
                $width = 250;
                break;
            case 7:
                $margin_left = 13;
                $width = 250;
                break;
            case 8:
                $margin_left = 27;
                $width = 300;
                break;
            case 9:
                $margin_left = 20;
                $width = 300;
                break;
            default:
                $margin_left = 10;
                $width = 320;
                break;
        }
    @endphp
    @include('pdf.price.price', [
        'price' => $optionalService['price'],
        'text' => 'Ціна',
        'wrapperStyles' => 'left:379px;top:670px;font-size:20px;width:'.$width.'px;height:70px;background-color:#009769;',
        'priceStyles' => [
            'text' => 'margin-left:'.$margin_left.'px; font-size:31px; margin-top:-101px;',
            'price' => 'font-size:31px; margin-left: -5px; margin-top:-101px;',
            'currency' => 'margin-left: -3px; margin-top:-114px; font-size:26px'
        ]
    ])
    <div class="optional-service-data">
        <div class="optional-service-title font-weight-bold">
            {{ $optionalService['name'] }}
        </div>
        <div class="optional-service-comment">
            {{ $optionalService['comment'] }}
        </div>
        <div class="optional-service-bottom-logo">
            <img class="sas-logo" src="storage/image2.png" alt="logo">
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<div class="page-break"></div>

<style>
    #optional-service {
        position: relative;
        width: 100%;
        height: 100%;
        background-color: #525252;
    }

    #optional-service .optional-service-data {
        float: left;
        width: 33.33333333%;
    }

    #optional-service .optional-service-data .optional-service-title {
        font-family: ProximaNovaBlack;
        font-size: 40px;
        color: #fff;
        text-align: center;
        padding-top: 20px;
        padding-bottom: 10px;
    }

    #optional-service .optional-service-data .optional-service-comment {
        font-family: ProximaNovaBlack;
        font-size: 24px;
        color: #fff;
        padding-left: 60px;
        padding-right: 60px;
        padding-top: 20px;
        width: 640px;
    }

    #optional-service .optional-service-bottom-logo {
        position: absolute;
        left: 927px;
        top: 758px;
        width: 210px;
        height: 118px;
    }

    #optional-service .optional-service-bottom-logo img {
        margin-right: 20px;
        margin-bottom: 20px;
        height: 70px;
    }

</style>