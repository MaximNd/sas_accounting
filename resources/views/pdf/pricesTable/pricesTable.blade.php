<div class="prices-table">
    <table>
        <thead>
            <tr>
                @foreach($headers as $text)
                    <th class="prices-table-header">
                        {{ $text }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
                <tr>
                    @foreach($row as $col)
                        <td class="{{ $col['classes'] or '' }}">
                            {{ $col['text'] }}
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="notation">
        <p>
            Усі розрахунки проводимо в гривні, ціна вказана з урахуванням ПДВ.
        </p>
    </div>
    @if(isset($dollarDate))
        <div class="dollar-date">
            <p>
                * курс вказаний на дату {{ $dollarDate }}
            </p>
        </div>
    @endif
</div>

<style>
    .prices-table {
        line-height: 0.9;
    }

    .prices-table table {
        color: #4D4D4D;
        margin: 0 auto;
        width: 75%;
        border-collapse:separate;
        border-spacing: 6px 6px;
    }

    .prices-table table tr th.prices-table-header {
        font-family: ProximaNovaBold;
        font-weight: 400;
        background-color: #28B691;
        text-align: center;
        color: #fff;
        font-size: 28px;
        padding: 5px 10px;
        margin: 0;
    }

    .prices-table table tr:nth-child(even) td {
        background-color: #E9E9E9;
    }

    .prices-table table tr:nth-child(odd) td {
        background-color: #F2F2F2;
    }

    .prices-table table tr:first-child td {
        /*border: 2px solid #fff;*/
        /*border-top: 4px solid #fff;*/
        margin: 0;
    }

    .prices-table table tr td {
        /*border: 2px solid #fff;*/
        margin: 0;
    }

    .prices-table table tr:nth-child(1) th {
        /*border-left: 2px solid #fff;*/
        /*border-right: 2px solid #fff;*/
        margin: 0;
    }

    .prices-table table tr:nth-child(2) th {
        /*border-left: 4px solid #fff;*/
        margin: 0;
    }

    .prices-table table tr {
        margin: 0;
    }

    .prices-table table tr td {
        font-family: ProximaNovaBold;
        font-size: 28px;
        padding: 5px 10px;
        text-align: center;
    }

    .prices-table table tr td.small-text {
        font-family: ProximaNova;
        font-size: 20px;
        padding: 3px 8px;
    }

    .prices-table table tr td.bold-text {
        font-family: ProximaNovaBold;
    }

    .prices-table table tr td.prices-text-left {
        text-align: left;
    }

    .prices-table .notation {
        font-family: ProximaNovaBold;
        margin: 0 auto;
        width: 75%;
        font-size: 19px;
        color: #949494;
    }

    .prices-table .notation p {
        margin-top: 10px;
        margin-left: 7px;
        margin-bottom: 0;
    }

    .prices-table .dollar-date {
        font-family: ProximaNova;
        margin: 0 auto;
        width: 75%;
        color: rgb(218, 0, 0);
    }

    .prices-table .dollar-date p {
        margin-top: 6px;
        margin-left: 23px;
        margin-bottom: 0;
    }
</style>
