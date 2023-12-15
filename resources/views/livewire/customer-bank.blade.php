<div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Customer Banks</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Institution Name</th>
                            {{-- <th>Institution Email</th> --}}
                            <th>Institution Phone Number</th>
                            <th>Website</th>
                            {{-- <th>MSA Code</th> --}}
                            <th>State</th>
                            {{-- <th>Contract Start</th>
                            <th>Contract End</th>
                             <th>Charges</th> --}}
                            <th>Reports</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $dt)
                            <tr>
                                <td>{{ $dt->bank_name }}</td>
                                {{-- <td>{{ $dt->bank_email }}</td> --}}
                                <td>{{ $dt->bank_phone_numebr }}</td>
                                <td>{{ $dt->website }}</td>
                                {{-- <td>{{ $dt->msa_code }}</td> --}}
                                <td>{{ $dt->states->name }}</td>
                                {{-- <td>{{ date('m-d-Y', strtotime($dt->contract->contract_start)) }}</td>
                                <td>{{ date('m-d-Y', strtotime($dt->contract->contract_end)) }}</td>
                                <td>{{ number_format($dt->contract->charges, 2) }}</td> --}}
                                @if ($dt->display_reports == "state")
                                    <td>Standard Metropolitan Report</td>
                                @elseif ($dt->display_reports == "custom")
                                    <td>Custom Report</td>
                                @endif
                                <td class="d-flex" height="75px">
                                    <button type="button" class="btn"
                                        wire:click="view({{ $dt->id }})"><span
                                            class="bi bi-eye-fill"></span></button>
                                    {{-- <button type="button" class="btn"
                                        wire:click="edit({{ $dt->id }})"><span
                                            class="bi bi-pen"></span></button> --}}
                                    <button type="button" class="btn"
                                        wire:click="delete({{ $dt->id }})"><span
                                            class="bi bi-trash"></span></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No Data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $data->links('livewire::bootstrap') }}
            </div>
        </div>
    </div>
</div>
