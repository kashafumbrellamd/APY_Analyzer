{{-- <div class="table-responsive">
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
</div> --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @page {
            margin: 100px 25px;
        }

        header {
            position: fixed;
            top: -60px;
            height: 50px;
            font-family:  Arial, sans-serif;
            font-size:10;
            text-align: center;
            line-height: 35px;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 3px;
            text-align: center;
            font-size: 10px;
        }

        th {
            background-color: #f2f2f2;
        }

    </style>
</head>

<body>
    <header>
        @foreach ($msa_codes as $key => $item)
                    {{ ++$key.") ".$item->cbsa_name }}
        @endforeach
    </header>

    <main>
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
    </main>
    <script type="text/php">
        if ( isset($pdf) ) {
            $font = $fontMetrics->getFont("Arial", "bold");
            $pdf->page_text(20, 18, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0,0,0));
            $pdf->page_text(250, 18, "Last Updated Date: {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', \App\Models\BankPrices::max('updated_at'))->format('m-d-Y'); }}", $font, 10, array(0,0,0));
            $pdf->page_text(410, 18, "Downloaded Date: {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',now())->format('m-d-Y') }} ", $font, 10, array(0,0,0));
        }
    </script>
</body>

</html>
