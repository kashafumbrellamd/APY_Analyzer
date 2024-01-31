<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add New User</h6>
        </div>
        <div class="card-body">
            @if (auth()->user()->hasRole('admin'))
                <div class="d-flex justify-content-between mb-4">
                    <input type="text" class="form-control mr-2 @error('name') is-invalid @enderror" wire:model="name"
                        placeholder="Name....">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <input type="email" class="form-control mr-2 @error('email') is-invalid @enderror"
                        wire:model="email" placeholder="Email....">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <select class="form-select form-control mr-2 @error('role_id') is-invalid @enderror"
                        wire:model="role_id">
                        <option>Select Role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                        @error('role_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </select>
                </div>
                <div class="d-flex justify-content-center mb-4">
                    <button type="submit" wire:click="submitForm" class="btn btn-primary">Submit</button>
                </div>
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
                            <th>Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $dt)
                            <tr>
                                <td>{{ $dt->id }}</td>
                                <td>{{ $dt->name }}</td>
                                <td>{{ $dt->email }}</td>
                                <td>{{ $dt->role->name }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn" wire:click="delete({{ $dt->id }})"><span
                                            class="bi bi-trash"></span></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No Data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
