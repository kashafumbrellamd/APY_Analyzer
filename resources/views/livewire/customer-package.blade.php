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
                            <button class="btn btn-danger mx-4">
                                <a href="{{ route('logout') }}" style="text-decoration: none; !important; color:white;"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                            </button>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        @else
                            <button onclick="window.location.href='/signup'" class="btn signUp_btn me-2">Sign Up Now</button>
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
                <h2 class="mb-5 text-center">Intelli-Rate</h2>
                <div class="main_signUp">
                    <div>
                        <h5>Choose Subscription Plan (One year)</h5>
                        <div>
                            <div class="row">
                                <div>
                                    <section class="show_box">
                                        <div class="container-fluid">
                                            <div class="container p-5">
                                                <div class="row">
                                                    <div class="section-header text-center  pb-5">
                                                        <h2 class="fw-bold fs-2 ">
                                                            Select Your Plan
                                                        </h2>
                                                        <p style="text-align: justify;">
                                                            The dropdown menu indicates metropolitan areas where the Standard Report is currently offered.
                                                            Click the “Select” button, then choose your metropolitan area in the field below.
                                                            If not listed, select a Custom Report and we will design a report specifically for your area with the institutions of your choice.
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    @foreach ($packages as $package)
                                                        <div class="col-lg-6 col-md-12 mb-6">
                                                            <div class="card card_2 h-100 shadow-lg mb-3"
                                                                style="min-height: 393px;">
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
                                                                        <p>Four-Week Free Trial</p>
                                                                        <select class="form-select form-control mb-3 ">
                                                                            @foreach ($standard_report_list as $srl)
                                                                                <option>{{ $srl->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    @endif
                                                                </div>
                                                                <div class="card-body text-center">
                                                                    <button class="btn btn-outline-primary btn-md"
                                                                        style="border-radius:10px"
                                                                        wire:click="subscription_changed('{{ $package->package_type }}')">
                                                                        Select</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                    </section>
                                </div>
                                <div class="text-center">
                                    <div wire:loading.delay>
                                        <div class="spinner-border text-danger" role="status">
                                        </div>
                                        <br>
                                        <span class="text-danger">Loading...</span>
                                    </div>
                                </div>
                                @error('subscription')
                                    <div class="mb-5 text-center" wire:loading.class="invisible">
                                        <span class="alert alert-danger" role="alert">{{ $message }}</span>
                                    </div>
                                @enderror
                                @if ($this->current_amount != 0)
                                    <p wire:loading.class="invisible" class="text-success fw-bold">Total Amount:
                                        ${{ number_format($this->current_amount) }}</p>
                                @endif
                                @if ($this->subscription == 'custom')
                                    <div class="col-md-7" style="width: 100% !important" wire:loading.class="invisible">
                                        <div>
                                            <div>
                                                <div class="mb-3">
                                                    <label for="bank_type" class="form-label">Select Institution
                                                        Type</label>
                                                    <select class="form-select" id="bank_type" name="bank_type"
                                                        aria-label="Default select example" wire:model="bank_type"
                                                        wire:change="selectbanktype($event.target.value)">
                                                        <option value="">All Institution Types</option>
                                                        @foreach ($bank_types as $bank_type)
                                                            <option value="{{ $bank_type->id }}">
                                                                {{ $bank_type->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div>
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
                                                    <label for="bank_type" class="form-label">Select Institution
                                                        State</label>
                                                    <select class="form-select form-control mb-3"
                                                        aria-label="Default select example"
                                                        wire:model="selected_state_now"
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
                                            {{-- <div>
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
                                                    <label for="bank_type" class="form-label">Select Institution
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
                                            </div> --}}
                                            <div>
                                                <div class="mb-3">
                                                    <div>
                                                        @foreach ($bank_cbsa_filter_name as $key => $filtered_city)
                                                            <span
                                                                class="border border-dark p-1 rounded position-relative me-3 mb-2">{{ $filtered_city }}
                                                                <button type="button"
                                                                    wire:click="deleteCbsa({{ $key }})">
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
                                                    <label for="bank_type" class="form-label">Select Metropolitician
                                                        Area</label>
                                                    <select class="form-select form-control mb-3 "
                                                        aria-label="Default select example"
                                                        wire:model="selected_city_now"
                                                        wire:change="selectcbsa($event.target.value)">
                                                        <option value="">Select Metropolitician Area</option>
                                                        @foreach ($available_cbsa as $city)
                                                            <option value="{{ $city->cbsa_code }}">
                                                                {{ $city->cbsa_name }}</option>
                                                        @endforeach
                                                        <option value="all">All Data</option>
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- <div>
                                                <div class="mb-3">
                                                    <label for="zip_search" class="form-label">Enter Zip Code</label>
                                                    <input type="text" class="form-control" wire:model.defer="bank_zip_code"
                                                        onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"
                                                         style="width: 50%!important; display:inline;"  maxlength="5">
                                                    <button class="btn btn-primary" wire:click="zipCodeChanged">Search</button>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                    <div class="col-md-6" wire:loading.class="invisible">
                                        <div>
                                            <div>
                                                <div class="mb-3">
                                                    <div class="d-flex justify-content-between">
                                                        <label for="bank_name_city" class="form-label">Institution
                                                            Name ,
                                                            State ,
                                                            City
                                                        </label>
                                                        <label>Numbers Selected: {{ count($this->custom_banks) }}</label>
                                                    </div>
                                                    <div class="mt-2">
                                                        <div class="bank_select_divv">
                                                            {{-- @if (count($this->custom_banks) == count($this->all_banks))
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
                                                            @endif --}}
                                                            @if (count($this->all_banks) != 0)
                                                                @php $count = 0; @endphp
                                                                @foreach ($this->all_banks as $bank)
                                                                    @if (in_array($bank->id, $this->custom_banks))
                                                                        <div class="form-check">
                                                                            <input class="form-check-input"
                                                                                type="checkbox" value="{{ $bank->id }}"
                                                                                id="defaultCheck{{ $bank->id }}"
                                                                                wire:model.defer="selectedItems"
                                                                                {{-- wire:click="select_bank({{ $bank->id }})" --}}
                                                                                checked>
                                                                            <label class="form-check-label"
                                                                                for="defaultCheck{{ $bank->id }}">
                                                                                {{ $bank->name }} <span
                                                                                    class="state_city_span">({{ $bank->zip_code }}, {{ $bank->states->name }},
                                                                                    &nbsp;{{ $bank->cities->name }})</span>
                                                                            </label>
                                                                        </div>
                                                                        @php $count++; @endphp
                                                                    @else
                                                                        <div class="form-check">
                                                                            <input class="form-check-input"
                                                                                type="checkbox" value="{{ $bank->id }}"
                                                                                id="defaultCheck{{ $bank->id }}"
                                                                                wire:model.defer="selectedItems"
                                                                                {{-- wire:click="select_bank({{ $bank->id }})" --}}
                                                                                >
                                                                            <label class="form-check-label"
                                                                                for="defaultCheck{{ $bank->id }}">
                                                                                {{ $bank->name }} <span
                                                                                    class="state_city_span">
                                                                                    ({{-- {{ $bank->zip_code }}, --}}{{ $bank->states->name }},
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
                                                        {{-- <div class="text-center text-primary">
                                                        </div> --}}
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
                                                        ({{-- {{ $item['zip_code'] }}, --}}{{ $item['states']['name'] }},{{ $item['cities']['name'] }})
                                                    </li>
                                                @empty
                                                @endforelse
                                                <div class="d-flex justify-content-center m-2">
                                                    <button class="btn btn-danger" wire:click="clear()"> Clear </button>
                                                </div>
                                            </ul>
                                        @endif
                                        {{-- </div> --}}
                                    </div>
                                    @error('notselected')
                                        <div class="mb-5 text-center" wire:loading.class="invisible">
                                            <span class="alert alert-danger" role="alert">{{ $message }}</span>
                                        </div>
                                    @enderror
                                @elseif ($this->subscription == 'state')
                                    <div class="col-md-12" wire:loading.class="invisible">
                                        <div>
                                            <div>
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
                                                    <label for="bank_type" class="form-label">Select Metropolitan Area</label>
                                                    <select class="form-select form-control mb-3 "
                                                        aria-label="Default select example"
                                                        wire:model="selected_city_now"
                                                        wire:change="selectcity($event.target.value)">
                                                        <option value="">Select Metropolitan Area</option>
                                                        @foreach ($standard_report_list as $srl)
                                                            <option value="{{ $srl->city_id }}">{{ $srl->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>
                            <div class="col-md-12">
                                <div class="mb-3 text-center">
                                    <button type="submit" class="btn submit_btn"
                                        wire:click="submitForm">Next</button>
                                </div>
                            </div>
                        </div>
                    </div>
    </section>
</div>
