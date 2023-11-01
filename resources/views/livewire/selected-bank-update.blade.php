<div>
    <div class="card shadow mb-4">
        <div class="accordion" id="accordionFlushExample">
            <div class="accordion-item">
                <div class="card-header py-3" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                    aria-expanded="false" aria-controls="flush-collapseOne">
                    <div class="d-flex justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Selected Banks</h6>
                        <i class="fa fa-chevron-down pl-2" aria-hidden="true"></i>
                    </div>
                </div>
                <div id="flush-collapseOne" class="accordion-collapse card-body collapse    "
                    aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Institution Name</th>
                                    <th>Institution Email</th>
                                    <th>Institution Phone Number</th>
                                    <th>Website</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $dt)
                                    <tr>
                                        <td>{{ $dt->name }}</td>
                                        <td>{{ $dt->cp_email }}</td>
                                        <td>{{ $dt->phone_number }}</td>
                                        <td>{{ $dt->website }}</td>
                                        <td>
                                            <button type="button" class="btn"
                                                wire:click="deleteRequest({{ $dt->cpb_id }})"><span
                                                    class="bi bi-trash"></span></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No Data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Customize My Package</h6>
        </div>
        <div class="card-body">
            @error('payment')
                <div class="mt-3 text-center">
                    <span class="alert alert-danger" role="alert">{{ $message }}</span>
                </div>
            @enderror
            @error('request')
                <div class="mt-3 text-center">
                    <span class="alert alert-success" role="alert">{{ $message }}</span>
                </div>
            @enderror
            <h5>Choose Subscription Plan (One year)</h5>
            <div class="text-center">
                <div wire:loading.delay>
                    <div class="spinner-border text-danger" role="status">
                    </div>
                    <br>
                    <span class="text-danger">Loading...</span>
                </div>
            </div>
            <div class="row" wire:loading.remove>
                <div class="col-md-6">
                    <div class="mb-3">
                        @foreach ($packages as $package)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                    id="inlineRadio{{ $package->id }}" value="{{ $package->package_type }}"
                                    wire:model.lazy="subscription" disabled>
                                <label class="form-check-label" style="margin-bottom: 12px;"
                                    for="inlineRadio{{ $package->id }}">{{ $package->name }}
                                </label>
                            </div>
                            <div class="bank_select_divv h-100">
                                {{ $package->description }}
                            </div>
                            <br>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    @if ($this->current_amount != 0)
                        <p wire:loading.class="invisible" class="text-success fw-bold">Total Amount:
                            ${{ number_format($this->current_amount) }}</p>
                    @endif
                </div>
                <div class="col-md-6"></div>
                @if ($this->subscription == 'custom')
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="bank_type" class="form-label">Select Bank
                                Type</label>
                            <select class="form-control" id="bank_type" name="bank_type"
                                aria-label="Default select example" wire:model="bank_type"
                                wire:change="selectbanktype($event.target.value)">
                                <option value="">All Bank Types</option>
                                @foreach ($bank_types as $bank_type)
                                    <option value="{{ $bank_type->id }}">
                                        {{ $bank_type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <div>
                                @foreach ($bank_state_filter_name as $key => $filtered_state)
                                    <span
                                        class="border border-dark p-1 rounded position-relative me-3 mb-2">{{ $filtered_state }}
                                        <span wire:click="deleteState({{ $key }})"
                                            style="position: absolute;
                                        font-size: 14px;
                                        background-color: #f12d2d;
                                        padding: 0px 7px;
                                        border-radius: 13px;
                                        top: -12px;
                                        cursor:pointer;
                                        right: -12px;
                                        color: #fff;
                                        font-weight: 600;">x</span>
                                    </span>
                                @endforeach
                            </div>
                            <label for="bank_type" class="form-label">Select Bank
                                State</label>
                            <select class="form-select form-control mb-3" aria-label="Default select example"
                                wire:model="selected_state_now" wire:change="selectstate($event.target.value)">
                                <option value="">Select State</option>
                                @foreach ($available_states as $state)
                                    <option value="{{ $state->id }}">
                                        {{ $state->name }}</option>
                                @endforeach
                                <option value="all">All Data</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6"></div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <div>
                                @foreach ($bank_city_filter_name as $key => $filtered_city)
                                    <span
                                        class="border border-dark p-1 rounded position-relative me-3 mb-2">{{ $filtered_city }}
                                        <span wire:click="deleteCity({{ $key }})"
                                            style="position: absolute;
                                        font-size: 14px;
                                        background-color: red;
                                        padding: 0px 7px;
                                        border-radius: 13px;
                                        top: -12px;
                                        right: -12px;
                                        color: #fff;
                                        font-weight: 600;">x</span>
                                    </span>
                                @endforeach
                            </div>
                            <label for="bank_type" class="form-label">Select Bank
                                City</label>
                            <select class="form-select form-control mb-3 " aria-label="Default select example"
                                wire:model="selected_city_now" wire:change="selectcity($event.target.value)">
                                <option value="">Select City</option>
                                @foreach ($available_cities as $city)
                                    <option value="{{ $city->city_id }}">
                                        {{ $city->cities->name }}</option>
                                @endforeach
                                <option value="all">All Data</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6"></div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <div>
                                @foreach ($bank_cbsa_filter_name as $key => $filtered_city)
                                    <span
                                        class="border border-dark p-1 rounded position-relative me-3 mb-2">{{ $filtered_city }}
                                        <span wire:click="deleteCbsa({{ $key }})"
                                            style="position: absolute;
                                        font-size: 14px;
                                        background-color: red;
                                        padding: 0px 7px;
                                        border-radius: 13px;
                                        top: -12px;
                                        right: -12px;
                                        color: #fff;
                                        font-weight: 600;">x</span>
                                    </span>
                                @endforeach
                            </div>
                            <label for="bank_type" class="form-label">Select Bank
                                CBSA</label>
                            <select class="form-select form-control mb-3 " aria-label="Default select example"
                                wire:model="selected_city_now" wire:change="selectcbsa($event.target.value)">
                                <option value="">Select CBSA</option>
                                @foreach ($available_cbsa as $city)
                                    <option value="{{ $city->cbsa_code }}">
                                        {{ $city->cbsa_name }}</option>
                                @endforeach
                                <option value="all">All Data</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6"></div>

                    <div class="col-md-6">
                        <div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <label for="bank_name_city" class="form-label">Institution Name ,
                                        State ,
                                        City
                                    </label>
                                    @if (count($this->custom_banks) <= $this->selected_package->number_of_units)
                                        <label>{{ count($this->custom_banks) }}/{{ $this->selected_package->number_of_units }}</label>
                                    @else
                                        <label
                                            class="text-danger">{{ count($this->custom_banks) }}/{{ $this->selected_package->number_of_units }}</label>
                                    @endif
                                </div>
                                <div class="mt-2">
                                    <div class="bank_select_divv">
                                        @if (count($this->custom_banks) == count($this->all_banks))
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    style="position: relative;" value="" id="defaultCheckall"
                                                    wire:click="deselect_all_banks()" checked>
                                                <label class="form-check-label" for="defaultCheckall">
                                                    Deselect All <span class="state_city_span"></span>
                                                </label>
                                            </div>
                                        @else
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    style="position: relative;" value="" id="defaultCheckall"
                                                    wire:click="select_all_banks()">
                                                <label class="form-check-label" for="defaultCheckall">
                                                    Select All <span class="state_city_span"></span>
                                                </label>
                                            </div>
                                        @endif
                                        @if (count($this->all_banks) != 0)
                                            @php $count = 0; @endphp
                                            @foreach ($this->all_banks as $bank)
                                                @if (in_array($bank->id, $this->custom_banks))
                                                    <div class="form-check">
                                                        <input class="form-check-input" style="position: relative;"
                                                            type="checkbox" value=""
                                                            id="defaultCheck{{ $bank->id }}"
                                                            wire:click="select_bank({{ $bank->id }})" checked
                                                            {{ in_array($bank->id, $this->already) ? 'disabled' : '' }}>
                                                        <label class="form-check-label"
                                                            for="defaultCheck{{ $bank->id }}">
                                                            {{ $bank->name }} <span
                                                                class="state_city_span">({{ $bank->state_name }},
                                                                &nbsp;{{ $bank->city_name }})</span>
                                                        </label>
                                                    </div>
                                                    @php $count++; @endphp
                                                @else
                                                    <div class="form-check">
                                                        <input class="form-check-input" style="position: relative;"
                                                            type="checkbox" value=""
                                                            id="defaultCheck{{ $bank->id }}"
                                                            wire:click="select_bank({{ $bank->id }})">
                                                        <label class="form-check-label"
                                                            for="defaultCheck{{ $bank->id }}">
                                                            {{ $bank->name }} <span
                                                                class="state_city_span">({{ $bank->state_name }},
                                                                &nbsp;{{ $bank->city_name }})</span>
                                                        </label>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                        <a wire:click="loadMore"
                                            style="cursor:pointer; display: block; text-align: center;"
                                            class="">Load More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif ($this->subscription == 'state')
                    <div class="col-md-6" wire:loading.class="invisible">
                        <div>
                            <div>
                                <div class="mb-3">
                                    <div>
                                        @foreach ($bank_city_filter_name as $key => $filtered_city)
                                            <span
                                                class="border border-dark p-1 rounded position-relative me-3 mb-2">{{ $filtered_city }}
                                                <button type="button" wire:click="deleteCity({{ $key }})">
                                                    <span
                                                        style="position: absolute;
                                                font-size: 14px;
                                                background-color: red;
                                                padding: 0px 7px;
                                                border-radius: 13px;
                                                top: -12px;
                                                right: -12px;
                                                color: #fff;
                                                font-weight: 600;">x</span>
                                                </button>
                                            </span>
                                        @endforeach
                                    </div>
                                        <?php
                                            $check_city = App\Models\BankSelectedCity::where('bank_id',Auth::user()->bank_id)->pluck('city_id')->toArray();
                                        ?>
                                    <label for="bank_type" class="form-label">Select Institution
                                        City And State</label>
                                    <select class="form-select form-control mb-3 " aria-label="Default select example"
                                        wire:model="selected_city_now" wire:change="selectcity($event.target.value)">
                                        <option value="">Select City</option>
                                        {{-- <option value="119383">Kansas City</option> --}}
                                        @if (!in_array('125680',$check_city))
                                            <option value="125680">Saint Louis, Missouri</option>
                                        @endif
                                        @if (!in_array('121746',$check_city))
                                            <option value="121746">Miami, Florida</option>
                                        @endif
                                        @if (!in_array('127407',$check_city))
                                            <option value="127407">Tampa, Florida</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-md-12">
                    <div class="mb-3 text-center">
                        <button type="submit"
                            class="btn btn-primary" wire:click="submitForm">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
