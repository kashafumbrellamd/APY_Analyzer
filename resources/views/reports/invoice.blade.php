<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BancAnalytics Corporation Invoice</title>
    <style>
        /* .invoice {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        } */

        .header {
            background-color: #333399;
            color: #fff;
            padding: 20px;
            text-align: left;
        }

        .color_blue {
            color: #333399;
            font-style: italic;
            margin: 10px 0px;
        }

        .header h1 {
            font-style: italic;
        }

        .client-details,
        .services,
        .message {
            padding-left: 15px;
            padding-right: 15px;
            padding-bottom: 5px;
            padding-top: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }


        th,
        td {
            padding: 8px;
            text-align: left;
        }

        .first_table th {
            width: 40%;
        }

        .details_blow_text {
            color: red;
            text-align: center;
            font-style: italic;
        }

        .details_blow_text_blue {
            color: blue;
            text-align: center;
            font-size: 12px;
        }

        .border_none {
            border: none;
        }

        .detached_blow_line {
            width: 80%;
            height: 2px;
            background-color: #333399;
            text-align: center;
            margin: auto auto;
        }

        .margin_0 {
            margin: 2px 0px;
        }

        .align_center {
            text-align: center;
        }

        .align_right {
            text-align: right;
        }

        .invoice_heading {
            color: #333399;
            text-align: center;
            margin: 10px 0px;
            font-size: 25px;
        }
    </style>
</head>

<body>
    <div class="invoice">
        <div class="header">
            <h1><u>BancAnalytics Corporation</u></h1>
            <p class="margin_0 align_right"><strong>Date: </strong>{{ date('m-d-Y') }}</p>
            <p class="margin_0">Intelli-rate.com</p>
            <p class="margin_0">PO Box 510385</p>
            <p class="margin_0">St. Louis, MO 63151 </p>


        </div>

        <h3 class="invoice_heading">Invoice</h3>

        <div class="client-details ">
            <h2>Client:</h2>
            <p class="margin_0"><strong>Bank Name: </strong>{{ $bank->bank_name }}</p>
            @if ($bank->billing_address != null)
                <p class="margin_0"><strong>Address: </strong> {{ $bank->billing_address }}</p>
            @endif
            <p class="margin_0"><strong>City / State / Zip Code: </strong> {{ $bank->cities->name }}, {{ $bank->states->name }} {{ $bank->zip_code }}</p>
        </div>

        <div class="services">
            <h2>Service:</h2>
            <table class="first_table">
                <tbody>

                    <tr>
                        <th>Invoice No.</th>
                        <td>IR-{{ str_pad($reports->id, 5, '0', STR_PAD_LEFT); }}</td>
                    </tr>

                    <tr>
                        <th>Product Type</th>
                        <td>Intelli-Rate Report.</td>
                    </tr>

                    <tr>
                        <th>Product Desc.</th>
                        <td>Survey</td>
                    </tr>

                    <tr>
                        <th>Order/Renewal Date</th>
                        <td>{{ date("m-d-Y") }}</td>
                    </tr>

                    <tr>
                        <th>Start Date</th>
                        <td>{{ date("m-d-Y", strtotime($reports->contract_start)) }}</td>
                    </tr>

                    <tr>
                        <th>Term(in Months)</th>
                        @php
                            $toDate = \Carbon\Carbon::parse($reports->contract_start);
                            $fromDate = \Carbon\Carbon::parse($reports->contract_end);
                        @endphp
                        <td>{{ $fromDate->diffInMonths($toDate); }}</td>
                    </tr>

                    <tr>
                        <th>End Date</th>
                        <td>{{ date("m-d-Y", strtotime($reports->contract_end)) }}</td>
                    </tr>

                    <tr>
                        <th>Price</th>
                        <td>${{ $reports->charges }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="message ">
            <h2>Message:</h2>
            <p></p>
        </div>

        <p class="details_blow_text">Please make checks payable to: BancAnalytics Corporation</p>
        <p class="details_blow_text_blue">(Detach bottom portion of invoice to include with payment)
        </p>

        <p class="detached_blow_line"></p>

        <div class="services">

            <table>
                <tbody>
                    <tr>

                        <td class="border_none">
                            <h3 class="color_blue"><u>BancAnalytics Corporation</u></h3>
                            <p class="margin_0">Intelli-rate.com</p>
                            <p class="margin_0">PO Box 510385</p>
                            <p class="margin_0">St. Louis, MO 63151 </p>
                        </td>

                        <td class="align_right border_none">
                            <p><strong>Invoice No:</strong> IR-{{ str_pad($reports->id, 5, '0', STR_PAD_LEFT); }}</p>
                            <p><strong>Product Type:</strong> Intelli-Rate Report.</p>
                            <p><strong>Product Desc.</strong> Survey</p>
                            <p><strong>Terms(Mos.)</strong> {{ $fromDate->diffInMonths($toDate); }}</p>
                            <p><strong>Different Terms:</strong> ______________________</p>
                            <p><strong>Different Product:</strong> ______________________</p>
                        </td>

                    </tr>
                </tbody>
            </table>

            <table class="third_table border_none">
                <tbody>
                    <tr>
                        <td class="border_none">
                            <p class="margin_0">{{ $bank->bank_name }}</p>
                            @if ($bank->billing_address != null)
                                <p class="margin_0"> {{ $bank->billing_address }}</p>
                            @endif
                            <p class="margin_0">{{ $bank->cities->name }}, {{ $bank->states->name }} {{ $bank->zip_code }}</p>
                            <p class="margin_0"><strong>Phone:</strong>{{ $bank->bank_phone_numebr }}</p>
                        </td>

                        <td class="border_none align_center">
                            <p class="margin_0">Please note changes here</p>
                            <p class="margin_0">____________________</p>
                            <p class="margin_0">____________________</p>
                            <p class="margin_0">____________________</p>
                        </td>

                        <td class="border_none align_right">
                            <p class="margin_0"><strong>Amount Enclosed:</strong>__________</p>
                            <p class="margin_0"><strong>Check Number:</strong>__________</p>

                        </td>
                    </tr>
                </tbody>

            </table>
        </div>

    </div>
</body>

</html>
