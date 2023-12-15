<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Customer Bank Details</h6>
        </div>
        <div class="card-body">
            <div>
                <h3 class="font-weight-bold text-primary">Institute Details</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <span><strong>Institute Name: </strong>
                                {{ $customerBank->bank_name }}
                            </span>
                        </div>

                        <div class="mb-3">
                            <span><strong>Institute Phone Number: </strong>
                                {{ $customerBank->bank_phone_numebr }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <span><strong>Website: </strong>
                                {{ $customerBank->website }}
                            </span>
                        </div>

                        <div class="mb-3">
                            <span><strong>State: </strong>
                                {{ $customerBank->states->name }}
                            </span>
                        </div>

                        <div class="mb-3">
                            <span><strong>Display Report Type: </strong>
                                @if ($customerBank->display_reports == "state")
                                    <td>Standard Metropolitan Report</td>
                                @elseif ($customerBank->display_reports == "custom")
                                    <td>Custom Report</td>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div>
                <h3 class="font-weight-bold text-primary">Contract Details</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <span><strong>Contract Start Date: </strong>
                                {{ date('m-d-Y', strtotime($customerBank->contract->contract_start)) }}
                            </span>
                        </div>

                        <div class="mb-3">
                            <span><strong>Contract End Date: </strong>
                                {{ date('m-d-Y', strtotime($customerBank->contract->contract_end)) }}
                            </span>
                        </div>

                        <div class="mb-3">
                            <span><strong>Contract Charges: </strong>
                                {{ number_format($customerBank->contract->charges, 2) }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                    </div>
                </div>
            </div>

            <hr>

            <div>
                <h3 class="font-weight-bold text-primary">Selected Bank Details</h3>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                @if ($customerBank->display_reports == "custom")
                                    <th>Bank Name</th>
                                    <th>Zip Code</th>
                                    <th>State</th>
                                    <th>City</th>
                                @else
                                    <th>Metropolitan Area</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($customerBank->selected_banks as $dt)
                                <tr>
                                @if ($customerBank->display_reports == "custom")
                                    <td>{{ $dt->name }}</td>
                                    <td>{{ $dt->zip_code }}</td>
                                    <td>{{ $dt->state_name }}</td>
                                    <td>{{ $dt->city_name }}</td>
                                @else
                                    <td>{{ $dt->city_name }}</td>
                                @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No Data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <hr>

            <div>
                <h3 class="font-weight-bold text-primary">Payment Details</h3>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Cheque Number</th>
                                <th>Amount</th>
                                <th>Cheque Image</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($customerBank->payment as $pay)
                                <tr>
                                    <td>{{ $pay->cheque_number }}</td>
                                    <td>{{ $pay->amount }}</td>
                                    <td><a href="{{ env('APP_URL')."storage/".$pay->cheque_image }}" target="_blank">
                                        <button class="btn btn-primary"> View</button>
                                    </a></td>
                                    <td>{{ $pay->status == "1" ?"Approved":"Not Approved Yet" }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No Payment yet</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
