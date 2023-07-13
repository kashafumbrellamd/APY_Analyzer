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
                <div class="col-md-7">
                    <button class="btn" style="background-color:#4e73df; color:white; float:right;" wire:click="print_report">Generate PDF</button>
                </div>
                <div class="col-md-2">
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
                            @foreach ($reports as $rt)
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
                                @if ($count == count($reports))
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
