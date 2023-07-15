<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Reports</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
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
                        <option value="">Select Bank Type</option>
                        @foreach ($bankTypes as $bt)
                            <option value="{{ $bt->id }}">{{ $bt->name }}</option>
                        @endforeach
                    </select>
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
            <!-- <div class="form-check">
                @foreach ($rate_type as $rt)
                @if ($columns[$rt->id] == 1)
                <input class="form-check-input" type="checkbox" value="" checked wire:click="check_column({{ $rt->id }})">
                @else
                <input class="form-check-input" type="checkbox" value="" wire:click="check_column({{ $rt->id }})">
                @endif
                                <label class="form-check-label" for="flexCheckDefault">
                                    {{ $rt->name }}
                                </label>
                                <br>
                @endforeach
                            </div> -->
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="first-col">Bank Name</th>
                            @foreach ($rate_type as $rt)
                                @if ($columns[$rt->id] == 1)
                                    <th>{{ $rt->name }}</th>
                                @endif
                            @endforeach
                            <!-- <th>Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reports as $report)
                            <tr>
                                <td class="first-col">{{ $report->name }}</td>
                                @foreach ($rate_type as $rt_key => $rt)
                                    @if ($columns[$rt->id] == 1)
                                        @if ($report[$rt->id] != null)
                                            <td>{{ number_format($report[$rt->id]['current_rate'],2) }}</td>
                                        @else
                                            <td>---</td>
                                        @endif
                                    @endif
                                @endforeach
                                <!-- <td class="text-center">
                                    <button type="button" class="btn"
                                        wire:click="delete({{ $report->id }})"><span
                                            class="bi bi-trash"></span></button>
                                </td> -->
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($rate_type)+1 }}" class="text-center">No Data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
