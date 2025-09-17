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
            <form id="edit_lead">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Name <span class="mandatory">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{$lead->name}}">
                            <div class="error-message name-error"></div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Contact Number</label>
                            <input class="form-control" type="text" name="contact_no" value="{{$lead->contact_no}}">
                            <div class="error-message contact-error"></div>
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Address</label>
                            <textarea class="form-control" name="address">{{$lead->address}}</textarea>
                            <div class="error-message address-error"></div>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Website</label>
                            <input type="text" name="website" class="form-control" value="{{$lead->website}}">
                            <div class="error-message website-error"></div>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Instagram</label>
                            <input type="text" name="instagram" class="form-control" placeholder="@insta"  value="{{$lead->instagram}}">
                            <div class="error-message instagram-error"></div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group mb-3">
                            <label class="form-label">Lead Category <span class="mandatory">*</span></label>
                            <select class="form-control btn-square" name="lead_category_id">
                                <option value="">Select Category Name</option>
                                    @forelse ($categories as $value)
                                        @if($lead->lead_category_id == $value->id)
                                        <option value="{{$value->id}}" selected>{{$value->name}}</option>
                                        @else
                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endif
                                    @empty
                                        <option value="">Select Category Name</option>
                                    @endforelse
                            </select>
                            <span class="error-message category-error"></span>
                        </div>
                    </div>

                    <div class="col-sm-4 col-xs-6"> 
                        <div class="form-group">
                            <label class="control-label">Status</label>
                            <select class="form-control" name="status"> 
                                <option value="">Select Status</option>
                                <option value="0" {{($lead->status == 0) ? 'selected' : ''}}>Pending</option>
                                <option value="1" {{($lead->status == 1) ? 'selected' : ''}}>Follow Up 1</option>
                                <option value="2" {{($lead->status == 2) ? 'selected' : ''}}>Follow Up 2</option>
                                <option value="3" {{($lead->status == 3) ? 'selected' : ''}}>Follow Up 3</option>
                                <option value="4" {{($lead->status == 4) ? 'selected' : ''}}>Not Interested</option>
                                <option value="5" {{($lead->status == 5) ? 'selected' : ''}}>Closed</option>
                                <option value="6" {{($lead->status == 6) ? 'selected' : ''}}>Invoiced</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Remarks</label>
                            <textarea class="form-control" name="remarks">{{$lead->remarks}}</textarea>
                            <div class="error-message remarks-error"></div>
                        </div>
                    </div>
                </div>
                
                <button id="edit_lead_btn" class="btn btn-info">
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
        $("#edit_lead_btn").click(function(e) {
            e.preventDefault();
            $("#edit_lead_btn").attr('disabled', true);
            $("#edit_lead_btn .spinner-border").css('display', 'inline-block');
            $(".error-message").hide();
            $(".success-message").hide();
            $(".lead-error").text('');

            var request = $("#edit_lead").serializeArray();
            var id = '{{$lead->id}}';

            $.ajax({
                url: base_url+"/admin/update-lead/"+id,
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
                    }
                },
                complete: function() {
                    $("#edit_lead_btn").attr('disabled', false);
                    $("#edit_lead_btn .spinner-border").css('display', 'none');
                }
            });
        });
        
    </script>
@endsection