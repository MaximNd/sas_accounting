<div id="chemical-analysis-of-soils" class="page">
    @include('pdf.leftImage.leftImage', ['image' => 'storage/image77_s.jpg'])
    @php
        $str_price = strval($price);
        $margin_left = 25;
        switch (strlen($str_price)) {
            case 1:
                $margin_left = 47;
                break;
            case 3:
                $margin_left = 35;
                break;
            case 4:
                $margin_left = 25;
                break;
            default:
                $margin_left = 25;
                break;
        }
    @endphp
    @include('pdf.price.price', [
        'price' => $price,
        'text' => 'Ціна',
        'wrapperStyles' => 'left:179px;top:670px;font-size:20px;width:200px;height:70px;background-color:rgba(205, 180, 56, 0.84);',
        'priceStyles' => [
            'text' => 'margin-left:'.$margin_left.'px; font-size:31px; margin-top:-101px;',
            'price' => 'font-size:31px; margin-left: -5px; margin-top:-101px;',
            'currency' => 'margin-left: -4px; margin-top:-114px; font-size:26px'
        ]
    ])
    @include('pdf.serviceData.serviceData', [
        'grid' => false,
        'withYara' => true,
        'data' => [
            'title' => 'Хімічний аналіз ґрунтів',
            'data' => [
                [ 'list_item_offset' => '-10px', 'icon_margin_top' => '-3px', 'icon' => 'storage/image78.png', 'text' => 'Відбір проб' ],
                [ 'list_item_offset' => '-5px', 'icon_margin_top' => '-3px', 'icon' => 'storage/image80.png', 'text' => 'Доставка' ],
                [ 'list_item_offset' => '-10px', 'icon_margin_top' => '-5px', 'icon' => 'storage/image79.png', 'text' => 'Тестування' ],
                [ 'list_item_offset' => '-10px', 'icon_margin_top' => '-1px', 'icon' => 'storage/image81.png', 'text' => 'Рекомендації' ],
                [ 'list_item_offset' => '0px', 'icon_margin_top' => '0px', 'icon' => 'storage/image83.png', 'text' => 'Візуалізація' ]
            ],
            'iconWidth' => '7.5%',
            'textWidth' => '92.5%',
            'listMarginLeft' => '50px',
            'listMarginTop' => '50px'
        ]
    ])
    <div class="clearfix"></div>
</div>
<div class="page-break"></div>

<style>
    #chemical-analysis-of-soils {
        position: relative;
        width: 100%;
    }
</style>
