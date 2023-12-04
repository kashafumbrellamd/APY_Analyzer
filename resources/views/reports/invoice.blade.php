<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        .wax_width {
            width: max-content;
        }

        /* header css */

        .invoice_header {
            display: flex !important;
            align-items: flex-start !important;
            justify-content: space-between !important;
            padding: 20px;
        }

        .invoice_header_details>h1 {
            font-style: italic;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-weight: 900;
            color: rgb(55 55 155);
        }

        .invoice_header_details>p {
            font-weight: 600;
            font-size: 14px;
        }

        .invoice_date {
            display: flex !important;
            align-items: center !important;
            flex-direction: column !important;
            padding: 20px;
        }

        .invoice_date>h3 {
            font-size: 25px;
            padding: 5px;
        }

        /* client section css  */

        .invoice_client {
            display: flex !important;
            align-items: flex-start !important;
            justify-content: flex-start !important;
            padding: 20px;
            width: 85%;
            margin-left: 60px;
            margin-bottom: 20px;
            border: 2px solid blue;
        }

        .client_heading {
            margin-right: 50px;
            width: 100px;
        }

        /* service section css  */

        .invoice_service {
            display: flex !important;
            align-items: flex-start !important;
            justify-content: flex-start !important;
            padding: 20px;
            width: 85%;
            margin-left: 60px;
            margin-bottom: 20px;
            border: 2px solid blue;
        }

        .service_heading {
            margin-right: 50px;
            width: 100px;
        }

        th {
            text-align: left;
            width: 150px;
            font-size: 13px;
        }

        td {
            font-size: 13px;
        }

        /* message section css  */

        .invoice_message {
            display: flex !important;
            align-items: flex-start !important;
            justify-content: flex-start !important;
            padding: 20px;
            width: 85%;
            margin-left: 60px;
            margin-bottom: 20px;
            border: 2px solid blue;
        }

        .message_heading {
            margin-right: 50px;
            width: 100px;

        }

        th,
        td {
            font-size: 13px;
        }

        .blue_line {
            height: 2px;
            background-color: blue;
            width: 90%;
            margin-left: 60px;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        /* single line para css para css  */

        .red_para {
            text-align: center;
            color: red;
            padding: 5px;
        }

        .blue_para {
            text-align: center;
            color: blue;
            font-size: 12px;
            padding: 5px;
        }


        /* footer section css  */



        .invoice_footer {
            padding: 20px;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
        }
    </style>
</head>

<body>
    <div class="invoice_pdf">

        <!-- invoice header -->
        <div class="invoice_header">
            <div class="invoice_header_details">
                <h1>BancAnalytics Corporation</h1>
                <p>Intelli-rate.com</p>
                <p>PO Box 510385</p>
                <p>St. Louis, MO 63151</p>
            </div>
            <div class="invoice_date">
                <h3>Invoice</h3>
                <p><b>Date : </b>{{ date('m-d-Y') }}</p>
            </div>
        </div>

        <!-- invoice client -->

        <div class="invoice_client">
            <div class="client_heading">
                <h3 class="wax_width">Client</h3>
            </div>
            <table class="client_details">
                <tr>
                    <td>{{ $bank->bank_name }}</td>
                </tr>
                <tr>
                    @if ($bank->billing_address != null)
                        <td>{{ $bank->billing_address }}</td>
                    @endif
                    {{-- <td>ATTN Accounts Payable</td> --}}
                </tr>
                <tr>
                    <td>{{ $bank->cities->name }},{{ $bank->states->name }}</td>
                </tr>
                <tr>
                    <td>{{ $bank->zip_code }}</td>
                </tr>
            </table>

        </div>

        <!-- Service client -->

        <div class="invoice_service">
            <div class="service_heading">
                <h3 class="wax_width">Service : </h3>
            </div>
            <table class="client_details">
                <tr>
                    <th>Invoice No</th>
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
            </table>

        </div>

        <!-- invoice message -->

        <div class="invoice_message">
            <div class="message_heading">
                <h3 class="wax_width">Message : </h3>
            </div>
            <div class="invoice_message_details">
                <p></p>
            </div>

        </div>

        <!-- invoice single line text -->

        <p class="red_para">Please make checks payable to: BancAnalytics Corporation</p>
        <p class="blue_para">(Detach bottom portion of invoice to include with payment)</p>

        <div class="blue_line"></div>

        <!-- invoice service details -->

        <div class="invoice_header">
            <div class="invoice_header_details">
                <h1>BancAnalytics Corporation</h1>
                <p>Intelli-rate.com</p>
                <p>PO Box 510385</p>
                <p>St. Louis, MO 63151</p>
            </div>
            <div class="invoice_date">
                <table class="client_details">
                    <tr>
                        <th>Invoice No</th>
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
                        <th>Terms(Mos.)</th>
                        <td>{{ $fromDate->diffInMonths($toDate); }}</td>
                    </tr>
                    <tr>
                        <th>Different Terms:</th>
                        <td>______________________</td>
                    </tr>
                    <tr>
                        <th>Different Product:</th>
                        <td>______________________</td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- invoice footer -->

        <div class="invoice_footer">

            <div class="three_divs">
                <p>{{ $bank->bank_name }}</p>
                {{-- <p>ATTN: Accounts Payable</p> --}}
                <p>{{ $bank->zip_code }}</p>
                <p>{{ $bank->cities->name }},{{ $bank->states->name }}</p>
                <p>Phone: {{ $bank->bank_phone_numebr }} </p>
            </div>

            <div class="three_divs">
                <p>Please note changes here</p>
                <p>________________________</p>
                <p>________________________</p>
                <p>________________________</p>
                <p>________________________</p>
            </div>

            <div class="three_divs">
                <table>
                    <tr>
                        <th>Amount Enclosed:</th>
                        <td>______________</td>
                    </tr>
                    <tr>
                        <th>Check Number::</th>
                        <td>______________</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
