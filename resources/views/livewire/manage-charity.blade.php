<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add New Charity</h6>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-4">
                @if (auth()->user()->hasRole('admin'))
                    <input type="text" class="form-control mr-2" wire:model.lazy="charity_name"
                        placeholder="Enter Charity Name...">
                    <textarea class="form-control mr-2" cols="1" rows="1" wire:model.lazy="charity_description"
                        placeholder="Enter Charity Description..."></textarea>
                    <button type="submit" wire:click="submitForm" class="btn btn-primary">Submit</button>
                @endif
            </div>
            @error('charity')
                <div class="mt-3 text-center">
                    <span class="alert alert-danger" role="alert">{{ $message }}</span>
                </div>
            @enderror
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Charities</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($charities as $charity)
                            @php $count = 0; @endphp
                            <tr>
                                <td>{{ $charity->id }}</td>
                                @if ($update)
                                    @if ($user_id == $charity->id)
                                        @php $count = 1; @endphp
                                        <td class="d-flex">
                                            <input type="text" class="form-control mr-2"
                                                wire:model.lazy="update_name" placeholder="Enter Charity Name...." />
                                        </td>
                                        <td>
                                            <textarea class="form-control mr-2" cols="1" rows="1" wire:model.lazy="update_des"
                                                placeholder="Enter Charity Description..."></textarea>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" wire:click="update"
                                                class="btn btn-primary mr-2">Update</button>

                                            <button type="button" wire:click="cancel"
                                                class="btn btn-primary mr-2">Cancel</button>
                                        </td>
                                    @else
                                        <td>{{ $charity->name }}</td>
                                        <td>{{ $charity->description }}</td>
                                    @endif
                                @else
                                    <td>{{ $charity->name }}</td>
                                    <td>{{ $charity->description }}</td>
                                @endif
                                @if ($count!=1)
                                <td class="text-center">
                                    <button type="button" class="btn" wire:click="edit({{ $charity->id }})"><span
                                            class="bi bi-pen"></span></button>
                                    <button type="button" class="btn" wire:click="delete({{ $charity->id }})"><span
                                            class="bi bi-trash"></span></button>
                                </td>
                                @endif
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No Data</td>
                                </tr>
                            @endforelse
                            @error('update_name')
                                <div class="mt-3 text-center">
                                    <span class="alert alert-danger" role="alert">{{ $message }}</span>
                                </div>
                            @enderror
                        </tbody>
                </table>
                {{ $charities->links('livewire::bootstrap') }}
            </div>
        </div>
    </div>
</div>
