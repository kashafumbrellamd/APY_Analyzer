<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            @if($update)
            <h6 class="m-0 font-weight-bold text-primary">Edit Institution</h6>
            @else
            <h6 class="m-0 font-weight-bold text-primary">Add New Institution</h6>
            @endif
        </div>
        <div class="card-body">
                @if (auth()->user()->hasRole('admin'))
                    @if($update)
                        <form wire:submit.prevent="updateForm">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="name">Name</label>
                                            <input type="text" id="name" class="form-control mr-2" wire:model.lazy="name"
                                                placeholder="Enter Institution Name...." required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="website">Website</label>
                                            <input type="text" id="website" class="form-control mr-2" wire:model.lazy="website"
                                                placeholder="Enter Website...." required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="name">Phone Number</label>
                                            <input type="text" id="phone_number" class="form-control mr-2" wire:model.lazy="phone_number"
                                                placeholder="Enter Phone Number...." required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="state">State</label>
                                            <select class="form-select form-control" id="state" aria-label="Default select example"
                                                wire:model="state_id" required>
                                                <option value="">Select State</option>
                                                @foreach ($states as $state)
                                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="city">City</label>
                                            <select class="form-select form-control" id="city" aria-label="Default select example"
                                                wire:model="msa_code" required>
                                                <option value="">Select City</option>
                                                @foreach ($cities as $city)
                                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="bank-type-id">Institution Type</label>
                                            <select class="form-select form-control" id="bank-type-id" aria-label="Default select example"
                                                wire:model="bank_type" required>
                                                <option value="">Select Institution Type</option>
                                                @foreach ($bts as $bt)
                                                    <option value="{{ $bt->id }}">{{ $bt->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <label for="more">Contact Person Details(Optional)</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="cp_name">Name</label>
                                            <input type="text" id="cp_name" class="form-control mr-2" wire:model.lazy="cp_name"
                                                placeholder="Enter Name....">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="cp_email">Email</label>
                                                <input type="email" id="cp_email" class="form-control mr-2" wire:model.lazy="cp_email"
                                                    placeholder="Enter Email....">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="cp_phone">Phone Number</label>
                                            <input type="text" id="cp_phone" class="form-control mr-2" wire:model.lazy="cp_phone"
                                                placeholder="Enter Phone NUmber....">
                                        </div>
                                    </div>
                                    <center>
                                        <button type="submit" class="btn btn-primary mt-3">Update</button>
                                        <button type="button" wire:click="cancel()" class="btn btn-danger mt-3">Cancel</button>
                                    </center>
                        </form>
                    @else
                        <form wire:submit.prevent="submitForm">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="name">Name</label>
                                        <input type="text" id="name" class="form-control mr-2" wire:model.lazy="name"
                                            placeholder="Enter Institution Name....">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="website">Website</label>
                                        <input type="text" id="website" class="form-control mr-2" wire:model.lazy="website"
                                            placeholder="Enter Website....">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="name">Phone Number</label>
                                        <input type="text" id="phone_number" class="form-control mr-2" wire:model.lazy="phone_number"
                                            placeholder="Enter Phone Number....">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="state">State</label>
                                        <select class="form-select form-control" id="state" aria-label="Default select example"
                                            wire:model="state_id">
                                            <option value="">Select State</option>
                                            @foreach ($states as $state)
                                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="city">City</label>
                                        <select class="form-select form-control" id="city" aria-label="Default select example"
                                            wire:model="msa_code">
                                            <option value="">Select City</option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="bank-type-id">Institution Type Id</label>
                                        <select class="form-select form-control" id="bank-type-id" aria-label="Default select example"
                                            wire:model="bank_type">
                                            <option value="">Select Institution Type</option>
                                            @foreach ($bts as $bt)
                                                <option value="{{ $bt->id }}">{{ $bt->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="more">(Optional)</label><br>
                                        <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                            Load More
                                        </a>
                                    </div>
                                </div>
                                <div class="collapse" id="collapseExample">
                                    <label for="more">Contact Person Details(Optional)</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="cp_name">Name</label>
                                            <input type="text" id="cp_name" class="form-control mr-2" wire:model.lazy="cp_name"
                                                placeholder="Enter Name....">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="cp_email">Email</label>
                                                <input type="email" id="cp_email" class="form-control mr-2" wire:model.lazy="cp_email"
                                                    placeholder="Enter Email....">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="cp_phone">Phone Number</label>
                                            <input type="text" id="cp_phone" class="form-control mr-2" wire:model.lazy="cp_phone"
                                                placeholder="Enter Phone Number....">
                                        </div>
                                    </div>
                                </div>
                                <center><button type="submit" class="btn btn-primary mt-3">Submit</button></center>
                        </form>
                    @endif
                @endif
            @error('submit')
                <div class="mt-3 text-center">
                    <span class="alert alert-danger" role="alert">{{ $message }}</span>
                </div>
            @enderror
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row d-flex justify-content-between">
                <div class="col-md-6">
                    <h5 class="m-0 font-weight-bold text-primary">Institutions</h5>
                </div>
                <div class="col-md-6">
                    <button wire:click="download_xlsx" class="btn btn-primary">Format <i class="fa fa-download" aria-hidden="true"></i></button>
                    <input type="file" wire:model="file" class="btn btn-primary"/>
                    <button wire:click="upload_xlsx" class="btn btn-primary">Upload <i class="fa fa-upload" aria-hidden="true"></i></button>
                </div>
            </div>
            @error('upload_error')
                <div class="mt-3 text-center">
                    @foreach($not_inserted_banks as $bank)
                    <span class="alert alert-danger" role="alert">{{ $bank }}</span>
                    @endforeach
                </div>
                <div class="mt-4 text-center">
                    <span class="text-danger">{{$message}}</span>
                </div>
            @enderror
            @error('file_error')
                <div class="mt-4 text-center">
                    <span class="text-danger">{{$message}}</span>
                </div>
            @enderror
            @error('upload_success')
                <div class="mt-4 text-center">
                    <span class="text-success">{{$message}}</span>
                </div>
            @enderror
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>State</th>
                            <th>Phone Number</th>
                            <th>Website</th>
                            <th>City</th>
                            <th>Institution Type</th>
                            <th>Contact Person Name</th>
                            <th>Contact Person Email</th>
                            <th>Contact Person Phone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $dt)
                            <tr>
                                <td>{{ $dt->name }}</td>
                                <td>{{ $dt->state_name }}</td>
                                <td>{{ $dt->phone_number }}</td>
                                <td>{{ $dt->website }}</td>
                                <td>{{ $dt->cities->name }}</td>
                                <td>{{ $dt->type_name }}</td>
                                <td>{{ $dt->cp_name }}</td>
                                <td>{{ $dt->cp_email }}</td>
                                <td>{{ $dt->cp_phone }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn" wire:click="edit({{ $dt->id }})"><span
                                            class="bi bi-pen"></span></button>
                                    <button type="button" class="btn" wire:click="delete({{ $dt->id }})"><span
                                            class="bi bi-trash"></span></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
