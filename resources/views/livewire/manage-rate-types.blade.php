<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add New Rate Type</h6>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-4">
                @if (auth()->user()->hasRole('admin'))
                    <input type="text" class="form-control mr-2" wire:model.lazy="rate_type"
                        placeholder="Enter New Rate Type....">
                    <input type="text" class="form-control mr-2" wire:model.lazy="display_order"
                        placeholder="Enter Its Order of Display....">
                    <button type="submit" wire:click="submitForm" class="btn btn-primary">Submit</button>
                @endif
            </div>
            @error('rate_type')
                <div class="mt-3 text-center">
                    <span class="alert alert-danger" role="alert">{{ $message }}</span>
                </div>
            @enderror
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Rate Types</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Display Order</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $dt)
                            <tr>
                                <td>{{ $dt->id }}</td>
                                @if ($update)
                                    @if ($rate_type_id == $dt->id)
                                        <td class="d-flex">
                                            <input type="text" class="form-control mr-2"
                                                wire:model.lazy="update_name" placeholder="Enter New Role...." />
                                        </td>
                                        <td>
                                            <input type="text" class="form-control mr-2"
                                                wire:model.lazy="update_display_order" placeholder="Enter New Role...." />
                                        </td>
                                        <td>
                                            <button type="button" wire:click="update"
                                            class="btn btn-primary mr-2">Update</button>

                                            <button type="button" wire:click="cancel"
                                                class="btn btn-danger mr-2">Cancel</button>
                                        </td>
                                    @else
                                        <td>{{ $dt->name }}</td>
                                        <td>{{ $dt->display_order }}</td>
                                    @endif
                                @else
                                    <td>{{ $dt->name }}</td>
                                    <td>{{ $dt->display_order }}</td>

                                @endif
                                @if (!$update)
                                    <td class="text-center">
                                        <button type="button" class="btn" wire:click="edit({{ $dt->id }})"><span
                                                class="bi bi-pen"></span></button>
                                        <button type="button" class="btn" wire:click="delete({{ $dt->id }})"><span
                                                class="bi bi-trash"></span></button>
                                    </td>
                                @endif
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No Data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
