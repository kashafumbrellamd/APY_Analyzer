<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Permanent Users</h6>
        </div>
        <div class="card-body">
            @error('error')
                <div class="mt-3 text-center">
                    <span class="alert alert-danger" role="alert">{{ $message }}</span>
                </div>
            @enderror
            <form wire:submit.prevent="submitForm">
                <div class="container">
                    <!-- Bank's Admin Details -->
                    <div class="mt-2">
                        <h6 class="m-0 font-weight-bold text-dark mb-2">Institution's Admin Details</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="name">Name</label>
                                <input type="text" wire:model.lazy="admin_name" class="form-control mr-2"
                                    placeholder="Name....">
                            </div>
                            <div class="col-md-4">
                                <label for="name">Email</label>
                                <input type="text" wire:model.lazy="admin_email" class="form-control mr-2"
                                     placeholder="Email....">
                            </div>
                            <div class="col-md-4">
                                <label for="name">Phone Number</label>
                                <input type="text" wire:model.lazy="admin_phone_number" class="form-control mr-2"
                                     placeholder="Phone Number....">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="name">Designation</label>
                                <input type="text" wire:model.lazy="designation" class="form-control mr-2"
                                    placeholder="Designation....">
                            </div>
                            <div class="col-md-4">
                                <label for="name">Employee Id</label>
                                <input type="text" wire:model.lazy="employee_id" class="form-control mr-2"
                                     placeholder="Employee Id....">
                            </div>
                            <div class="col-md-4">
                                <label for="name">Gender</label>
                                <select class="form-select form-control"
                                    aria-label="Default select example" wire:model.lazy="gender">
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="name">Institution Name</label>
                                <select class="form-select form-control"
                                    aria-label="Default select example" wire:model.lazy="bank_id">
                                    <option value="">Select Institution</option>
                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}">{{ $bank->bank_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <center><button type="submit" class="btn btn-primary mt-3">Submit</button></center>
            </form>
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
                            <th>Admin Name</th>
                            <th>Admin Email</th>
                            <th>Admin Phone Number</th>
                            <th>Admin Designation</th>
                            <th>Admin Gender</th>
                            <th>Admin Employee Id</th>
                            <th>Institution Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $dt)
                            <tr>
                                <td>{{ $dt->name }}</td>
                                <td>{{ $dt->email }}</td>
                                <td>{{ $dt->phone_number }}</td>
                                <td>{{ $dt->designation }}</td>
                                <td>{{ $dt->gender }}</td>
                                <td>{{ $dt->employee_id }}</td>
                                <td>{{ $dt->banks->bank_name }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn" wire:click="delete({{ $dt->id }})"><span
                                            class="bi bi-trash"></span></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No Data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{$data->links('livewire::bootstrap')}}
            </div>
        </div>
    </div>
</div>
