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
                        <option value="">Select Bank</option>
                        @foreach ($banks as $bank)
                            <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">

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
            </div>
            <div class="table-responsive table__font_style">
                <div class="table-wrapper">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
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

                            @for ($i = 0; $i < $maxItems; $i++)
                                <tr>
                                    @foreach ($rate_type as $rt)
                                        @if ($columns[$rt->id] == 1)
                                            @if (isset($rt['data'][$i]))
                                                @if ($rt['data'][$i]->bk_id != $selected_bank)
                                                    <td title="Change: {{ $rt['data'][$i]->change }} &#10;Previous: {{ $rt['data'][$i]->previous_rate }}&#10;">
                                                        {{ $rt['data'][$i]->bk_name }}
                                                        ({{ $rt['data'][$i]->current_rate }})</td>
                                                @else
                                                    <td title="Change: {{ $rt['data'][$i]->change }} &#10;Previous: {{ $rt['data'][$i]->previous_rate }}&#10;"
                                                        class="text-danger">{{ $rt['data'][$i]->bk_name }}
                                                        ({{ $rt['data'][$i]->current_rate }})</td>
                                                @endif
                                            @else
                                                <td></td>
                                            @endif
                                        @endif
                                    @endforeach
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
