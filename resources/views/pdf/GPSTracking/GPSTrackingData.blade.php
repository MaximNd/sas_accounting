@php
    $slicedEquipmentList = array_chunk($equipment, 7);
    $mainList = [];
    $secondaryList = [];
    if (isset($slicedEquipmentList[0]) && count($slicedEquipmentList[0]) > 0) {
        $mainList = $slicedEquipmentList[0];
    }
    if (isset($slicedEquipmentList[1]) && count($slicedEquipmentList[1]) > 0) {
        $secondaryList = $slicedEquipmentList[1];
    }

    $finalPrice = 0;
    for ($i = 0; $i < count($equipment); ++$i) {
       $finalPrice += $equipment[$i]['price'];
    }
@endphp

<div id="gps-tracking-data{{ $index }}" class="page">
    <div class="gps-data-title-wrapper">
        <div class="gps-data-title">GPS - моніторинг</div>
    </div>
    <div class="gps-data-left">
        <ul class="main-data-list">
            @foreach($mainList as $equipmentItem)
                @include('pdf.GPSTracking.listItem.listItem', [
                    'isMain' => true,
                    'image' => $equipmentItem['image'],
                    'name' => $equipmentItem['name'],
                    'price' => $equipmentItem['price']
                ])
            @endforeach
        </ul>
    </div>
    <div class="gps-data-right">
        <div class="transport-image-wrapper">
            <div class="transport-image">
                <img src="{{ $transportImage }}" alt="transport">
            </div>
            <div>
                <p class="transport-name">{{ $transportName }}</p>
            </div>
        </div>
        <div class="secondary-data-list-wrapper" style="{{ count($secondaryList) <= 2 ? 'margin-top:30px' : '' }}">
            @php
                $splittedSecondaryList = array_chunk($secondaryList, 2);
            @endphp
            @foreach($splittedSecondaryList as $chunkSecondaryList)
                <ul class="secondary-data-list">
                    @foreach($chunkSecondaryList as $equipmentItem)
                        @include('pdf.GPSTracking.listItem.listItem', [
                            'isMain' => false,
                            'image' => $equipmentItem['image'],
                            'name' => $equipmentItem['name'],
                            'price' => $equipmentItem['price']
                        ])
                    @endforeach
                </ul>
            @endforeach
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="gps-data-bottom-logo">
        @include('pdf.price.price', [
            'text' => 'Всього',
            'price' => $finalPrice,
            'dataWrapperStyles' => 'float:right',
            'wrapperStyles' => 'left:0px;top:728px;text-align:right;font-size:20px;width:380px;height:60px;background-color:#00b881',
            'priceStyles' => [
                'text' => 'font-size:34px; margin-top:6px;',
                'price' => 'font-size:34px; margin-left: -4px; margin-right: -2px; margin-top:6px;',
                'currency' => 'margin-right:20px; margin-top:-5px; font-size:28px'
            ]
        ])
        <img src="storage/image4.png" alt="logo">
    </div>
    <div class="clearfix"></div>
</div>
<div class="page-break"></div>

<style>
    .gps-data-title-wrapper {
        width: 100%;
        height: 50px;
    }

    .gps-data-title {
        width: 100%;
        font-family: ProximaNovaBlack !important;
        font-size: 49px;
        text-align: center;
        margin-top: 25px;
        color: rgb(77, 77, 77);
    }

    .gps-data-left {
        float: left;
        width: 41.66666667%;
        height: 582px;
    }

    .gps-data-right {
        float: left;
        width: 58.33333333%;
        height: 582px;
    }

    .gps-data-right .transport-image-wrapper {
        margin-top: 65px;
        width: 100%;
        height: 500px;
    }

    .gps-data-right .secondary-data-list-wrapper {
        width: 100%;
        height: 82px;
    }

    .main-data-list {
        height: 100%;
        padding: 0;
        margin: 0;
        list-style: none;
        margin-left: 40px;
    }

    .secondary-data-list {
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .transport-image {
        height: 400px;
        width: 80%;
        margin: 0 auto;
    }

    .transport-image img {
        max-width: 100%;
        display: block;
    }

    .transport-name {
        font-family: ProximaNovaBlack;
        height: 100px;
        text-align: center;
        font-size: 32px;
        margin-bottom: 0px;
    }

    .gps-data-bottom-logo {
        margin-top: 125px;
        width: 1137.9px;
        height: 150px;
    }

    .gps-data-bottom-logo img {
        margin-right: 10px;
        margin-bottom: 10px;
        width: 200px;
        float: right;
    }
</style>