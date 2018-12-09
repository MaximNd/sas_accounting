<li
    class="{{ $isMain ? 'list-item' : 'list-item-horizontal' }}">
    <div class="icon">
        <img src="{{ $image }}" alt="icon">
    </div>
    <div class="list-item-data">
        <div class="name">{{ $name }}</div>
        <div class="price">
            <span class="price-name">Ціна:&nbsp;</span>
            <span class="price-price">{{ $price }}</span>
            <span class="currency">$</span>
        </div>
    </div>
</li>

<style>
    .list-item {
        height: 80px;
        line-height: 200px;
        margin-bottom: 3px;
        width: auto;
    }

    .list-item-horizontal {
        display: inline-block;
        width: 49%;
        height: 80px;
        /*list-style-type: none;*/
        /*float: left;*/
    }

    .list-item-horizontal .icon,
    .list-item .icon {
        display: inline-block;
        vertical-align: middle;
        line-height: 1.2;
        width: 23%;
        margin-right: 8px;
    }

    .list-item-horizontal .icon img,
    .list-item .icon img {
        max-width: 100%;
    }

    .list-item-horizontal .list-item-data,
    .list-item .list-item-data {
        display: inline-block;
        vertical-align: middle;
        line-height: 1.2;
        text-align: center;
        font-family: ProximaNova;
        font-size: 20px;
    }

    .list-item-horizontal .list-item-data .name,
    .list-item .list-item-data .name {
        font-family: ProximaNovaBlack;
        text-align: left;
    }

    .list-item-horizontal .list-item-data .price,
    .list-item .list-item-data .price {
        font-family: ProximaNova;
        /*display: flex;*/
        /*justify-content: flex-start;*/
        /*align-items: center;*/
        text-align: left;
        margin-top: -3px;
    }

    .list-item-horizontal .list-item-data .price-name,
    .list-item-horizontal .list-item-data .price-price,
    .list-item-horizontal .list-item-data .currency,
    .list-item .list-item-data .price-name,
    .list-item .list-item-data .price-price,
    .list-item .list-item-data .currency {
        display: inline-block;
        vertical-align: middle;
        /*line-height: 1.2;*/
    }


    .list-item-horizontal .list-item-data .price-price,
    .list-item-horizontal .list-item-data .currency,
    .list-item .list-item-data .price-price,
    .list-item .list-item-data .currency {
        font-family: ProximaNovaBold;
    }

    .list-item-horizontal .list-item-data .price span.price-name,
    .list-item .list-item-data .price span.price-name {
        font-size: 20px;
    }

    .list-item-horizontal .list-item-data .price span.price-price,
    .list-item .list-item-data .price span.price-price {
        font-size: 24px;
    }

    .list-item-horizontal .list-item-data .price span.currency,
    .list-item .list-item-data .price span.currency {
        font-size: 20px;
        margin-top: -5px;
        margin-left: -4px;
    }
</style>