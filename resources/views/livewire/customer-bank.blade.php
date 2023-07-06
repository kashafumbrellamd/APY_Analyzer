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
                                    <label for="msa_code">MSA Code</label>
                                    <input type="text" wire:model.lazy="msa_code" class="form-control mr-2"
                                        placeholder="Enter Bank MSA Code....">
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
                            </div>
                        </div>

                        <!-- Bank's Admin Details -->
                        <div class="mt-2">
                            <h6 class="m-0 font-weight-bold text-dark mb-2">Bank's Admin Details</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="name">Name</label>
                                    <input type="text" wire:model.lazy="admin_name" class="form-control mr-2"
                                        placeholder="Enter Name....">
                                </div>
                                <div class="col-md-4">
                                    <label for="name">Email</label>
                                    <input type="text" wire:model.lazy="admin_email" class="form-control mr-2"
                                        placeholder="Enter Email....">
                                </div>
                                <div class="col-md-4">
                                    <label for="name">Phone Number</label>
                                    <input type="text" wire:model.lazy="admin_phone_number" class="form-control mr-2"
                                        placeholder="Enter Phone Number....">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="name">Designation</label>
                                    <input type="text" wire:model.lazy="designation" class="form-control mr-2"
                                        placeholder="Enter Designation....">
                                </div>
                                <div class="col-md-4">
                                    <label for="name">Employee Id</label>
                                    <input type="text" wire:model.lazy="employee_id" class="form-control mr-2"
                                        placeholder="Enter Employee Id....">
                                </div>
                                <div class="col-md-4">
                                    <label for="name">Gender</label>
                                    <select class="form-select form-control" aria-label="Default select example"
                                        wire:model.lazy="gender">
                                        <option value="">Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Bank's Subscription Details -->
                        <div class="mt-2">
                            <h6 class="m-0 font-weight-bold text-dark mb-2">Bank's Subscription Details</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="name">Contract Start</label>
                                    <input type="date" wire:model.lazy="contract_start" class="form-control mr-2"
                                        placeholder="Enter Name....">
                                </div>
                                <div class="col-md-4">
                                    <label for="name">Contract End</label>
                                    <input type="date" wire:model.lazy="contract_end" class="form-control mr-2"
                                        placeholder="Enter New Role....">
                                </div>
                                <div class="col-md-4">
                                    <label for="name">Charges</label>
                                    <input type="text" wire:model.lazy="charges" class="form-control mr-2"
                                        placeholder="Enter Subscription Charges....">
                                </div>
                            </div>
                        </div>


                        <!-- Reports -->
                        <div class="mt-2">
                            <div class="row">
                                <div class="col-md-12">

                                    <h6 class="m-0 font-weight-bold text-dark mb-2">Reports To Show</h6>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" wire:model.lazy="report" value="state">
                                        <label class="form-check-label" for="state">By State</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" wire:model.lazy="report" value="msa">
                                        <label class="form-check-label" for="msa">By MSA Code</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" wire:model.lazy="report" value="custom">
                                        <label class="form-check-label" for="custom">Custom</label>
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
                                    <label for="msa_code">MSA Code</label>
                                    <input type="text" wire:model.lazy="msa_code" class="form-control mr-2"
                                        placeholder="Enter Bank MSA Code....">
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
                            </div>
                        </div>

                        <!-- Bank's Admin Details -->
                        <div class="mt-2">
                            <h6 class="m-0 font-weight-bold text-dark mb-2">Bank's Admin Details</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="name">Name</label>
                                    <input type="text" wire:model.lazy="admin_name" class="form-control mr-2"
                                        placeholder="Enter Name....">
                                </div>
                                <div class="col-md-4">
                                    <label for="name">Email</label>
                                    <input type="text" wire:model.lazy="admin_email" class="form-control mr-2"
                                        placeholder="Enter Email....">
                                </div>
                                <div class="col-md-4">
                                    <label for="name">Phone Number</label>
                                    <input type="text" wire:model.lazy="admin_phone_number" class="form-control mr-2"
                                        placeholder="Enter Phone Number....">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="name">Designation</label>
                                    <input type="text" wire:model.lazy="designation" class="form-control mr-2"
                                        placeholder="Enter Designation....">
                                </div>
                                <div class="col-md-4">
                                    <label for="name">Employee Id</label>
                                    <input type="text" wire:model.lazy="employee_id" class="form-control mr-2"
                                        placeholder="Enter Employee Id....">
                                </div>
                                <div class="col-md-4">
                                    <label for="name">Gender</label>
                                    <select class="form-select form-control" aria-label="Default select example"
                                        wire:model.lazy="gender">
                                        <option value="">Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Bank's Subscription Details -->
                        <div class="mt-2">
                            <h6 class="m-0 font-weight-bold text-dark mb-2">Bank's Subscription Details</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="name">Contract Start</label>
                                    <input type="date" wire:model.lazy="contract_start" class="form-control mr-2"
                                        placeholder="Enter Name....">
                                </div>
                                <div class="col-md-4">
                                    <label for="name">Contract End</label>
                                    <input type="date" wire:model.lazy="contract_end" class="form-control mr-2"
                                        placeholder="Enter New Role....">
                                </div>
                                <div class="col-md-4">
                                    <label for="name">Charges</label>
                                    <input type="text" wire:model.lazy="charges" class="form-control mr-2"
                                        placeholder="Enter Subscription Charges....">
                                </div>
                            </div>
                        </div>


                        <!-- Reports -->
                        <div class="mt-2">
                            <div class="row">
                                <div class="col-md-12">

                                    <h6 class="m-0 font-weight-bold text-dark mb-2">Reports To Show</h6>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" wire:model.lazy="report" value="state">
                                        <label class="form-check-label" for="state">By State</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" wire:model.lazy="report" value="msa">
                                        <label class="form-check-label" for="msa">By MSA Code</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" wire:model.lazy="report" value="custom">
                                        <label class="form-check-label" for="custom">Custom</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <center><button type="submit" class="btn btn-primary mt-3">Submit</button></center>
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
                            <th>Contract Start</th>
                            <th>Contract End</th>
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
                                <td>{{ date('m-d-Y',strtotime($dt->contract->contract_start)) }}</td>
                                <td>{{ date('m-d-Y',strtotime($dt->contract->contract_end)) }}</td>
                                <td>{{ number_format($dt->contract->charges, 2) }}</td>
                                <td>{{ Str::ucfirst($dt->display_reports) }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn" wire:click="edit({{ $dt->id }})"><span
                                            class="bi bi-pen"></span></button>
                                    <button type="button" class="btn" wire:click="delete({{ $dt->id }})"><span
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
