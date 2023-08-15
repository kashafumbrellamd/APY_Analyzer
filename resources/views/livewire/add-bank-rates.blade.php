<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Select Institution</h6>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-4">
                <div class="container">
                    <div class="row">
                        <div class="col-md-2" style="border-right: 5px solid blue;">
                            <label for="state">Institution</label>
                            <select class="form-select form-control" aria-label="Default select example"
                                wire:change="onbankselect($event.target.value)">
                                <option value="0">Select Institution</option>
                                @foreach ($data as $d)
                                    <option value="{{ $d->id }}">{{ $d->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($bank != null)
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="name">Name</label>
                                        <input type="text" id="name" class="form-control mr-2"
                                            value="{{ $bank->name }}" placeholder="Enter New Role...." readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="state">State</label>
                                        <select class="form-select form-control" id="state"
                                            aria-label="Default select example" readonly>
                                            <option value="{{ $bank->state_id }}">{{ $state_name }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="name">Phone Number</label>
                                        <input type="text" id="phone_number" class="form-control mr-2"
                                            value="{{ $bank->phone_number }}" placeholder="Enter New Role...." readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="website">Website</label>
                                        <input type="text" id="website" class="form-control mr-2"
                                            value="{{ $bank->website }}" placeholder="Enter New Role...." readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="msa_code">MSA Code</label>
                                        <input type="text" id="msa_code" class="form-control mr-2"
                                            value="{{ $bank->msa_code }}" placeholder="Enter New Role...." readonly>
                                    </div>
                                    <div class="col-md-4">
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card shadow mb-4">
        <div class="accordion" id="accordionFlushExample">
            <div class="accordion-item">
                <div class="card-header py-3" data-bs-toggle="collapse"
                    data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                    <div class="d-flex justify-content-between">
                        <div class="col-md-6">
                            <h6 class="m-0 font-weight-bold text-primary">Institution Rates</h6>
                        </div>
                        <div class="col-md-6 d-flex justify-content-between">
                            <button wire:click="download_xlsx" class="btn btn-primary">Format <i class="fa fa-download" aria-hidden="true"></i></button>
                            <input type="file" wire:model="file" class="btn btn-primary"/>
                            <button wire:click="upload_xlsx" class="btn btn-primary">Upload <i class="fa fa-upload" aria-hidden="true"></i></button>
                            <i class="fa fa-chevron-down mt-3 pl-2" aria-hidden="true"></i>
                        </div>
                    </div>
                    @error('upload_error')
                    @php $count = 0; @endphp
                        <div class="mt-3 text-center">
                            @foreach($not_inserted_banks as $bank)
                            @php $count++; @endphp
                            <span class="alert alert-danger" role="alert">{{ $bank }}</span>
                            @if($count%4==0)
                            <br>
                            <br>
                            @endif
                            @endforeach
                        </div>
                        <div class="mt-4 text-center">
                            <span class="text-danger">{{$message}}</span>
                        </div>
                    @enderror
                    @error('upload_rt_error')
                    @php $count = 0; @endphp
                        <div class="mt-3 text-center">
                            @foreach($not_inserted_rt as $rt)
                            @php $count++; @endphp
                            <span class="alert alert-danger" role="alert">{{ $rt }}</span>
                            @if($count%5==0)
                            <br>
                            <br>
                            @endif
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
                <div id="flush-collapseOne" class="accordion-collapse collapse show card-body"
                    aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                    <div class="container">
                        @if (
                            $bank_id != '' &&
                                $bank != null &&
                                !auth()->user()->hasRole('data-verification-operator'))
                            <form wire:submit.prevent="submitForm">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="">Rate Types</label>
                                        <select class="form-select form-control" aria-label="Default select example"
                                            wire:model="rate_type_id">
                                            <option value="">Select Rate Type</option>
                                            @foreach ($rate_types as $rt)
                                                <option value="{{ $rt->id }}">{{ $rt->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if (auth()->user()->hasRole('admin'))
                                        <div class="col-md-4">
                                            <label for="rate">rate</label>
                                            <input type="text" id="rate" class="form-control mr-2"
                                                wire:model="rate" placeholder="Enter Rate....">
                                        </div>
                                    @endif
                                    @if (auth()->user()->hasRole('data-entry-operator'))
                                        <div class="col-md-4">
                                            <label for="rate">New Rate</label>
                                            <input type="text" id="rate" class="form-control mr-2"
                                                wire:model="rate" placeholder="Enter New Rate....">
                                        </div>
                                    @endif
                                    <div class="col-md-4 mt-3">
                                        <label for="rate"></label>
                                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                                    </div>
                                </div>
                            </form>
                        @endif
                        @error('submit')
                            <div class="mt-3 text-center mb-3">
                                <span class="alert alert-danger" role="alert">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                    <div class="table-responsive">

                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Rate Type</th>
                                    @if (auth()->user()->hasRole('admin'))
                                        <th>Rate</th>
                                    @endif
                                    <th>Previous Rate</th>
                                    <th>Current Rate</th>
                                    <th>Change</th>
                                    <th>Date/Time</th>
                                    @if (auth()->user()->hasRole('data-entry-operator'))
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if ($bank_prices != null)
                                    @foreach ($bank_prices as $bp)
                                        <tr>
                                            <td>{{ $bp->rate_type_name }}</td>
                                            @if (auth()->user()->hasRole('admin'))
                                                <td>{{ number_format($bp->rate,2) }}</td>
                                            @endif
                                            <td>{{ number_format($bp->previous_rate,2) }}</td>
                                            <td>{{ number_format($bp->current_rate,2) }}</td>
                                            @if ($bp->current_rate > $bp->previous_rate)
                                               <td class="text-success">{{ number_format($bp->change,2) }}  <i class="fa fa-arrow-up" aria-hidden="true"></i></td>
                                            @elseif ($bp->current_rate == $bp->previous_rate)
                                               <td class="text-dark">{{ number_format($bp->change,2) }}</td>
                                            @else
                                               <td class="text-danger">{{ number_format($bp->change,2) }}  <i class="fa fa-arrow-down" aria-hidden="true"></i></td>
                                            @endif
                                            <td>{{ date('m-d-Y', strtotime(explode(' ', $bp->created_at)[0])) }}
                                                {{ explode(' ', $bp->created_at)[1] }}</td>
                                            @if (auth()->user()->hasRole('data-entry-operator'))
                                                <td class="text-center">
                                                    @if ($bp->is_checked != 1)
                                                        <button class="btn btn-success" wire:click="status_change({{ $bp->id }})">check</button>
                                                    @else
                                                    <button class="btn btn-primary">checked</button>
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card shadow mb-4">
        <div class="accordion" id="accordionFlushExample">
            <div class="accordion-item">
                <div class="card-header py-3" data-bs-toggle="collapse"
                    data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                    <div class="d-flex justify-content-between">
                        <div class="col-md-6">
                            <h6 class="m-0 font-weight-bold text-primary">Institution Rates (Special)</h6>
                        </div>
                        <div class="col-md-6 d-flex justify-content-between">
                            <button wire:click="download_special_xlsx" class="btn btn-primary">Format <i class="fa fa-download" aria-hidden="true"></i></button>
                            <input type="file" wire:model="spec_file" class="btn btn-primary"/>
                            <button wire:click="upload_special_xlsx" class="btn btn-primary">Upload <i class="fa fa-upload" aria-hidden="true"></i></button>
                            <i class="fa fa-chevron-down mt-3 pl-2" aria-hidden="true"></i>
                        </div>
                    </div>
                    @error('upload_spec_error')
                    @php $count = 0; @endphp
                        <div class="mt-3 text-center">
                            @foreach($not_inserted_banks as $bank)
                            @php $count++; @endphp
                            <span class="alert alert-danger" role="alert">{{ $bank }}</span>
                            @if($count%4==0)
                            <br>
                            <br>
                            @endif
                            @endforeach
                        </div>
                        <div class="mt-4 text-center">
                            <span class="text-danger">{{$message}}</span>
                        </div>
                    @enderror
                    @error('upload_spec_rt_error')
                    @php $count = 0; @endphp
                        <div class="mt-3 text-center">
                            @foreach($not_inserted_rt as $rt)
                            @php $count++; @endphp
                            <span class="alert alert-danger" role="alert">{{ $rt }}</span>
                            @if($count%5==0)
                            <br>
                            <br>
                            @endif
                            @endforeach
                        </div>
                        <div class="mt-4 text-center">
                            <span class="text-danger">{{$message}}</span>
                        </div>
                    @enderror
                    @error('spec_file_error')
                        <div class="mt-4 text-center">
                            <span class="text-danger">{{$message}}</span>
                        </div>
                    @enderror
                    @error('upload_spec_success')
                        <div class="mt-4 text-center">
                            <span class="text-success">{{$message}}</span>
                        </div>
                    @enderror
                </div>
                <div id="flush-collapseTwo" class="accordion-collapse collapse show card-body"
                    aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                    <div class="container">
                        @if ($bank_id != '' && $bank != null && !auth()->user()->hasRole('data-verification-operator'))
                            <form wire:submit.prevent="specialRateSubmit">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="special_rate">New Rate</label>
                                        <input type="text" id="special_rate" class="form-control mr-2"
                                            wire:model="special_rate" placeholder="Enter New Special Rate....">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="special_description">Description</label>
                                        <input type="text" id="special_description" class="form-control mr-2"
                                            wire:model="special_description" placeholder="Enter New Special Description....">
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                                    </div>
                                </div>
                            </form>
                        @error('s_submit')
                            <div class="mt-3 text-center mb-3">
                                <span class="alert alert-danger" role="alert">{{ $message }}</span>
                            </div>
                        @enderror
                        @endif
                    </div>
                    <div class="table-responsive">

                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Rate</th>
                                    <th>Description</th>
                                    @if (auth()->user()->hasRole('admin'))
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if ($special_prices != null)
                                    @foreach ($special_prices as $sp)
                                        <tr>
                                            <td>{{ number_format($sp->rate,2) }}</td>
                                            <td>{{ $sp->description }}</td>
                                            @if (auth()->user()->hasRole('admin'))
                                                <td class="text-center">
                                                    <button type="button" class="btn" wire:click="deleteSpecRate({{ $sp->id }})"><span
                                                            class="bi bi-trash"></span></button>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
