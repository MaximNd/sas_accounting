<div id="counting-seealings" class="page">
    @include('pdf.leftImage.leftImage', ['image' => '/storage/image57_s.jpg'])
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
            'title' => 'Підрахунок всходів',
            'data' => [
                [ 'list_item_offset' => '-20px', 'icon_margin_top' => '2px', 'icon' => 'storage/image52.png', 'html' => '<span style="font-family:ProximaNovaBold;font-size: 22px;">Сканування частин полів (3-5га) на малих висотах -<br> 20-30м</span>' ],
                [ 'list_item_offset' => '-20px', 'icon_margin_top' => '3px', 'icon' => 'storage/image59.png', 'html' => '<span style="font-family:ProximaNovaBold;font-size: 22px;">Створення ортофотоплану надвисокої роздільної<br> здатності (0,5 см/пкс)</span>' ],
                [ 'list_item_offset' => '0px', 'icon_margin_top' => '0px', 'icon' => 'storage/image58.png', 'text' => 'Аналіз та підрахунок кількості рослин' ]
            ],
            'iconWidth' => '8.5%',
            'textWidth' => '91.5%',
            'listMarginLeft' => '50px',
            'listMarginTop' => '65px'
        ]
    ])
    <div class="clearfix"></div>
</div>
<div class="page-break"></div>

<style>
    #counting-seealings {
        position: relative;
        width: 100%;
    }
</style>