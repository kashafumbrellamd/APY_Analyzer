<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add a User</h6>
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
                        <div class="row">
                            <div class="col-md-4">
                                <label for="name">First Name</label>
                                <input type="text" wire:model.lazy="first_admin_name" class="form-control mr-2"
                                    placeholder="Name....">
                            </div>
                            <div class="col-md-4">
                                <label for="name">Last Name</label>
                                <input type="text" wire:model.lazy="last_admin_name" class="form-control mr-2"
                                    placeholder="Name....">
                            </div>
                            <div class="col-md-4">
                                <label for="name">Email Address</label>
                                <input type="text" wire:model.lazy="admin_email" class="form-control mr-2"
                                    placeholder="Email....">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="name">Phone Number</label>
                                <input type="text" wire:model.lazy="admin_phone_number" class="form-control mr-2"
                                    placeholder="Phone Number....">
                            </div>
                            <div class="col-md-4">
                                <label for="name"> Title</label>
                                <input type="text" wire:model.lazy="designation" class="form-control mr-2"
                                    placeholder="Designation....">
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
            <h6 class="m-0 font-weight-bold text-primary">Authorized Users</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Title</th>
                            <th>Institution Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $dt)
                            <tr>
                                <td>{{ $dt->name }}</td>
                                <td>{{ $dt->last_name }}</td>
                                <td>{{ $dt->email }}</td>
                                <td>{{ $dt->phone_number }}</td>
                                <td>{{ $dt->designation }}</td>
                                <td>{{ $dt->banks->bank_name }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn"
                                        wire:click="delete({{ $dt->id }})"><span
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

            </div>
        </div>
    </div>
</div>
