<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            font-family:Arial, Helvetica, sans-serif;
        }

        .wax_width{
            width: max-content;
        }

        /* header css */

        .invoice_header{
            display: flex !important;
            align-items:flex-start !important;
            justify-content: space-between !important;
            padding: 20px;
        }

        .invoice_header_details > h1{
            font-style: italic;
            font-family:Verdana, Geneva, Tahoma, sans-serif;
            font-weight: 900;
            color: rgb(55 55 155);
        }

        .invoice_header_details > p{
            font-weight: 600;
            font-size: 14px;
        }

        .invoice_date{
            display: flex !important;
            align-items: center !important;
            flex-direction: column !important;
            padding: 20px;
        }

        .invoice_date > h3{
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

        .invoice_service{
            display: flex !important;
            align-items: flex-start !important;
            justify-content: flex-start !important;
            padding: 20px;
            width: 85%;
            margin-left: 60px;
            margin-bottom: 20px;
            border: 2px solid blue;
        }

        .service_heading{
            margin-right: 50px;
            width: 100px;
        }

        th{
            text-align: left;
            width: 150px;
            font-size: 13px;
        }
        td{
            font-size: 13px;
        }

        /* message section css  */

        .invoice_message{
            display: flex !important;
            align-items: flex-start !important;
            justify-content: flex-start!important;
            padding: 20px;
            width: 85%;
            margin-left: 60px;
            margin-bottom: 20px;
            border: 2px solid blue;
        }

        .message_heading{
            margin-right: 50px;
            width: 100px;

        }

        th ,td{
            font-size: 13px;
        }

        .blue_line{
            height: 2px;
            background-color: blue;
            width: 90%;
            margin-left: 60px;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        /* single line para css para css  */

        .red_para{
            text-align: center;
            color: red;
            padding: 5px;
        }

        .blue_para{
            text-align: center;
            color: blue;
            font-size: 12px;
            padding: 5px;
        }


        /* footer section css  */



        .invoice_footer{
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
                <p>ancanalytics.com</p>
                <p>PO Box 510385</p>
                <p>St. Louis, MO 63151</p>
            </div>
            <div class="invoice_date">
                <h3>Invoice</h3>
                <p><b>Date : </b>06 Nov 2023</p>
            </div>
        </div>

        <!-- invoice client -->

        <div class="invoice_client">
            <div class="client_heading">
                <h3 class="wax_width">Client</h3>
            </div>
            <table class="client_details" >
                <tr><td>Royal Banks of Missouri</td></tr>
                <tr><td>ATTN Accounts Payable</td></tr>
                <tr><td>1555 Kisker Rd.</td></tr>
                <tr><td>St. Peters, MO 63304</td></tr>
            </table>

        </div>

                <!-- Service client -->

                <div class="invoice_service">
                    <div class="service_heading">
                        <h3 class="wax_width">Service : </h3>
                    </div>
                    <table class="client_details" >
                        <tr><th>Invoice No</th>              <td>9059 9059</td></tr>
                        <tr><th>PO Number</th>               <td>9059</td></tr>
                        <tr><th>Product Type</th>            <td>MoneyMonitor</td></tr>
                        <tr><th>Product Desc.</th>           <td>Survey</td></tr>
                        <tr><th>Order/Renewal Date</th>      <td>14-Jun-23</td></tr>
                        <tr><th>Start Date</th>              <td>14-Jun-23</td></tr>
                        <tr><th>Term(in Months)</th>         <td>05</td></tr>
                        <tr><th>End Date</th>                <td>06-Jun-24</td></tr>
                        <tr><th>Price</th>                   <td>$895.00</td></tr>
                    </table>

                </div>

        <!-- invoice message -->

        <div class="invoice_message">
            <div class="message_heading">
                <h3 class="wax_width">Message : </h3>
            </div>
            <div class="invoice_message_details" >
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ex suscipit, voluptates earum ipsum odit rem autem iusto nobis et eligendi! Harum placeat accusantium dolor porro inventore sequi nesciunt quam recusandae!</p>
            </div>

        </div>

        <!-- invoice single line text -->

        <p class="red_para">Please make checks payable to: BancAnalytics Corporation</p>
        <p class="blue_para">Please make checks payable to: BancAnalytics Corporation</p>

        <div class="blue_line"></div>

                <!-- invoice service details -->

                <div class="invoice_header">
                    <div class="invoice_header_details">
                        <h1>BancAnalytics Corporation</h1>
                        <p>ancanalytics.com</p>
                        <p>PO Box 510385</p>
                        <p>St. Louis, MO 63151</p>
                    </div>
                    <div class="invoice_date">
                        <table class="client_details" >
                        <tr><th>Invoice No</th>               <td>9059 9059</td></tr>
                        <tr><th>PO Number</th>               <td>9059</td></tr>
                        <tr><th>Product Type</th>            <td>MoneyMonitor</td></tr>
                        <tr><th>Product Desc.</th>           <td>Survey</td></tr>
                        <tr><th>Product Desc.</th>           <td>______________________</td></tr>
                        <tr><th>Product Desc.</th>           <td>______________________</td></tr>
                    </table>
                </div>

            </div>
                     <!-- invoice footer -->

                     <div class="invoice_footer">

                        <div class="three_divs">

                            <p>Royal Banks of Missouri</p>
                            <p>ATTN: Accounts Payable</p>
                            <p>1555 Kisker Rd.</p>
                            <p>St. Peters, MO 63304</p>
                            <p>Phone (314)212-165 </p>
                            <p>Fax (314)212-165 </p>

                        </div>

                        <div class="three_divs">
                            <p>Please note changes here</p>
                            <p>________________________</p>
                            <p>________________________</p>
                            <p>________________________</p>
                            <p>________________________</p>
                            <p>________________________</p>
                        </div>

                        <div class="three_divs">

                         <table>
                            <tr><th>Amount Enclosed:</th><td>______________</td></tr>
                            <tr><th>Check Number::</th><td>______________</td></tr>
                         </table>

                        </div>

                     </div>




    </div>
</body>
</html>
