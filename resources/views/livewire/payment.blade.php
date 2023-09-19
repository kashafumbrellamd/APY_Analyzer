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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-check-label"
                                    for="cheque_image"> Cheque Image
                                </label>
                                <input type="file" class="form-control" wire:model="photo" id="cheque_image">
                            </div>
                            <div class="mb-3">
                                @if ($photo)
                                    Preview:
                                    <img src="{{ $photo->temporaryUrl() }}" height="100px">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-check-label"
                                    for="cheque_number"> Cheque Number
                                </label>
                                <input type="text" class="form-control" wire:model="cheque_number" id="cheque_number">
                            </div>
                        </div>
                        <div class="col-md-6">
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-check-label"
                                    for="amount"> Amount
                                </label>
                                <input type="text" class="form-control" wire:model="amount" id="amount" value="{{ $amount }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-check-label"
                                    for="bank_name"> Bank Name
                                </label>
                                <input type="text" class="form-control" wire:model="bank_name" id="bank_name">
                            </div>
                        </div>
                        <div class="col-md-6">
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
