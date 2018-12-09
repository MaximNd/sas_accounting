<div id="sas-mapper" class="page">
    <img style="margin-top: 90px;margin-left: 169px;" src="storage/image76.png" alt="image">
    <div class="sas-mapper-title">SAS Mapper</div>
    <div class="icon map">
        <img src="storage/image72.png" alt="icon">
    </div>
    <div class="icon ndvi">
        <img src="storage/image75.png" alt="icon">
    </div>
    <div class="icon seedCalc">
        <img src="storage/image74.png" alt="icon">
    </div>
    <div class="icon pictures">
        <img src="storage/image73.png" alt="icon">
    </div>
    <div class="name map-name font-weight-bold">
        <p>Картування</p>
    </div>
    <div class="name ndvi-name font-weight-bold">
        <p>NDVI</p>
    </div>
    <div class="name seedCalc-name font-weight-bold">
        <p>Підрахунок<br>всходів</p>
    </div>
    <div class="name pictures-name font-weight-bold">
        <p>Зшиття<br>знімків</p>
    </div>
    @php
        $str_price = strval($price);
        $margin_left = 29;
        switch (strlen($str_price)) {
            case 1:
                $margin_left = 49;
                break;
            case 3:
                $margin_left = 39;
                break;
            case 4:
                $margin_left = 29;
                break;
            default:
                $margin_left = 29;
                break;
        }
    @endphp
    @include('pdf.price.price', [
        'text' => 'Ціна',
        'price' => $price,
        'wrapperStyles' => 'left:78px;top:670px;font-size:18px;width:200px;height:60px;background-color:#00aa77',
        'priceStyles' => [
            'text' => 'margin-left:'.$margin_left.'px;font-size:29px;margin-top:18px',
            'price' => 'font-size:29px;margin-top:18px',
            'currency' => 'margin-left:-4px;margin-top:8px;font-size:24px'
        ]
    ])
    <div class="logo"><img src="storage/image2.png" alt="logo"></div>
</div>
<div class="page-break"></div>

<style>
    #sas-mapper {
        background-color: #525252;
        line-height: 0.9;
    }

    #sas-mapper .icon,
    #sas-mapper .name,
    #sas-mapper .logo,
    #sas-mapper .sas-mapper-title {
        position: absolute;
    }

    #sas-mapper .sas-mapper-title {
        font-family: ProximaNovaBlack;
        font-size: 44px;
        color: #fff;
        left: 460px;
        top: 10px;
    }

    #sas-mapper .icon {
        width: 100px
    }

    #sas-mapper .map {
        width: 97px;
        left: 528px;
        top: 140px;
    }

    #sas-mapper .ndvi {
        width: 82px;
        left: 750px;
        top: 364px;
    }

    #sas-mapper .seedCalc {
        width: 82px;
        left: 528px;
        top: 571px;
    }

    #sas-mapper .pictures {
        left: 300px;
        top: 350px;
    }

    #sas-mapper .icon img {
        max-width: 100%;
    }

    #sas-mapper .name {
        font-family: ProximaNovaBold;
        font-size: 28px;
        color: #fff;
    }

    #sas-mapper .map-name {
        left: 342px;
        top: 216px;
    }

    #sas-mapper .ndvi-name {
        left: 717px;
        top: 270px;
    }

    #sas-mapper .seedCalc-name {
        left: 660px;
        top: 540px;
    }

    #sas-mapper .pictures-name {
        left: 347px;
        top: 490px;
    }

    #sas-mapper .logo {
        position: absolute;
        right: 0;
        bottom: 0;
    }

    #sas-mapper .logo img {
        margin-right: 20px;
        margin-bottom: 20px;
        width: 300px;
    }
</style>