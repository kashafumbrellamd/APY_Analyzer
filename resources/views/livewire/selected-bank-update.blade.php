<div>
    @if ($this->subscription == 'custom')
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
    @endif
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
                <div class="col-md-12">
                    <section class="show_box">
                        <div class="container-fluid">
                            <div class="container p-5">
                                <div class="row">
                                    @foreach ($packages as $package)
                                    <div class="col-lg-12 col-md-12 mb-6">
                                        @if ($this->subscription == $package->package_type)
                                        <div class="card card_2 h-100 shadow-lg mb-3"
                                            style="min-height: 320px;">
                                            <div class="card-body">
                                                <div class="text-center p-3">
                                                    <h5 class="card-title h3"
                                                        style="font-weight: 600;">
                                                        {{ $package->name }}</h5>
                                                    <span
                                                        class="h3">${{ number_format($package->price) }}</span>/Annually
                                                </div>
                                                <p class="card-text2"
                                                    style="text-align: justify; margin-bottom: 0px;">
                                                    {{ $package->description }} </p>
                                            </div>
                                            <div class="card-body text-center">
                                                @if ($package->package_type == 'state')
                                                    <select class="form-select form-control">
                                                        <option>Saint Louis, Missouri</option>
                                                        <option>Miami, Florida</option>
                                                        <option>Tampa, Florida</option>
                                                    </select>
                                                @endif
                                            </div>
                                            <div class="card-body text-center">
                                                <button class="btn btn-outline-primary btn-md"
                                                    style="border-radius:10px"
                                                    >
                                                    Select</button>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                    </section>
                </div>
                <div class="col-md-6"></div>
                {{-- <div class="col-md-12">
                    @if ($this->current_amount != 0)
                        <p wire:loading.class="invisible" class="text-success fw-bold">Total Amount:
                            ${{ number_format($this->current_amount) }}</p>
                    @endif
                </div> --}}
                @if ($this->subscription == 'custom')
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="bank_type" class="form-label">Select Institution Type</label>
                            <select class="form-control" id="bank_type" name="bank_type"
                                aria-label="Default select example" wire:model="bank_type"
                                wire:change="selectbanktype($event.target.value)">
                                <option value="">All Institution Type</option>
                                @foreach ($bank_types as $bank_type)
                                    <option value="{{ $bank_type->id }}">
                                        {{ $bank_type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
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
                            <label for="bank_type" class="form-label">Select Institution State</label>
                            <select class="form-select form-control mb-3" aria-label="Default select example"
                                wire:model="selected_state_now" wire:change="selectstate($event.target.value)">
                                <option value="">Select Institution State</option>
                                @foreach ($available_states as $state)
                                    <option value="{{ $state->id }}">
                                        {{ $state->name }}</option>
                                @endforeach
                                <option value="all">All Data</option>
                            </select>
                        </div>
                    </div>
                    {{-- <div class="col-md-12">
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
                    </div> --}}
                    <div class="col-md-12">
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
                            <label for="bank_type" class="form-label">Select Metropolitician Area</label>
                            <select class="form-select form-control mb-3 " aria-label="Default select example"
                                wire:model="selected_city_now" wire:change="selectcbsa($event.target.value)">
                                <option value="">Select Metropolitician Area</option>
                                @foreach ($available_cbsa as $city)
                                    <option value="{{ $city->cbsa_code }}">
                                        {{ $city->cbsa_name }}</option>
                                @endforeach
                                <option value="all">All Data</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <label for="bank_name_city" class="form-label">Institution Name ,
                                        State ,
                                        City
                                    </label>
                                    @if ($this->current_amount != 0)
                                        <label wire:loading.class="invisible" class="text-success fw-bold">Total Amount:
                                            ${{ number_format($this->current_amount) }}</label>
                                    @endif
                                        <label>Numbers Selected: {{ count($this->custom_banks) }}</label>
                                </div>
                                <div class="mt-2">
                                    <div class="bank_select_divv">
                                        @if (count($this->all_banks) != 0)
                                            @php $count = 0; @endphp
                                            @foreach ($this->all_banks as $bank)
                                                @if (in_array($bank->id, $this->custom_banks))
                                                    <div class="form-check">
                                                        <input class="form-check-input" style="position: relative;"
                                                            type="checkbox" value="{{ $bank->id }}"
                                                            id="defaultCheck{{ $bank->id }}"
                                                            wire:model.defer="selectedItems"
                                                            {{-- wire:click="select_bank({{ $bank->id }})"  --}}
                                                            checked
                                                            {{ in_array($bank->id, $this->already) ? 'disabled' : '' }}>
                                                        <label class="form-check-label"
                                                            for="defaultCheck{{ $bank->id }}">
                                                            {{ $bank->name }} <span
                                                                class="state_city_span">({{ $bank->states->name }},
                                                                &nbsp;{{ $bank->cities->name }})</span>
                                                        </label>
                                                    </div>
                                                    @php $count++; @endphp
                                                @else
                                                    <div class="form-check">
                                                        <input class="form-check-input" style="position: relative;"
                                                            type="checkbox" value="{{ $bank->id }}"
                                                            id="defaultCheck{{ $bank->id }}"
                                                            wire:model.defer="selectedItems"
                                                            {{-- wire:click="select_bank({{ $bank->id }})" --}}
                                                            >
                                                        <label class="form-check-label"
                                                            for="defaultCheck{{ $bank->id }}">
                                                            {{ $bank->name }} <span
                                                                class="state_city_span">({{ $bank->states->name }},
                                                                &nbsp;{{ $bank->cities->name }})</span>
                                                        </label>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                        <a wire:click="loadMore"
                                            style="cursor:pointer; display: block; text-align: center;"
                                            class="">Load More</a>
                                    </div>
                                    <div class="d-flex justify-content-center m-2">
                                        <button class="btn btn-primary" wire:click="save_banks">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex align-items-start pt-5 justify-content-start"
                        wire:loading.class="invisible">
                        {{-- <div class="d-flex align-items-center justify-content-center width__100"> --}}
                        @if (count($selected_banks_name) != 0)
                            <ul class="width__100 order__list">
                                @forelse ($selected_banks_name as $item)
                                    {{-- <li class="">{{ $item['name'] }}</li> --}}
                                    <li class=""><b>{{ $item['name'] }}</b>
                                        ({{ $item['states']['name'] }},{{ $item['cities']['name'] }})
                                    </li>
                                @empty
                                @endforelse
                                <div class="d-flex justify-content-center">
                                    <button class="btn btn-danger" wire:click="clear()"> Clear </button>
                                </div>
                            </ul>
                        @endif
                        {{-- </div> --}}
                    </div>
                @elseif ($this->subscription == 'state')
                    <div class="col-md-12" wire:loading.class="invisible">
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
                                    <label for="bank_type" class="form-label">Select Metropolitan Area</label>
                                    <select class="form-select form-control mb-3 " aria-label="Default select example"
                                        wire:model="selected_city_now" wire:change="selectcity($event.target.value)">
                                        <option value="">Select Metropolitan Area</option>
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
                            class="btn btn-primary" wire:click="submitForm">Next</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
