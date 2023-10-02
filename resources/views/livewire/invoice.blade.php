<div>
    <section class="back_sign__ py-3">
        <div class="container-fluid">
            <div class="col-md-8  m-auto">
                <h2 class="mb-5 text-center">Intelli-Rate</h2>
                <div class="main_signUp">
                    <div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class=" border border-3 border-dark p-3">
                                @include('reports.invoice',compact('reports'))
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3 text-center">
                                <button type="submit"
                                    class="btn submit_btn" wire:click="download">Download Invoice</button>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="bank_select_divv" style="height: 300px">
                                <h2 class="text-center"> Terms & Conditions</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="mb-3 text-center">
                        <button type="submit"
                            class="btn submit_btn" wire:click="next">Next</button>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </section>
</div>
