<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add New Report</h6>
        </div>
        <div class="card-body">
            {{-- name
                state_id
                city_id
                status --}}
            <div class="d-flex justify-content-between mb-4">
                @if (auth()->user()->hasRole('admin'))
                    <input type="text" class="form-control mr-2" wire:model.lazy="name"
                        placeholder="Enter the name of the Report....">
                    <select name="city_id" class="form-control mr-2" wire:model.lazy="city_id">
                        <option value="">Select City</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->cbsa_code }}">{{ $city->cbsa_name }}</option>
                        @endforeach
                    </select>
                    @if ($update)
                        <button type="submit" wire:click="update" class="btn btn-primary">Update</button>
                        <button type="submit" wire:click="cancel" class="btn btn-danger ml-2">Cancel</button>
                    @else
                        <button type="submit" wire:click="submitForm" class="btn btn-primary">Submit</button>
                    @endif
                @endif
            </div>
            @error('report')
                <div class="mt-3 text-center">
                    <span class="alert alert-danger" role="alert">{{ $message }}</span>
                </div>
            @enderror
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Standard Report List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>City</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $dt)
                            <tr>
                                <td>{{ $dt->id }}</td>
                                <td>{{ $dt->name }}</td>
                                <td>{{ $dt->cbsa->cbsa_name }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn" wire:click="edit({{ $dt->id }})"><span
                                            class="bi bi-pen"></span></button>
                                    <button type="button" class="btn" wire:click="delete({{ $dt->id }})"><span
                                            class="bi bi-trash"></span></button>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No Data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $data->links('livewire::bootstrap') }}
                </div>
            </div>
        </div>
    </div>
