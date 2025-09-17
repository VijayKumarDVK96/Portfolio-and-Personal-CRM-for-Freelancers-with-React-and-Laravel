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
            <form id="update_payment">
                <div class="row">
                    <div class="col-sm-4"> 
                        <div class="form-group">
                            <label class="control-label">Client Name</label>
                            <select class="form-control" name="client_id"> 
                                <option value="">Select Client</option>
                                @foreach ($clients as $value)
                                <option value="{{$value->id}}" <?php echo ($value->id == $payment_data->client_id) ? 'selected' : '' ?>>{{$value->full_name}}</option>
                                @endforeach
                            </select>

                            <span class="client-error error-message"></span>
                        </div>
                    </div>

                    <div class="col-sm-4"> 
                        <div class="form-group">
                            <label class="control-label">Project Name</label>
                            <select class="form-control" name="project_id"> 
                                <option value="">Select Project</option>
                                @foreach ($projects as $value)
                                <option value="{{$value->id}}" <?php echo ($value->id == $payment_data->project_id) ? 'selected' : '' ?>>{{$value->name}}</option>
                                @endforeach
                            </select>

                            <span class="project-error error-message"></span>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Paid Amount <span class="mandatory">*</span></label>
                            <input class="form-control" name="paid_amount" type="text" value="{{$payment_data->paid_amount}}">
                            <div class="error-message amount-error"></div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Paid Date <span class="mandatory">*</span></label>
                            <div class="cal-icon"><input class="form-control date paid_at" name="paid_at" type="text" value="{{$payment_data->paid_at}}"></div>
                            <div class="error-message paid-at-error"></div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Payment Type</label>
                            <select class="form-control" name="statement_type"> 
                                <option value="">Select Type</option>
                                <option value="1" <?php echo ($payment_data->statement_type == '1') ? 'selected' : '' ?>>Credit</option>
                                <option value="0" <?php echo ($payment_data->statement_type == '0') ? 'selected' : '' ?>>Debit</option>
                            </select>
                            <div class="error-message payment-type-error"></div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Payment Mode</label>
                            <select class="form-control" name="payment_type"> 
                                <option value="">Select Payment</option>
                                @foreach ($payment as $value)
                                <option value="{{$value}}" <?php echo ($value == $payment_data->payment_type) ? 'selected' : '' ?>>{{$value}}</option>
                                @endforeach
                            </select>
                            <div class="error-message payment-mode-error"></div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Purpose <span class="mandatory">*</span></label>
                            <div class="cal-icon"><input class="form-control" name="purpose" type="text" value="{{$payment_data->purpose}}"></div>
                            <div class="error-message purpose-error"></div>
                        </div>
                    </div>

                    <div class="col-sm-8">
                        <div class="form-group">
                            <label>Description</label>
                            <div class="cal-icon"><input class="form-control" name="description" type="text" value="{{$payment_data->description}}"></div>
                            <div class="error-message description-error"></div>
                        </div>
                    </div>
                </div>
                
                <button id="edit_payment" class="btn btn-info">
                    <span class="spinner-border spinner-border-sm"></span>
                    <span>Save</span>
                </button>
                <a href="{{url('admin/payments')}}" class="btn btn-secondary">Go Back</a>

                <span class="success-message"></span>
                <span class="payment-error error-message"></span>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{url('plugins/jquery-ui/js/jquery-ui.js')}}"></script>
    <script>
        $(".paid_at").datepicker({
            dateFormat: 'yy-mm-dd',
        });

        $("#edit_payment").click(function(e) {
            e.preventDefault();
            $("#edit_payment").attr('disabled', true);
            $("#edit_payment .spinner-border").css('display', 'inline-block');
            $(".error-message").hide();
            $(".success-message").hide();

            var request = $("#update_payment").serializeArray();
            var id = '{{$id}}';

            $.ajax({
                url: base_url+"/admin/update-payment/"+id,
                method: 'post',
                data: request,
                dataType: "json",
                error: function(data) {
                    $(".error-message").show();
                    var object = JSON.parse(data.responseText);

                    if(data.status === 422) {
                        $.each(object, function(key, value) {
                            $(".client-error").text(value.client_id ?? '');
                            $(".project-error").text(value.project_id ?? '');
                            $(".amount-error").text(value.paid_amount ?? '');
                            $(".paid-at-error").text(value.paid_at ?? '');
                            $(".payment-type-error").text(value.statement_type ?? '');
                            $(".payment-mode-error").text(value.payment_type ?? '');
                            $(".purpose-error").text(value.purpose ?? '');
                            $(".description-error").text(value.description ?? '');
                        });
                    } else {
                        $(".payment-error").text(object.message);
                    }
                },
                success: function(data) {
                    if (data.status == "success") {
                        $(".error-message").hide();
                        $(".success-message").show();
                        $(".success-message").text(data.message);
                        $("#update_payment").trigger("reset");
                    }
                },
                complete: function() {
                    $("#edit_payment").attr('disabled', false);
                    $("#edit_payment .spinner-border").css('display', 'none');
                }
            });
        });
        
    </script>
@endsection