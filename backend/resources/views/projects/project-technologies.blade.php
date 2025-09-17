@extends('includes.admin-layout')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{url('plugins/sweetalert/sweetalert2.css')}}">
@endsection

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row">
            @include('includes.admin-breadcrumb')

            <div class="col-lg-6">
                <a class="btn btn-success btn-lg pull-right ml-2 addCategory" href="javascript:void(0)" data-toggle="modal" data-target="#addCategory">Add Category</a>
                <a class="btn btn-primary btn-lg pull-right addTechnology" href="javascript:void(0)" data-toggle="modal" data-target="#addTechnology">Add Technology</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Left side: Categories Accordion -->
    <div class="col-md-4">

        <div class="default-according" id="accordion1">
            @forelse($categories as $catKey => $category)
                @if($category->id != 0)
                    <div class="card">
                        <div class="card-header bg-primary" id="headingFour" style="display: flex; justify-content: space-between">
                            <h5 class="mb-0">
                            <button class="btn btn-link txt-white" data-toggle="collapse" data-target="#collapseFour{{ $category->id }}" aria-expanded="true" aria-controls="collapseFour">{{ $category->name }}</button>
                            </h5>

                            <div>
                                <button class="btn btn-info btn-sm edit-category" type="button" data-id="{{ $category->id }}" data-name="{{ $category->name }}"><i class="fa fa-edit" style="position: relative; left: 0; top: 0"></i></button>
                                <button class="btn btn-danger btn-sm" type="button" onclick="deleteCategory({{ $category->id }})"><i class="fa fa-trash" style="position: relative; left: 0; top: 0"></i></button>
                            </div>
                        </div>
                        <div class="collapse {{ $loop->first ? 'show' : '' }}" id="collapseFour{{ $category->id }}" aria-labelledby="headingOne" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" data-parent="#accordion1">
                            <div class="card-body" style="padding-left: 0; padding-right: 0; padding-top: 0">
                                @php $techs = $technologies->where('category_id', $category->id); @endphp
                                @if($techs->count())
                                    <ul class="list-group">
                                        @foreach($techs as $tech)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <div class="avatars">
                                                    <div class="avatar">
                                                        <img src="{{ $tech->logo }}" alt="Logo" style="width: 90px; height: 50px; object-fit: contain; margin-right: 10px;">
                                                    </div>
                                                    
                                                    {{ $tech->name }}
                                                </div>
                                                <div>
                                                    <button class="btn btn-sm btn-primary edit-technology"
                                                            data-id="{{ $tech->id }}"
                                                            data-name="{{ $tech->name }}"
                                                            data-logo="{{ $tech->logo }}"
                                                            data-category="{{ $tech->category_id }}">Edit</button>
                                                    <button class="btn btn-sm btn-danger" onclick="deleteTechnology({{ $tech->id }})">Delete</button>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-muted mb-0">No technologies mapped.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <p class="text-muted">No Categories Found</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Category Modal -->
<div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="addCategory" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="categoryForm">
                <div class="modal-header">
                    <h5 class="modal-title">Add Category</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="category_id">
                    <label>Category</label>
                    <input type="text" name="name" id="category_name" class="form-control" placeholder="Enter Category Name">
                    <span class="add-category-error error-message text-danger"></span>
                </div>
                <div class="modal-footer">
                    <span class="success-message text-success"></span>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-success" type="submit" id="save_category">
                        <span class="spinner-border spinner-border-sm" style="display:none"></span>
                        <span>Save</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Technology Modal -->
<div class="modal fade" id="addTechnology" tabindex="-1" role="dialog" aria-labelledby="addTechnology" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="technologyForm">
                <div class="modal-header">
                    <h5 class="modal-title">Add Technology</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="technology_id">
                    <label>Technology</label>
                    <input type="text" name="name" id="technology_name" class="form-control" placeholder="Enter Technology Name">
                    <span class="technology-error error-message text-danger"></span>
                    <br/>

                    <label class="mt-2">Category</label>
                    <select name="category_id" id="technology_category" class="form-control">
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $cat)
                            @if($cat->id != 0)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    <span class="category-error error-message text-danger"></span>
                    <br/>
                    
                    <label>Logo URL</label>                    
                    <input type="text" name="logo" id="logo" class="form-control" placeholder="Enter Logo Image URL">
                    <span class="logo-error error-message text-danger"></span>
                </div>
                <div class="modal-footer">
                    <span class="success-message text-success"></span>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit" id="save_technology">
                        <span class="spinner-border spinner-border-sm" style="display:none"></span>
                        <span>Save</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{url('plugins/sweetalert/sweetalert.min.js')}}"></script>

<script>
$(document).ready(function () {
    // Save Category
    $("#categoryForm").submit(function(e) {
        e.preventDefault();
        $("#save_category").attr("disabled", true).find(".spinner-border").show();
        let id = $("#category_id").val();
        let url = id ? base_url+"/admin/update-technology-category/"+id : base_url+"/admin/add-technology-category";

        $.post(url, $(this).serialize())
            .done(() => location.reload())
            .fail(xhr => {
                $(".error-message").show();
                var object = JSON.parse(xhr.responseText);

                if(xhr.status === 422) {
                    $.each(object, function(key, value) {
                        $(".add-category-error").text(value.name ?? '');
                    });
                } else {
                    $(".add-category-error").text(object.message);
                }
            })
            .always(() => $("#save_category").attr("disabled", false).find(".spinner-border").hide());
    });

    $(".edit-category").click(function() {
        $("#category_id").val($(this).data("id"));
        $("#category_name").val($(this).data("name"));
        $("#addCategory .modal-title").text("Edit Category");
        $("#save_category span:last").text("Update");
        $("#addCategory").modal("show");
    });

    // Reset modal to Add mode
    $(".addCategory").on("click", function() {
        $("#categoryForm")[0].reset();
        $("#category_id").val('');
        $("#addCategory .modal-title").text("Add Category");
        $("#save_category span:last").text("Save");
        $(".error-message").text('');
    });

    // Save Technology
    $("#technologyForm").submit(function(e) {
        e.preventDefault();
        $("#save_technology").attr("disabled", true).find(".spinner-border").show();
        let id = $("#technology_id").val();
        let url = id ? base_url+"/admin/update-project-technology/"+id : base_url+"/admin/add-project-technology";

        $.post(url, $(this).serialize())
            .done(() => location.reload())
            .fail(xhr => {
                $(".error-message").show();
                var object = JSON.parse(xhr.responseText);

                if(xhr.status === 422) {
                    $.each(object, function(key, value) {
                        $(".technology-error").text(value.name ?? '');
                        $(".logo-error").text(value.logo ?? '');
                        $(".category-error").text(value.category_id ?? '');
                    });
                } else {
                    $(".category-error").text(object.message);
                }
            })
            .always(() => $("#save_technology").attr("disabled", false).find(".spinner-border").hide());
    });

    $(".edit-technology").click(function() {
        $("#technology_id").val($(this).data("id"));
        $("#technology_name").val($(this).data("name"));
        $("#logo").val($(this).data("logo"));
        $("#technology_category").val($(this).data("category"));
        $("#addTechnology .modal-title").text("Edit Technology");
        $("#save_technology span:last").text("Update");
        $("#addTechnology").modal("show");
    });

    // Reset modal to Add mode
    $(".addTechnology").on("click", function() {
        $("#technologyForm")[0].reset();
        $("#technology_id").val('');
        $("#addTechnology .modal-title").text("Add Technology");
        $("#save_technology span:last").text("Save");
        $(".technology-error").text('');
    });
});

function deleteCategory(id) {
    swal({
        title: "Are you sure?",
        text: "Are you sure you want to delete this category, this will delete the child technologies also?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {

            $.ajax({
                url: base_url+'/admin/delete-technology-category/'+id,
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
                        swal("Category deleted!", {
                            icon: "success",
                            title: "Success",
                        });

                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }
                }
            });
        }
    });
}

function deleteTechnology(id) {
    swal({
        title: "Are you sure?",
        text: "Are you sure you want to delete this technology?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {

            $.ajax({
                url: base_url+'/admin/delete-technology/'+id,
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
                        swal("Technology deleted!", {
                            icon: "success",
                            title: "Success",
                        });

                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }
                }
            });
        }
    });
}
</script>
@endsection
