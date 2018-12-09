<div id="eng-project" class="page" column>
    <div class="title-eng-project-wrapper">
        <div class="title-eng-project">
            Інженерний проект
        </div>
    </div>
    <div style="{{ !$showPrices ? 'margin-top: 10%;' : ''}}">
        @include('pdf.pricesTable.pricesTable', [
            'headers' => ['Тип', 'шт.', 'Ціна, $'],
            'data' => $data,
            'dollarDate' => $dollarDate
        ])
        @if($showPrices)
            <div class="eng-project-prices" style="margin-top:{{ $gruppedEquipmentLength <= 10 ? '40px': '15px' }}">
                <div class="days-price">
                    <p>Відрядні: {{ $formattedPriceForDays }} <img class="currency" src="storage/196px-Hryvnia_symbol.svg.png" alt="UAH"></p>
                </div>
                <div class="equipment-price">
                    <p>Обладнання: {{ $formattedEquipmentPrice }} <img class="currency" src="storage/196px-Hryvnia_symbol.svg.png" alt="UAH"></p>
                </div>
                <div class="installation-price">
                    <p>Монтаж обладнання: {{ $formattedInstallationPrice }} <img class="currency" src="storage/196px-Hryvnia_symbol.svg.png" alt="UAH"></p>
                </div>
                <div class="transport-price">
                    <p>Транспортні витрати: {{ $formattedTransportPrice }} <img class="currency" src="storage/196px-Hryvnia_symbol.svg.png" alt="UAH"></p>
                </div>
                <div class="final-price">
                    <p>Всього: {{ $formattedFinalPrice }} <img class="currency" src="storage/196px-Hryvnia_symbol.svg (1).png" alt="UAH"></p>
                </div>
            </div>
        @endif
    </div>
    <div class="eng-project-bottom-logo">
        <img class="sas-logo" src="storage/image4.png" alt="logo">
    </div>
</div>
<div class="page-break"></div>

<style>
    #eng-project .title-eng-project-wrapper {
        height: 75px;
    }

    #eng-project .title-eng-project-wrapper .title-eng-project {
        font-family: ProximaNovaBlack;
        font-size: 40px;
        text-align: center;
        color: #4D4D4D;
        margin-top: 10px;
        margin-left: 10px;
    }

    #eng-project .eng-project-prices {
        line-height: 0.9;
        text-align: center;
    }

    #eng-project .eng-project-prices p {
        margin: 0;
        padding: 0;
    }

    #eng-project .eng-project-prices img.currency {
        display: inline-block;
        margin-top: 2px;
    }

    #eng-project .eng-project-prices .final-price img.currency {
        margin-top: 0px;
    }

    #eng-project .eng-project-prices .equipment-price,
    #eng-project .eng-project-prices .installation-price,
    #eng-project .eng-project-prices .transport-price,
    #eng-project .eng-project-prices .days-price {
        font-family: ProximaNova;
        font-size: 28px;
        color: rgb(77, 77, 77);
        margin-bottom: 10px;
    }

    #eng-project .eng-project-prices .final-price {
        font-family: ProximaNovaBold;
        font-size: 36px;
        color: rgb(77, 77, 77);
    }

    #eng-project .eng-project-bottom-logo {
        position: absolute;
        left: 927px;
        top: 758px;
        width: 210px;
        height: 50px;
    }

    #eng-project .eng-project-bottom-logo img {
        margin-right: 10px;
        margin-bottom: 10px;
        width: 200px;
    }
</style>