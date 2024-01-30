<div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th style="text-align: left;">Institution Name</th>
                <th style="text-align: left;">APY</th>
                <th style="text-align: left;">Description</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($specialization_rates as $key => $dt)
                <tr>
                    <td style="text-align: left; width:max-content;">{{ $dt->bank->name }}</td>
                    <td style="width:max-content;">{{ number_format($dt->rate,2) }}</td>
                    <td style="text-align: left; width:max-content;">{{ $dt->description }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">No Data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
