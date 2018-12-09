<div class="price-wrapper" style="{{ $wrapperStyles }}">
    <div class="price-data-wrapper" style="{{ $dataWrapperStyles or '' }}">
        <span style="{{ $priceStyles['text'] }}" class="price-text">{{ $text }}&nbsp;</span>
        <span style="{{ $priceStyles['price'] }}" class="price font-weight-bold">{{ $price }}</span>
        <span style="{{ $priceStyles['currency'] }}" class="price-currency font-weight-bold">$</span>
    </div>
</div>

<style>
    .price-wrapper {
        position: absolute;
        left:377px;top:670px;
        color: white;
        font-family: ProximaNova;
        text-align: center;
        vertical-align: middle;
        z-index: 2;
    }

    .price-wrapper .price-data-wrapper {
        display: inline-block;
    }

    .price-wrapper .price-text {
        z-index: 3;
        display: inline-block;
        font-family: ProximaNova;
    }

    .price-wrapper .price {
        z-index: 3;
        display: inline-block;
        font-family: ProximaNovaBlack;
    }

    .price-wrapper .price-currency {
        z-index: 3;
        display: inline-block;
        font-family: ProximaNovaBold;
    }
</style>