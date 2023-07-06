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
                                                    <input type="name" id="bank_name" name="bank_name" class="form-control" aria-describedby="name" wire:model.lazy="bank_name">
                                                    <!-- <div id="name" class="form-text">error message</div> -->
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="bank_email" class="form-label">Email</label>
                                                    <input type="email" id="bank_email" name="bank_email" class="form-control" aria-describedby="email" wire:model.lazy="bank_email">
                                    
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="bank_phone" class="form-label">Phone Number</label>
                                                    <input type="number" id="bank_phone" name="bank_phone" class="form-control" aria-describedby="phone" wire:model.lazy="bank_phone">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="bank_website" class="form-label">Website</label>
                                                    <input type="text" id="bank_website" name="bank_website" class="form-control" aria-describedby="website" wire:model.lazy="bank_website">
                                    
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="bank_msa" class="form-label">MSA Code</label>
                                                    <input type="text" id="bank_msa" name="bank_msa" class="form-control" aria-describedby="msa_code" wire:model.lazy="bank_msa">
                                    
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="bank_state" class="form-label">State</label>
                                                    <select class="form-select" id="bank_state" name="bank_state" aria-label="Default select example" wire:model.lazy="bank_state">
                                                        <option value="">Select State</option>
                                                        @foreach($states as $state)
                                                        <option value="{{$state->id}}">{{$state->name}}</option>
                                                        @endforeach
                                                    </select>
                                    
                                                </div>
                                            </div>
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
                                                    <label for="admin_name" class="form-label">Name</label>
                                                    <input type="name" id="admin_name" name="admin_name" class="form-control" aria-describedby="name" wire:model.lazy="admin_name">
                                                    <!-- <div id="name" class="form-text">error message</div> -->
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="admin_email" class="form-label">Email</label>
                                                    <input type="email" id="admin_email" name="admin_email" class="form-control" aria-describedby="email" wire:model.lazy="admin_email">
                                    
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="admin_phone" class="form-label">Phone Number</label>
                                                    <input type="number" id="admin_phone" name="admin_phone" class="form-control" aria-describedby="phone" wire:model.lazy="admin_phone">
                                    
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="admin_designation" class="form-label">Designation</label>
                                                    <input type="text" id="admin_designation" name="admin_designation" class="form-control" aria-describedby="Designation" wire:model.lazy="admin_designation">
                                    
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="admin_id" class="form-label">Employee Id</label>
                                                    <input type="text" id="admin_id" name="admin_employeeid" class="form-control" aria-describedby="msa_code" wire:model.lazy="admin_employeeid">
                                    
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="admin_gender" class="form-label">Gender</label>
                                                    <select class="form-select" id="admin_gender" name="admin_gender" aria-label="Default select example" wire:model.lazy="admin_gender">
                                                        <option value="">Select Gender</option>
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                    </select>
                                    
                                                </div>
                                            </div>
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
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="custom" wire:model.lazy="subscription">
                                                        <label class="form-check-label" for="inlineRadio1">Platinum Package (All Bank details)</label>
                                                    </div>
                                                    <br>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="state" wire:model.lazy="subscription">
                                                        <label class="form-check-label" for="inlineRadio2">Gold Package (Banks of your State)</label>
                                                    </div>
                                                    <br>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="msa" wire:model.lazy="subscription">
                                                        <label class="form-check-label" for="inlineRadio3">Silver Package (Only your MSA code Banks)</label>
                                                    </div>
                                                </div>
                                            </div>
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
