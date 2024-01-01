<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add New Package</h6>
        </div>
        <div class="card-body">
            @if ($update)
                <div class="d-flex justify-content-between mb-4">
                    <input type="text" class="form-control mr-2" wire:model.lazy="name"
                        placeholder="Enter Package Name...">
                    <input type="text" class="form-control mr-2" wire:model.lazy="price"
                        placeholder="Enter Price of the Packages...">
                        <input type="text" class="form-control mr-2" wire:model.lazy="additional_price"
                        placeholder="Enter Additional Bank Price...">
                </div>
                <div class="d-flex justify-content-between mb-4">
                    <input type="text" class="form-control mr-2" wire:model.lazy="number_of_units"
                        placeholder="Enter Number of Bank...">
                    <select wire:model="package_type" class="form-control form-select mr-2 ">
                        <option value="">Select Report Type</option>
                        <option value="state">Standard Report</option>
                        <option value="custom">Custom Report</option>
                    </select>
                </div>
                <div class="d-flex justify-content-between mb-4">
                    <textarea class="form-control mr-2" cols="1" rows="1" wire:model.lazy="description"
                        placeholder="Enter Package Description..."></textarea>
                </div>
                <button type="submit" wire:click="updateForm" class="btn btn-primary">Update</button>
            @else
                <div class="d-flex justify-content-between mb-4">
                    <input type="text" class="form-control mr-2" wire:model.lazy="name"
                        placeholder="Enter Package Name...">
                    <input type="text" class="form-control mr-2" wire:model.lazy="price"
                        placeholder="Enter Price of the Packages...">
                        <input type="text" class="form-control mr-2" wire:model.lazy="additional_price"
                        placeholder="Enter Additional Bank Price...">
                </div>
                <div class="d-flex justify-content-between mb-4">
                    <input type="text" class="form-control mr-2" wire:model.lazy="number_of_units"
                        placeholder="Enter Number of Bank...">
                    <select wire:model="package_type" class="form-control form-select mr-2 ">
                        <option value="">Select Report Type</option>
                        <option value="state">Standard Report</option>
                        <option value="custom">Custom Report</option>
                    </select>
                </div>
                <div class="d-flex justify-content-between mb-4">
                    <textarea class="form-control mr-2" cols="1" rows="1" wire:model.lazy="description"
                        placeholder="Enter Package Description..."></textarea>
                </div>
                <button type="submit" wire:click="submitForm" class="btn btn-primary">Submit</button>
            @endif
            @error('package')
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
                            <th>Price</th>
                            <th>Additional Price</th>
                            <th>Number Of Banks</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($packages as $package)
                            <tr>
                                <td>{{ $package->id }}</td>
                                <td>{{ $package->name }}</td>
                                <td>{{ $package->price }}</td>
                                <td>{{ $package->additional_price }}</td>
                                <td>{{ $package->number_of_units }}</td>
                                <td>{{ $package->description }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn"
                                        wire:click="edit({{ $package->id }})"><span
                                            class="bi bi-pen"></span></button>
                                    <button type="button" class="btn"
                                        wire:click="delete({{ $package->id }})"><span
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
            </div>
        </div>
    </div>
</div>
