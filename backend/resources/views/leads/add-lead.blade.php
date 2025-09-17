@extends('includes.admin-layout')

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
            <form id="add_lead">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Name <span class="mandatory">*</span></label>
                            <input type="text" name="name" class="form-control">
                            <div class="error-message name-error"></div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Contact Number</label>
                            <input class="form-control" type="text" name="contact_no">
                            <div class="error-message contact-error"></div>
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Address</label>
                            <textarea class="form-control" name="address"></textarea>
                            <div class="error-message address-error"></div>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Website</label>
                            <input type="text" name="website" class="form-control">
                            <div class="error-message website-error"></div>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Instagram</label>
                            <input type="text" name="instagram" class="form-control" placeholder="@insta">
                            <div class="error-message instagram-error"></div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group mb-3">
                            <label class="form-label">Lead Category <span class="mandatory">*</span></label>
                            <select class="form-control btn-square" name="lead_category_id">
                                <option value="">Select Category Name</option>
                                    @foreach ($categories as $value)
                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                    @endforeach
                            </select>
                            <span class="error-message category-error"></span>
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Remarks</label>
                            <textarea class="form-control" name="remarks"></textarea>
                            <div class="error-message remarks-error"></div>
                        </div>
                    </div>
                </div>
                
                <button id="add_lead_btn" class="btn btn-info">
                    <span class="spinner-border spinner-border-sm"></span>
                    <span>Save</span>
                </button>
                <a href="{{url('admin/leads')}}" class="btn btn-secondary">Go Back</a>

                <span class="success-message"></span>
                <span class="lead-error error-message"></span>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $("#add_lead_btn").click(function(e) {
            e.preventDefault();
            $("#add_lead_btn").attr('disabled', true);
            $("#add_lead_btn .spinner-border").css('display', 'inline-block');
            $(".error-message").hide();
            $(".success-message").hide();
            $(".lead-error").text('');

            var request = $("#add_lead").serializeArray();

            $.ajax({
                url: base_url+"/admin/create-lead",
                method: 'post',
                data: request,
                dataType: "json",
                error: function(data) {
                    var object = JSON.parse(data.responseText);

                    if(data.status === 422) {
                        $.each(object, function(key, value) {
                            // console.log(value);
                            $(".name-error").text(value.name ?? '');
                            $(".contact-error").text(value.contact_no ?? '');
                            $(".address-error").text(value.address ?? '');
                            $(".category-error").text(value.lead_category_id ?? '');
                        });
                    } else {
                        $(".lead-error").text(object.message);
                    }

                    $(".error-message").show();
                },
                success: function(data) {
                    if (data.status == "success") {
                        $(".error-message").hide();
                        $(".success-message").show();
                        $(".success-message").text(data.message);
                        $("#add_lead").trigger("reset");
                    }
                },
                complete: function() {
                    $("#add_lead_btn").attr('disabled', false);
                    $("#add_lead_btn .spinner-border").css('display', 'none');
                }
            });
        });
        
    </script>
@endsection