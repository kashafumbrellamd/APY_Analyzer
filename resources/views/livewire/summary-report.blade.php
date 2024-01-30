<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Reports &nbsp;&nbsp;<span> (Last Updated On:
                    {{ $last_updated }}) updated on weekly basis</span></h6>

        </div>
        <div class="card-body">
            <div class="row">
                @if ($customer_bank->display_reports == "state")
                    <div class="col-md-3 mb-2">
                        <select class="form-select form-control" aria-label="Default select example"
                            wire:model="selected_bank">
                            <option value="">Select Institution</option>
                            @foreach ($banks as $bank)
                                <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-7">
                        <div class="dropdown d-flex mb-2" style="float:right;">
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
                        {{-- <select class="form-select form-control" aria-label="Default select example"
                            wire:model="selected_bank_type">
                            <option value="">Select All</option>
                            <option value="">Select Institution Type</option>
                            @foreach ($bankTypes as $bankType)
                                <option value="{{ $bankType->id }}">{{ $bankType->name }}</option>
                            @endforeach
                        </select> --}}
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
                    <div class="col-md-2">
                        <button class="btn" style="background-color:#4e73df; color:white;" wire:click="clear_filer">Clear Filters</button>
                    </div>
                    {{-- <div class="col-md-4"></div>
                    <div class="align-items-end col-md-2 d-flex">
                        <h4>Unique: </h4>
                        <label class="switch">
                            <input type="checkbox" wire:model="unique">
                            <span class="slider round"></span>
                        </label>
                    </div> --}}
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
                @endif
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
                <div class="table-wrapper" style="height: 100vh;  overflow: auto;">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead style="position: sticky;top: 0; color: #373737; background: #fafafa">
                            <tr>
                                <th scope="col">Rank</th>
                                @foreach ($rate_type as $rt)
                                    @if ($columns[$rt->id] == 1)
                                        <th scope="col">{{ $rt->name }}</th>
                                    @endif
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $maxItems = 0;
                                foreach ($rate_type as $rt) {
                                    if ($columns[$rt->id] == 1 && count($rt['data']) > $maxItems) {
                                        $maxItems = count($rt['data']);
                                    }
                                }
                            @endphp

                            @php
                                $count = 1;
                            @endphp
                            @for ($i = 0; $i < $maxItems; $i++)
                                <tr>
                                    <td>{{ $count }}</td>
                                    @foreach ($rate_type as $key => $rt)
                                        @if ($columns[$rt->id] == 1)
                                            @if (isset($rt['data'][$i]))
                                            @if ($rt['data'][$i]->bank_id != $my_bank_id)
                                                @if ($rt['data'][$i]->bank_id != $selected_bank)
                                                    <td
                                                        title="Change: {{ $rt['data'][$i]->change }} &#10;Previous: {{ $rt['data'][$i]->previous_rate }}&#10;Last Updated: {{date('m-d-Y',strtotime(explode(' ',$rt['data'][$i]->created_at)[0]))}}">
                                                        {{ $rt['data'][$i]->bank_name }}
                                                        {{-- <span style="color: #000000!important;">({{ $rt['data'][$i]->cbsa_name }}) ({{ $rt['data'][$i]->zip_code }})</span> --}}
                                                        ({{ number_format($rt['data'][$i]->current_rate,2) }})</td>
                                                @else
                                                    <td
                                                        title="Change: {{ $rt['data'][$i]->change }} &#10;Previous: {{ $rt['data'][$i]->previous_rate }}&#10;"
                                                        class="text-danger">{{ $rt['data'][$i]->bank_name }}
                                                        {{-- <span style="color: #000000!important;">({{ $rt['data'][$i]->cbsa_name }}) ({{ $rt['data'][$i]->zip_code }})</span> --}}
                                                        ({{ number_format($rt['data'][$i]->current_rate,2) }})</td>
                                                @endif
                                            @else
                                                @if ($rt['data'][$i]->bank_id != $selected_bank)
                                                    <td style="color:#9d4201!important;"
                                                        title="Change: {{ $rt['data'][$i]->change }} &#10;Previous: {{ $rt['data'][$i]->previous_rate }}&#10;Last Updated: {{date('m-d-Y',strtotime(explode(' ',$rt['data'][$i]->created_at)[0]))}}">
                                                        {{ $rt['data'][$i]->bank_name }}
                                                         {{-- <span style="color: #000000!important;">({{ $rt['data'][$i]->cbsa_name }}) ({{ $rt['data'][$i]->zip_code }})</span> --}}
                                                        ({{ number_format($rt['data'][$i]->current_rate,2) }})</td>
                                                @else
                                                    <td style="color:#9d4201!important;"
                                                        title="Change: {{ $rt['data'][$i]->change }} &#10;Previous: {{ $rt['data'][$i]->previous_rate }}&#10;"
                                                        class="text-danger">
                                                            {{ $rt['data'][$i]->bank_name }}
                                                            {{-- <span style="color: #000000!important;">({{ $rt['data'][$i]->cbsa_name }}) ({{ $rt['data'][$i]->zip_code }})</span> --}}
                                                            ({{ number_format($rt['data'][$i]->current_rate,2) }})
                                                    </td>
                                                @endif
                                            @endif
                                            @else
                                                <td> </td>
                                            @endif
                                        @endif
                                    @endforeach
                                </tr>
                                @php
                                 $count++;
                                @endphp
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
<style>
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

    .text-danger{
        color: green !important;
    }





</style>
