<div class="right-data">
    <div class="right-data-main">
        <div
            class="right-data-title"
            style="margin-bottom: {{ $data['titleOffset'] or '0px'  }};height: {{ isset($data['subtitle']) ? '60px' : '90px' }};">
            {{ $data['title'] }}
        </div>
        <div class="data" style="height: {{ isset($data['subtitle']) ? '642px' : '612px' }};">
            @if(isset($data['subtitle']))
                <div
                    class="data-subtitle"
                    style="{{ $grid ? 'line-height: 0.9;' : '' }}margin-top: {{ $grid ? '25px' : '0px' }};margin-left: {{ $grid ? '35px' : '0px' }};text-align: {{ $grid ? 'left' : 'center' }};">
                    {{ $data['subtitle'] }}
                </div>
            @endif

            @if(!$grid)
                <ul
                    class="data-list"
                    style="margin-left: {{ $data['listMarginLeft'] }};margin-top: {{ $data['listMarginTop'] or '0px' }};">
                    @foreach($data['data'] as $item)
                        <li class="data-list-item" style="margin-bottom: {{ $item['list_item_offset'] }};">
                            <div class="icon" style="width: {{ $data['iconWidth'] or '7%' }};margin-top: {{ $item['icon_margin_top'] }};">
                                <img src="{{ $item['icon'] }}" alt="icon">
                            </div>
                            <div class="text" style="width: {{ $data['textWidth'] or 'auto' }};">
                                @if(isset($item['html']))
                                    <p style="font-family: ProximaNova;font-size: 22px;">
                                        {!! $item['html'] !!}
                                    </p>
                                @else
                                    <p>{{ $item['text'] }}</p>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="data-grid-list">
                    @foreach(array_chunk($data['data'], 4) as $dataItems)
                        <div>
                            @foreach($dataItems as $item)
                                <div class="item-data">
                                    <div class="icon" style="{{ $item['iconStyles'] }}">
                                        <img src="{{ $item['icon'] }}" alt="icon">
                                    </div>
                                    <div class="text" style="{{ $item['textStyles'] }}">
                                        <p>{{ $item['text'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="logo-bottom">
            @if(isset($withYara) && $withYara)
                <img class="yara-logo" src="storage/image82.png" alt="logo">
            @endif
            <img class="sas-logo" src="storage/image2.png" alt="logo">
        </div>
    </div>
</div>

<style>
    .right-data {
        height: 100%;
        background-color: #525252;
        /*position: relative;*/
        float: left;
        width: 66.66666667%;
        height: 807.9px;
    }

    .right-data .right-data-main {
        height: 807.9px;
    }

    .right-data .right-data-title {
        font-family: ProximaNovaBlack;
        font-size: 40px;
        color: #fff;
        text-align: center;
        padding-top: 5px;
        padding-bottom: 10px;
    }

    .right-data .data .data-subtitle {
        font-family: ProximaNovaBlack;
        font-size: 28px;
        color: #fff;
        margin-top: -37px;
    }

    .right-data .data .data-list {
        padding: 0;
        margin: 0;
        margin-left: 50px;
        list-style: none;
    }

    .right-data .data .data-grid-list {
        display: block;
        max-width: 100%;
        height: 610px;
    }

    .right-data .data .data-list .data-list-item {
        display: block;
        width: 100%;
    }

    .right-data .data-grid-list .item-data {
        width: 160px;
        height: 130px;
        padding: 12px;
        display: inline-block;
        position: relative;
    }

    .right-data .data-grid-list .item-data .icon {
        width: 75px;
        position: absolute;
    }

    .right-data .data .data-list .icon {
        display: inline-block;
        text-align: center;
        padding-left: 5px;
        padding-right: 5px;
    }

    .right-data .data .data-list .icon img,
    .right-data .data .data-grid-list .icon img {
        max-width: 100%;
    }

    .right-data .data .data-grid-list .text {
        position: absolute;
        font-family: ProximaNovaBold;
        font-size: 22px;
        color: #fff;
        text-align: center;
    }

    .right-data .data .data-list .text {
        display: inline-block;
        text-align: left;
        padding-left: 30px;
        padding-right: 5px;
        color: #fff;
        line-height: 1;
        vertical-align: middle;
    }

    .right-data .data .data-list .text p,
    .right-data .data .data-grid-list .text {
        font-family: ProximaNovaBold;
        font-size: 22px;
        margin: 0;
        padding: 0;
    }

    .right-data .logo-bottom {
        height: 118px;
    }

    .right-data .logo-bottom img.sas-logo {
        margin-right: 20px;
        margin-bottom: 20px;
        height: 70px;
        float: right;
    }

    .right-data .logo-bottom img.yara-logo {
        margin-left: 20px;
        margin-bottom: 20px;
        width: 70px;
        float: left;
    }
</style>