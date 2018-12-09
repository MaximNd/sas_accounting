<div id="prices-1c">
    <div class="prices-1c-title-wrapper">
        <div class="prices-1c-title">
            1C Інтеграція
        </div>
    </div>
    <div class="prices-1c-table">
        @include('pdf.pricesTable.pricesTable', [
            'headers' => [
                'Кількість га',
                'Ціна, $'
            ],
            'data' => $prices
        ])
    </div>
    <div class="prices-1c-bottom-logo">
        <img class="sas-logo" src="storage/image4.png" alt="logo">
    </div>
</div>
<div class="page-break"></div>

<style>
    #prices-1c .prices-1c-title-wrapper {
        height: 220px;
    }

    #prices-1c .prices-1c-title-wrapper .prices-1c-title {
        font-family: ProximaNovaBlack;
        font-size: 40px;
        text-align: center;
        color: #4D4D4D;
        margin-top: 10px;
        margin-left: 10px;
    }

    #prices-1c .prices-1c-bottom-logo {
        position: absolute;
        left: 927px;
        top: 758px;
        width: 210px;
        height: 50px;
    }

    #prices-1c .prices-1c-bottom-logo img {
        margin-right: 10px;
        margin-bottom: 10px;
        width: 200px;
    }
</style>