<div id="service-prices" class="page">
    <div class="service-prices-table">
        @include('pdf.pricesTable.pricesTable', [
            'headers' => ['Послуги', 'Ціна, $'],
            'data' => $servicePrices,
            'dollarDate' => $dollarDate
        ])
        <div class="service-prices">
            <div class="final-price">
                <p>Всього: {{ $finalPrice }} <img class="currency" src="storage/196px-Hryvnia_symbol.svg (2).png" alt="uah"></p>
            </div>
        </div>
    </div>
    <div class="service-prices-bottom-logo">
        <img src="storage/image4.png" alt="logo">
    </div>
</div>
<div class="page-break"></div>

<style>
    #service-prices .service-prices {
        margin-top: 50px;
        text-align: center;
    }

    #service-prices .service-prices-table {
        margin-top: 40px;
    }

    #service-prices .service-prices p {
        margin: 0;
        padding: 0;
    }

    #service-prices .service-prices .final-price {
        font-family: ProximaNovaBold;
        font-size: 36px;
        color: rgb(77, 77, 77);
    }

    #service-prices .service-prices .final-price img.currency {
        display: inline-block;
        margin-top: 2px;
    }

    #service-prices .service-prices-bottom-logo {
        position: absolute;
        left: 927px;
        top: 758px;
        width: 210px;
        height: 50px;
    }

    #service-prices .service-prices-bottom-logo img {
        margin-right: 10px;
        margin-bottom: 10px;
        width: 200px;
    }
</style>