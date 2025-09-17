@extends('includes.admin-layout')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{url('plugins/jquery-ui/css/jquery-ui.css')}}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                @include('includes.admin-breadcrumb')
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <form id="create_invoice">
                <div class="row">
                    <div class="col-sm-3"> 
                        <div class="form-group">
                            <label class="control-label">Client Name</label>
                            <select class="form-control" name="client_name"> 
                                <option value="">Select Client</option>
                                @foreach ($clients as $value)
                                <option value="{{$value->id}}">{{$value->full_name}}</option>
                                @endforeach
                            </select>

                            <span class="client-error error-message"></span>
                        </div>
                    </div>

                    <div class="col-sm-3"> 
                        <div class="form-group">
                            <label class="control-label">Project Name</label>
                            <select class="form-control" name="project_name"> 
                                <option value="">Select Project</option>
                                @foreach ($projects as $value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>

                            <span class="project-error error-message"></span>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Invoice Date <span class="mandatory">*</span></label>
                            <div class="cal-icon"><input class="form-control date invoice_date" name="invoice_date" type="text"></div>
                            <div class="error-message invoice-date-error"></div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Due Date <span class="mandatory">*</span></label>
                            <div class="cal-icon"><input class="form-control date due_date" name="due_date" type="text"></div>
                            <div class="error-message due-date-error"></div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Payment Mode</label>
                            <select class="form-control" name="payment_mode"> 
                                <option value="">Select Payment</option>
                                @foreach ($payment as $value)
                                <option value="{{$value}}">{{$value}}</option>
                                @endforeach
                            </select>
                            <div class="error-message payment-error"></div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Currency <span class="mandatory">*</span></label>
                            <select name="currency" class="form-control" id="currency">
                                @foreach ($currency as $item)
                                    <option value="{{$item}}">{{$item}}</option>
                                @endforeach
                            </select>
                            <div class="error-message currency-error"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table class="table table-hover table-white items">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="col-sm-2">Item</th>
                                        <th class="col-md-6">Description</th>
                                        <th style="width:100px;">Unit Cost</th>
                                        <th style="width:80px;">Qty</th>
                                        <th>Amount</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td data-no="1">
                                            <input class="form-control" type="text" style="min-width:150px" name="item[]">
                                            <span class="item-error error-message"></span>
                                        </td>
                                        <td data-no="2">
                                            <input class="form-control" type="text" style="min-width:150px" name="description[]">
                                            <span class="description-error error-message"></span>
                                        </td>
                                        <td data-no="3">
                                            <input class="form-control unit_cost1" data-type="unit_cost" name="unit_cost[]" style="width:100px" type="text" onkeyup="calculateTotal(this, 'unit')">
                                            <span class="unit-cost-error error-message"></span>
                                        </td>
                                        <td data-no="4">
                                            <input class="form-control" data-type="quantity" value="1" name="quantity[]" onkeyup="calculateTotal(this, 'qty')" style="width:80px" type="text">
                                            <span class="quantity-error error-message"></span>
                                        </td>
                                        <td data-no="5">
                                            <input class="form-control" readonly="" style="width:120px" type="text" name="amount[]" onkeyup="getAmount(this)">
                                            <span class="amount-error error-message"></span>
                                        </td>
                                        <td data-no="6" class="add_item">
                                            <button type="button" class="btn btn-sm btn-success" onclick="addItem()"><i class="fa fa-plus"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-white">
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <h5 class="text-right">Total</h5>
                                        </td>
                                        <td style="text-align: right; padding-right: 30px;width: 230px">
                                            <span class="total">0</span>
                                        </td>
                                    </tr>
                                    {{-- <tr>
                                        <td colspan="5" class="text-right">Tax</td>
                                        <td style="text-align: right; padding-right: 30px;width: 230px">
                                            <input class="form-control text-right" value="0" readonly="" type="text">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-right">
                                            Discount %
                                        </td>
                                        <td style="text-align: right; padding-right: 30px;width: 230px">
                                            <input class="form-control text-right" type="text">
                                        </td>
                                    </tr> --}}
                                    <tr>
                                        <td colspan="5">
                                            <h5 style="text-align: right; font-weight: bold">Grand Total</h5>
                                        </td>
                                        <td style="text-align: right; padding-right: 30px; font-weight: bold; font-size: 16px;width: 230px">
                                            <h5 style="text-align: right; font-weight: bold">
                                                <span class="currency">USD</span> 
                                                <span class="grand-total">0</span>
                                            </h5>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>                               
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Other Information</label>
                                    <textarea class="form-control" rows="4" name="other_information"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button id="add_invoice" class="btn btn-info">
                    <span class="spinner-border spinner-border-sm"></span>
                    <span>Save</span>
                </button>
                <a href="{{url('admin/invoices')}}" class="btn btn-secondary">Go Back</a>

                <span class="success-message"></span>
                <span class="invoice-error error-message"></span>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{url('plugins/jquery-ui/js/jquery-ui.js')}}"></script>
    <script>
        $(".invoice_date").datepicker({
            dateFormat: 'yy-mm-dd',
            onSelect: function(dateStr) {
                $(".due_date").datepicker("destroy");
                $(".due_date").datepicker({
                    dateFormat: 'yy-mm-dd',
                    minDate: new Date(dateStr)
                });
            }
        });

        $("#currency").change(function() {
            $(".currency").text($("#currency").val());
        });
        
        function addItem() {
            $(".items tbody").append('<tr><td><input class="form-control" name="item[]" type="text" style="min-width:150px"></td><td><input class="form-control" name="description[]" type="text" style="min-width:150px"></td><td><input class="form-control" data-type="unit_cost" name="unit_cost[]" onkeyup="calculateTotal(this)" style="width:100px" type="text"></td><td><input data-type="quantity" value="1" class="form-control" name="quantity[]" onkeyup="calculateTotal(this)" style="width:80px" type="text" ></td><td><input class="form-control" readonly="" name="amount[]" value="0" onkeyup="getAmount(this)" style="width:120px" type="text"></td><td><button type="button" class="btn-danger" title="Remove" onclick="deleteItem(this)"><i class="fa fa-trash-o"></i></button></td></tr>');
        }

        function deleteItem(e) {
            var amount = parseFloat($(e).parent().prev().children().val());
            var total = parseFloat($(".total").text());
            var grand_total = parseFloat($(".grand-total").text());

            var new_total = total - amount;
            var new_grand_total = grand_total - amount;

            $(".total").text(new_total);
            $(".grand-total").text(new_grand_total);

            $(e).parent().parent().remove();
        }

        function calculateTotal(e) {
            var total = 0;
            var type = $(e).attr('data-type');
            
            var unit_cost = $("input[name='unit_cost[]']")
              .map(function(){return $(this).val();}).get();

            var quantity = $("input[name='quantity[]']")
              .map(function(){return $(this).val();}).get();

            if(type == 'unit_cost') {
                var data = unit_cost;
                var append_amount = $(e).parent().next().next().children();
            } else {
                var data = quantity;
                var append_amount = $(e).parent().next().children();
            }

            for (let i = 0; i < data.length; i++) {
                if(data[i] == e.value) {
                    var key = i;
                }

                total += unit_cost[i] * quantity[i];
            }
            
            var qty = parseFloat(quantity[key]) || 1;
            var amount = parseFloat(unit_cost[key]) * qty;

            append_amount.val(amount);
            $(".total").text(total);
            $(".grand-total").text(total);
        }

        $("#add_invoice").click(function(e) {
            e.preventDefault();
            $("#add_invoice").attr('disabled', true);
            $("#add_invoice .spinner-border").css('display', 'inline-block');
            $(".error-message").hide();
            $(".success-message").hide();

            var request = $("#create_invoice").serializeArray();

            $.ajax({
                url: base_url+"/admin/create-invoice",
                method: 'post',
                data: request,
                dataType: "json",
                error: function(data) {
                    $(".error-message").show();
                    var object = JSON.parse(data.responseText);

                    if(data.status === 422) {
                        $.each(object, function(key, value) {
                            $(".client-error").text(value.client_name ?? '');
                            $(".project-error").text(value.project_name ?? '');
                            $(".invoice-date-error").text(value.invoice_date ?? '');
                            $(".due-date-error").text(value.due_date ?? '');
                            $(".payment-error").text(value.payment_mode ?? '');

                            $(".item-error").text(value.item ?? '');
                            $(".description-error").text(value.description ?? '');
                            $(".unit-cost-error").text(value.unit_cost ?? '');
                            $(".quantity-error").text(value.quantity ?? '');
                            $(".amount-error").text(value.amount ?? '');
                        });
                    } else {
                        $(".invoice-error").text(object.message);
                    }
                },
                success: function(data) {
                    if (data.status == "success") {
                        $(".error-message").hide();
                        $(".success-message").show();
                        $(".success-message").text(data.message);
                        $("#create_invoice").trigger("reset");
                    }
                },
                complete: function() {
                    $("#add_invoice").attr('disabled', false);
                    $("#add_invoice .spinner-border").css('display', 'none');
                }
            });
        });
        
    </script>
@endsection