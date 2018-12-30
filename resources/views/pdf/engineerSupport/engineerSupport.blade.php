<div id="engineer-support" class="page">
    @include('pdf.leftImage.leftImage', ['image' => 'storage/image102_s.jpg'])
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
        'wrapperStyles' => 'left:179px;top:670px;font-size:20px;width:200px;height:70px;background-color:rgba(136, 207, 215, 0.84);',
        'priceStyles' => [
            'text' => 'margin-left:'.$margin_left.'px; font-size:31px; margin-top:-101px;',
            'price' => 'font-size:31px; margin-left: -5px; margin-top:-101px;',
            'currency' => 'margin-left: -3px; margin-top:-114px; font-size:26px'
        ]
    ])
    @include('pdf.serviceData.serviceData', [
        'grid' => false,
        'data' => [
            'title' => 'Інженерна служба',
            'data' => [
                [ 'list_item_offset' => '-10px', 'icon_margin_top' => '-3px', 'icon' => 'storage/image103.png', 'text' => 'Установка та налаштування GPS-трекерів' ],
                [ 'list_item_offset' => '-10px', 'icon_margin_top' => '-2px', 'icon' => 'storage/image104.png', 'text' => 'Встановлення та заміна SIM-карт' ],
                [ 'list_item_offset' => '0px', 'icon_margin_top' => '3px', 'icon' => 'storage/image105.png', 'html' => '<span style="font-family:ProximaNovaBold;font-size: 22px;">Технічка підтримка (ремонт та обслуговування<br> обладнання навігації, виїзд впродовж 72 год.)</span>' ]
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
    #engineer-support {
        position: relative;
        width: 100%;
    }
</style>