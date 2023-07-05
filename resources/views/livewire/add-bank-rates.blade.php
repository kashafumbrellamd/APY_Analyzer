<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Select Bank</h6>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-4">
                <div class="container">
                    <div class="row">
                        <div class="col-md-2" style="border-right: 5px solid blue;">
                            <label for="state">Banks</label>
                            <select class="form-select form-control" aria-label="Default select example"
                                wire:change="onbankselect($event.target.value)">
                                <option value="0">Select Bank</option>
                                @foreach ($data as $d)
                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if($bank!=null)
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="name">Name</label>
                                    <input type="text" id="name" class="form-control mr-2" value="{{$bank->name}}"
                                        placeholder="Enter New Role...." readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="state">State</label>
                                    <select class="form-select form-control" id="state" aria-label="Default select example" readonly>
                                        <option value="{{$bank->state_id}}">{{$state_name}}</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="name">Phone Number</label>
                                    <input type="text" id="phone_number" class="form-control mr-2" value="{{$bank->phone_number}}"
                                        placeholder="Enter New Role...." readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="website">Website</label>
                                    <input type="text" id="website" class="form-control mr-2" value="{{$bank->website}}"
                                        placeholder="Enter New Role...." readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="msa_code">MSA Code</label>
                                    <input type="text" id="msa_code" class="form-control mr-2" value="{{$bank->msa_code}}"
                                        placeholder="Enter New Role...." readonly>
                                </div>
                                <div class="col-md-4">
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- @error('submit')
                <div class="mt-3 text-center">
                    <span class="alert alert-danger" role="alert">{{ $message }}</span>
                </div>
            @enderror -->
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Bank Rates</h6>
        </div>
        <div class="card-body">
            <div class="container">
                @if($bank_id != '' && $bank!=null && !auth()->user()->hasRole('data-verification-operator'))
                <form wire:submit.prevent="submitForm">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="">Rate Types</label>
                        <select class="form-select form-control" aria-label="Default select example"
                            wire:model="rate_type_id">
                            <option value="">Select Rate Type</option>
                            @foreach ($rate_types as $rt)
                            <option value="{{ $rt->id }}">{{ $rt->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if(auth()->user()->hasRole('admin'))
                    <div class="col-md-4">
                        <label for="rate">rate</label>
                            <input type="text" id="rate" class="form-control mr-2" wire:model="rate"
                                placeholder="Enter Rate....">
                    </div>
                    @endif
                    @if(auth()->user()->hasRole('data-entry-operator'))
                    <div class="col-md-4">
                        <label for="rate">New Rate</label>
                            <input type="text" id="rate" class="form-control mr-2" wire:model="rate"
                                placeholder="Enter New Rate....">
                    </div>
                    @endif
                    <div class="col-md-4 mt-3">
                        <label for="rate"></label>
                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                    </div>
                </div>
                </form>
                @endif
                @error('submit')
                <div class="mt-3 text-center mb-3">
                    <span class="alert alert-danger" role="alert">{{ $message }}</span>
                </div>
                @enderror
            </div>
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Rate Type</th>
                            @if(auth()->user()->hasRole('admin'))
                            <th>Rate</th>
                            @endif
                            <th>Previous Rate</th>
                            <th>Current Rate</th>
                            <th>Change</th>
                            <th>Date/Time</th>
                            @if(auth()->user()->hasRole('data-entry-operator'))
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if($bank_prices!=null)
                        @foreach($bank_prices as $bp)
                            <tr>
                                <td>{{ $bp->rate_type_name }}</td>
                                @if(auth()->user()->hasRole('admin'))
                                <td>{{ $bp->rate }}</td>
                                @endif
                                <td>{{ $bp->previous_rate }}</td>
                                <td>{{ $bp->current_rate }}</td>
                                <td>{{ $bp->change }}</td>
                                <td>{{ $bp->created_at }}</td>
                                @if(auth()->user()->hasRole('data-entry-operator'))
                                <td class="text-center">
                                    <!-- <button type="button" class="btn" wire:click="edit({{ $bp->id }})"><span
                                            class="bi bi-pen"></span></button>
                                    <button type="button" class="btn" wire:click="delete({{ $bp->id }})"><span
                                            class="bi bi-trash"></span></button> -->
                                    @if($bp->is_checked != 1)
                                    <input class="form-check-input" type="checkbox" value="" wire:click="status_change({{$bp->id}})">
                                    @else
                                    <input class="form-check-input" type="checkbox" value="" checked disabled>
                                    @endif
                                    <!-- <label class="form-check-label" for="flexCheckDefault">
                                        Default checkbox
                                    </label> -->
                                </td>
                                @endif
                            </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
