<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Reports &nbsp;&nbsp;<span> (Last Updated On:
                    {{ $last_updated }}) updated on weekly basis</span></h6>

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
                    <select class="form-select form-control" aria-label="Default select example"
                        wire:model="selected_bank_type">
                        <option value="">Select Institution Type</option>
                        @foreach ($bankTypes as $bt)
                            <option value="{{ $bt->id }}">{{ $bt->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <p><span class="text-success">Green: Increase </span>
                        <span class="text-danger"> Red: Decrease </span>
                        <span class="text-dark">Black: No Change</span>
                    </p>
                </div>
                <div class="col-md-2">
                    <div class="dropdown d-flex mb-2" style="float:right;">
                        <button class="btn dropdown-toggle" style="background-color:#4e73df; color:white;"
                            type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
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
                                        style="background-color:#4e73df; color:white; padding: 1px 15px;"
                                        wire:click="deselectAll">
                                        Deselect All
                                    </button>
                                @else
                                    <button class="btn mt-2"
                                        style="background-color:#4e73df; color:white; padding: 1px 15px;"
                                        wire:click="selectAll">
                                        Select All
                                    </button>
                                @endif
                            </div>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="table-responsive table__font_style">
                <div class="table-wrapper">
                    <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <td class="first-col">Institution Name</td>
                                @foreach ($rate_type as $rt)
                                    @if ($columns[$rt->id] == 1)
                                        <th>{{ $rt->name }}</th>
                                    @endif
                                @endforeach
                            </tr>
                            <tr>
                                <th class="first-col"> </th>
                                @foreach ($rate_type as $rt)
                                    @if ($columns[$rt->id] == 1)
                                        <th>
                                            <table class="table table-bordered" id="dataTable" width="100%"
                                                cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Previous</th>
                                                        <th>APY</th>
                                                        <th>Changes</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </th>
                                    @endif
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($reports as $report)
                                <tr>
                                    <td class="first-col">{{ $report->name }}</td>
                                    @foreach ($rate_type as $rt_key => $rt)
                                        @if ($columns[$rt->id] == 1)
                                            <td>
                                                <table class="table table-bordered" id="dataTable" width="100%"
                                                    cellspacing="0">
                                                    <tbody>
                                                        @if ($report[$rt->id] != null)
                                                            <tr>
                                                                @if ($report[$rt->id]['current_rate'] > $report[$rt->id]['previous_rate'])
                                                                    <td class="text-success">
                                                                        {{ number_format($report[$rt->id]['previous_rate'],2) }}</td>
                                                                    <td class="text-success">
                                                                        {{ number_format($report[$rt->id]['current_rate'],2) }}</td>
                                                                    <td class="text-success">
                                                                        {{ number_format($report[$rt->id]['change'],2) }} <i
                                                                            class="fa fa-arrow-up"
                                                                            aria-hidden="true"></i></td>
                                                                @elseif ($report[$rt->id]['current_rate'] == $report[$rt->id]['previous_rate'])
                                                                    <td class="text-dark">{{ number_format($report[$rt->id]['previous_rate'],2) }}</td>
                                                                    <td class="text-dark">{{ number_format($report[$rt->id]['current_rate'],2) }}</td>
                                                                    <td class="text-dark">{{ number_format($report[$rt->id]['change'],2) }}</td>
                                                                @else
                                                                    <td class="text-danger">
                                                                        {{ number_format($report[$rt->id]['previous_rate'],2) }}</td>
                                                                    <td class="text-danger">
                                                                        {{ number_format($report[$rt->id]['current_rate'],2) }}</td>
                                                                    <td class="text-danger">
                                                                        {{ number_format($report[$rt->id]['change'],2) }} <i
                                                                            class="fa fa-arrow-down"
                                                                            aria-hidden="true"></i></td>
                                                                @endif
                                                            </tr>
                                                        @else
                                                            <tr>
                                                                <td>---</td>
                                                                <td>---</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </td>
                                        @endif
                                    @endforeach
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No Data</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                @if ($results != null)
                                    <td class="first-col"></td>
                                    @foreach ($results as $rt)
                                        @if ($columns[$rt->id] == 1)
                                            @if (
                                                $rt->c_max != null &&
                                                    $rt->p_max != null &&
                                                    $rt->c_min != null &&
                                                    $rt->p_min != null &&
                                                    $rt->c_avg != null &&
                                                    $rt->p_avg != null &&
                                                    $rt->c_med != null &&
                                                    $rt->p_med != null &&
                                                    $rt->c_mode != null &&
                                                    $rt->p_mode != null)
                                                <td>
                                                    <table class="table table-bordered" id="dataTable" width="100%"
                                                        cellspacing="0">
                                                        <thead>
                                                            <th></th>
                                                            <th>Current</th>
                                                            <th>Prior</th>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Highest APY</td>
                                                                <td>{{ number_format($rt->c_max, 2) }}</td>
                                                                <td>{{ number_format($rt->p_max, 2) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Median</td>
                                                                <td>{{ number_format($rt->c_med, 2) }}</td>
                                                                <td>{{ number_format($rt->p_med, 2) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Lowest APY</td>
                                                                <td>{{ number_format($rt->c_min, 2) }}</td>
                                                                <td>{{ number_format($rt->p_min, 2) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Average</td>
                                                                <td>{{ number_format($rt->c_avg, 2) }}</td>
                                                                <td>{{ number_format($rt->p_avg, 2) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Mode</td>
                                                                <td>{{ number_format($rt->c_mode, 2) }}</td>
                                                                <td>{{ number_format($rt->p_mode, 2) }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            @endif
                                        @endif
                                    @endforeach
                                @endif
                            </tr>
                        </tfoot>
                    </table>
                </div>
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
