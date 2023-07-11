<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Permanent Users</h6>
        </div>
        <div class="card-body">
            @if ($update)
                <form wire:submit.prevent="updateForm">
                    <div class="container">
                        <!-- Bank Details -->
                        <div class="mt-2">
                            <h6 class="m-0 font-weight-bold text-dark mb-2">Bank's Details</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="name">Name</label>
                                    <input type="text" wire:model.lazy="bank_name" class="form-control mr-2"
                                        placeholder="Enter Bank Name....">
                                </div>
                                <div class="col-md-4">
                                    <label for="msa_code">Email</label>
                                    <input type="text" wire:model.lazy="bank_email" class="form-control mr-2"
                                        placeholder="Enter Bank Email....">
                                </div>
                                <div class="col-md-4">
                                    <label for="name">Phone Number</label>
                                    <input type="text" wire:model.lazy="bank_phone_numebr" class="form-control mr-2"
                                        placeholder="Enter Bank Phone Number....">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="website">Website</label>
                                    <input type="text" wire:model.lazy="website" class="form-control mr-2"
                                        placeholder="Enter Website....">
                                </div>
                                <div class="col-md-4">
                                    <label for="state">State</label>
                                    <select class="form-select form-control" aria-label="Default select example"
                                        wire:model.lazy="state">
                                        <option value="">Select State</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if ($bank_cities != null)
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="bank_city" class="form-label">City</label>
                                            <select class="form-select form-control" id="bank_city" name="bank_city"
                                                aria-label="Default select example" wire:model.lazy="bank_city"
                                                required>
                                                <option value="">Select State</option>
                                                @foreach ($bank_cities as $city)
                                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Bank's Admin Details -->
                        <div class="mt-2">
                            <h6 class="m-0 font-weight-bold text-dark mb-2">Bank's Admin Details</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="name">Name</label>
                                    <input type="text" wire:model.lazy="admin_name" class="form-control mr-2"
                                        placeholder="Enter First Name....">
                                </div>
                                <div class="col-md-4">
                                    <label for="name">Last Name</label>
                                    <input type="text" wire:model.lazy="admin_last_name" class="form-control mr-2"
                                        placeholder="Enter Last Name....">
                                </div>
                                <div class="col-md-4">
                                    <label for="name">Email</label>
                                    <input type="text" wire:model.lazy="admin_email" class="form-control mr-2"
                                        placeholder="Enter Email....">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="name">Phone Number</label>
                                    <input type="text" wire:model.lazy="admin_phone_number" class="form-control mr-2"
                                        placeholder="Enter Phone Number....">
                                </div>
                                <div class="col-md-4">
                                    <label for="name">Title</label>
                                    <input type="text" wire:model.lazy="designation" class="form-control mr-2"
                                        placeholder="Enter Designation....">
                                </div>
                            </div>
                        </div>

                        <div class="mt-2">
                            <div class="row">
                                <div class="col-md-12">
                                    <h6 class="m-0 font-weight-bold text-dark mb-2">Choose Subscription Plan (One year)
                                    </h6>
                                    <div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    @foreach ($packages as $package)
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="inlineRadioOptions"
                                                                id="inlineRadio{{ $package->id }}"
                                                                value="{{ $package->package_type }}"
                                                                wire:model.lazy="subscription">
                                                            <label class="form-check-label"
                                                                for="inlineRadio{{ $package->id }}">{{ $package->name }}
                                                                ({{ $package->package_type }})
                                                            </label>
                                                        </div>
                                                        <br>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                            </div>
                                            @if ($this->subscription == 'custom')
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="custom_states" class="form-label">State</label>
                                                        <div class="d-flex">
                                                            @foreach ($selected as $key => $item)
                                                                <p class="border border-secondary rounded">
                                                                    {{ $item }}
                                                                    <button type="button" class="btn"
                                                                        wire:click="deleteState({{ $key }})"><span
                                                                            class="fa fa-close"></span></button>
                                                                </p> &nbsp;&nbsp;
                                                            @endforeach
                                                        </div>
                                                        <div>
                                                            <select class="form-control"
                                                                wire:change="addArray($event.target.value)">
                                                                <option value="">Select Option</option>
                                                                @foreach ($bank_states as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="col-md-6">
                                            </div>
                                            @if ($this->custom_bank_select != '' && $this->subscription == 'custom')
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="custom_banks" class="form-label">Banks</label>
                                                        <div class="d-flex">
                                                            @foreach ($selectedbanks as $key => $item)
                                                                <p class="border border-secondary rounded">
                                                                    {{ $item }}
                                                                    <button type="button" class="btn"
                                                                        wire:click="deleteBank({{ $key }})"><span
                                                                            class="fa fa-close"></span></button>
                                                                </p> &nbsp;&nbsp;
                                                            @endforeach
                                                        </div>
                                                        <div>
                                                            <select class="form-control"
                                                                wire:change="addBanks($event.target.value)">
                                                                <option value="">Select Option</option>
                                                                @foreach ($this->custom_bank_select as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @error('customer_banks')
                                                <div class="mt-3 text-center mb-5">
                                                    <span class="alert alert-danger"
                                                        role="alert">{{ $message }}</span>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <center><button type="submit" class="btn btn-primary mt-3">Update</button></center>
                    </div>
                </form>
            @else
                <form wire:submit.prevent="submitForm">
                    <div class="container">
                        <!-- Bank Details -->
                        <div class="mt-2">
                            <h6 class="m-0 font-weight-bold text-dark mb-2">Bank's Details</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="name">Name</label>
                                    <input type="text" wire:model.lazy="bank_name" class="form-control mr-2"
                                        placeholder="Enter Bank Name....">
                                </div>
                                <div class="col-md-4">
                                    <label for="msa_code">Email</label>
                                    <input type="text" wire:model.lazy="bank_email" class="form-control mr-2"
                                        placeholder="Enter Bank Email....">
                                </div>
                                <div class="col-md-4">
                                    <label for="name">Phone Number</label>
                                    <input type="text" wire:model.lazy="bank_phone_numebr"
                                        class="form-control mr-2" placeholder="Enter Bank Phone Number....">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="website">Website</label>
                                    <input type="text" wire:model.lazy="website" class="form-control mr-2"
                                        placeholder="Enter Website....">
                                </div>
                                <div class="col-md-4">
                                    <label for="state">State</label>
                                    <select class="form-select form-control" aria-label="Default select example"
                                        wire:model.lazy="state">
                                        <option value="">Select State</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if ($bank_cities != null)
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="bank_city" class="form-label">City</label>
                                            <select class="form-select form-control" id="bank_city" name="bank_city"
                                                aria-label="Default select example" wire:model.lazy="bank_city"
                                                required>
                                                <option value="">Select State</option>
                                                @foreach ($bank_cities as $city)
                                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Bank's Admin Details -->
                        <div class="mt-2">
                            <h6 class="m-0 font-weight-bold text-dark mb-2">Bank's Admin Details</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="name">First Name</label>
                                    <input type="text" wire:model.lazy="admin_name" class="form-control mr-2"
                                        placeholder="Enter First Name....">
                                </div>
                                <div class="col-md-4">
                                    <label for="name">Last Name</label>
                                    <input type="text" wire:model.lazy="admin_last_name" class="form-control mr-2"
                                        placeholder="Enter Last Name....">
                                </div>
                                <div class="col-md-4">
                                    <label for="name">Email</label>
                                    <input type="text" wire:model.lazy="admin_email" class="form-control mr-2"
                                        placeholder="Enter Email....">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="name">Phone Number</label>
                                    <input type="text" wire:model.lazy="admin_phone_number"
                                        class="form-control mr-2" placeholder="Enter Phone Number....">
                                </div>
                                <div class="col-md-4">
                                    <label for="name">Title</label>
                                    <input type="text" wire:model.lazy="designation" class="form-control mr-2"
                                        placeholder="Enter Designation....">
                                </div>

                            </div>
                        </div>

                        <!-- Bank's Subscription Details -->
                        <div class="mt-2">
                            <div class="row">
                                <div class="col-md-12">
                                    <h6 class="m-0 font-weight-bold text-dark mb-2">Choose Subscription Plan (One year)
                                    </h6>
                                    <div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    @foreach ($packages as $package)
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="inlineRadioOptions"
                                                                id="inlineRadio{{ $package->id }}"
                                                                value="{{ $package->package_type }}"
                                                                wire:model.lazy="subscription">
                                                            <label class="form-check-label"
                                                                for="inlineRadio{{ $package->id }}">{{ $package->name }}
                                                                ({{ $package->package_type }})
                                                            </label>
                                                        </div>
                                                        <br>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                            </div>
                                            @if ($this->subscription == 'custom')
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="custom_states" class="form-label">State</label>
                                                        <div class="d-flex">
                                                            @foreach ($selected as $key => $item)
                                                                <p class="border border-secondary rounded">
                                                                    {{ $item }}
                                                                    <button type="button" class="btn"
                                                                        wire:click="deleteState({{ $key }})"><span
                                                                            class="fa fa-close"></span></button>
                                                                </p> &nbsp;&nbsp;
                                                            @endforeach
                                                        </div>
                                                        <div>
                                                            <select class="form-control"
                                                                wire:change="addArray($event.target.value)">
                                                                <option value="">Select Option</option>
                                                                @foreach ($bank_states as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="col-md-6">
                                            </div>
                                            @if ($this->custom_bank_select != '' && $this->subscription == 'custom')
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="custom_banks" class="form-label">Banks</label>
                                                        <div class="d-flex">
                                                            @foreach ($selectedbanks as $key => $item)
                                                                <p class="border border-secondary rounded">
                                                                    {{ $item }}
                                                                    <button type="button" class="btn"
                                                                        wire:click="deleteBank({{ $key }})"><span
                                                                            class="fa fa-close"></span></button>
                                                                </p> &nbsp;&nbsp;
                                                            @endforeach
                                                        </div>
                                                        <div>
                                                            <select class="form-control"
                                                                wire:change="addBanks($event.target.value)">
                                                                <option value="">Select Option</option>
                                                                @foreach ($this->custom_bank_select as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @error('customer_banks')
                                                <div class="mt-3 text-center mb-5">
                                                    <span class="alert alert-danger"
                                                        role="alert">{{ $message }}</span>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3 text-center">
                                        <button type="submit" wire:click="submitForm"
                                            class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Roles</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Bank Name</th>
                            <th>Bank Email</th>
                            <th>Bank Phone Number</th>
                            <th>Website</th>
                            <th>MSA Code</th>
                            <th>State</th>
                            {{-- <th>Contract Start</th>
                            <th>Contract End</th> --}}
                            <th>Charges</th>
                            <th>Reports</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $dt)
                            <tr>
                                <td>{{ $dt->bank_name }}</td>
                                <td>{{ $dt->bank_email }}</td>
                                <td>{{ $dt->bank_phone_numebr }}</td>
                                <td>{{ $dt->website }}</td>
                                <td>{{ $dt->msa_code }}</td>
                                <td>{{ $dt->state }}</td>
                                {{-- <td>{{ date('m-d-Y', strtotime($dt->contract->contract_start)) }}</td>
                                <td>{{ date('m-d-Y', strtotime($dt->contract->contract_end)) }}</td> --}}
                                <td>{{ number_format($dt->contract->charges, 2) }}</td>
                                <td>{{ Str::ucfirst($dt->display_reports) }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn"
                                        wire:click="edit({{ $dt->id }})"><span
                                            class="bi bi-pen"></span></button>
                                    <button type="button" class="btn"
                                        wire:click="delete({{ $dt->id }})"><span
                                            class="bi bi-trash"></span></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No Data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
