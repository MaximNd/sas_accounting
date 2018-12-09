<div id="soil-hardness-measuring" class="page">
    @include('pdf.leftImage.leftImage', ['image' => '/storage/image84_s.jpg'])
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
        'data' => [
            'title' => 'Вимірювання твердості ґрунту',
            'data' => [
                [ 'list_item_offset' => '-32px', 'icon_margin_top' => '3px', 'icon' => 'storage/image85.png', 'html' => '<span style="font-family: ProximaNovaBold;font-size: 22px;">Вимірювання твердості ґрунту на різних глибинах (до<br> 45см)</span>' ],
                [ 'list_item_offset' => '-13px', 'icon_margin_top' => '-3px', 'icon' => 'storage/image86.png', 'text' => 'Прив\'язка GPS кординат до кожного виміру' ],
                [ 'list_item_offset' => '-8px', 'icon_margin_top' => '0px', 'icon' => 'storage/image87.png', 'text' => 'Відправка даних на сервер через GSM' ],
                [ 'list_item_offset' => '0px', 'icon_margin_top' => '-1px', 'icon' => 'storage/image88.png', 'text' => 'Візуалізація карти щільності в Cropio' ]
            ],
            'iconWidth' => '7.5%',
            'textWidth' => '92.5%',
            'listMarginLeft' => '50px',
            'listMarginTop' => '45px'
        ]
    ])
    <div class="clearfix"></div>
</div>
<div class="page-break"></div>

<style>
    #soil-hardness-measuring {
        position: relative;
        width: 100%;
    }
</style>