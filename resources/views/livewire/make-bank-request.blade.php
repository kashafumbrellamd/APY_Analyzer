<div>
    @if (auth()->user()->hasRole('bank-admin'))
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Add New User</h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-4">
                    <div class="d-flex flex-column w-25 mr-3 ">
                        <input type="text" class="form-control mr-2 @error('name') is-invalid @enderror"
                            wire:model="name" placeholder="Enter Name....">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex flex-column w-25 mr-3">
                        <input type="text" class="form-control mr-2 @error('zip_code') is-invalid @enderror"
                            wire:model="zip_code" placeholder="Enter Zip code...." wire:keyup="fetch_zip_code">
                        @error('zip_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex flex-column w-25 mr-3">
                        <select class="form-select form-control mr-2" id="state" wire:model="state_id">
                            <option value="">Select State</option>
                            @foreach ($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                        </select>
                        @error('state_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex flex-column w-25 mr-3">
                        <select class="form-select form-control mr-2" id="city_id" wire:model="city_id">
                            <option value="">Select City</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                        @error('city_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-center mb-4">
                    <textarea type="text" class="form-control mr-2 @error('description') is-invalid @enderror" wire:model="description"
                        placeholder="Enter Description...." rows="4" cols="50"></textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex justify-content-center mb-4">
                    <button type="submit" wire:click="submitForm" class="btn btn-primary">Submit</button>
                </div>
                <div class="d-flex justify-content-around text-center">
                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    @if (auth()->user()->hasRole('admin'))
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Bank Requests</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Customer Bank Id</th>
                                <th>Customer Bank Name</th>
                                <th>Requested Bank Name</th>
                                {{-- <th>Zip Code</th> --}}
                                <th>State</th>
                                <th>City</th>
                                {{-- <th>Description</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $dt)
                                <tr>
                                    <td>
                                        <a href="/view/detailed/customer/bank/{{ $dt->customer_bank_id }}"
                                            style="color:black !important;">
                                            {{ $dt->customer_bank_id }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="/view/detailed/customer/bank/{{ $dt->customer_bank_id }}"
                                        style="color:black !important;">{{ $dt->customer_bank_name }}
                                        </a>
                                    </td>
                                    <td>{{ $dt->name }}</td>
                                    {{-- <td>{{ $dt->zip_code }}</td> --}}
                                    <td>{{ $dt->state->name }}</td>
                                    <td>{{ $dt->cities->name }}</td>
                                    {{-- <td>{{ $dt->description }}</td> --}}
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No Data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $data->links('livewire::bootstrap') }}

                </div>
            </div>
        </div>
    @endif

</div>
