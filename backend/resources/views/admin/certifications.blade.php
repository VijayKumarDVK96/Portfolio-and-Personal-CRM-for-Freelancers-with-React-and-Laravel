@extends('includes.admin-layout')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{url('plugins/cropper/cropper.css')}}">
@endsection

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between">
            <h4>Certification Categories</h4>
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addCategoryModal">+ Add Category</button>
        </div>
        <div class="card-body" style="padding-top: 0">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            <button class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#editCategoryModal"
                                onClick="editCategory(this, {{ $category->id }})"
                                data-id="{{ $category->id }}"
                                data-name="{{ $category->name }}"
                            >
                                Edit
                            </button>
                            
                           <button type="button" onclick="deleteCategory({{ $category->id }})" class="btn btn-danger btn-sm">
                                Delete
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4>Certifications</h4>
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addCertificationModal" onclick="$('#image_type').val('add_certification')">+ Add Certification</button>
        </div>
        <div class="card-body" style="padding-top: 0">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Organization</th>
                        <th>Year</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($certifications as $certification)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><a href="{{ ($certification->credentials && $certification->credentials !== '#') ? $certification->credentials : 'javascript:void(0);' }}" target="{{($certification->credentials && $certification->credentials !== '#') ? '_blank' : '_self' }}" rel="noopener noreferrer">{{ $certification->title }}</a></td>
                        <td>{{ $certification->organization }}</td>
                        <td>{{ $certification->year }}</td>
                        <td>{{ $certification->category->name ?? '-' }}</td>
                        <td>{{ $certification->description }}</td>
                        <td>
                            <img src="{{ $certification->image ? url($certification->image) : '' }}" alt="image" style="height: 70px">
                        </td>
                        <td>
                            <button class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#editCertificationModal"
                                onClick="editCertification(this, {{ $certification->id }})"
                                data-id="{{ $certification->id }}"
                                data-title="{{ $certification->title }}"
                                data-organization="{{ $certification->organization }}"
                                data-year="{{ $certification->year }}"
                                data-category_id="{{ $certification->category_id }}"
                                data-image="{{ $certification->image }}"
                                data-description="{{ $certification->description }}"
                                data-credentials="{{ $certification->credentials }}"
                            >
                                Edit
                            </button>
                            
                            <button type="button" onclick="deleteCertification({{ $certification->id }})" class="btn btn-danger btn-sm">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="modal fade" id="addCategoryModal" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="#">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Add Category</h5>
                        <button type="button" class="btn-close" data-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control">
                            <div class="error-message text-danger category-error"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="add_category" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="modal fade" id="addCertificationModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form method="POST" action="#">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Add Certification</h5>
                        <button type="button" class="btn-close" data-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Title</label>
                                <input type="text" name="title" class="form-control">
                                <div class="error-message text-danger title-error"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Organization</label>
                                <input type="text" name="organization" class="form-control">
                                <div class="error-message text-danger organization-error"></div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Year</label>
                                <input type="number" name="year" class="form-control">
                                <div class="error-message text-danger year-error"></div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Category</label>
                                <select name="category_id" class="form-control">
                                    <option value="">-- Select --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <div class="error-message text-danger category-error"></div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Image</label>
                                <input type="file" name="certification_image" id="certification_image" class="form-control">
                                <input type="hidden" name="image" id="add_image">
                                <div class="error-message text-danger image-error"></div>

                                <img src="" alt="Image Preview" id="add_certification_preview" style="margin-top:10px; height: 60px;">
                            </div>
                            <div class="col-12 mb-3">
                                <label>Description</label>
                                <textarea name="description" class="form-control" rows="3"></textarea>
                                <div class="error-message text-danger description-error"></div>
                            </div>
                            <div class="col-12 mb-3">
                                <label>Credentials</label>
                                <input type="text" name="credentials" class="form-control">
                                <div class="error-message text-danger credentials-error"></div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="error-message text-danger certification-error"></div>
                                <div class="success-message text-success"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="add_certification" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade edit_category" id="editCategoryModal" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="#">
                @csrf
                <input type="hidden" name="category_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Edit Category</h5>
                        <button type="button" class="btn-close" data-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control">
                            <div class="error-message text-danger category-error"></div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="success-message text-success"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="update_category" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade edit_certification" id="editCertificationModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form method="POST" action="#">
                @csrf
                <input type="hidden" name="certification_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Edit Certification</h5>
                        <button type="button" class="btn-close" data-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Title</label>
                                <input type="text" name="title" class="form-control">
                                <div class="error-message text-danger title-error"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Organization</label>
                                <input type="text" name="organization" class="form-control">
                                <div class="error-message text-danger organization-error"></div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Year</label>
                                <input type="number" name="year" class="form-control">
                                <div class="error-message text-danger year-error"></div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Category</label>
                                <select name="category_id" class="form-control">
                                    <option value="">-- Select --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="error-message text-danger category-error"></div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Image</label>
                                <input type="file" name="certification_image" id="edit_certification_image" class="form-control">
                                <input type="hidden" name="image" id="edit_image">
                                <div class="error-message text-danger image-error"></div>

                                <img src="" alt="Image Preview" id="edit_certification_preview" style="margin-top:10px; height: 60px;">
                            </div>
                            <div class="col-12 mb-3">
                                <label>Description</label>
                                <textarea name="description" class="form-control" rows="3"></textarea>
                                <div class="error-message text-danger description-error"></div>
                            </div>
                            <div class="col-12 mb-3">
                                <label>Credentials</label>
                                <input type="text" name="credentials" class="form-control">
                                <div class="error-message text-danger credentials-error"></div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="error-message text-danger certification-error"></div>
                                <div class="success-message text-success"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="update_certification" class="btn btn-success">Update</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    
    <input type="hidden" id="image_type" value="add_certification">

    <div class="modal fade" id="certification_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalLabel">Crop & Upload the certification image</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="img-container">
              <img id="certification_image_layout" src="">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="certification_upload">
                <span class="spinner-border spinner-border-sm"></span>
                <span>Upload</span>
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="certification_modal_edit" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalLabel">Crop & Upload the certification image</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="img-container">
              <img id="certification_image_layout_edit" src="">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="certification_upload_edit">
                <span class="spinner-border spinner-border-sm"></span>
                <span>Upload</span>
            </button>
          </div>
        </div>
      </div>
    </div>
@endsection

@section('scripts')

@include('includes.admin-scripts')

<script src="{{url('plugins/notifications/js/notifications.min.js')}}"></script>
<script src="{{url('plugins/cropper/cropper.min.js')}}"></script>
<script src="{{url('plugins/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{url('plugins/summernote/dist/summernote-bs4.min.js')}}"></script>

<!--Data Tables js-->
<script src="{{url('plugins/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{url('plugins/datatables/js/dataTables.bootstrap4.min.js')}}"></script>

<script>
    $('#add_description').summernote({
        height: 200,
        tabsize: 2,
    });

    $('#edit_description').summernote({
        height: 200,
        tabsize: 2,
    });

    function editCertification(btn) {
        $("#image_type").val('edit_certification');
        const $btn = $(btn);
        const data = {
            id: $btn.data('id') ?? '',
            title: $btn.data('title') ?? '',
            organization: $btn.data('organization') ?? '',
            year: $btn.data('year') ?? '',
            category_id: $btn.data('category_id') ?? '',
            image: $btn.data('image') ?? '',
            description: $btn.data('description') ?? '',
            credentials: $btn.data('credentials') ?? ''
        };

        const $modal = $('#editCertificationModal');

        $modal.find('input[name=certification_id]').val(data.id);
        $modal.find('input[name=title]').val(data.title);
        $modal.find('input[name=organization]').val(data.organization);
        $modal.find('input[name=year]').val(data.year);
        $modal.find('select[name=category_id]').val(data.category_id).trigger('change');
        $modal.find('input[name=icon]').val(data.icon);
        $modal.find('input[name=credentials]').val(data.credentials);
        $modal.find('textarea[name=description]').val(data.description);
        $modal.find('#edit_image').val(data.image);

        // clear previous messages
        $modal.find('.error-message').text('').hide();
        $modal.find('.success-message').text('').hide();
    }

    function deleteCertification(id) {
        swal({
            title: "Are you sure?",
            text: "You want to delete this certification?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: base_url+'/admin/delete-certification/'+id,
                    dataType: 'json',
                    error: function () {
                        swal("Something went wrong", {
                            icon: "error",
                            title: "Error",
                        });
                    },
                    success: function (data) {
                        if (data.status == "success") {
                            swal("Certification deleted!", {
                                icon: "success",
                                title: "Success",
                            });

                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        }
                    }
                });
            }
        });
    }

    $("#add_certification").click(function(e) {
        e.preventDefault();
        $("#add_certification").attr('disabled', true);
        $("#add_certification .spinner-border").css('display', 'inline-block');
        $(".error-message").hide();
        $(".success-message").hide();

        var request = $("#addCertificationModal form").serializeArray();

        $.ajax({
            url: base_url+"/admin/add-new-certification",
            method: 'post',
            data: request,
            error: function(data) {
                $(".error-message").show();
                var object = JSON.parse(data.responseText);

                if(data.status === 422) {
                    $.each(object, function(key, value) {
                        $("#addCertificationModal .title-error").text(value.title ?? '');
                        $("#addCertificationModal .organization-error").text(value.organization ?? '');
                        $("#addCertificationModal .provider-error").text(value.provider ?? '');
                        $("#addCertificationModal .year-error").text(value.year ?? '');
                        $("#addCertificationModal .image-error").text(value.image ?? '');
                        $("#addCertificationModal .category-error").text(value.category_id ?? '');
                        $("#addCertificationModal .description-error").text(value.description ?? '');
                        $("#addCertificationModal .certification-error").text(value.certification ?? '');
                        $("#addCertificationModal .credentials-error").text(value.credentials ?? '');
                    });
                } else {
                    $("#addCertificationModal .certification-error").text('Something went wrong');
                }
            },
            success: function(data) {
                if (data.status === "success") {
                    $(".error-message").hide();
                    $(".success-message").show().text(data.message);
                    $("#addCertificationModal form").trigger("reset");
                    $('#add_description').summernote('reset');
                    $("#addCertificationModal").modal('hide');

                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }
            },
            complete: function() {
                $("#add_certification").attr('disabled', false);
                $("#add_certification .spinner-border").css('display', 'none');
            }
        });
    });

    $("#update_certification").click(function(e) {
        e.preventDefault();
        $("#update_certification").attr('disabled', true);
        $("#update_certification .spinner-border").css('display', 'inline-block');
        $(".error-message").hide();
        $(".success-message").hide();

        var request = $(".edit_certification form").serializeArray();
        var id = $("input[name=certification_id]").val();

        $.ajax({
            url: base_url+"/admin/update-certification/"+id,
            method: 'post',
            data: request,
            error: function(data) {
                $(".error-message").show();
                var object = JSON.parse(data.responseText);

                if(data.status === 422) {
                    $.each(object, function(key, value) {
                        $(".edit_certification .title-error").text(value.title ?? '');
                        $(".edit_certification .organization-error").text(value.organization ?? '');
                        $(".edit_certification .provider-error").text(value.provider ?? '');
                        $(".edit_certification .year-error").text(value.year ?? '');
                        $(".edit_certification .image-error").text(value.image ?? '');
                        $(".edit_certification .category-error").text(value.category_id ?? '');
                        $(".edit_certification .description-error").text(value.description ?? '');
                        $(".edit_certification .certification-error").text(value.certification ?? '');
                        $(".edit_certification .credentials-error").text(value.credentials ?? '');
                    });
                } else {
                    $(".edit_certification .certification-error").text('Something went wrong');
                }
            },
            success: function(data) {
                if (data.status === "success") {
                    $(".error-message").hide();
                    $(".success-message").show().text(data.message);

                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }
            },
            complete: function() {
                $("#update_certification").attr('disabled', false);
                $("#update_certification .spinner-border").css('display', 'none');
            }
        });
    });

    $("#add_category").click(function(e) {
        e.preventDefault();
        $("#add_category").attr('disabled', true);
        $("#add_category .spinner-border").css('display', 'inline-block');
        $(".error-message").hide();
        $(".success-message").hide();
        $(".category-error").text('');
        $(".name-error").text('');

        var request = $("#addCategoryModal form").serializeArray();

        $.ajax({
            url: base_url+"/admin/add-certification-category",
            method: 'post',
            data: request,
            error: function(data) {
                $(".error-message").show();
                var object = JSON.parse(data.responseText);

                if(data.status === 422) {
                    $.each(object, function(key, value) {
                        $(".category-error").text(value.name ?? '');
                    });
                } else {
                    $(".category-error").text('Something went wrong');
                }
            },
            success: function(data) {
                if (data.status == "success") {
                    $(".error-message").hide();
                    $(".success-message").show().text(data.message);
                    $("#addCategoryModal form").trigger("reset");
                    $("#addCategoryModal").modal('hide');

                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }
            },
            complete: function() {
                $("#add_category").attr('disabled', false);
                $("#add_category .spinner-border").css('display', 'none');
            }
        });
    });

    $("#update_category").click(function(e) {
        e.preventDefault();
        $(".edit_category .error-message").text('').hide();
        $("#edit_category").attr('disabled', true);
        $("#edit_category .spinner-border").css('display', 'inline-block');

        var request = $(".edit_category form").serializeArray();
        var id = $("input[name=category_id]").val();

        $.ajax({
            url: base_url+"/admin/update-certification-category/"+id,
            method: 'post',
            data: request,
            error: function(data) {
                $(".edit_category .error-message").show();
                var object = JSON.parse(data.responseText);

                if(data.status === 422) {
                    $.each(object, function(key, value) {
                        $(".edit_category .category-error").text(value.name ?? '');
                    });
                } else {
                    $(".edit_category .category-error").text('Something went wrong');
                }
            },
            success: function(data) {
                if (data.status === "success") {
                    $(".edit_category .error-message").hide();
                    $(".edit_category .success-message").show().text(data.message);

                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }
            },
            complete: function() {
                $("#edit_category").attr('disabled', false);
                $("#edit_category .spinner-border").css('display', 'none');
            }
        });
    });

    function editCategory(btn) {
        const $btn = $(btn);
        const data = {
            id: $btn.data('id') ?? '',
            name: $btn.data('name') ?? ''
        };

        const $modal = $('#editCategoryModal');

        $modal.find('input[name=category_id]').val(data.id);
        $modal.find('input[name=name]').val(data.name);

        // clear previous messages
        $modal.find('.error-message').text('').hide();
        $modal.find('.success-message').text('').hide();
    }

    function deleteCategory(id) {
        swal({
            title: "Are you sure?",
            text: "You want to delete this category?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: base_url+'/admin/delete-certification-category/'+id,
                    dataType: 'json',
                    error: function () {
                        swal("Something went wrong", {
                            icon: "error",
                            title: "Error",
                        });
                    },
                    success: function (data) {
                        if (data.status == "success") {
                            swal("Category deleted!", {
                                icon: "success",
                                title: "Success",
                            });

                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        }
                    }
                });
            }
        });
    }

    // use certification_id (not category_id) and build the upload URL safely
    var id = $('input[name=certification_id]').val();
    var type = $("#image_type").val();

    // use a base URL that doesn't require a route parameter and append the id client-side
    var certificationImageUploadUrl = '{{ url("admin/upload-certification-image") }}/'+type+"/";
    if (id) {
        // ensure there's no trailing slash before appending the id
        certificationImageUploadUrl = certificationImageUploadUrl.replace(/\/$/, '') + '/' + id;
    }

    var isEditMode = $("#image_type").val() === 'edit_certification';

    imageUpload('certification_image_layout', 'certification_image', '#certification_modal', 1920, 1080, certificationImageUploadUrl, 'certification_upload', 'add_certification');
    imageUpload('certification_image_layout_edit', 'edit_certification_image', '#certification_modal_edit', 1920, 1080, certificationImageUploadUrl, 'certification_upload_edit', 'edit_certification');

</script>
@endsection