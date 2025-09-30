@extends('includes.admin-layout')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{url('plugins/jquery-ui/css/jquery-ui.css')}}">
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

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form id="addProject">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Project Name <span class="mandatory">*</span></label>
                                    <input class="form-control" type="text" name="name">
                                    <span class="error-message project-error"></span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Client <span class="mandatory">*</span></label>
                                    <select class="form-control btn-square" name="client_id">
                                        <option value="">Select Client Name</option>
                                            @foreach($clients as $value)
                                                <option value="{{$value->id}}">{{$value->full_name}}</option>
                                            @endforeach
                                    </select>
                                    <span class="error-message client-error"></span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Project Category <span class="mandatory">*</span></label>
                                    <select class="form-control btn-square" name="projects_category_id">
                                        <option value="">Select Category Name</option>
                                            @foreach ($categories as $value)
                                                <option value="{{$value->id}}">{{$value->name}}</option>
                                            @endforeach
                                    </select>
                                    <span class="error-message category-error"></span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-2">
                                <div class="form-group mb-3">
                                    <label class="form-label">Estimated Price <span class="mandatory">*</span></label>
                                    <input class="form-control" type="number" name="estimated_price">
                                    <span class="error-message estimated-price-error"></span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-2">
                                <div class="form-group mb-3">
                                    <label class="form-label">Deadline <span class="mandatory">*</span></label>
                                    <input class="form-control deadline date" type="text" name="deadline" readonly placeholder="Choose Date">
                                    <span class="error-message deadline-error"></span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Demo URL</label>
                                    <input class="form-control" type="text" name="url" placeholder="Enter the URL">
                                    <span class="error-message url-error"></span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Project URL (eg: GitHub, BitBucket)</label>
                                    <input class="form-control" type="text" name="project_url" placeholder="Project URL (eg: GitHub, BitBucket)">
                                    <span class="error-message project-url-error"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group m-checkbox-inline mb-3">
                                    <label class="form-label">Project Technologies</label>
                                    @foreach($technology as $key => $value)
                                    <div class="checkbox checkbox-solid-primary">
                                        <input id="inline-{{$key}}" type="checkbox" name="technology[]" value="{{$value->id}}">
                                        <label for="inline-{{$key}}">{{$value->name}}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Short Description for Homepage</label>
                                    <textarea name="meta_description" id="meta_description" class="form-control"></textarea>
                                </div>
                            </div>

                            {{-- <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Meta Keywords</label>
                                    <textarea name="meta_keywords" id="meta_keywords" class="form-control"></textarea>
                                </div>
                            </div> --}}

                            <div class="col-sm-12 col-md-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Project Detailed Description</label>
                                    <textarea name="description" class="form-control" id="description" cols="30" rows="10"></textarea>
                                    <span class="error-message description-error"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button class="btn btn-primary" id="add_project" type="submit">
                                        <span class="spinner-border spinner-border-sm"></span>
                                        <span>Add Project</span>
                                    </button>
                                </div>
                                
                                <span class="success-message"></span>
                                <span class="add-project-error error-message"></span>
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
    <script src="{{url('plugins/jquery-ui/js/jquery-ui.js')}}"></script>
    <script src="{{url('plugins/summernote/dist/summernote-bs4.min.js')}}"></script>
    <script>
        $('#description').summernote({
            height: 200,
            tabsize: 2
        });

        $(".deadline").datepicker({
			minDate: 0,
			dateFormat: 'yy-mm-dd'
		});

        $("#add_project").click(function(e) {
            e.preventDefault();
            $("#add_project").attr('disabled', true);
            $("#add_project .spinner-border").css('display', 'inline-block');
            $(".error-message").hide();
            $(".success-message").hide();

            $.ajax({
                url: base_url+"/admin/add-new-project",
                method: 'post',
                data: $("#addProject").serialize(),
                error: function(data) {
                    $(".error-message").show();
                    var object = JSON.parse(data.responseText);

                    if(data.status === 422) {
                        $.each(object, function(key, value) {
                            $(".project-error").text(value.name ?? '');
                            $(".client-error").text(value.client_id ?? '');
                            $(".category-error").text(value.projects_category_id ?? '');
                            $(".estimated-price-error").text(value.estimated_price ?? '');
                            $(".deadline-error").text(value.deadline ?? '');
                        });
                    } else {
                        $(".add-project-error").text(object.message);
                    }
                },
                success: function(data) {
                    if (data.status == "success") {
                        $(".error-message").hide();
                        $(".success-message").show();
                        $(".success-message").text(data.message);
                        $("#addProject").trigger("reset");
                    }
                },
                complete: function() {
                    $("#add_project").attr('disabled', false);
                    $("#add_project .spinner-border").css('display', 'none');
                }
            });
        });
    </script>
@endsection