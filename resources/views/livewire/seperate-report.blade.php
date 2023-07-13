<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Reports &nbsp;&nbsp;<span> (Last Updated On: {{ $last_updated }}) updated on weekly basis</span></h6>

        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-2">
                    @if ($customer_type->display_reports == 'custom')
                        <select class="form-select form-control" aria-label="Default select example" wire:model="state_id">
                            <option value="">Select State</option>
                            @foreach ($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                            <option value="all">All Data</option>
                        </select>
                    @elseif($customer_type->display_reports == 'state')
                        <select class="form-select form-control" aria-label="Default select example"
                            wire:model="msa_code">
                            <option value="">Select MSA Code</option>
                            @foreach ($msa_codes as $code)
                                <option value="{{ $code->msa_code }}">{{ $code->msa_code }}</option>
                            @endforeach
                            <option value="all">All Data</option>
                        </select>
                    @endif
                </div>
                <div class="col-md-3">

                </div>
                <div class="col-md-6">
                    <div class="dropdown d-flex mb-2" style="float:right;">
                        <button class="btn dropdown-toggle" style="background-color:#4e73df; color:white;" type="button" id="dropdownMenuButton1"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Select Columns
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark" style="background:gray;"
                            aria-labelledby="dropdownMenuButton1">
                            @php
                                $count = 0;
                            @endphp
                            @foreach ($rate_type as $rt)
                            <li>
                                <div class="form-check ml-1" style="color:white;">
                                    @if ($columns[$rt->id] == 1)
                                        <input class="form-check-input" type="checkbox" value="" checked
                                            wire:click="check_column({{ $rt->id }})">
                                        {{ $rt->name }}
                                        @php
                                            $count++;
                                        @endphp
                                    @else
                                        <input class="form-check-input" type="checkbox" value=""
                                            wire:click="check_column({{ $rt->id }})">
                                        {{ $rt->name }}
                                    @endif
                                </div>
                            </li>
                            @endforeach
                            <div class="text-center">
                                @if ($count == count($rate_type))
                                    <button class="btn mt-2"
                                        style="background-color:#4e73df; color:white; padding: 1px 15px;" wire:click="deselectAll">
                                        Deselect All
                                    </button>
                                @else
                                    <button class="btn mt-2"
                                        style="background-color:#4e73df; color:white; padding: 1px 15px;" wire:click="selectAll">
                                        Select All
                                    </button>
                                @endif
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
            @foreach($reports as $rt)
            @if($columns[$rt->id] == 1)
            <div class="table-responsive table__font_style">
                <div class="table-wrapper">
                <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="first-col">Bank Name</td>
                            <th class="first-col">Previous</td>
                            <th class="first-col">APY</td>
                            <th class="first-col">Changes</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rt['banks'] as $bank)
                            <tr>
                                <tbody>
                                    @if ($bank != null)
                                        <tr>
                                            @if ($bank['current_rate'] > $bank['previous_rate'])
                                                <td class="text-success">{{ $bank['bank_name'] }}</td>
                                                <td class="text-success">{{ $bank['previous_rate'] }}</td>
                                                <td class="text-success">{{ $bank['current_rate'] }}</td>
                                                <td class="text-success">{{ $bank['change'] }}  <i class="fa fa-arrow-up" aria-hidden="true"></i></td>
                                            @elseif ($bank['current_rate'] == $bank['previous_rate'])
                                                <td>{{ $bank['bank_name'] }}</td>
                                                <td>{{ $bank['previous_rate'] }}</td>
                                                <td>{{ $bank['current_rate'] }}</td>
                                                <td>{{ $bank['change'] }}</td>
                                                @else
                                                <td class="text-danger">{{ $bank['bank_name'] }}</td>
                                                <td class="text-danger">{{ $bank['previous_rate'] }}</td>
                                                <td class="text-danger">{{ $bank['current_rate'] }}</td>
                                                <td class="text-danger">{{ $bank['change'] }}  <i class="fa fa-arrow-down" aria-hidden="true"></i></td>
                                            @endif
                                        </tr>
                                    @else
                                        <tr>
                                            <td>---</td>
                                            <td>---</td>
                                            <td>---</td>
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
                            <th>Stats</th>
                            <th>Current</th>
                            <th>Prior</th>
                        </tr>
                        <tr>
                            <td>Highest APY</td>
                            <td>{{ round($results[$rt->id]['c_max'],2) }}</td>
                            <td>{{ round($results[$rt->id]['p_max'],2) }}</td>
                        </tr>
                        <tr>
                            <td>Median</td>
                            <td>{{ round($results[$rt->id]['c_med'],2) }}</td>
                            <td>{{ round($results[$rt->rate_type_id]['p_med'],2) }}</td>
                        </tr>
                        <tr>
                            <td>Lowest APY</td>
                            <td>{{ round($results[$rt->rate_type_id]['c_min'],2) }}</td>
                            <td>{{ round($results[$rt->rate_type_id]['p_min'],2) }}</td>
                        </tr>
                        <tr>
                            <td>Average</td>
                            <td>{{ round($results[$rt->rate_type_id]['c_avg'],2) }}</td>
                            <td>{{ round($results[$rt->rate_type_id]['p_avg'],2) }}</td>
                        </tr>
                        <tr>
                            <td>Mode</td>
                            <td>{{ round($results[$rt->rate_type_id]['c_mode'],2) }}</td>
                            <td>{{ round($results[$rt->rate_type_id]['p_mode'],2) }}</td>
                        </tr>
                    </tfoot>
                </table>
                </div>
            </div>
            @endif
            @endforeach

            {{-- <div class="card-body">
                <h2 class="text-center"></h2>
                <div class="chart-area m-2">
                    <canvas id="mhlChart"></canvas>
                </div>
                <hr>
                <h2 class="text-center"></h2>
                <div class="chart-area m-2">
                    <canvas id="mamChart"></canvas>
                </div>
                <hr>
                <h2 class="text-center"></h2>
                <div class="chart-area m-2">
                    <canvas id="mhrChart"></canvas>
                </div>
            </div> --}}
        </div>
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
