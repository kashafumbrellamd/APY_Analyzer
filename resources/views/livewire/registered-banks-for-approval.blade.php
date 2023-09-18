<div>
    @if (auth()->user()->hasRole('admin'))
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Bank Requests</h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <div wire:loading.delay>
                        <div class="spinner-border text-danger" role="status">
                        </div>
                        <br>
                        <span class="text-danger">Loading...</span>
                    </div>
                </div>
                <div class="table-responsive" wire:loading.remove>

                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Bank Name</th>
                                <th>Cheque Number</th>
                                <th>Amount</th>
                                <th>Cheque Image</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $dt)
                                <tr>
                                    <td>{{ $dt->bank_name }}</td>
                                    <td>{{ $dt->cheque_number }}</td>
                                    <td>{{ $dt->amount }}</td>
                                    <td><a href="{{ env('APP_URL')."storage/".$dt->cheque_image }}" target="_blank">
                                            <button class="btn btn-primary"> View</button>
                                        </a></td>
                                    <td>{{ ($dt->status==0?'Not Active':'Active') }}</td>
                                    <td><button class="btn btn-success" wire:click="approved({{ $dt->id }})"> Approve </button></td>
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
        </div>
    @endif

</div>
