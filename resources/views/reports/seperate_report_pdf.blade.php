<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 3px;
            text-align: center;
            font-size: 10px;
        }

        th {
            background-color: #f2f2f2;
        }

    </style>
</head>

<body>
    <div class="text-center">Downloaded Date: {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',now())->format('m-d-Y') }}</div>
    <div class="text-center">Last Updated Date: {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', \App\Models\BankPrices::max('updated_at'))->format('m-d-Y'); }}</div>
    <div class="text-center">City:
    @foreach ($msa_codes as $key => $item)
            <p>
                {{ ++$key.") ".$item->cbsa_name }}
            </p>
    @endforeach
    </div>
    @foreach ($reports as $key => $rt)
    @if ($columns[$rt->id] == 1)
    <div class="table">
    <h5 style="text-align:center;">{{ $rt->name }}</h5>
        <table>
            <thead>
                <tr>
                    <th>Bank Name</td>
                    <th>Previous</td>
                    <th>APY</td>
                    <th>Changes</td>
                </tr>
            </thead>
            <tbody>
                @forelse ($rt['banks'] as $bank)
                    <tr>
                        <tbody>
                            @if ($bank != null)
                                <tr>
                                    @if ($bank['current_rate'] > $bank['previous_rate'])
                                        <td class="text-success" style="text-align:left;">
                                            {{ $bank['bank_name'] }}</td>
                                        <td class="text-success" style="text-align:left;">
                                            {{ number_format($bank['previous_rate'],2) }}</td>
                                        <td class="text-success" style="text-align:left;">
                                            {{ number_format($bank['current_rate'],2) }}</td>
                                        <td class="text-success" style="text-align:left;">
                                            {{ number_format($bank['change'],2) }} <i class="fa fa-arrow-up"
                                                aria-hidden="true"></i></td>
                                    @elseif ($bank['current_rate'] == $bank['previous_rate'])
                                        <td style="text-align:left;">{{ $bank['bank_name'] }}</td>
                                        <td style="text-align:left;">{{ number_format($bank['previous_rate'],2) }}</td>
                                        <td style="text-align:left;">{{ number_format($bank['current_rate'],2) }}</td>
                                        <td style="text-align:left;">---</td>
                                    @else
                                        <td class="text-danger" style="text-align:left;">
                                            {{ $bank['bank_name'] }}</td>
                                        <td class="text-danger" style="text-align:left;">
                                            {{ number_format($bank['previous_rate'],2) }}</td>
                                        <td class="text-danger" style="text-align:left;">
                                            {{ number_format($bank['current_rate'],2) }}</td>
                                        <td class="text-danger" style="text-align:left;">
                                            {{ number_format($bank['change'],2) }} <i class="fa fa-arrow-down"
                                                aria-hidden="true"></i></td>
                                    @endif
                                </tr>
                            @else
                                <tr>
                                    <td style="text-align:left;">---</td>
                                    <td style="text-align:left;">---</td>
                                    <td style="text-align:left;">---</td>
                                </tr>
                            @endif
                        </tbody>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No Data</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                </tr>
                <tr>
                    <th></th>
                    <th style="text-align:center;">Current</th>
                    <th style="text-align:center;">Prior</th>
                    <th style="text-align:center;">Change</th>
                </tr>
                <tr>
                    <td style="text-align:center;">Highest APY</td>
                    {{-- <td style="text-align:center;">{{ number_format($results[$key]['p_max'],2) }}</td>
                    <td style="text-align:center;">{{ number_format($results[$key]['c_max'],2) }}</td> --}}
                    @if ($results[$key]['c_max']-$results[$key]['p_max'] == "0")
                        <td style="text-align:center;">{{ number_format($results[$key]['p_max'],2) }}</td>
                        <td style="text-align:center;">{{ number_format($results[$key]['c_max'],2) }}</td>
                        <td style="text-align:center;" class="text-dark">---</td>
                    @elseif ($results[$key]['c_max']-$results[$key]['p_max'] > "0")
                        <td style="text-align:center;" class="text-success">{{ number_format($results[$key]['p_max'],2) }}</td>
                        <td style="text-align:center;" class="text-success">{{ number_format($results[$key]['c_max'],2) }}</td>
                        <td style="text-align:center;" class="text-success">{{ number_format($results[$key]['c_max']-$results[$key]['p_max'],2) }} <i class="fa fa-arrow-up" aria-hidden="true"></i></td>
                    @else
                        <td style="text-align:center;" class="text-danger">{{ number_format($results[$key]['p_max'],2) }}</td>
                        <td style="text-align:center;" class="text-danger">{{ number_format($results[$key]['c_max'],2) }}</td>
                        <td style="text-align:center;" class="text-danger">{{ number_format($results[$key]['c_max']-$results[$key]['p_max'],2) }} <i class="fa fa-arrow-down" aria-hidden="true"></i></td>
                    @endif
                </tr>
                <tr>
                    <td style="text-align:center;">Median</td>
                    @if ($results[$key]['c_med']-$results[$key]['p_med'] == "0")
                        <td style="text-align:center;">{{ number_format($results[$key]['p_med'],2) }}</td>
                        <td style="text-align:center;">{{ number_format($results[$key]['c_med'],2) }}</td>
                        <td style="text-align:center;" class="text-dark">---</td>
                    @elseif ($results[$key]['c_med']-$results[$key]['p_med'] > "0")
                        <td style="text-align:center;" class="text-success">{{ number_format($results[$key]['p_med'],2) }}</td>
                        <td style="text-align:center;" class="text-success">{{ number_format($results[$key]['c_med'],2) }}</td>
                        <td style="text-align:center;" class="text-success">{{ number_format($results[$key]['c_med']-$results[$key]['p_med'],2) }} <i class="fa fa-arrow-up" aria-hidden="true"></i></td>
                    @else
                        <td style="text-align:center;" class="text-danger">{{ number_format($results[$key]['p_med'],2) }}</td>
                        <td style="text-align:center;" class="text-danger">{{ number_format($results[$key]['c_med'],2) }}</td>
                        <td style="text-align:center;" class="text-danger">{{ number_format($results[$key]['c_med']-$results[$key]['p_med'],2) }} <i class="fa fa-arrow-down" aria-hidden="true"></i></td>
                    @endif
                </tr>
                <tr>
                    <td style="text-align:center;">Lowest APY</td>
                    @if ($results[$key]['c_min']-$results[$key]['p_min'] == "0")
                        <td style="text-align:center;">{{ number_format($results[$key]['p_min'],2) }}</td>
                        <td style="text-align:center;">{{ number_format($results[$key]['c_min'],2) }}</td>
                        <td style="text-align:center;" class="text-dark">---</td>
                    @elseif ($results[$key]['c_min']-$results[$key]['p_min'] > "0")
                        <td style="text-align:center;" class="text-success">{{ number_format($results[$key]['p_min'],2) }}</td>
                        <td style="text-align:center;" class="text-success">{{ number_format($results[$key]['c_min'],2) }}</td>
                        <td style="text-align:center;" class="text-success">{{ number_format($results[$key]['c_min']-$results[$key]['p_min'],2) }} <i class="fa fa-arrow-up" aria-hidden="true"></i></td>
                    @else
                        <td style="text-align:center;" class="text-danger">{{ number_format($results[$key]['p_min'],2) }}</td>
                        <td style="text-align:center;" class="text-danger">{{ number_format($results[$key]['c_min'],2) }}</td>
                        <td style="text-align:center;" class="text-danger">{{ number_format($results[$key]['c_min']-$results[$key]['p_min'],2) }} <i class="fa fa-arrow-down" aria-hidden="true"></i></td>
                    @endif
                    {{-- <td style="text-align:center;">{{ number_format($results[$key]['c_min']-$results[$key]['p_min'],2) }}</td> --}}
                </tr>
                <tr>
                    <td style="text-align:center;">Average</td>
                    @if ($results[$key]['c_avg']-$results[$key]['p_avg'] == "0")
                        <td style="text-align:center;">{{ number_format($results[$key]['p_avg'],2) }}</td>
                        <td style="text-align:center;">{{ number_format($results[$key]['c_avg'],2) }}</td>
                        <td style="text-align:center;" class="text-dark">---</td>
                    @elseif ($results[$key]['c_avg']-$results[$key]['p_avg'] > "0")
                        <td style="text-align:center;" class="text-success">{{ number_format($results[$key]['p_avg'],2) }}</td>
                        <td style="text-align:center;" class="text-success">{{ number_format($results[$key]['c_avg'],2) }}</td>
                        <td style="text-align:center;" class="text-success">{{ number_format($results[$key]['c_avg']-$results[$key]['p_avg'],2) }} <i class="fa fa-arrow-up" aria-hidden="true"></i></td>
                    @else
                        <td style="text-align:center;" class="text-danger">{{ number_format($results[$key]['p_avg'],2) }}</td>
                        <td style="text-align:center;" class="text-danger">{{ number_format($results[$key]['c_avg'],2) }}</td>
                        <td style="text-align:center;" class="text-danger">{{ number_format($results[$key]['c_avg']-$results[$key]['p_avg'],2) }} <i class="fa fa-arrow-down" aria-hidden="true"></i></td>
                    @endif
                </tr>
                <tr>
                    <td style="text-align:center;">Mode</td>
                    @if ($results[$key]['c_mode']-$results[$key]['p_mode'] == "0")
                        <td style="text-align:center;">{{ number_format($results[$key]['p_mode'],2) }}</td>
                        <td style="text-align:center;">{{ number_format($results[$key]['c_mode'],2) }}</td>
                        <td style="text-align:center;" class="text-dark">---</td>
                    @elseif ($results[$key]['c_mode']-$results[$key]['p_mode'] > "0")
                        <td style="text-align:center;" class="text-success">{{ number_format($results[$key]['p_mode'],2) }}</td>
                        <td style="text-align:center;" class="text-success">{{ number_format($results[$key]['c_mode'],2) }}</td>
                        <td style="text-align:center;" class="text-success">{{ number_format($results[$key]['c_mode']-$results[$key]['p_mode'],2) }} <i class="fa fa-arrow-up" aria-hidden="true"></i></td>
                    @else
                        <td style="text-align:center;" class="text-danger">{{ number_format($results[$key]['p_mode'],2) }}</td>
                        <td style="text-align:center;" class="text-danger">{{ number_format($results[$key]['c_mode'],2) }}</td>
                        <td style="text-align:center;" class="text-danger">{{ number_format($results[$key]['c_mode']-$results[$key]['p_mode'],2) }} <i class="fa fa-arrow-down" aria-hidden="true"></i></td>
                    @endif
                </tr>
            </tfoot>
        </table>
    </div>
    @endif
    @endforeach
    <div class="clearfix"></div>
</body>

</html>
