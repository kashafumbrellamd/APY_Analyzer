<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Institution Type</h6>
        </div>
        <div class="card-body">
            @error('error')
                <div class="mt-3 text-center">
                    <span class="alert alert-danger" role="alert">{{ $message }}</span>
                </div>
            @enderror
            @if ($update)
                <form wire:submit.prevent="updateForm">
                    <div class="container">
                        <div class="mt-2">
                            <h6 class="m-0 font-weight-bold text-dark mb-2">Institution Type <h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name">Name</label>
                                    <input type="text" wire:model.lazy="name" class="form-control mr-2"
                                        placeholder="Name....">
                                </div>
                                <div class="col-md-6">
                                    <label for="status">Status</label>
                                    <select wire:model="status" id="status" class="form-control mr-2">
                                        <option value="1">Active</option>
                                        <option value="0">Deactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <center><button type="submit" class="btn btn-primary mt-3">Update</button></center>
                </form>
            @else
                <form wire:submit.prevent="submitForm">
                    <div class="container">
                        <div class="mt-2">
                            <h6 class="m-0 font-weight-bold text-dark mb-2">Institution Type <h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="name">Name</label>
                                            <input type="text" wire:model.lazy="name" class="form-control mr-2"
                                                placeholder="Name....">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="status">Status</label>
                                            <select wire:model="status" id="status" class="form-control mr-2">
                                                <option value="">Select State</option>
                                                <option value="1">Active</option>
                                                <option value="0">Deactive</option>
                                            </select>
                                        </div>
                                    </div>
                        </div>
                    </div>
                    <center><button type="submit" class="btn btn-primary mt-3">Submit</button></center>
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
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $dt)
                            <tr>
                                <td>{{ $dt->name }}</td>
                                @if ($dt->status == 1)
                                    <td>Active</td>
                                @else
                                    <td>Deactive</td>
                                @endif
                                <td class="text-center w-25">
                                    <button type="button" class="btn" wire:click="edit({{ $dt->id }})"><span
                                            class="bi bi-pen"></span></button>
                                    <button type="button" class="btn" wire:click="delete({{ $dt->id }})"><span
                                            class="bi bi-trash"></span></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No Data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $data->links('livewire::bootstrap') }}
            </div>
        </div>
    </div>
</div>
