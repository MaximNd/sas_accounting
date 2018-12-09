<div id="connection-to-platform-title" class="page">
    @include('pdf.serviceTitle.serviceTitle', ['title' => 'Підключення <br/> до платформи SASAGRO.COM', 'styles' => 'top: 24%;transform: translateY(-24%);'])
    @php
        $str_price = strval($price);
        $margin_left = 65;
        $dollar_margin_left = '-10';
        switch (strlen($str_price)) {
            case 1:
                $margin_left = 105;
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
        'price' => $price,
        'text' => 'Ціна',
        'wrapperStyles' => 'left:0;top:678px;font-size: 36px; width: 338px; height: 88px; background-color: #009769;',
        'priceStyles' => [
            'text' => 'margin-left:'.$margin_left.'px; font-size:44px; margin-top:20px;',
            'price' => 'font-size:44px; margin-left: -10px; margin-top:20px;',
            'currency' => 'margin-left: '.$dollar_margin_left.'px; margin-top: 2px;'
        ]
    ])
</div>
<div class="page-break"></div>

<style>
    #connection-to-platform-title {
        background-image: url('/storage/image12_s.jpg');
        background-size: 102% 101%;
        background-position-x: 100%;
    }
</style>