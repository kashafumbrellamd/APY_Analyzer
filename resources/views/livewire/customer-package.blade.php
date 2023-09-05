<div>
    <section class="back_sign__ py-3">
        <div class="container-fluid">
            <div class="col-md-8  m-auto">
                <h2 class="mb-5 text-center">Intelli-Rate</h2>
                <div class="main_signUp">
                    <div>
                        <h5>Choose Subscription Plan (One year)</h5>
                        <div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        @foreach ($packages as $package)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                                    id="inlineRadio{{ $package->id }}"
                                                    value="{{ $package->package_type }}" wire:model.lazy="subscription">
                                                <label class="form-check-label"
                                                    for="inlineRadio{{ $package->id }}">{{ $package->name }}
                                                    (${{ $package->price }})
                                                </label>
                                                <span class="text-sm-start">(For Per Additional Bank: ${{ $package->additional_price }})</span>
                                            </div>
                                            <br>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-md-6">
                                </div>
                                @if ($this->subscription == 'custom')
                                    <div class="text-center">
                                        <div wire:loading.delay>
                                            <div class="spinner-border text-danger" role="status">
                                            </div>
                                            <br>
                                            <span class="text-danger">Loading...</span>
                                        </div>
                                    </div>
                                    <div wire:loading.class="invisible">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="bank_type" class="form-label">Select Bank
                                                    Type</label>
                                                <select class="form-select" id="bank_type" name="bank_type"
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
                                        <div class="col-md-6">
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div>
                                                    @foreach ($bank_state_filter_name as $key => $filtered_state)
                                                        <span
                                                            class="border border-dark p-1 rounded position-relative me-3 mb-2">{{ $filtered_state }}
                                                            <button type="button"
                                                                wire:click="deleteState({{ $key }})">
                                                                <span
                                                                    style="position: absolute;
                                                            font-size: 14px;
                                                            background-color: #f12d2d;
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
                                                <label for="bank_type" class="form-label">Select Bank
                                                    State</label>
                                                <select class="form-select form-control mb-3"
                                                    aria-label="Default select example" wire:model="selected_state_now"
                                                    wire:change="selectstate($event.target.value)">
                                                    <option value="">Select State</option>
                                                    @foreach ($available_states as $state)
                                                        <option value="{{ $state->id }}">
                                                            {{ $state->name }}</option>
                                                    @endforeach
                                                    <option value="all">All Data</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div>
                                                    @foreach ($bank_city_filter_name as $key => $filtered_city)
                                                        <span
                                                            class="border border-dark p-1 rounded position-relative me-3 mb-2">{{ $filtered_city }}
                                                            <button type="button"
                                                                wire:click="deleteCity({{ $key }})">
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
                                                <label for="bank_type" class="form-label">Select Bank
                                                    City</label>
                                                <select class="form-select form-control mb-3 "
                                                    aria-label="Default select example" wire:model="selected_city_now"
                                                    wire:change="selectcity($event.target.value)">
                                                    <option value="">Select City</option>
                                                    @foreach ($available_cities as $city)
                                                        <option value="{{ $city->city_id }}">
                                                            {{ $city->cities->name }}</option>
                                                    @endforeach
                                                    <option value="all">All Data</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                        </div>
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
                                                            <label class="text-danger">{{ count($this->custom_banks) }}/{{ $this->selected_package->number_of_units }}</label>
                                                        @endif
                                                    </div>
                                                    <div class="mt-2">
                                                        <div class="bank_select_divv">
                                                            @if (count($this->custom_banks) == count($this->all_banks))
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="" id="defaultCheckall"
                                                                        wire:click="deselect_all_banks()" checked>
                                                                    <label class="form-check-label"
                                                                        for="defaultCheckall">
                                                                        Deselect All <span
                                                                            class="state_city_span"></span>
                                                                    </label>
                                                                </div>
                                                            @else
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="" id="defaultCheckall"
                                                                        wire:click="select_all_banks()">
                                                                    <label class="form-check-label"
                                                                        for="defaultCheckall">
                                                                        Select All <span class="state_city_span"></span>
                                                                    </label>
                                                                </div>
                                                            @endif
                                                            @if (count($this->all_banks) != 0)
                                                                @php $count = 0; @endphp
                                                                @foreach ($this->all_banks as $bank)
                                                                    @if (in_array($bank->id, $this->custom_banks))
                                                                        <div class="form-check">
                                                                            <input class="form-check-input"
                                                                                type="checkbox" value=""
                                                                                id="defaultCheck{{ $bank->id }}"
                                                                                wire:click="select_bank({{ $bank->id }})"
                                                                                checked>
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
                                                                            <input class="form-check-input"
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
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3 text-center">
                                    <button type="submit"
                                        class="btn submit_btn" wire:click="submitForm">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
    </section>
</div>
