<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>View Estimate</title>
    <style>
        * {
            margin: 0;
            box-sizing: border-box;
            -webkit-print-color-adjust: exact;
        }

        body {
            background: #E0E0E0;
            font-family: 'Roboto', sans-serif;
        }

        ::selection {
            background: #f31544;
            color: #FFF;
        }

        ::moz-selection {
            background: #f31544;
            color: #FFF;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        .col-left {
            float: left;
        }

        .col-right {
            float: right;
        }

        h1 {
            font-size: 1.5em;
            color: #444;
        }

        h2 {
            font-size: .9em;
        }

        h3 {
            font-size: 1.2em;
            font-weight: 300;
            line-height: 2em;
        }

        p, ol li {
            font-size: .75em;
            color: #666;
            line-height: 1.2em;
            text-align: justify;
        }

        ol li {
            margin-top: 10px;
            padding: 0 5px;
        }

        a {
            text-decoration: none;
            color: #00a63f;
        }

        #invoiceholder {
            width: 100%;
            height: 100%;
            padding: 50px 0;
        }

        #invoice {
            position: relative;
            margin: 0 auto;
            width: 700px;
            /* background: #FFF; */
            background: url('{{url('images/watermark.png')}}') #fff;
            background-repeat: no-repeat;
            background-position: center;
        }

        [id*='invoice-'] {
            padding: 20px;
        }

        #invoice-top {
            border-bottom: 2px solid #00a63f;
        }

        #invoice-mid {
            min-height: 110px;
        }

        #invoice-bot {
            min-height: 240px;
        }

        .logo {
            display: inline-block;
            vertical-align: middle;
            width: 150px;
            overflow: hidden;
        }

        .info {
            display: inline-block;
            vertical-align: middle;
            margin-left: 20px;
        }

        .logo img,
        .clientlogo img {
            width: 100%;
        }

        .clientlogo {
            display: inline-block;
            vertical-align: middle;
            width: 50px;
        }

        .clientinfo {
            display: inline-block;
            vertical-align: middle;
        }

        .title {
            float: right;
        }

        .title p {
            text-align: right;
        }

        #message {
            margin-bottom: 30px;
            display: block;
        }

        h2 {
            margin-bottom: 5px;
            color: #444;
        }

        .col-right td {
            color: #666;
            padding: 5px 8px;
            border: 0;
            font-size: 0.75em;
            border-bottom: 1px solid #eeeeee;
        }

        .col-right td label {
            margin-left: 5px;
            font-weight: 600;
            color: #444;
        }

        .cta-group a {
            display: inline-block;
            padding: 7px;
            border-radius: 4px;
            background: rgb(196, 57, 10);
            margin-right: 10px;
            min-width: 100px;
            text-align: center;
            color: #fff;
            font-size: 0.75em;
        }

        .cta-group .btn-primary {
            background: #00a63f;
        }

        .cta-group .btn-secondary {
            background: #7366ff;
        }

        .cta-group.mobile-btn-group {
            display: none;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #cccaca;
            font-size: 0.70em;
            text-align: left;
        }

        .tabletitle th {
            border-top: 2px solid #ddd;
            border-bottom: 2px solid #ddd;
            text-align: right;
            font-size: 1em;
        }

        .tabletitle th:nth-child(2) {
            text-align: left;
        }

        th {
            font-size: 0.7em;
            text-align: left;
            padding: 5px 10px;
        }

        .item {
            width: 50%;
        }

        .list-item td {
            text-align: right;
        }

        .list-item td:nth-child(2) {
            text-align: left;
        }

        .total-row th,
        .total-row td {
            text-align: right;
            font-weight: 700;
            font-size: .75em;
            border: 0 none;
        }
        
        .tableitem h4 {
            font-size: 1rem;
        }

        footer {
            border-top: 1px solid #eeeeee;
            ;
            padding: 15px 20px;
        }

        .effect2 {
            position: relative;
        }

        .effect2:before,
        .effect2:after {
            z-index: -1;
            position: absolute;
            content: "";
            bottom: 15px;
            left: 10px;
            width: 50%;
            top: 80%;
            max-width: 300px;
            background: #777;
            -webkit-box-shadow: 0 15px 10px #777;
            -moz-box-shadow: 0 15px 10px #777;
            box-shadow: 0 15px 10px #777;
            -webkit-transform: rotate(-3deg);
            -moz-transform: rotate(-3deg);
            -o-transform: rotate(-3deg);
            -ms-transform: rotate(-3deg);
            transform: rotate(-3deg);
        }

        .effect2:after {
            -webkit-transform: rotate(3deg);
            -moz-transform: rotate(3deg);
            -o-transform: rotate(3deg);
            -ms-transform: rotate(3deg);
            transform: rotate(3deg);
            right: 10px;
            left: auto;
        }

        @media screen and (max-width: 767px) {
            h1 {
                font-size: .9em;
            }

            #invoice {
                width: 100%;
            }

            #message {
                margin-bottom: 20px;
            }

            [id*='invoice-'] {
                padding: 20px 10px;
            }

            .logo {
                width: 150px;
            }

            .title {
                float: none;
                display: inline-block;
                vertical-align: middle;
                margin-left: 40px;
            }

            .title p {
                text-align: left;
            }

            .col-left,
            .col-right {
                width: 100%;
            }

            .table {
                margin-top: 20px;
            }

            #table {
                white-space: nowrap;
                overflow: auto;
            }

            td {
                white-space: normal;
            }

            .cta-group {
                text-align: center;
            }

            .cta-group.mobile-btn-group {
                display: block;
                margin-bottom: 20px;
            }

            /*==================== Table ====================*/
            .table-main {
                border: 0 none;
            }

            .table-main thead {
                border: none;
                clip: rect(0 0 0 0);
                height: 1px;
                margin: -1px;
                overflow: hidden;
                padding: 0;
                position: absolute;
                width: 1px;
            }

            .table-main tr {
                border-bottom: 2px solid #eee;
                display: block;
                margin-bottom: 40px;
            }

            .table-main td {
                font-weight: 700;
                display: block;
                padding-left: 40%;
                max-width: none;
                position: relative;
                border: 1px solid #cccaca;
                text-align: left;
            }

            .table-main td:before {
                /*
                * aria-label has no advantage, it won't be read inside a table
                content: attr(aria-label);
                */
                content: attr(data-label);
                position: absolute;
                left: 10px;
                font-weight: normal;
                text-transform: uppercase;
            }

            .total-row th {
                display: none;
            }

            .total-row td {
                text-align: left;
            }

            footer {
                text-align: center;
            }
        }

        @media screen and (max-width: 464px) {
            #invoice-top {
                display: flex;
            }
        }

        @media print {
            .print {
                display: none;
            }

            .effect2::before, .effect2::after {
                box-shadow: none;
            }
        }

    </style>

    <script>
        @if(Session::has('message'))
        alert("{{session('message')}}");
        @endif
    </script>
</head>

<body>
    <div id="invoiceholder">
        <div id="invoice" class="effect2">

            <div id="invoice-top" style="padding: 15px">
                <div class="logo"><img src="{{url('images/admin-logo.jpg')}}"
                        alt="Logo" /></div>
                <div class="title">
                    <h1>Vijay Kumar DVK</h1>
                    <p>{{$details->email}}</p>
                    <p>+91 - {{$details->mobile}}</p>
                    <p><a target="_blank" href="https://vijaykumardvk.com">https://vijaykumardvk.com</a></p>
                </div>
                <!--End Title-->
            </div>
            <!--End InvoiceTop-->



            <div id="invoice-mid" style="padding-bottom: 0">
                <div id="message">
                    <h2>Hello {{$estimate->client_name}},</h2>

                    @if($estimate->description)
                    <p>{{$estimate->description}}</p>
                    @endif
                </div>
                <div class="clearfix">
                    <div class="col-left" style="margin-top: 10px">
                        <h2>Estimate No. - {{$estimate->estimate_number}}</h2>
                        <p>Date: {{date('d-m-Y', strtotime($estimate->estimate_date))}}</p>
                    </div>
                    <div class="col-right" style="margin-top: 10px">
                        <div class="clientinfo">
                            <h2 id="supplier">{{$estimate->client_name}}</h2>
                            <p><span id="address">{{$estimate->company_name}}</span><br><span id="city">{{$estimate->email}}</span><br>@if($estimate->mobile)<span id="tax_num">{{$estimate->mobile}}</span><br>@endif</p>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Invoice Mid-->

            <div id="invoice-bot">

                <div id="table">
                    <table class="table-main">
                        <thead>
                            <tr class="tabletitle">
                                <th>S.no.</th>
                                <th>Description</th>
                                <th>Unit Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($estimate->estimate_items as $key => $item)
                            <tr class="list-item">
                                <td data-label="Type" class="tableitem">{{$key+1}}</td>
                                <td data-label="Description" class="tableitem"><h4>{{$item->name}}</h4><br>{{$item->description}}</td>
                                <td data-label="Quantity" class="tableitem">{{$estimate->currency}} {{$item->unit_price}}</td>
                                <td data-label="Unit Price" class="tableitem">{{$item->quantity}}</td>
                                <td data-label="Total" class="tableitem">{{$estimate->currency}} {{$item->total_price}}</td>
                            </tr>
                            @endforeach
                            <tr class="list-item total-row">
                                <th colspan="4" class="tableitem"><h4>Grand Total</h4></th>
                                <td data-label="Grand Total" class="tableitem" style="text-align: right"><h4>{{$estimate->currency}} {{$grand_total}}</h4></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!--End Table-->

                @if(isset($show_buttons) && $show_buttons == 1)
                <div class="cta-group print">
                    <a href="javascript:void(0);" class="btn-secondary"  onclick="window.print()">Print</a>
                    <a href="{{url('admin/send-estimate', $estimate->id)}}" class="btn-primary">Send</a>
                    <a href="{{url('admin/estimates')}}" class="btn-default">Back</a>
                </div>
                @endif

                <h2 style="margin-top: 10px">Terms and Conditions</h2>

                <ol style="padding: 0; padding-left: 15px">
                    <li>This estimate is not a contract or bill. It is our best guess at the total price to complete the work stated above based upon our initial inspection. If prices change or additional work and time are required, we will inform you prior to proceeding with the work.</li>
                    <li>Certain percent of total amount should be paid in advance prior starting the work.</li>
                </ol>

            </div>
            <!--End InvoiceBot-->
            <footer>
                <div id="legalcopy" class="clearfix">
                    <p class="col-right" style="font-weight: 700">Thank you for your business.</p>
                </div>
            </footer>
        </div>
        <!--End Invoice-->
    </div><!-- End Invoice Holder-->



</body>

</html>