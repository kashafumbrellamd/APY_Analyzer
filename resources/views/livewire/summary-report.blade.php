<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Reports &nbsp;&nbsp;<span> (Last Updated On:
                    {{ $last_updated }}) updated on weekly basis</span></h6>

        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-2">
                    <select class="form-select form-control" aria-label="Default select example"
                        wire:model="selected_bank">
                        <option value="">Select Institution</option>
                        @foreach ($banks as $bank)
                            <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select form-control" aria-label="Default select example"
                        wire:model="selected_bank_type">
                        <option value="">Select Institution Type</option>
                        @foreach ($bankTypes as $bankType)
                            <option value="{{ $bankType->id }}">{{ $bankType->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
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
                    <button class="btn" style="background-color:#4e73df; color:white;" wire:click="load_filters">Load Filters</button>
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
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Rank.</th>
                                @foreach ($rate_type as $rt)
                                    @if ($columns[$rt->id] == 1)
                                        <th>{{ $rt->name }}</th>
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
                                            @if ($rt['data'][$i]->bk_id != $my_bank_id)
                                                @if ($rt['data'][$i]->bk_id != $selected_bank)
                                                    <td 
                                                        title="Change: {{ $rt['data'][$i]->change }} &#10;Previous: {{ $rt['data'][$i]->previous_rate }}&#10;Last Updated: {{date('m-d-Y',strtotime(explode(' ',$rt['data'][$i]->created_at)[0]))}}">
                                                        {{ $rt['data'][$i]->bk_name }}
                                                        ({{ number_format($rt['data'][$i]->current_rate,2) }})</td>
                                                @else
                                                    <td
                                                        title="Change: {{ $rt['data'][$i]->change }} &#10;Previous: {{ $rt['data'][$i]->previous_rate }}&#10;"
                                                        class="text-danger">{{ $rt['data'][$i]->bk_name }}
                                                        ({{ number_format($rt['data'][$i]->current_rate,2) }})</td>
                                                @endif
                                            @else
                                                @if ($rt['data'][$i]->bk_id != $selected_bank)
                                                    <td style="color:#a50101!important;"
                                                        title="Change: {{ $rt['data'][$i]->change }} &#10;Previous: {{ $rt['data'][$i]->previous_rate }}&#10;Last Updated: {{date('m-d-Y',strtotime(explode(' ',$rt['data'][$i]->created_at)[0]))}}">
                                                        {{ $rt['data'][$i]->bk_name }}
                                                        ({{ number_format($rt['data'][$i]->current_rate,2) }})</td>
                                                @else
                                                    <td style="color:#a50101!important;" 
                                                        title="Change: {{ $rt['data'][$i]->change }} &#10;Previous: {{ $rt['data'][$i]->previous_rate }}&#10;"
                                                        class="text-danger">{{ $rt['data'][$i]->bk_name }}
                                                        ({{ number_format($rt['data'][$i]->current_rate,2) }})</td>
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
