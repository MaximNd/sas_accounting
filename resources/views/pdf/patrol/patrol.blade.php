<div id="patrol" class="page">
    @include('pdf.leftImage.leftImage', ['image' => 'storage/image46_s.png'])
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
        'wrapperStyles' => 'left:379px;top:670px;font-size:20px;width:200px;height:70px;background-color:#009769;',
        'priceStyles' => [
            'text' => 'margin-left:'.$margin_left.'px; font-size:31px; margin-top:-101px;',
            'price' => 'font-size:31px; margin-left: -5px; margin-top:-101px;',
            'currency' => 'margin-left: -3px; margin-top:-114px; font-size:26px'
        ]
    ])
    @include('pdf.serviceData.serviceData', [
        'grid' => false,
        'data' => [
            'title' => 'Патрулювання',
            'data' => [
                [ 'list_item_offset' => '30px', 'icon_margin_top' => '-3px', 'icon' => 'storage/image47.png', 'text' => 'Узгодження потенційно небезпечних територій' ],
                [ 'list_item_offset' => '30px', 'icon_margin_top' => '-3px', 'icon' => 'storage/image48.png', 'text' => 'Здійснення патрулювання посівів' ],
                [ 'list_item_offset' => '30px', 'icon_margin_top' => '7px', 'icon' => 'storage/image49.png', 'html' => '<span style="font-family: ProximaNovaBold;font-size: 22px;">У разі виявлення порушників інформування служби <br> безпеки господарства</span>' ],
                [ 'list_item_offset' => '0px', 'icon_margin_top' => '-7px', 'icon' => 'storage/image50.png', 'text' => 'Звіт про виконану роботу' ]
            ],
            'iconWidth' => '8%',
            'textWidth' => '92%',
            'listMarginLeft' => '55px',
            'listMarginTop' => '60px'
        ]
    ])
    <div class="clearfix"></div>
</div>
<div class="page-break"></div>

<style>
    #patrol {
        position: relative;
        width: 100%;
    }
</style>