<div>
    <section class="back_sign__ py-3">
        <div class="container-fluid">
            <div class="col-md-8  m-auto">
                <h2 class="mb-5 text-center">Intelli-Rate</h2>
                <div class="main_signUp">
                    <div>
                    @if (session('contract'))
                        <div class="col-sm-12">
                            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                                {{ session('contract') }}
                            </div>
                        </div>
                    @endif
                    @error('error')
                        <div class="col-sm-12">
                            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                                {{ $message }}
                            </div>
                        </div>
                    @enderror
                    <div>
                        <p class="text-success fw-bold text-end">Total Amount: ${{ number_format($amount) }}</p>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3 mb-3">
                            <label for="card_holder_first_name"> Card Holder First Name </label>
                            <input type="text" class="form-control" name="card_holder_first_name" id="card_holder_first_name" wire:model="first_name">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="card_holder_last_name"> Card Holder Last Name </label>
                            <input type="text" class="form-control" name="card_holder_last_name" id="card_holder_last_name" wire:model="last_name">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email"> Email </label>
                            <input type="text" class="form-control" name="email" id="email" wire:model="email">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone_number"> Phone Number </label>
                            <input type="text" class="form-control" name="phone_number" id="phone_number" wire:model="phone_number"
                            oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');" maxlength="13">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="card_number">Card Number</label>
                            <input type="text" class="form-control" name="card_number" id="card_number" wire:model="card_number"
                                oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');" maxlength="19">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="cvc"> CVV/CVC </label>
                            <input type="text" class="form-control" name="cvc" id="cvc" wire:model="cvc"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');" maxlength="4">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="exp_month"> Expiry Month </label>
                            <label for="exp_year"> Expiry Year </label>
                            <select class="form-control" name="exp_month" id="exp_month" wire:model="exp_month">
                                @for ($i = 01; $i < 10; $i++)
                                    <option value="0{{ $i }}">0{{ $i }}</option>
                                @endfor
                                @for ($i = 10; $i < 13; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="exp_year"> Expiry Year </label>
                            <select class="form-control" name="exp_year" id="exp_year" wire:model="exp_year">
                                @php
                                    $year = date('Y');
                                @endphp
                                @for ($i = 0; $i < 10; $i++)
                                    <option value="{{ $year+$i }}">{{ $year+$i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="zip_code"> Zip Code </label>
                            <input type="text" class="form-control" name="zip_code" id="zip_code" wire:model="zip_code" wire:keyup="fetch_zip_code">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="state"> State </label>
                            <input type="text" class="form-control" name="state" id="state" wire:model="state" disabled>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="city"> City </label>
                            <input type="text" class="form-control" name="city" id="city" wire:model="city" disabled>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="address"> Address </label>
                            <input type="text" class="form-control" name="address" id="address" wire:model="address">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3 text-center">
                            <button type="submit"
                                class="btn submit_btn" wire:click="submitForm">Submit</button>
                        </div>
                    </div>
                </div>

                </div>
            </div>
        </div>
    </section>
</div>
