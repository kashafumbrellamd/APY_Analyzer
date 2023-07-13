<div class="container">
<div class="row">
@foreach($reports as $key => $rt)
@if($columns[$rt->id] == 1)
<div class="col-md-6 mt-3">
<div class="table-responsive table__font_style">
<h5 class="m-0 font-weight-bold text-primary" style="text-align:center;">{{$rt->name}}</h5>
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
                                    <td class="text-success" style="text-align:center;">{{ $bank['bank_name'] }}</td>
                                    <td class="text-success" style="text-align:center;">{{ $bank['previous_rate'] }}</td>
                                    <td class="text-success" style="text-align:center;">{{ $bank['current_rate'] }}</td>
                                    <td class="text-success" style="text-align:center;">{{ $bank['change'] }}  <i class="fa fa-arrow-up" aria-hidden="true"></i></td>
                                @elseif ($bank['current_rate'] == $bank['previous_rate'])
                                    <td style="text-align:center;">{{ $bank['bank_name'] }}</td>
                                    <td style="text-align:center;">{{ $bank['previous_rate'] }}</td>
                                    <td style="text-align:center;">{{ $bank['current_rate'] }}</td>
                                    <td style="text-align:center;">{{ $bank['change'] }}</td>
                                    @else
                                    <td class="text-danger" style="text-align:center;">{{ $bank['bank_name'] }}</td>
                                    <td class="text-danger" style="text-align:center;">{{ $bank['previous_rate'] }}</td>
                                    <td class="text-danger" style="text-align:center;">{{ $bank['current_rate'] }}</td>
                                    <td class="text-danger" style="text-align:center;">{{ $bank['change'] }}  <i class="fa fa-arrow-down" aria-hidden="true"></i></td>
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
                <th></th>
                <th style="text-align:center;">Current</th>
                <th style="text-align:center;">Prior</th>
            </tr>
            <tr>
                <td></td>
                <td style="text-align:center;">Highest APY</td>
                <td style="text-align:center;">{{ $results[$key]['c_max'] }}</td>
                <td style="text-align:center;">{{ $results[$key]['p_max'] }}</td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align:center;">Median</td>
                <td style="text-align:center;">{{ $results[$key]['c_med'] }}</td>
                <td style="text-align:center;">{{ $results[$key]['p_med'] }}</td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align:center;">Lowest APY</td>
                <td style="text-align:center;">{{ $results[$key]['c_min'] }}</td>
                <td style="text-align:center;">{{ $results[$key]['p_min'] }}</td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align:center;">Average</td>
                <td style="text-align:center;">{{ $results[$key]['c_avg'] }}</td>
                <td style="text-align:center;">{{ $results[$key]['p_avg'] }}</td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align:center;">Mode</td>
                <td style="text-align:center;">{{ $results[$key]['c_mode'] }}</td>
                <td style="text-align:center;">{{ $results[$key]['p_mode'] }}</td>
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
    .first-col{
    position: sticky;
    left: 0;
    color: #373737;
    background: #fafafa
    }
    .table td {
    white-space: nowrap;
    }
</style>
