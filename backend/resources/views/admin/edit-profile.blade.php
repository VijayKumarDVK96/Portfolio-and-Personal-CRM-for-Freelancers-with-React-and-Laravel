@extends('includes.admin-layout')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{url('plugins/jquery-ui/css/jquery-ui.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('plugins/cropper/cropper.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('plugins/summernote/dist/summernote-bs4.css')}}"/>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                @include('includes.admin-breadcrumb')
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="edit-profile">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-options"><a class="card-options-collapse" href="#"
                                    data-toggle="card-collapse"><i
                                        class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#"
                                    data-toggle="card-remove"><i
                                        class="fe fe-x"></i></a></div>
                        </div>
                        <div class="card-body">
                            <form id="updateProfile">
                                <div class="row mb-2">
                                    <div class="col-md-4 place-center">
                                        <div class="profile-image">
                                            <img class="img-70 rounded-circle" alt="" src="{{url('images/'.$details->profile_image)}}">
                                            <label class="icon-edit1" for="profile_image"><i class="fa fa-pencil"></i></label>
                                            <input type="file" name="profile_image" id="profile_image" hidden>
                                        </div>
                                            
                                        <div class="col text-center">
                                            <h3 class="mt-1 mb-1">Vijayakumar D</h3>
                                            <p>SENIOR SOFTWARE DEVELOPER</p>
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-4">
                                        <ul class="mt-4">
                                            <li><strong>Last Login At</strong> - {{date('d-m-Y h:i A', strtotime(auth()->user()->last_login_at))}}</li>
                                            <li><strong>Last Login IP Address</strong> - {{auth()->user()->last_login_ip}}</li>
                                            <li><strong>Last Login Region</strong> - {{auth()->user()->last_login_region}}</li>
                                            <li><strong>Last Login Coordinates</strong> - {{auth()->user()->last_login_coordinates}}</li>
                                        </ul>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <form class="card" id="editProfile">
                        <div class="card-header">
                            <div class="card-options">
                                <a class="card-options-collapse" href="#" data-toggle="card-collapse">
                                    <i class="fe fe-chevron-up"></i>
                                </a>
                                <a class="card-options-remove" href="#" data-toggle="card-remove">
                                    <i class="fe fe-x"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Email address</label>
                                        <input class="form-control" name="email" type="email" placeholder="Email" value="{{$details->email}}">
                                        <span class="email-error error-message"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Mobile</label>
                                        <input class="form-control" name="mobile" type="text" placeholder="Mobile" value="{{$details->mobile}}">
                                        <span class="mobile-error error-message"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Date of Birth</label>
                                        <input class="form-control" name="dob" type="text" placeholder="Choose DOB" readonly value="{{$details->dob}}">
                                        <span class="dob-error error-message"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">State</label>
                                        <input class="form-control" name="state" type="text" placeholder="State" value="{{$details->state}}">
                                    </div>
                                    <span class="state-error error-message"></span>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">City</label>
                                        <input class="form-control" name="city" type="text" placeholder="City" value="{{$details->city}}">
                                    </div>
                                    <span class="city-error error-message"></span>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-3 mb-0">
                                        <label class="form-label">About Me</label>
                                        <textarea class="form-control" name="about_me" rows="5" id="about_me" placeholder="Enter About Me">{{$details->about_me}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Instagram</label>
                                        <input class="form-control" type="text" name="instagram" placeholder="Enter Instagram Profile" value="{{$details->instagram}}">
                                        <span class="instagram-error error-message"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Linkedin</label>
                                        <input class="form-control" type="text" name="linkedin" placeholder="Enter Linkedin Profile" value="{{$details->linkedin}}">
                                        <span class="linkedin-error error-message"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">GitHub</label>
                                        <input class="form-control" type="text" name="github" placeholder="Enter GitHub Profile" value="{{$details->github}}">
                                        <span class="github-error error-message"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">

                            <button id="update_profile" class="btn btn-primary" type="submit">
                                <span class="spinner-border spinner-border-sm"></span>
                                <span>Update Profile</span>
                            </button>

                            <span class="success-message"></span>
                            <span class="profile-error error-message"></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="profile_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalLabel">Crop & Upload the profile image</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="img-container">
              <img id="profile_image_layout" src="">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="profile_image_upload">
                <span class="spinner-border spinner-border-sm"></span>
                <span>Upload</span>
            </button>
          </div>
        </div>
      </div>
    </div>
@endsection

@section('scripts')
    <script src="{{url('plugins/jquery-ui/js/jquery-ui.js')}}"></script>
    <script src="{{url('plugins/cropper/cropper.min.js')}}"></script>
    <script src="{{url('plugins/summernote/dist/summernote-bs4.min.js')}}"></script>
    @include('includes.admin-scripts')
    
    <script>

        $('#about_me').summernote({
            height: 200,
            tabsize: 2
        });

        $("input[name=dob]").datepicker({
            dateFormat: 'yy-mm-dd',
            defaultDate: $("input[name=dob]").val(),
            maxDate: 0,
            changeYear:true,
            yearRange: "-50:+0"
        });

        $("#editProfile").submit(function(e) {
            e.preventDefault();
            $("#update_profile").attr('disabled', true);
            $("#update_profile .spinner-border").css('display', 'inline-block');
            $(".error-message").hide();
            $(".success-message").hide();
            
            $.ajax({
                url: base_url+"/admin/update-profile",
                method: 'post',
                dataType: 'json',
                data: $("#editProfile").serialize(),
                error: function(data) {
                    $(".error-message").show();
                    var object = JSON.parse(data.responseText);

                    if(data.status === 422) {
                        $.each(object, function(key, value) {
                            $(".email-error").text(value.email ?? '');
                            $(".mobile-error").text(value.mobile ?? '');
                            $(".dob-error").text(value.dob ?? '');
                            $(".state-error").text(value.state ?? '');
                            $(".city-error").text(value.city ?? '');
                        });
                    } else {
                        $(".profile-error").text(object.message);
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
                    $("#update_profile").attr('disabled', false);
                    $("#update_profile .spinner-border").css('display', 'none');
                }
            });
        });
        
        imageUpload('profile_image_layout', 'profile_image', '#profile_modal', 300, 300, '{{route("profile-image-upload") }}', 'profile_image_upload', 'profile_image');

    </script>
@endsection