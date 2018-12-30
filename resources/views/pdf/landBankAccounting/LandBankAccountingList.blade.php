<div id="land-bank-accounting-list" class="page">
    @include('pdf.leftImage.leftImage', ['image' => 'storage/image31_s.jpg'])
    @php
        $str_price = strval($price);
        $margin_left = 20;
        switch (strlen($str_price)) {
            case 1:
                $margin_left = 47;
                break;
            case 3:
                $margin_left = 37;
                break;
            case 4:
                $margin_left = 27;
                break;
            default:
                $margin_left = 20;
                break;
        }
    @endphp
    @include('pdf.price.price', [
        'price' => $price,
        'text' => 'Ціна',
        'wrapperStyles' => 'left:377px;top:670px;font-size:20px;width:200px;height:70px;background-color:#009769;',
        'priceStyles' => [
            'text' => 'margin-left:'.$margin_left.'px; font-size:31px; margin-top:-101px;',
            'price' => 'font-size:31px; margin-left: -5px; margin-top:-101px;',
            'currency' => 'margin-left: -3px; margin-top:-114px; font-size:26px'
        ]
    ])
    @include('pdf.serviceData.serviceData', [
        'grid' => false,
        'data' => [
            'title' => 'Облік земельного банку',
            'data' => [
                [ 'list_item_offset' => '35px', 'icon_margin_top' => '0px', 'icon' => 'storage/image32.png', 'text' => 'Створення векторного (цифрового) шару' ],
                [ 'list_item_offset' => '35px', 'icon_margin_top' => '0px', 'icon' => 'storage/image34.png', 'text' => 'Тренінги по роботі з модулем' ],
                [ 'list_item_offset' => '0px', 'icon_margin_top' => '0px', 'icon' => 'storage/image33.png', 'text' => 'Початкове налаштування системи' ]
            ],
            'iconWidth' => '7.5%',
            'textWidth' => '92.5%',
            'listMarginTop' => '60px',
            'listMarginLeft' => '50px'
        ]
    ])
    <div class="clearfix"></div>
</div>
<div class="page-break"></div>
