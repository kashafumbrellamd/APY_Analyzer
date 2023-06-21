<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            @if($update)
            <h6 class="m-0 font-weight-bold text-primary">Edit Bank</h6>
            @else
            <h6 class="m-0 font-weight-bold text-primary">Add New Bank</h6>
            @endif
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-4">
                @if (auth()->user()->hasRole('admin'))
                    @if($update)
                        <form wire:submit.prevent="updateForm">
                            <fieldset>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="name">Name</label>
                                            <input type="text" id="name" class="form-control mr-2" wire:model.lazy="name"
                                                placeholder="Enter New Role....">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="state">State</label>
                                            <select class="form-select form-control" id="state" aria-label="Default select example"
                                                wire:model="state_id">
                                                <option value="">Select State</option>
                                                @foreach ($states as $state)
                                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="name">Phone Number</label>
                                            <input type="text" id="phone_number" class="form-control mr-2" wire:model.lazy="phone_number"
                                                placeholder="Enter New Role....">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="website">Website</label>
                                            <input type="text" id="website" class="form-control mr-2" wire:model.lazy="website"
                                                placeholder="Enter New Role....">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="msa_code">MSA Code</label>
                                            <input type="text" id="msa_code" class="form-control mr-2" wire:model.lazy="msa_code"
                                                placeholder="Enter New Role....">
                                        </div>
                                        <div class="col-md-4">
                                        </div>
                                    </div>
                                    <center><button type="submit" class="btn btn-primary mt-3">Update</button></center>
                                </div>
                            </fieldset>
                        </form>
                    @else
                        <form wire:submit.prevent="submitForm">
                            <fieldset>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="name">Name</label>
                                            <input type="text" id="name" class="form-control mr-2" wire:model.lazy="name"
                                                placeholder="Enter New Role....">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="state">State</label>
                                            <select class="form-select form-control" id="state" aria-label="Default select example"
                                                wire:model="state_id">
                                                <option value="">Select State</option>
                                                @foreach ($states as $state)
                                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="name">Phone Number</label>
                                            <input type="text" id="phone_number" class="form-control mr-2" wire:model.lazy="phone_number"
                                                placeholder="Enter New Role....">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="website">Website</label>
                                            <input type="text" id="website" class="form-control mr-2" wire:model.lazy="website"
                                                placeholder="Enter New Role....">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="msa_code">MSA Code</label>
                                            <input type="text" id="msa_code" class="form-control mr-2" wire:model.lazy="msa_code"
                                                placeholder="Enter New Role....">
                                        </div>
                                        <div class="col-md-4">
                                        </div>
                                    </div>
                                    <center><button type="submit" class="btn btn-primary mt-3">Submit</button></center>
                                </div>
                            </fieldset>
                        </form>
                    @endif
                @endif
            </div>
            @error('submit')
                <div class="mt-3 text-center">
                    <span class="alert alert-danger" role="alert">{{ $message }}</span>
                </div>
            @enderror
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Banks</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>State</th>
                            <th>Phone Number</th>
                            <th>Website</th>
                            <th>MSA Code</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $dt)
                            <tr>
                                <td>{{ $dt->name }}</td>
                                <td>{{ $dt->state_id }}</td>
                                <td>{{ $dt->phone_number }}</td>
                                <td>{{ $dt->website }}</td>
                                <td>{{ $dt->msa_code }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn" wire:click="edit({{ $dt->id }})"><span
                                            class="bi bi-pen"></span></button>
                                    <button type="button" class="btn" wire:click="delete({{ $dt->id }})"><span
                                            class="bi bi-trash"></span></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
