@extends('includes.admin-layout')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{url('plugins/jquery-ui/css/jquery-ui.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('plugins/cropper/cropper.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('plugins/summernote/dist/summernote-bs4.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('plugins/sweetalert/sweetalert2.css')}}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                @include('includes.admin-breadcrumb')
                <div class="col-lg-6">
                    <a class="btn btn-secondary mr-2 pull-right" href="#" onClick="deleteProject()">Delete Project</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-pills nav-primary" id="pills-clrtab1" role="tablist">
                        <li class="nav-item"><a class="nav-link active" id="pills-clrhome-tab1" data-toggle="pill" href="#project-details" role="tab" aria-controls="pills-clrhome1" aria-selected="true">Project Details</a></li>
                        <li class="nav-item"><a class="nav-link" id="pills-clrhome-tab1" data-toggle="pill" href="#images" role="tab" aria-controls="pills-clrhome1" aria-selected="true">Images</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tabbed-card">
                      <div class="tab-content" id="pills-clrtabContent1">
                        <div class="tab-pane fade show active" id="project-details" role="tabpanel" aria-labelledby="pills-clrhome-tab1">
                          <form id="updateProject">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6 col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Project Name <span class="mandatory">*</span></label>
                                        <input class="form-control" type="text" name="name" value="{{$project->name}}">
                                        <span class="error-message project-error"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Client <span class="mandatory">*</span></label>
                                        <select class="form-control btn-square" name="client_id">
                                            <option value="">Select Client Name</option>
                                                @forelse ($clients as $value)
                                                    @if($project->client_id == $value->id)
                                                    <option value="{{$value->id}}" selected>{{$value->full_name}}</option>
                                                    @else
                                                    <option value="{{$value->id}}">{{$value->full_name}}</option>
                                                    @endif
                                                @empty
                                                <option value="">Select Client Name</option>
                                                @endforelse
                                        </select>
                                        <span class="error-message client-error"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Project Category <span class="mandatory">*</span></label>
                                        <select class="form-control btn-square" name="projects_category_id">
                                            <option value="">Select Category Name</option>
                                                @forelse ($categories as $value)
                                                    @if($project->projects_category_id == $value->id)
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
                                <div class="col-sm-6 col-md-2">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Estimated Price <span class="mandatory">*</span></label>
                                        <input class="form-control" type="number" name="estimated_price" value="{{$project->estimated_price}}">
                                        <span class="error-message estimated-price-error"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-2">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Total Price</label>
                                        <input class="form-control" type="number" name="total_price" value="{{$project->total_price}}">
                                        <span class="error-message total-price-error"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Deadline <span class="mandatory">*</span></label>
                                        <input class="form-control deadline date" type="text" name="deadline" readonly placeholder="Choose Date" value="{{$project->deadline}}">
                                        <span class="error-message deadline-error"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Status <span class="mandatory">*</span></label>
                                        <select class="form-control btn-square" name="status">
                                            <option value="">Select Status</option>
                                            <option value="0" {{($project->status == 0) ? 'selected' : ''}}>Pending</option>
                                            <option value="1" {{($project->status == 1) ? 'selected' : ''}}>Completed</option>
                                            <option value="2" {{($project->status == 2) ? 'selected' : ''}}>On Hold</option>
                                            <option value="3" {{($project->status == 3) ? 'selected' : ''}}>Closed</option>
                                        </select>
                                        <span class="error-message status-error"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Demo URL</label>
                                        <input class="form-control" type="text" name="url" placeholder="Enter the URL" value="{{$project->url}}">
                                        <span class="error-message url-error"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Project URL (eg: GitHub, BitBucket)</label>
                                        <input class="form-control" type="text" name="project_url" placeholder="Project URL (eg: GitHub, BitBucket)" value="{{$project->project_url}}">
                                        <span class="error-message project-url-error"></span>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Show on Home Page </label><br>
                                        <input type="radio" id="yes" name="show_on_home" value="1" {{$project->show_on_home ? 'checked' : ''}}>
                                        <label for="yes">Yes</label>
                                        <br>
                                        <input type="radio" id="no" name="show_on_home" value="0" {{($project->show_on_home == 0) ? 'checked' : ''}}>
                                        <label for="no">No</label>
                                        <br>
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
                                        <textarea name="meta_description" id="meta_description" class="form-control">{{$project->meta_description}}</textarea>
                                    </div>
                                </div>

                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Meta Keywords</label>
                                        <textarea name="meta_keywords" id="meta_keywords" class="form-control">{{$project->meta_keywords}}</textarea>
                                    </div>
                                </div> --}}

                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Project Detailed Description</label>
                                        <textarea name="description" id="description" class="form-control" cols="30" rows="10">{{$project->description}}</textarea>
                                        <span class="error-message description-error"></span>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button class="btn btn-primary" id="update_project" type="submit">
                                            <span class="spinner-border spinner-border-sm"></span>
                                            <span>Update Project</span>
                                        </button>
                                    </div>
                                    
                                    <span class="success-message"></span>
                                    <span class="update-project-error error-message"></span>
                                </div>
                            </div>
                          </form>
                        </div>

                        <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="pills-clrhome-tab1">
                          <form id="#">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Thumbnail Image</h4>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6 col-md-2">
                                    <div class="thumb thumbnail-image">
                                        @if($project->thumbnail_image)
                                        <img src="{{url('images/projects/thumbnail/'.$project->thumbnail_image)}}" width="100%" alt="">
                                        @else
                                        <img src="{{url('admin-assets/images/placeholder.png')}}" width="100%" alt="">
                                        @endif

                                        <label class="icon-edit1" for="thumbnail_image"><i class="fa fa-pencil"></i></label>
                                        <input type="file" name="thumbnail_image" id="thumbnail_image" hidden>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <h4>Portfolio Images</h4>
                                </div>
                            </div>

                            <div class="row portfolio" id="sortable">
                                @forelse ($project->galleries as $gallery)
                                    <div class="col-sm-6 col-md-4 edit-gallery-block" data-id="{{$gallery->id}}" data-position="{{$gallery->position}}">
                                        <div class="thumb">
                                            <img src="{{url('images/projects').'/'.$gallery->name}}" width="100%" alt="">
                                            <label class="icon-delete btn-danger" onclick="deletePortfolioImage({{$gallery->id}}, this)"><i class="fa fa-trash"></i></label>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-sm-6 col-md-4 edit-gallery-block">
                                        <div class="thumb">
                                            <img src="{{url('admin-assets/images/placeholder.png')}}" class="no-portfolio-image" width="100%" alt="">
                                        </div>
                                    </div>
                                @endforelse

                                <div class="col-sm-6 col-md-2">
                                    <div class="add_new_portfolio">
                                        <label class="" for="portfolio_image"><i class="fa fa-plus"></i></label>
                                        <input type="file" name="portfolio_image" id="portfolio_image" hidden>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <span class="success-message"></span>
                                    <span class="update-project-error error-message"></span>
                                </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
            </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="thumbnail_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalLabel">Crop & Upload the thumbnail image</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="img-container">
              <img id="thumbnail_image_layout" src="">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="thumbnail_upload">
                <span class="spinner-border spinner-border-sm"></span>
                <span>Upload</span>
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="portfolio_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalLabel">Crop & Upload the portfolio image</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="img-container">
              <img id="portfolio_image_layout" src="">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="portfolio_upload">
                <span class="spinner-border spinner-border-sm"></span>
                <span>Upload</span>
            </button>
          </div>
        </div>
      </div>
    </div>
@endsection

<?php
foreach($project->technologies as $technologies) {
    $technologies_array[] = $technologies->id;
}
?>

@section('scripts')
    <script src="{{url('plugins/jquery-ui/js/jquery-ui.js')}}"></script>
    <script src="{{url('plugins/cropper/cropper.min.js')}}"></script>
    <script src="{{url('plugins/summernote/dist/summernote-bs4.min.js')}}"></script>
    <script src="{{url('plugins/sweetalert/sweetalert.min.js')}}"></script>
    @include('includes.admin-scripts')

    <script>

        $('#description').summernote({
            height: 200,
            tabsize: 2
        });

        $("#sortable").sortable({
            update: function(event, ui) {
                var ids = [];

                $(this).children().each(function(i) {
                    if($(this).attr('data-position') != (i+1)) {
                        $(this).attr('data-position', (i+1));
                    }
                });

                $(".edit-gallery-block").each(function() {
                    ids.push($(this).attr('data-id'));
                });

                $.ajax({
                    type: "post",
                    url: '{{url("admin/change-gallery-position")}}',
                    data: {
                        'ids': ids,
                    },
                    success: function (data) {
                        
                    },
                });
            }
        });
        
        function setTechnology(id) {
            var values = $("input[name='technology[]']");

            $.map(values, function(value, index) {
                if($(value).val() == id) {
                    $(value).attr('checked', true);
                }
            });
        }

        var technologies_array = {{json_encode($technologies_array)}};

        $.map(technologies_array, function(value, index) {
            setTechnology(value);
        });

        $(".deadline").datepicker({
			minDate: 0,
			dateFormat: 'yy-mm-dd'
		});

        $("#update_project").click(function(e) {
            e.preventDefault();
            $("#update_project").attr('disabled', true);
            $("#update_project .spinner-border").css('display', 'inline-block');
            $(".error-message").hide();
            $(".success-message").hide();
            var id = '{{$id}}';

            $.ajax({
                url: base_url+"/admin/update-project/"+id,
                method: 'post',
                data: $("#updateProject").serialize(),
                error: function(data) {
                    $(".error-message").show();
                    var object = JSON.parse(data.responseText);

                    if(data.status === 422) {
                        $.each(object, function(key, value) {
                            $(".project-error").text(value.name ?? '');
                            $(".client-error").text(value.client_id ?? '');
                            $(".category-error").text(value.projects_category_id ?? '');
                        });
                    } else {
                        $(".update-project-error").text(object.message);
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
                    $("#update_project").attr('disabled', false);
                    $("#update_project .spinner-border").css('display', 'none');
                }
            });
        });

        function deletePortfolioImage(id, el) {
            swal({
                title: "Are you sure?",
                text: "Are you sure you want to delete this portfolio image?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {

                    $.ajax({
                        url: base_url+'/admin/delete-portfolio-image/'+id,
                        dataType: 'json',
                        error: function (xhr, exception, thrownError) {
                            // console.log(thrownError);
                            swal("Something went wrong", {
                                icon: "error",
                                title: "Error",
                            });
                        },
                        success: function (data) {
                            if (data.status == "success") {
                                $(el).parent().parent().remove();
                                swal("Image deleted!", {
                                    icon: "success",
                                    title: "Success",
                                });
                            }
                        }
                    });
                }
            });
        }

        imageUpload('thumbnail_image_layout', 'thumbnail_image', '#thumbnail_modal', 1920, 1080, '{{route("thumbnail-image-upload",$id) }}', 'thumbnail_upload', 'thumbnail');

        imageUpload('portfolio_image_layout', 'portfolio_image', '#portfolio_modal', 1920, 1080, '{{route("portfolio-image-upload",$id) }}', 'portfolio_upload', 'portfolio');
        
        function deleteProject() {
            
            var id = '{{$id}}';
            
            swal({
                title: "Are you sure?",
                text: "Are you sure you want to delete this project?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {

                    $.ajax({
                        url: base_url+'/admin/delete-project/'+id,
                        dataType: 'json',
                        error: function (xhr, exception, thrownError) {
                            // console.log(thrownError);
                            swal("Something went wrong", {
                                icon: "error",
                                title: "Error",
                            });
                        },
                        success: function (data) {
                            if (data.status == "success") {
                                swal("Project deleted!", {
                                    icon: "success",
                                    title: "Success",
                                });
                                
                                window.location.replace("{{url('admin/projects')}}");
                            }
                        }
                    });
                }
            });
        }
        
    </script>
@endsection