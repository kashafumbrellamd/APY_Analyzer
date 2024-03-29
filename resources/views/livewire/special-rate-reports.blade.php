<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Special Rates Report</h6>
        </div>
        <div class="text-center my-3" wire:loading.delay>
            <div>
                <div class="spinner-border text-danger" role="status">
                </div>
                <br>
                <span class="text-danger">Loading...</span>
            </div>
        </div>
        <div class="card-body" wire:loading.remove>
            <div class="row">
                @php
                    $bank = \app\Models\CustomerBank::where('id',Auth::user()->bank_id)->first();
                @endphp
                <div class="col-md-4">
                    {{-- <label for="state">Select State</label> --}}
                    <select class="form-select form-control mb-3" aria-label="Default select example" wire:model="bank_state_filter" wire:change="selectstate($event.target.value)">
                        <option value="">Select State</option>
                        @foreach ($bank_states as $state)
                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                        @endforeach
                        <option value="all">All Data</option>
                    </select>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-2">
                    {{-- <label for="download"> Download Special Report</label> --}}
                    <button class="btn btn-primary" wire:click="print_report">Download PDF</button>
                </div>
                {{-- @if($bank->display_reports == 'custom')
                    <div class="col-md-4">
                        <label for="city"> Select City</label>
                        <select class="form-select form-control mb-3" id="city" aria-label="Default select example" wire:model="bank_city_filter">
                            <option value="">Select City</option>
                            @foreach ($bank_cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                            <option value="">All Data</option>
                        </select>
                    </div>
                @endif --}}
            </div>
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Institution Name</th>
                            <th>APY</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($specialization_rates as $key => $dt)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td style="text-align: left;">{{ $dt->bank->name }}</td>
                                <td>{{ number_format($dt->rate,2) }}</td>
                                <td style="text-align: left;">{{ $dt->description }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No Data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
