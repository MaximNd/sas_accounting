<div id="fields-mapping-by-ph" class="page">
    @include('pdf.leftImage.leftImage', ['image' => 'storage/image22_s.jpg'])
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
            'title' => 'Картування полів',
            'subtitle' => 'Фізичний обмір',
            'data' => [
                [ 'list_item_offset' => '-3px', 'icon_margin_top' => '0px', 'icon' => 'storage/image23.png', 'text' => 'Об\'їзд' ],
                [ 'list_item_offset' => '-3px', 'icon_margin_top' => '0px', 'icon' => 'storage/image25.png', 'text' => 'Точкування' ],
                [ 'list_item_offset' => '-3px', 'icon_margin_top' => '0px', 'icon' => 'storage/image26.png', 'text' => 'Результат' ],
                [ 'list_item_offset' => '-3px', 'icon_margin_top' => '0px', 'icon' => 'storage/image27.png', 'text' => 'Швидка обробка результату' ],
                [ 'list_item_offset' => '-3px', 'icon_margin_top' => '0px', 'icon' => 'storage/image27.png', 'text' => 'Низька ціна' ],
                [ 'list_item_offset' => '-3px', 'icon_margin_top' => '0px', 'icon' => 'storage/image28.png', 'text' => 'Точність 15см' ],
                [ 'list_item_offset' => '0px', 'icon_margin_top' => '0px', 'icon' => 'storage/image28.png', 'text' => 'Неможливість обміру за наявності посівів' ]
            ],
            'iconWidth' => '5.5%',
            'textWidth' => '94.5%',
            'listMarginLeft' => '50px',
            'listMarginTop' => '10px'
        ]
    ])
    <div class="clearfix"></div>
</div>
<div class="page-break"></div>

<style>
    #fields-mapping-by-ph {
        position: relative;
        width: 100%;
    }
</style>