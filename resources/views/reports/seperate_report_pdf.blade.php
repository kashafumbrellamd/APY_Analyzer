<div class="container">
    <div class="row">
        @foreach ($reports as $key => $rt)
            @if ($columns[$rt->id] == 1)
                <div class="col-md-6 mt-3">
                    <div class="table-responsive table__font_style">
                        <h5 class="m-0 font-weight-bold text-primary" style="text-align:center;">{{ $rt->name }}</h5>
                        <div class="table-wrapper">
                            <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="first-col" style="text-align:center;">Bank Name</td>
                                        <th class="first-col" style="text-align:center;">Previous</td>
                                        <th class="first-col" style="text-align:center;">APY</td>
                                        <th class="first-col" style="text-align:center;">Changes</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($rt['banks'] as $bank)
                                        <tr>
                                            <tbody>
                                                @if ($bank != null)
                                                    <tr>
                                                        @if ($bank['current_rate'] > $bank['previous_rate'])
                                                            <td class="text-success" style="text-align:center;">
                                                                {{ $bank['bank_name'] }}</td>
                                                            <td class="text-success" style="text-align:center;">
                                                                {{ $bank['previous_rate'] }}</td>
                                                            <td class="text-success" style="text-align:center;">
                                                                {{ $bank['current_rate'] }}</td>
                                                            <td class="text-success" style="text-align:center;">
                                                                {{ $bank['change'] }} <i class="fa fa-arrow-up"
                                                                    aria-hidden="true"></i></td>
                                                        @elseif ($bank['current_rate'] == $bank['previous_rate'])
                                                            <td style="text-align:center;">{{ $bank['bank_name'] }}</td>
                                                            <td style="text-align:center;">{{ $bank['previous_rate'] }}</td>
                                                            <td style="text-align:center;">{{ $bank['current_rate'] }}</td>
                                                            <td style="text-align:center;">---</td>
                                                        @else
                                                            <td class="text-danger" style="text-align:center;">
                                                                {{ $bank['bank_name'] }}</td>
                                                            <td class="text-danger" style="text-align:center;">
                                                                {{ $bank['previous_rate'] }}</td>
                                                            <td class="text-danger" style="text-align:center;">
                                                                {{ $bank['current_rate'] }}</td>
                                                            <td class="text-danger" style="text-align:center;">
                                                                {{ $bank['change'] }} <i class="fa fa-arrow-down"
                                                                    aria-hidden="true"></i></td>
                                                        @endif
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td style="text-align:center;">---</td>
                                                        <td style="text-align:center;">---</td>
                                                        <td style="text-align:center;">---</td>
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
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
<style>
    .table {
        border-radius: 0.2rem;
        width: 100%;
        padding-bottom: 1rem;
        color: #212529;
        margin-bottom: 0;
    }

    .first-col {
        position: sticky;
        left: 0;
        color: #373737;
        background: #fafafa
    }

    .table td {
        white-space: nowrap;
    }
</style>
