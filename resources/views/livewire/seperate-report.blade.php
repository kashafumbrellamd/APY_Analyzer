<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="d-flex font-weight-bold justify-content-between m-0 text-primary">Reports &nbsp;&nbsp; (Last Updated On: {{ $last_updated }}) updated on weekly basis
                {{-- <span class="text-success">Green: Increase </span>
                    <span class="text-danger">Red: Decrease</span>
                    <span class="text-dark">Black: No Change</span> --}}
                </h6>

        </div>
        <div class="card-body">
            <div class="row">
                @if ($customer_type->display_reports == 'custom')
                    {{-- <div class="col-md-2 mb-2">
                        <select class="form-select form-control" aria-label="Default select example" wire:change="selectstate($event.target.value)" wire:model="state_id">
                            <option value="">Select State</option>
                            @foreach ($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select form-control" aria-label="Default select example"
                            wire:model="msa_code">
                            <option value="">Select Metropolitan Area</option>
                            @foreach ($msa_codes as $code)
                                <option value="{{ $code->city_id }}">{{ $code->cities->name }}</option>
                            @endforeach
                        </select>
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
                    <div class="col-md-2">
                        <select class="form-select form-control" aria-label="Default select example"
                            wire:model="selected_bank">
                            <option value="">Select Institution</option>
                            @foreach ($banks as $bank)
                                <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <!-- <button class="btn btn-primary" style="background-color:#4e73df; color:white; float:right;" type="button">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button> -->
                        <button class="btn" style="background-color:#4e73df; color:white; float:right;" wire:click="print_report">Generate PDF</button>
                    </div>
                    <div class="col-md-2">
                        <div class="dropdown d-flex mb-2">
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
                    <div class="col-md-2">
                        <button class="btn" style="background-color:#4e73df; color:white;" wire:click="save_filters">Save Filters</button>
                    </div>
                    <div class="col-md-2">
                        <button class="btn" style="background-color:#4e73df; color:white;" wire:click="load_filters">Apply Filters</button>
                    </div>
                    <div class="col-md-2">
                        <button class="btn" style="background-color:#4e73df; color:white;" wire:click="clear()">Clear Filters</button>
                    </div> --}}
                @endif
                @if ($customer_type->display_reports == 'state')
                    <div class="col-md-3">
                        <select class="form-select form-control" aria-label="Default select example"
                            wire:model="msa_code">
                            <option value="">Select Metropolitan Area</option>
                            @foreach ($msa_codes as $code)
                                <option value="{{ $code->cbsa_code }}">{{ $code->cbsa_name }}</option>
                            @endforeach
                            <option value="all">All Data</option>
                        </select>
                    </div>

                    {{-- <div class="col-md-3">
                        <select class="form-select form-control" aria-label="Default select example"
                            wire:model="selected_bank_type">
                            <option value="">Select All</option>
                            <option value="">Select Institution Type</option>
                            @foreach ($bankTypes as $bt)
                                <option value="{{ $bt->id }}">{{ $bt->name }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                    <div class="col-md-3">
                        <select class="form-select form-control" aria-label="Default select example"
                            wire:model="selected_bank">
                            <option value="">Select Institution</option>
                            @foreach ($banks as $bank)
                                <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn" style="background-color:#4e73df; color:white; float:right;" wire:click="print_report">Generate PDF</button>
                    </div>
                    <div class="col-md-2">
                        <div class="dropdown d-flex mb-2">
                            <button class="btn dropdown-toggle" style="background-color:#4e73df; color:white;" type="button" id="dropdownMenuButton1"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Select Institution Types
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark" style="background:gray;"
                                aria-labelledby="dropdownMenuButton1">
                                @foreach ($bankTypes as $bt)
                                <li>
                                    <div class="form-check ml-1" style="color:white;">
                                        <input class="form-check-input" type="checkbox" value="{{ $bt->id }}" checked
                                            wire:model='selected_bank_type'
                                            {{-- wire:click="change_ins_type({{ $bt->id }})" --}}
                                            >
                                        {{ $bt->name }}
                                    </div>
                                </li>
                                @endforeach
                                <div class="text-center">
                                    @if (count($bankTypes) == count($selected_bank_type))
                                        <button class="btn mt-2"
                                            style="background-color:#4e73df; color:white; padding: 1px 15px;" wire:click="deselectAllInstituteType">
                                            Deselect All
                                        </button>
                                    @else
                                        <button class="btn mt-2"
                                            style="background-color:#4e73df; color:white; padding: 1px 15px;" wire:click="selectAllInstituteType">
                                            Select All
                                        </button>
                                    @endif
                                </div>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="dropdown d-flex mb-2">
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
                    <div class="col-md-2">
                        <button class="btn" style="background-color:#4e73df; color:white;" wire:click="save_filters">Save Filters</button>
                    </div>
                    <div class="col-md-2">
                        <button class="btn" style="background-color:#4e73df; color:white;" wire:click="load_filters">Apply Filters</button>
                    </div>
                    <div class="col-md-2">
                        <button class="btn" style="background-color:#4e73df; color:white;" wire:click="clear()">Clear Filters</button>
                    </div>
                    {{--<div class="col-md-4"></div>
                     <div class="align-items-end col-md-2 d-flex">
                        <h4>Unique: </h4>
                        <label class="switch">
                            <input type="checkbox" wire:model="unique">
                            <span class="slider round"></span>
                        </label>
                    </div> --}}
                @endif
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
            <div class="row" wire:loading.class="invisible">
            @foreach($reports as $key => $rt)
            @if($columns[$rt->id] == 1)
            <div class="col-md-6 mt-3">
            <div class="table-responsive table__font_style">
            <h5 class="m-0 font-weight-bold text-primary" style="text-align:center;">{{$rt->name}}</h5>
                <div class="table-wrapper">
                <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="first-col" style="text-align:center;">Rank</td>
                            <th class="first-col" style="text-align:center;">Institution Name</td>
                            {{-- <th class="first-col" style="text-align:center;">Area Name</td> --}}
                            {{-- <th class="first-col" style="text-align:center;">Zip Code</td> --}}
                            <th class="first-col" style="text-align:center;">Previous</td>
                            <th class="first-col" style="text-align:center;">APY</td>
                            <th class="first-col" style="text-align:center;">Changes</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rt['banks'] as $key1 => $bank)
                            <tr>
                                <tbody>
                                    @if ($bank != null)
                                        @if ($selected_bank == $bank['bank_id'])
                                            <tr style="background-color: #e8e7e7;">
                                                <td>{{ ++$key1 }}</td>
                                                @if($bank['bank_id'] == $my_bank_id)
                                                    <td style="text-align: left; color:#9d4201!important;">{{ $bank['bank_name'] }}</td>
                                                    {{-- <td style="color:#9d4201!important;">{{ $bank['cbsa_name'] }}</td>
                                                    <td style="color:#9d4201!important;">{{ $bank['zip_code'] }}</td> --}}
                                                @else
                                                    <td style="text-align: left;">{{ $bank['bank_name'] }}</td>
                                                    {{-- <td>{{ $bank['cbsa_name'] }}</td>
                                                    <td>{{ $bank['zip_code'] }}</td> --}}
                                                    @endif
                                                @if ($bank['current_rate'] > $bank['previous_rate'])
                                                    <td class="text-success" style="text-align:center;">{{ number_format($bank['previous_rate'],2) }}</td>
                                                    <td class="text-success" style="text-align:center;">{{ number_format($bank['current_rate'],2) }}</td>
                                                    <td class="text-success" style="text-align:center;">{{ number_format($bank['change'],2) }}  <i class="fa fa-arrow-up" aria-hidden="true"></i></td>
                                                @elseif ($bank['current_rate'] == $bank['previous_rate'])
                                                    <td class="text-dark" style="text-align:center;">{{ number_format($bank['previous_rate'],2) }}</td>
                                                    <td class="text-dark" style="text-align:center;">{{ number_format($bank['current_rate'],2) }}</td>
                                                    <td class="text-dark" style="text-align:center;">---</td>
                                                @else
                                                    <td class="text-danger" style="text-align:center;">{{ number_format($bank['previous_rate'],2) }}</td>
                                                    <td class="text-danger" style="text-align:center;">{{ number_format($bank['current_rate'],2) }}</td>
                                                    <td class="text-danger" style="text-align:center;">{{ abs(number_format($bank['change'],2)) }}  <i class="fa fa-arrow-down" aria-hidden="true"></i></td>
                                                @endif
                                            </tr>
                                        @else
                                            <tr>
                                                <td>{{ ++$key1 }}</td>
                                                @if($bank['bank_id'] == $my_bank_id)
                                                    <td style="text-align: left; color:#9d4201!important;">{{ $bank['bank_name'] }}</td>
                                                    {{-- <td style="color:#9d4201!important;">{{ $bank['cbsa_name'] }}</td>
                                                    <td style="color:#9d4201!important;">{{ $bank['zip_code'] }}</td> --}}
                                                    @if ($bank['current_rate'] > $bank['previous_rate'])
                                                        <td class="text-success" style="text-align:center; color:#9d4201!important;">{{ number_format($bank['previous_rate'],2) }}</td>
                                                        <td class="text-success" style="text-align:center; color:#9d4201!important;">{{ number_format($bank['current_rate'],2) }}</td>
                                                        <td class="text-success" style="text-align:center; color:#9d4201!important;">{{ number_format($bank['change'],2) }}  <i class="fa fa-arrow-up" aria-hidden="true"></i></td>
                                                    @elseif ($bank['current_rate'] == $bank['previous_rate'])
                                                        <td class="text-dark" style="text-align:center; color:#9d4201!important;">{{ number_format($bank['previous_rate'],2) }}</td>
                                                        <td class="text-dark" style="text-align:center; color:#9d4201!important;">{{ number_format($bank['current_rate'],2) }}</td>
                                                        <td class="text-dark" style="text-align:center; color:#9d4201!important;">---</td>
                                                    @else
                                                        <td class="text-danger" style="text-align:center; color:#9d4201!important;">{{ number_format($bank['previous_rate'],2) }}</td>
                                                        <td class="text-danger" style="text-align:center; color:#9d4201!important;">{{ number_format($bank['current_rate'],2) }}</td>
                                                        <td class="text-danger" style="text-align:center; color:#9d4201!important;">{{ abs(number_format($bank['change'],2)) }}  <i class="fa fa-arrow-down" aria-hidden="true"></i></td>
                                                    @endif
                                                @else
                                                    <td style="text-align: left;">{{ $bank['bank_name'] }}</td>
                                                    {{-- <td>{{ $bank['cbsa_name'] }}</td>
                                                    <td>{{ $bank['zip_code'] }}</td> --}}
                                                    @if ($bank['current_rate'] > $bank['previous_rate'])
                                                        <td class="text-success" style="text-align:center;">{{ number_format($bank['previous_rate'],2) }}</td>
                                                        <td class="text-success" style="text-align:center;">{{ number_format($bank['current_rate'],2) }}</td>
                                                        <td class="text-success" style="text-align:center;">{{ number_format($bank['change'],2) }}  <i class="fa fa-arrow-up" aria-hidden="true"></i></td>
                                                    @elseif ($bank['current_rate'] == $bank['previous_rate'])
                                                        <td class="text-dark" style="text-align:center;">{{ number_format($bank['previous_rate'],2) }}</td>
                                                        <td class="text-dark" style="text-align:center;">{{ number_format($bank['current_rate'],2) }}</td>
                                                        <td class="text-dark" style="text-align:center;">---</td>
                                                    @else
                                                        <td class="text-danger" style="text-align:center;">{{ number_format($bank['previous_rate'],2) }}</td>
                                                        <td class="text-danger" style="text-align:center;">{{ number_format($bank['current_rate'],2) }}</td>
                                                        <td class="text-danger" style="text-align:center;">{{ abs(number_format($bank['change'],2)) }}  <i class="fa fa-arrow-down" aria-hidden="true"></i></td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endif
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
                    {{-- @if (
                        $results[$key]['c_max'] != null &&
                        $results[$key]['p_max'] != null &&
                        $results[$key]['c_min'] != null &&
                        $results[$key]['p_min'] != null &&
                        $results[$key]['c_avg'] != null &&
                        $results[$key]['p_avg'] != null &&
                        $results[$key]['c_med'] != null &&
                        $results[$key]['p_med'] != null &&
                        $results[$key]['c_mode'] != null &&
                        $results[$key]['p_mode'] != null) --}}
                    <tfoot>
                        <tr>
                            <th></th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th style="text-align:center;">Prior</th>
                            <th style="text-align:center;">Current</th>
                            <th style="text-align:center;">Change</th>
                        </tr>
                        <tr>
                            <td></td>
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
                                <td style="text-align:center;" class="text-danger">{{ abs(number_format($results[$key]['c_max']-$results[$key]['p_max'],2)) }} <i class="fa fa-arrow-down" aria-hidden="true"></i></td>
                            @endif
                        </tr>
                        <tr>
                            <td></td>
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
                                <td style="text-align:center;" class="text-danger">{{ abs(number_format($results[$key]['c_med']-$results[$key]['p_med'],2)) }} <i class="fa fa-arrow-down" aria-hidden="true"></i></td>
                            @endif
                        </tr>
                        <tr>
                            <td></td>
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
                                <td style="text-align:center;" class="text-danger">{{ abs(number_format($results[$key]['c_min']-$results[$key]['p_min'],2)) }} <i class="fa fa-arrow-down" aria-hidden="true"></i></td>
                            @endif
                            {{-- <td style="text-align:center;">{{ number_format($results[$key]['c_min']-$results[$key]['p_min'],2) }}</td> --}}
                        </tr>
                        <tr>
                            <td></td>
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
                                <td style="text-align:center;" class="text-danger">{{ abs(number_format($results[$key]['c_avg']-$results[$key]['p_avg'],2)) }} <i class="fa fa-arrow-down" aria-hidden="true"></i></td>
                            @endif
                        </tr>
                        <tr>
                            <td></td>
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
                                <td style="text-align:center;" class="text-danger">{{ abs(number_format($results[$key]['c_mode']-$results[$key]['p_mode'],2)) }} <i class="fa fa-arrow-down" aria-hidden="true"></i></td>
                            @endif
                        </tr>
                    </tfoot>
                    {{-- @endif --}}
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
    .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
    }

    .switch input {
    opacity: 0;
    width: 0;
    height: 0;
    }

    .slider {
    position: absolute;
    cursor: pointer;
    top: 10px;
    left: 10px;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
    }

    .slider:before {
    position: absolute;
    content: "";
    height: 15px;
    width: 15px;
    left: 4px;
    bottom: 5px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
    }

    input:checked + .slider {
    background-color: #2196F3;
    }

    input:focus + .slider {
    box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
    border-radius: 34px;
    }

    .slider.round:before {
    border-radius: 50%;
    }
</style>
