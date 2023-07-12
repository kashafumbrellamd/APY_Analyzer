<div>
<section class="back_sign__ py-3">
        <div class="container-fluid">
            <div class="col-md-8  m-auto">
                <div class="main_signUp">
                    <h1 class="regiter_heading_h">Register Your Bank</h1>
                    <div class="row">
                        <form wire:submit.prevent="submitForm">
                            <div class="col-md-12">
                                <div>
                                    <h5>Bank's Details</h5>
                                    <div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="bank_name" class="form-label">Enter Bank Name</label>
                                                    <input type="name" id="bank_name" name="bank_name" class="form-control" aria-describedby="name" wire:model.lazy="bank_name" required>
                                                    <!-- <div id="name" class="form-text">error message</div> -->
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="bank_email" class="form-label">Email</label>
                                                    <input type="email" id="bank_email" name="bank_email" class="form-control" aria-describedby="email" wire:model.lazy="bank_email" required>

                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="bank_phone" class="form-label">Phone Number</label>
                                                    <input type="number" id="bank_phone" name="bank_phone" class="form-control" aria-describedby="phone" wire:model.lazy="bank_phone" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="bank_website" class="form-label">Website</label>
                                                    <input type="text" id="bank_website" name="bank_website" class="form-control" aria-describedby="website" wire:model.lazy="bank_website" required>

                                                </div>
                                            </div>
                                            {{-- <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="bank_msa" class="form-label">MSA Code</label>
                                                    <input type="text" id="bank_msa" name="bank_msa" class="form-control" aria-describedby="msa_code" wire:model.lazy="bank_msa" required>

                                                </div>
                                            </div> --}}
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="bank_state" class="form-label">State</label>
                                                    <select class="form-select" id="bank_state" name="bank_state" aria-label="Default select example" wire:model.lazy="bank_state" required>
                                                        <option value="">Select State</option>
                                                        @foreach($states as $state)
                                                        <option value="{{$state->id}}">{{$state->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            @if($bank_cities != null)
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="bank_state" class="form-label">City</label>
                                                        <select class="form-select" id="bank_city" name="bank_city" aria-label="Default select example" wire:model.lazy="bank_city" required>
                                                            <option value="">Select State</option>
                                                            @foreach($bank_cities as $city)
                                                                <option value="{{$city->id}}">{{$city->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                                <hr>
                                <div>
                                    <h5>Bank's Admin Details</h5>
                                    <div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="admin_first_name" class="form-label">First Name</label>
                                                    <input type="name" id="admin_first_name" name="admin_first_name" class="form-control" aria-describedby="name" wire:model.lazy="admin_first_name" required>
                                                    <!-- <div id="name" class="form-text">error message</div> -->
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="admin_last_name" class="form-label">Last Name</label>
                                                    <input type="name" id="admin_last_name" name="admin_last_name" class="form-control" aria-describedby="name" wire:model.lazy="admin_last_name" required>
                                                    <!-- <div id="name" class="form-text">error message</div> -->
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="admin_email" class="form-label">Email</label>
                                                    <input type="email" id="admin_email" name="admin_email" class="form-control" aria-describedby="email" wire:model.lazy="admin_email" required>

                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="admin_phone" class="form-label">Phone Number</label>
                                                    <input type="number" id="admin_phone" name="admin_phone" class="form-control" aria-describedby="phone" wire:model.lazy="admin_phone" required>

                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="admin_designation" class="form-label">Title</label>
                                                    <input type="text" id="admin_designation" name="admin_designation" class="form-control" aria-describedby="Designation" wire:model.lazy="admin_designation" required>

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
                                <div>
                                    <h5>Choose Subscription Plan (One year)</h5>
                                    <div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    @foreach($packages as $package)
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio{{$package->id}}" value="{{$package->package_type}}" wire:model.lazy="subscription">
                                                        <label class="form-check-label" for="inlineRadio{{$package->id}}">{{$package->name}} ({{ $package->package_type }})</label>
                                                    </div>
                                                    <br>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                            </div>
                                            @if($this->subscription == 'custom')
                                            <div class="col-md-6">
                                                <div>
                                                    <div class="mb-3">
                                                        <label for="bank_name_city" class="form-label">Bank Name , State , City</label>
                                                        <input type="text" class="form-control" id="bank_name_city" aria-describedby="emailHelp" wire:model="bank_search" placeholder="Search Banks by Name, State and City...">
                                                        <div class="mt-2">
                                                            <div class="bank_select_divv">
                                                                @if(count($this->all_banks)!=0)
                                                                @php $count = 0; @endphp
                                                                @foreach ($this->all_banks as $bank)
                                                                @if(in_array($bank->id,$this->custom_banks))
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck2"
                                                                    wire:click="select_bank({{ $bank->id }})" checked>
                                                                    <label class="form-check-label" for="defaultCheck2">
                                                                        {{$bank->name}} <span class="state_city_span">({{$bank->state_name}}, &nbsp;{{$bank->city_name}})</span>                                          
                                                                    </label>
                                                                </div>
                                                                @php $count++; @endphp
                                                                @else
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck2"
                                                                    wire:click="select_bank({{ $bank->id }})">
                                                                    <label class="form-check-label" for="defaultCheck2">
                                                                        {{$bank->name}} <span class="state_city_span">({{$bank->state_name}}, &nbsp;{{$bank->city_name}})</span>                                          
                                                                    </label>
                                                                </div>
                                                                @endif
                                                                @endforeach
                                                                @if($count == count($this->all_banks) && $count!=0)
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck2"
                                                                        wire:click="deselect_all_banks()" checked>
                                                                    <label class="form-check-label" for="defaultCheck2">
                                                                        Select All <span class="state_city_span"></span>                                          
                                                                    </label>
                                                                </div>
                                                                @else
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck2"
                                                                        wire:click="select_all_banks()">
                                                                    <label class="form-check-label" for="defaultCheck2">
                                                                        Select All <span class="state_city_span"></span>                                          
                                                                    </label>
                                                                </div>
                                                                @endif
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div>
                                    <h5>Charity Details</h5>
                                    <div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <!-- <label for="bank_charity" class="form-label">Charity Options</label> -->
                                                    <select class="form-select" id="bank_charity" name="bank_charity" aria-label="Default select example" wire:model.lazy="bank_charity">
                                                        <option value="">Select Charity</option>
                                                        @foreach($charities as $charity)
                                                        <option value="{{$charity->id}}">{{$charity->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            @error('customer_banks')
                                                <div class="mt-3 text-center mb-5">
                                                    <span class="alert alert-danger" role="alert">{{ $message }}</span>
                                                </div>
                                            @enderror
                                            <div class="col-md-12">
                                                <div class="mb-3 text-center">
                                                    <button type="submit" class="btn submit_btn">Submit</button>
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
