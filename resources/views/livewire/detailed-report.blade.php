<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Reports</h6>
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
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Select Columns
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark" style="background:gray;"
                            aria-labelledby="dropdownMenuButton1">
                            @foreach ($rate_type as $rt)
                                <li>
                                    <div class="form-check ml-1" style="color:white;">
                                        @if ($columns[$rt->id] == 1)
                                            <input class="form-check-input" type="checkbox" value="" checked
                                                wire:click="check_column({{ $rt->id }})">
                                            {{ $rt->name }}
                                        @else
                                            <input class="form-check-input" type="checkbox" value=""
                                                wire:click="check_column({{ $rt->id }})">
                                            {{ $rt->name }}
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Bank Name</th>
                            @foreach ($rate_type as $rt)
                                @if ($columns[$rt->id] == 1)
                                    <th>{{ $rt->name }}</th>
                                @endif
                            @endforeach
                        </tr>
                        <tr>
                            <th> </th>
                            @foreach ($rate_type as $rt)
                                @if ($columns[$rt->id] == 1)
                                    <th>
                                        <table class="table table-bordered" id="dataTable" width="100%"
                                            cellspacing="0">
                                            <thead>
                                                <tr>
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
                                <td>{{ $report->name }}</td>
                                @foreach ($rate_type as $rt_key => $rt)
                                    @if ($columns[$rt->id] == 1)
                                        <td>
                                            <table class="table table-bordered" id="dataTable" width="100%"
                                                cellspacing="0">
                                                <tbody>
                                                    @if ($report[$rt->id] != null)
                                                        <tr>
                                                            <td>{{ $report[$rt->id]['current_rate'] }}</td>
                                                            <td>{{ $report[$rt->id]['change'] }}</td>
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
                            <td></td>
                            @foreach ($results as $rt)
                                @if ($columns[$rt->id] == 1)
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
                                                    <td>{{ $rt->c_max }}</td>
                                                    <td>{{ $rt->p_max }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Median</td>
                                                    <td>{{ $rt->c_med }}</td>
                                                    <td>{{ $rt->p_med }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Lowest APY</td>
                                                    <td>{{ $rt->c_min }}</td>
                                                    <td>{{ $rt->p_min }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Average</td>
                                                    <td>{{ $rt->c_avg }}</td>
                                                    <td>{{ $rt->p_avg }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Mode</td>
                                                    <td>{{ $rt->c_mode }}</td>
                                                    <td>{{ $rt->p_mode }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                @endif
                            @endforeach
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
