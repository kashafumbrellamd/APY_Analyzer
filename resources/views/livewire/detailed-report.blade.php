<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Reports &nbsp;&nbsp;<span> (Last Updated On:
                    {{ $last_updated }}) updated on weekly basis</span></h6>

        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-2 mb-2">
                    @if ($customer_type->display_reports == 'custom')
                        <select class="form-select form-control" aria-label="Default select example" wire:change="selectstate($event.target.value)" wire:model="state_id">
                            <option value="">Select State</option>
                            @foreach ($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                            <option value="all">All Data</option>
                        </select>
                    @endif
                </div>
                <div class="col-md-2">
                    @if ($customer_type->display_reports == 'custom')
                    <select class="form-select form-control" aria-label="Default select example"
                        wire:model="msa_code">
                        <option value="">Select City</option>
                        @foreach ($msa_codes as $code)
                            <option value="{{ $code->city_id }}">{{ $code->cities->name }}</option>
                        @endforeach
                    </select>
                    @endif
                </div>
                <div class="col-md-2">
                    <select class="form-select form-control" aria-label="Default select example"
                        wire:model="selected_bank_type">
                        <option value="">Select All</option>
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
                <div class="col-md-2">
                    <button class="btn" style="background-color:#4e73df; color:white;" wire:click="save_filters">Save Filters</button>
                </div>
                <div class="col-md-2">
                    <button class="btn" style="background-color:#4e73df; color:white;" wire:click="load_filters">Apply Filters</button>
                </div>
                @error('filter_error')
                <div class="mt-3 text-center">
                    <span class="alert alert-danger" role="alert">{{ $message }}</span>
                </div>
                @enderror
                @error('filter_success')
                <div class="mt-3 text-center">
                    <span class="alert alert-success" role="alert">{{ $message }}</span>
                </div>
                @enderror
            </div>
            <div class="text-center">
                <div wire:loading.delay>
                    <div class="spinner-border text-danger" role="status">
                    </div>
                    <br>
                    <span class="text-danger">Loading...</span>
                </div>
            </div>
            <div class="table-responsive table__font_style mt-3" wire:loading.class="invisible">
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
                                    @if($report->id == $my_bank_id)
                                        <td class="first-col" style="color:#9d4201!important;">{{ $report->name }}</td>
                                    @else
                                        <td class="first-col">{{ $report->name }}</td>
                                    @endif
                                    @foreach ($rate_type as $rt_key => $rt)
                                        @if($report->id == $my_bank_id)
                                            @if ($columns[$rt->id] == 1)
                                                <td>
                                                    <table class="table table-bordered" id="dataTable" width="100%"
                                                        cellspacing="0">
                                                        <tbody>
                                                            @if ($report[$rt->id] != null)
                                                                <tr>
                                                                    @if ($report[$rt->id]['current_rate'] > $report[$rt->id]['previous_rate'])
                                                                        <td class="text-success" style="color:#9d4201!important;">
                                                                            {{ number_format($report[$rt->id]['previous_rate'],2) }}</td>
                                                                        <td class="text-success" style="color:#9d4201!important;">
                                                                            {{ number_format($report[$rt->id]['current_rate'],2) }}</td>
                                                                        <td class="text-success" style="color:#9d4201!important;">
                                                                            {{ number_format($report[$rt->id]['change'],2) }} <i
                                                                                class="fa fa-arrow-up"
                                                                                aria-hidden="true"></i></td>
                                                                    @elseif ($report[$rt->id]['current_rate'] == $report[$rt->id]['previous_rate'])
                                                                        <td class="text-dark" style="color:#9d4201!important;">{{ number_format($report[$rt->id]['previous_rate'],2) }}</td>
                                                                        <td class="text-dark" style="color:#9d4201!important;">{{ number_format($report[$rt->id]['current_rate'],2) }}</td>
                                                                        <td class="text-dark" style="color:#9d4201!important;">---</td>
                                                                    @else
                                                                        <td class="text-danger" style="color:#9d4201!important;">
                                                                            {{ number_format($report[$rt->id]['previous_rate'],2) }}</td>
                                                                        <td class="text-danger" style="color:#9d4201!important;">
                                                                            {{ number_format($report[$rt->id]['current_rate'],2) }}</td>
                                                                        <td class="text-danger" style="color:#9d4201!important;">
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
                                        @else
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
                                                                        <td class="text-dark">---</td>
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
                                                            <th>Prior</th>
                                                            <th>Current</th>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Highest APY</td>
                                                                <td>{{ number_format($rt->p_max, 2) }}</td>
                                                                <td>{{ number_format($rt->c_max, 2) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Median</td>
                                                                <td>{{ number_format($rt->p_med, 2) }}</td>
                                                                <td>{{ number_format($rt->c_med, 2) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Lowest APY</td>
                                                                <td>{{ number_format($rt->p_min, 2) }}</td>
                                                                <td>{{ number_format($rt->c_min, 2) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Average</td>
                                                                <td>{{ number_format($rt->p_avg, 2) }}</td>
                                                                <td>{{ number_format($rt->c_avg, 2) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Mode</td>
                                                                <td>{{ number_format($rt->p_mode, 2) }}</td>
                                                                <td>{{ number_format($rt->c_mode, 2) }}</td>
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
