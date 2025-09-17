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
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form id="addClient">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">Full Name <span class="mandatory">*</span></label>
                                    <input class="form-control" type="text" name="full_name">
                                    <span class="name-error error-message"></span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">Company Name <span class="mandatory">*</span></label>
                                    <input class="form-control" type="text" name="company_name">
                                    <span class="company-name-error error-message"></span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">Company Website</label>
                                    <input class="form-control" type="url" name="company_website">
                                    <span class="company-website-error error-message"></span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">Gender <span class="mandatory">*</span></label>
                                    <select class="form-control btn-square" name="gender">
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                    <span class="gender-error error-message"></span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Role <span class="mandatory">*</span></label>
                                    <input class="form-control" type="text" name="role">
                                    <span class="role-error error-message"></span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Email address <span class="mandatory">*</span></label>
                                    <input class="form-control" type="email" name="email">
                                    <span class="email-error error-message"></span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Mobile Number <span class="mandatory">*</span></label>
                                    <input class="form-control" type="number" name="mobile">
                                    <span class="mobile-error error-message"></span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Address <span class="mandatory">*</span></label>
                                    <input class="form-control" type="text" name="address">
                                    <span class="address-error error-message"></span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">State <span class="mandatory">*</span></label>
                                    <select class="form-control btn-square" name="state" id="state">
                                        <option value="">Select State</option>
                                            @forelse ($states as $value)
                                                @if($state_id == $value->id)
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
                            <div class="col-sm-6 col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">City <span class="mandatory">*</span></label>
                                    <select class="form-control btn-square" name="city" id="city">
                                        <option value="">Select City</option>
                                    </select>

                                    <span class="city-error error-message"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button id="add_client" class="btn btn-primary" type="submit">
                                        <span class="spinner-border spinner-border-sm"></span>
                                        <span>Add Client</span>
                                    </button>

                                    <a href="{{url('admin/clients')}}" class="btn btn-secondary">Go Back</a>

                                    <span class="success-message"></span>
                                    <span class="client-error error-message"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('scripts')
    <script>
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

        changeCity();
        $('#state').on('change', function() {
            changeCity();
        });

        $("#add_client").click(function(e) {
            e.preventDefault();
            $("#add_client").attr('disabled', true);
            $("#add_client .spinner-border").css('display', 'inline-block');
            $(".error-message").hide();
            $(".success-message").hide();
            
            $.ajax({
                url: base_url+"/admin/create-client",
                method: 'post',
                dataType: 'json',
                data: $("#addClient").serialize(),
                error: function(data) {
                    $(".error-message").show();
                    var object = JSON.parse(data.responseText);

                    if(data.status === 422) {
                        $.each(object, function(key, value) {
                            $(".name-error").text(value.full_name ?? '');
                            $(".company-name-error").text(value.company_name ?? '');
                            $(".company-website-error").text(value.company_website ?? '');
                            $(".gender-error").text(value.gender ?? '');
                            $(".role-error").text(value.role ?? '');
                            $(".email-error").text(value.email ?? '');
                            $(".mobile-error").text(value.mobile ?? '');
                            $(".address-error").text(value.address ?? '');
                            $(".state-error").text(value.state ?? '');
                            $(".city-error").text(value.city ?? '');
                        });
                    } else {
                        $(".client-error").text(object.message);
                    }
                },
                success: function(data) {
                    if (data.status == "success") {
                        $(".error-message").hide();
                        $(".success-message").text(data.message);
                        $("#addClient").trigger("reset");
                    }
                },
                complete: function() {
                    $("#add_client").attr('disabled', false);
                    $("#add_client .spinner-border").css('display', 'none');
                }
            });
        });
    </script>
    
@endsection