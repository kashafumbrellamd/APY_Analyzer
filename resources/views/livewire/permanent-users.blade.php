<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Permanent Users</h6>
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
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $dt)
                            <tr>
                                <td>{{ $dt->id }}</td>
                                <td>{{ $dt->name }}</td>
                                <td>{{ $dt->email }}</td>
                                @if ($update)
                                    @if ($user_id == $dt->id)
                                        <td class="d-flex">
                                            <select class="form-select form-control mr-2"
                                                aria-label="Default select example" wire:model.lazy="update_role">
                                                @foreach ($role as $roll)
                                                    @if ($roll->id == $update_role)
                                                        <option value="{{ $roll->id }}" selected>{{ $roll->name }}</option>
                                                    @else
                                                        <option value="{{ $roll->id }}">{{ $roll->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </td>
                                    @else
                                        <td>{{ $dt->roles[0]->name }}</td>
                                    @endif
                                @else
                                    <td>{{ $dt->roles[0]->name }}</td>
                                @endif
                                @if ($update)
                                    @if ($user_id == $dt->id)
                                        <td>
                                            <select class="form-select form-control mr-2"
                                                aria-label="Default select example" wire:model.lazy="status">
                                                <option value="0">Deactive</option>
                                                <option value="1">Active</option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" wire:click="update"
                                                class="btn btn-primary mr-2">Update</button>

                                            <button type="button" wire:click="cancel"
                                                class="btn btn-primary mr-2">Cancel</button>
                                        </td>
                                    @else
                                        <td>{{ $dt->status }}</td>
                                        <td>
                                            <button type="button" class="btn"
                                                wire:click="edit({{ $dt->id }})"><span
                                                    class="bi bi-pen"></span></button>
                                            <button type="button" class="btn"
                                                wire:click="delete({{ $dt->id }})"><span
                                                    class="bi bi-trash"></span></button>
                                        </td>
                                    @endif
                                @else
                                    <td>{{ $dt->status }}</td>
                                    <td>
                                        <button type="button" class="btn"
                                            wire:click="edit({{ $dt->id }})"><span
                                                class="bi bi-pen"></span></button>
                                        <button type="button" class="btn"
                                            wire:click="delete({{ $dt->id }})"><span
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
