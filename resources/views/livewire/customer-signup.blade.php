<div>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand header_brand_heading" href="{{ url('/') }}">INTELLI-RATE</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
                    aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarScroll">
                    <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('interesting_stories') }}">News</a>
                        </li>
                    </ul>
                    <div class="d-flex">
                        @if (Auth::check())
                        <button onclick="window.location.href='/home'" class="btn submit_btn">Go To
                            Dashboard</button>
                        @else
                        <button onclick="window.location.href='/signup'" class="btn signUp_btn me-2">Sign up for free</button>
                        <button onclick="window.location.href='/signin'" class="btn submit_btn">Login</button>
                        @endif
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <section class="back_sign__ py-3">
        <div class="container-fluid">
            <div class="col-md-8  m-auto">
                <div class="main_signUp">
                    <h1 class="regiter_heading_h">Register Your Institution</h1>
                    @error('error')
                        <div class="mt-4 text-center">
                            <span class="alert alert-danger">{{$message}}</span>
                        </div>
                    @enderror
                    <div class="row">
                        <form wire:submit.prevent="submitForm">
                            <div class="col-md-12">
                                <div>
                                    <h5>Institution's Details</h5>
                                    <div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="bank_name" class="form-label">Financial Institution Name</label>
                                                    <input type="name" id="bank_name" name="bank_name"
                                                        class="form-control" aria-describedby="name" placeholder="BancAnalytics"
                                                        wire:model.lazy="bank_name" required>
                                                    <!-- <div id="name" class="form-text">error message</div> -->
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="bank_email" class="form-label">Email</label>
                                                    <input type="email" id="bank_email" name="bank_email"
                                                        class="form-control" aria-describedby="email" placeholder="Email Address"
                                                        wire:model.lazy="bank_email" required>

                                                </div>
                                            </div> --}}
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="bank_phone" class="form-label">Main Phone Number</label>
                                                    <input type="text" id="bank_phone" name="bank_phone"
                                                        class="form-control" aria-describedby="phone" maxlength="12"
                                                        wire:model.lazy="bank_phone" required  placeholder="949-656-3133">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="bank_website" class="form-label">Website Address</label>
                                                    <input type="text" id="bank_website" name="bank_website"
                                                        class="form-control" aria-describedby="website"
                                                        wire:model.lazy="bank_website" required  placeholder="Your Website">

                                                </div>
                                            </div>
                                            {{-- <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="CBSA_CODE" class="form-label">CBSA Code</label>
                                                    <input type="text" id="CBSA_CODE" name="CBSA_CODE"
                                                        class="form-control" aria-describedby="website"
                                                        wire:model.lazy="cbsa_code" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="cbsa_name" class="form-label">CBSA Name</label>
                                                    <input type="text" id="cbsa_name" name="cbsa_name"
                                                        class="form-control" aria-describedby="cbsa_name"
                                                        wire:model="cbsa_name" required>
                                                </div>
                                            </div> --}}
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="zip_code" class="form-label">Zip Code</label>
                                                    <input type="text" id="zip_code" name="zip_code"
                                                        class="form-control" aria-describedby="website"
                                                        wire:model="zip_code" wire:keyup="fetch_zip_code" required  placeholder="Your Zip Code">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="bank_state" class="form-label">State</label>
                                                    <select class="form-select" id="bank_state" name="bank_state"
                                                        aria-label="Default select example" wire:model.lazy="bank_state" disabled
                                                        required>
                                                        <option value=""> </option>
                                                        @foreach ($states as $state)
                                                            <option value="{{ $state->id }}">{{ $state->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="bank_state" class="form-label">City</label>
                                                    <select class="form-select" id="bank_city" name="bank_city"
                                                        aria-label="Default select example" wire:model.lazy="bank_city" disabled
                                                        required>
                                                        <option value=""> </option>
                                                        @if ($bank_cities != null)
                                                            @foreach ($bank_cities as $city)
                                                                <option value="{{ $city->id }}">{{ $city->name }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <hr>
                                <div>
                                    <h5>Institution's Admin Details</h5>
                                    <div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="admin_first_name" class="form-label">First Name</label>
                                                    <input type="name" id="admin_first_name"
                                                        name="admin_first_name" class="form-control"
                                                        aria-describedby="name" wire:model.lazy="admin_first_name"
                                                        required  placeholder="John">
                                                    <!-- <div id="name" class="form-text">error message</div> -->
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="admin_last_name" class="form-label">Last Name</label>
                                                    <input type="name" id="admin_last_name" name="admin_last_name"
                                                        class="form-control" aria-describedby="name"
                                                        wire:model.lazy="admin_last_name"  placeholder="Doe" required>
                                                    <!-- <div id="name" class="form-text">error message</div> -->
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="admin_email" class="form-label">Email Address</label>
                                                    <input type="email" id="admin_email" name="admin_email"
                                                        class="form-control" aria-describedby="email"  placeholder="Contact Person Email Address"
                                                        wire:model.lazy="admin_email" required>

                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="admin_phone" class="form-label">Contact Phone Number</label>
                                                    <input type="text" id="admin_phone" name="admin_phone"
                                                        class="form-control" aria-describedby="phone" maxlength="12"
                                                        wire:model.lazy="admin_phone" required  placeholder="949-656-3133">

                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="admin_designation" class="form-label">Job Title</label>
                                                    <input type="text" id="admin_designation"
                                                        name="admin_designation" class="form-control"
                                                        aria-describedby="Designation" placeholder="Job Title"
                                                        wire:model.lazy="admin_designation" required>

                                                </div>
                                            </div>
                                            {{-- <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="admin_id" class="form-label">Employee Id</label>
                                                    <input type="text" id="admin_id" name="admin_employeeid" class="form-control" aria-describedby="msa_code" wire:model.lazy="admin_employeeid" required>

                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="admin_gender" class="form-label">Gender</label>
                                                    <select class="form-select" id="admin_gender" name="admin_gender" aria-label="Default select example" wire:model.lazy="admin_gender" required>
                                                        <option value="">Select Gender</option>
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                    </select>

                                                </div>
                                            </div> --}}
                                        </div>

                                    </div>
                                </div>
                                <hr>
                                {{-- <div>
                                    <h5>Choose Subscription Plan (One year)</h5>
                                    <div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    @foreach ($packages as $package)
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="inlineRadioOptions"
                                                                id="inlineRadio{{ $package->id }}"
                                                                value="{{ $package->package_type }}"
                                                                wire:model.lazy="subscription">
                                                            <label class="form-check-label"
                                                                for="inlineRadio{{ $package->id }}">{{ $package->name }}
                                                                ({{ $package->package_type }})
                                                            </label>
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
                                                            <select class="form-select" id="bank_type"
                                                                name="bank_type" aria-label="Default select example"
                                                                wire:model="bank_type"
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
                                                                aria-label="Default select example"
                                                                wire:model="selected_state_now"
                                                                wire:change="selectstate($event.target.value)">
                                                                <option value="">Select State</option>
                                                                @foreach ($avaiable_states as $state)
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
                                                                aria-label="Default select example"
                                                                wire:model="selected_city_now"
                                                                wire:change="selectcity($event.target.value)">
                                                                <option value="">Select City</option>
                                                                @foreach ($avaiable_cities as $city)
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
                                                                <label for="bank_name_city"
                                                                    class="form-label">Institution Name , State ,
                                                                    City</label>
                                                                <div class="mt-2">
                                                                    <div class="bank_select_divv">
                                                                        @if (count($this->custom_banks) == count($this->all_banks))
                                                                            <div class="form-check">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox" value=""
                                                                                    id="defaultCheckall"
                                                                                    wire:click="deselect_all_banks()"
                                                                                    checked>
                                                                                <label class="form-check-label"
                                                                                    for="defaultCheckall">
                                                                                    Deselect All <span
                                                                                        class="state_city_span"></span>
                                                                                </label>
                                                                            </div>
                                                                        @else
                                                                            <div class="form-check">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox" value=""
                                                                                    id="defaultCheckall"
                                                                                    wire:click="select_all_banks()">
                                                                                <label class="form-check-label"
                                                                                    for="defaultCheckall">
                                                                                    Select All <span
                                                                                        class="state_city_span"></span>
                                                                                </label>
                                                                            </div>
                                                                        @endif
                                                                        @if (count($this->all_banks) != 0)
                                                                            @php $count = 0; @endphp
                                                                            @foreach ($this->all_banks as $bank)
                                                                                @if (in_array($bank->id, $this->custom_banks))
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input"
                                                                                            type="checkbox"
                                                                                            value=""
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
                                                                                            type="checkbox"
                                                                                            value=""
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
                                                </div>--}}

                                                <div>
                                                    {{-- <h5>Charity Details</h5> --}}
                                                    <div>
                                                        <div class="row">
                                                            {{-- <div class="col-md-4">
                                                                <div class="mb-3">
                                                                    <select class="form-select" id="bank_charity"
                                                                        name="bank_charity"
                                                                        aria-label="Default select example"
                                                                        wire:model.lazy="bank_charity">
                                                                        <option value="">Select Charity</option>
                                                                        @foreach ($charities as $charity)
                                                                            <option value="{{ $charity->id }}">
                                                                                {{ $charity->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div> --}}
                                                            @error('customer_banks')
                                                                <div class="mt-3 text-center mb-5">
                                                                    <span class="alert alert-danger"
                                                                        role="alert">{{ $message }}</span>
                                                                </div>
                                                            @enderror
                                                            <div class="col-md-12">
                                                                <div class="mb-3 text-center">
                                                                    <button type="submit"
                                                                        class="btn submit_btn">Submit</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                        </form>
                        <div class="col-md-6"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
