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
            <form id="update_estimate">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Client Name <span class="mandatory">*</span></label>
                            <input type="text" name="client_name" class="form-control" value="{{$estimate->client_name}}">
                            <div class="error-message client-error"></div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Company Name <span class="mandatory">*</span></label>
                            <input type="text" name="company_name" class="form-control" value="{{$estimate->company_name}}">
                            <div class="error-message company-error"></div>
                        </div>
                    </div>
                    
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Email</label>
                            <input class="form-control" type="email" name="email" value="{{$estimate->email}}">
                            <div class="error-message email-error"></div>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Mobile</label>
                            <input class="form-control" type="text" name="mobile" value="{{$estimate->mobile}}">
                            <div class="error-message mobile-error"></div>
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Address</label>
                            <textarea class="form-control" name="address">{{$estimate->address}}</textarea>
                            <div class="error-message address-error"></div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="form-label">State <span class="mandatory">*</span></label>
                            <input type="hidden" name="country" value="India">
                            <select class="form-control btn-square" name="state" id="state">
                                <option value="">Select State</option>
                                    @forelse ($states as $value)
                                        @if($estimate->state == $value->id)
                                        <option value="{{$value->id}}" selected>{{$value->name}}</option>
                                        @else
                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endif
                                    @empty
                                    <option value="">Select State</option>
                                    @endforelse
                            </select>
                            <span class="state-error error-message"></span>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="form-label">City <span class="mandatory">*</span></label>
                            <select class="form-control btn-square" name="city" id="city">
                                <option value="">Select City</option>
                            </select>

                            <span class="city-error error-message"></span>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Estimate Date <span class="mandatory">*</span></label>
                            <div class="cal-icon"><input class="form-control date estimate_date" name="estimate_date" type="text" value="{{$estimate->estimate_date}}"></div>
                            <div class="error-message estimate-date-error"></div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Expiry Date <span class="mandatory">*</span></label>
                            <div class="cal-icon"><input class="form-control date expiry_date" name="expiry_date" type="text" value="{{$estimate->expiry_date}}"></div>
                            <div class="error-message expiry-date-error"></div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                @foreach ($status as $value)
                                    @if($value == $estimate->status)
                                    <option value="{{$value}}" selected>{{$value}}</option>
                                    @else
                                    <option value="{{$value}}">{{$value}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Currency <span class="mandatory">*</span></label>
                            <select name="currency" class="form-control" id="currency">
                                @foreach ($currency as $item)
                                    @if($item == $estimate->currency)
                                    <option value="{{$item}}" selected>{{$item}}</option>
                                    @else
                                    <option value="{{$item}}">{{$item}}</option>
                                    @endif
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
                                    @foreach($estimate->estimate_items as $key => $item)
                                    <tr>
                                        <td data-no="1">
                                            <input type="hidden" name="item_id[]" value="{{$item->id}}">
                                            <input class="form-control" type="text" style="min-width:150px" name="item[]" value="{{$item->name}}">
                                            <span class="item-error error-message"></span>
                                        </td>
                                        <td data-no="2">
                                            <input class="form-control" type="text" style="min-width:150px" name="description[]" value="{{$item->description}}">
                                            <span class="description-error error-message"></span>
                                        </td>
                                        <td data-no="3">
                                            <input class="form-control unit_cost1" data-type="unit_cost" name="unit_cost[]" style="width:100px" type="text" onkeyup="calculateTotal(this, 'unit')" value="{{$item->unit_price}}">
                                            <span class="unit-cost-error error-message"></span>
                                        </td>
                                        <td data-no="4">
                                            <input class="form-control" data-type="quantity" value="1" name="quantity[]" onkeyup="calculateTotal(this, 'qty')" style="width:80px" type="text" value="{{$item->quantity}}">
                                            <span class="quantity-error error-message"></span>
                                        </td>
                                        <td data-no="5">
                                            <input class="form-control" readonly="" style="width:120px" type="text" name="amount[]" onkeyup="getAmount(this)" value="{{$item->total_price}}">
                                            <span class="amount-error error-message"></span>
                                        </td>
                                        @if(count($estimate->estimate_items)-1 == $key)
                                        <td data-no="6" class="add_item">
                                            <button type="button" class="btn btn-sm btn-success" onclick="addItem()"><i class="fa fa-plus"></i></button>
                                        </td>
                                        @endif
                                    </tr>
                                    @endforeach
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
                                            <span class="total">{{$grand_total}}</span>
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
                                                <span class="currency">{{$estimate->currency}}</span> 
                                                <span class="grand-total">{{$grand_total}}</span>
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
                                    <textarea name="other_information" class="form-control" rows="4">{{$estimate->description}}</textarea>
                                    <div class="error-message other-information-error"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button id="edit_estimate" class="btn btn-info">
                    <span class="spinner-border spinner-border-sm"></span>
                    <span>Save</span>
                </button>
                <a href="{{url('admin/estimates')}}" class="btn btn-secondary">Go Back</a>

                <span class="success-message"></span>
                <span class="estimate-error error-message"></span>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{url('plugins/jquery-ui/js/jquery-ui.js')}}"></script>
    <script>
        $(".expiry_date").datepicker({
            dateFormat: 'yy-mm-dd',
        });

        $("#currency").change(function() {
            $(".currency").text($("#currency").val());
        });

        $(".estimate_date").datepicker({
            dateFormat: 'yy-mm-dd',
            onSelect: function(dateStr) {
                $(".expiry_date").datepicker("destroy");
                $(".expiry_date").datepicker({
                    dateFormat: 'yy-mm-dd',
                    minDate: new Date(dateStr)
                });
            }
        });

        function changeCity(id='') {
            var state = $('#state').val();
            $.ajax({
                url: base_url+"/show-cities/"+state,
                method: 'post',
                success: function(data) {
                    $('#city').html(data);
                    if(id != '') {
                        $('#city').val(id);
                    }
                }
            });
        }

        var city_id = '{{$estimate->city}}';

        changeCity(city_id);
        $('#state').on('change', function() {
            changeCity();
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

        $("#edit_estimate").click(function(e) {
            e.preventDefault();
            $("#edit_estimate").attr('disabled', true);
            $("#edit_estimate .spinner-border").css('display', 'inline-block');
            $(".error-message").hide();
            $(".success-message").hide();

            var request = $("#update_estimate").serializeArray();
            var id = '{{$id}}';

            $.ajax({
                url: base_url+"/admin/update-estimate/"+id,
                method: 'post',
                data: request,
                dataType: "json",
                error: function(data) {
                    $(".error-message").show();
                    var object = JSON.parse(data.responseText);

                    if(data.status === 422) {
                        $.each(object, function(key, value) {
                            // console.log(value);
                            $(".client-error").text(value.client_name ?? '');
                            $(".company-error").text(value.company_name ?? '');
                            $(".email-error").text(value.email ?? '');
                            $(".mobile-error").text(value.mobile ?? '');
                            $(".address-error").text(value.address ?? '');
                            $(".country-error").text(value.country ?? '');
                            $(".state-error").text(value.state ?? '');
                            $(".city-error").text(value.city ?? '');
                            $(".estimate-date-error").text(value.estimate_date ?? '');
                            $(".expiry-date-error").text(value.expiry_date ?? '');
                            $(".other-information-error").text(value.other_information ?? '');

                            $(".item-error").text(value.item ?? '');
                            $(".description-error").text(value.description ?? '');
                            $(".unit-cost-error").text(value.unit_cost ?? '');
                            $(".quantity-error").text(value.quantity ?? '');
                            $(".amount-error").text(value.amount ?? '');
                        });
                    } else {
                        $(".estimate-error").text(object.message);
                    }
                },
                success: function(data) {
                    if (data.status == "success") {
                        $(".error-message").hide();
                        $(".success-message").show();
                        $(".success-message").text(data.message);
                    }
                },
                complete: function() {
                    $("#edit_estimate").attr('disabled', false);
                    $("#edit_estimate .spinner-border").css('display', 'none');
                }
            });
        });
        
    </script>
@endsection