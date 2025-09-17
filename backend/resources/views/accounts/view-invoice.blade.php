<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; cha{{$invoice->currency}}et=UTF-8" />
    <title>Invoice</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
        @media only screen and (max-width: 960px) {
            .container {
                width: 600px;
            }
        }

        @media only screen and (max-width: 600px) {
            .container {
                width: 100%;
            }

            .invoice-left {
                width: 100%;
            }

            .invoice-right {
                width: 100%;
            }

            .total-price {
                padding-right: 10px;
            }
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
            text-decoration: none;
        }

        .cta-group .btn-secondary {
            background: #7366ff;
        }

        .cta-group .btn-primary {
            background: #00a63f;
        }

        @media screen and (max-width: 464px) {
            .contact tr td {
                display: block;
            }
        }

        @media print {
            .print {
                display: none;
            }
        }
    </style>
</head>

<body style="margin: 0; padding: 0;">
    <table width="100%" border="0" cellpadding="0" cellspacing="0"
        style="font-family: Helvetica Neue, Helvetica, Arial, sans-serif;">
        <tr>
            <td>
                <!-- // START CONTAINER -->
                <table class="container" width="600px" align="center" border="0" cellpadding="0" cellspacing="0"
                    style="background-color: #ffffff;">
                    <tr>
                        <td>
                            <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0"
                                style="background-color: #ffffff;">
                                <tr>
                                    <td>
                                        <img src="{{url('images/admin-logo.jpg')}}" alt="Vijay Kumar DVK" style="width: 130px">
                                    </td>
                                    <td align="right">
                                        <p style="font-size: 32px; color: #888888;">Invoice</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0"
                                style="background-color: #f2eeee;">
                                <tr>
                                    <td>
                                        <table class="invoice-left" width="50%" align="left" border="0" cellpadding="0"
                                            cellspacing="0" style="padding-top: 10px; padding-left: 20px;">
                                            <tr>
                                                <td>
                                                    <p style="margin-bottom: 0; font-size: 10px; text-transform: uppercase; color: #666666;">
                                                        INVOICE DATE</p>
                                                    <p style="margin-top: 0; font-size: 12px;">{{date('d-m-Y', strtotime($invoice->invoice_date))}}</p>
                                                </td>
                                                <td>
                                                    <p
                                                        style="margin-bottom: 0; font-size: 10px; text-transform: uppercase; color: #666666;">
                                                        Invoice Number</p>
                                                    <p style="margin-top: 0; font-size: 12px;">{{$invoice->invoice_id}}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p style="margin-bottom: 0; font-size: 10px; text-transform: uppercase; color: #666666;">
                                                        Status</p>
                                                    <p style="margin-top: 0; font-size: 12px;">{{$invoice->status}}</p>
                                                </td>
                                                <td>
                                                    <p
                                                        style="margin: 0; font-size: 10px; text-transform: uppercase; color: #666666;">Payment Mode</p>
                                                    <p style="margin: 0; font-size: 12px;">{{$invoice->payment_mode}}</p>
                                                </td>
                                            </tr>
                                        </table>
                                        <table class="invoice-right" width="50%" align="right" border="0"
                                            cellpadding="0" cellspacing="0" style="padding-left: 20px; margin: 10px 0;">
                                            <tr>
                                                <td>
                                                    <p style="font-size: 10px; text-transform: uppercase; color: #666666; margin: 0; margin-bottom: 5px">
                                                        BILLED TO</p>
                                                    <p style="margin: 0; margin-bottom: 5px; font-size: 12px;">Name : {{$client->full_name}}</p>
                                                    <p style="margin: 0; margin-bottom: 5px; font-size: 12px;">Company Name : {{$client->company_name}}</p>
                                                    <p style="margin: 0; margin-bottom: 5px; font-size: 12px;">Email : {{$client->email}}</p>
                                                    <p style="margin: 0; margin-bottom: 5px; font-size: 12px;">Mobile : {{$client->mobile}}</p>
                                                    <p style="margin: 0; margin-bottom: 5px; font-size: 12px;">Address : {{$client->address}}</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 30px;">
                            <table class="apple-services" border="0" cellpadding="0" cellspacing="0">
                                <p style="padding: 7px; font-size: 14px; font-weight: 500; background-color: #fafafa;">Services</p>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-left: 10px;">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding: 0 0 15px;">
                                @foreach ($invoice->invoice_items as $key => $item)
                                <tr>
                                    <td>
                                        <table align="left" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td align="left">
                                                    <p
                                                        style="margin: 0; font-size: 12px; font-weight: 600; color: #333333;">
                                                        {{$item->name}}
                                                    </p>
                                                    <p style="margin: 0; font-size: 12px; color: #666666;">{{$item->description}}</p>
                                                </td>
                                            </tr>
                                        </table>
                                        <table align="right" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td align="right">
                                                    <p style="margin: 10px; font-size: 12px; font-weight: 600;">{{$item->quantity}} * {{$item->unit_price}} = {{$item->total_price}} {{$invoice->currency}}
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding: 10px 0;">
                                <tr>
                                    <td align="right">
                                        <p class="total-price" style="margin: 4px; font-size: 12px; color: #666666;">
                                            Subtotal <span style="font-weight: 600; color:#000000">{{$invoice->currency}} {{$grand_total}}</span></p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="right">
                                        <table border="0" cellpadding="0" cellspacing="0"
                                            style="border-top: 1px solid #eeeeee; border-bottom: 1px solid #eeeeee;">
                                            <tr>
                                                <td width="70%" align="right" style="border-right: 1px solid #eeeeee;">
                                                    <p
                                                        style="padding-right: 35px; font-size: 10px; text-transform: uppercase; color: #666666;">
                                                        TOTAL</p>
                                                </td>
                                                <td>
                                                    <p class="total-price"
                                                        style="font-size: 16px; font-weight: 600;">
                                                        {{$invoice->currency}} {{$grand_total}}</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center">
                                        <p style="margin: 20px; font-size: 12px; color: #666666;">Thank you for your business.</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding-top: 5px;">
                                <tr>
                                    <td>
                                        <table class="contact" width="100%" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td align="center">
                                                    <p style="margin-bottom: 0; font-size: 12px; color: #666666;">Email : {{$details->email}}</p>
                                                </td>
                                                <td align="center">
                                                    <p style="margin-bottom: 0; font-size: 12px; color: #666666;">Phone : +91 - {{$details->mobile}}</p>
                                                </td>
                                                <td align="center">
                                                    <p style="margin-bottom: 0; font-size: 12px; color: #666666;">Website : https://vijaykumardvk.com</p>
                                                </td>
                                            </tr>

                                            @if(isset($show_buttons) && $show_buttons == 1)
                                            <tr style="position: relative; top: 20px;">
                                                <td colspan="3" align="center">
                                                    <div class="cta-group print">
                                                        <a href="javascript:void(0);" class="btn-secondary"  onclick="window.print()">Print</a>
                                                        <a href="{{url('admin/send-invoice', $invoice->id)}}" class="btn-primary">Send</a>
                                                        <a href="{{url('admin/invoices')}}" class="btn-default">Back</a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endif
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <!-- END CONTAINER \\ -->
    </td>
    </tr>
    </table>
</body>

</html>