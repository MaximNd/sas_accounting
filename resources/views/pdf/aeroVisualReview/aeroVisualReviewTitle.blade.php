<div id="aero-visual-review-title" class="page">
    @include('pdf.backgroundImage.BackgroundImage', ['image' => 'storage/image60_s.png'])
    @include('pdf.serviceTitle.serviceTitle', ['title' => 'Аеровізуальний<br> огляд', 'styles' => 'top: 34%;transform: translateY(-34%);'])
    @php
        $str_price = strval($price);
        $margin_left = 65;
        $dollar_margin_left = '-10';
        switch (strlen($str_price)) {
            case 1:
                $margin_left = 100;
                $dollar_margin_left = '-8';
                break;
            case 3:
                $margin_left = 80;
                $dollar_margin_left = '-8';
                break;
            case 4:
                $margin_left = 65;
                break;
            default:
                $margin_left = 65;
                break;
        }
    @endphp
    @include('pdf.price.price', [
        'price' => $price   ,
        'text' => 'Ціна',
        'wrapperStyles' => 'left:0;top:678px;font-size: 36px; width: 338px; height: 88px; background-color: #009769;',
        'priceStyles' => [
            'text' => 'margin-left:'.$margin_left.'px; font-size:44px; margin-top:21px;',
            'price' => 'font-size:44px; margin-left: -10px; margin-top:21px;',
            'currency' => 'margin-left: '.$dollar_margin_left.'px; margin-top: 3px;'
        ]
    ])
</div>
<div class="page-break"></div>

<style>
    /*#aero-visual-review-title {*/
        /*background-image: url('/storage/image60_s.png');*/
        /*background-repeat: no-repeat;*/
    /*}*/
</style>