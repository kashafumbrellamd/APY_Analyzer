<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Stories</h6>
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
                            <h6 class="m-0 font-weight-bold text-dark mb-2">Stories<h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="name">Title</label>
                                        <input type="text" wire:model.lazy="title" class="form-control mr-2"
                                            placeholder="Enter Title of the Story....">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="name">URL</label>
                                        <input type="text" wire:model.lazy="url" class="form-control mr-2"
                                            placeholder="Enter URL of the Website....">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="status">Status</label>
                                        <select wire:model="status" id="status" class="form-control mr-2">
                                            <option value="">Select State</option>
                                            <option value="1">Active</option>
                                            <option value="0">Deactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="description">Description</label>
                                        <input type="text" wire:model.lazy="description" class="form-control mr-2"
                                        placeholder="Enter Description of the Story...." >
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
                            <h6 class="m-0 font-weight-bold text-dark mb-2">Stories<h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="name">Title</label>
                                        <input type="text" wire:model.lazy="title" class="form-control mr-2"
                                            placeholder="Enter Title of the Story....">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="name">URL</label>
                                        <input type="text" wire:model.lazy="url" class="form-control mr-2"
                                            placeholder="Enter URL of the Website....">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="status">Status</label>
                                        <select wire:model="status" id="status" class="form-control mr-2">
                                            <option value="">Select State</option>
                                            <option value="1">Active</option>
                                            <option value="0">Deactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="Image">Image</label>
                                        <input type="file" wire:model.lazy="image" class="form-control mr-2">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="description">Description</label>
                                        <input type="text" wire:model.lazy="description" class="form-control mr-2"
                                        placeholder="Enter Description of the Story...." >
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
                            <th>Title</th>
                            <th>URL</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $dt)
                            <tr>
                                <td>{{ $dt->title }}</td>
                                <td>{{ $dt->url }}</td>
                                <td>{{ $dt->description }}</td>
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
