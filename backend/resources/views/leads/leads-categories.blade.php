@extends('includes.admin-layout')

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                @include('includes.admin-breadcrumb')

                <div class="col-lg-6">
                    <a class="btn btn-primary btn-lg pull-right" href="javascript::void()" data-toggle="modal" data-target="#addCategory">Add Category</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <ul class="list-group">
                @forelse ($categories as $key => $value)
                    <li class="list-group-item d-flex justify-content-between align-items-center">{{$key+1}}, {{$value->name}}</li>
                @empty
                    <li class="list-group-item d-flex justify-content-between align-items-center">No Category Found</li>
                @endforelse
            </ul>
        </div>

        <div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="addCategory"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form>
                        <div class="modal-header">
                            <h5 class="modal-title">Add Category</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <label for="">Category</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter Category Name">
                            <span class="name-error error-message"></span>
                        </div>
                        <div class="modal-footer">
                            <span class="success-message"></span>
                            <span class="category-error error-message"></span>
                            
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary" type="submit" id="add_category">
                                <span class="spinner-border spinner-border-sm"></span>
                                <span>Add</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $("#add_category").click(function(e) {
            e.preventDefault();
            $("#add_category").attr('disabled', true);
            $("#add_category .spinner-border").css('display', 'inline-block');
            $(".error-message").hide();
            $(".success-message").hide();

            $.ajax({
                url: base_url+"/admin/add-lead-category",
                method: 'post',
                data: $("#addCategory form").serialize(),
                error: function(data) {
                    $(".error-message").show();
                    var object = JSON.parse(data.responseText);

                    if(data.status === 422) {
                        $.each(object, function(key, value) {
                            $(".name-error").text(value.name ?? '');
                        });
                    } else {
                        $(".category-error").text(object.message);
                    }
                },
                success: function(data) {
                    if (data.status == "success") {
                        $(".error-message").hide();
                        $(".success-message").show();
                        $(".success-message").text(data.message);
                        $("#addCategory form").trigger("reset");

                        var i=1;
                        var category = '';
                        $.each(data.data, function(key, value) {
                            category += '<li class="list-group-item d-flex justify-content-between align-items-center">'+i+', '+value.name+'</li>';
                            i++;
                        });

                        $(".list-group").html(category);
                    }
                },
                complete: function() {
                    $("#add_category").attr('disabled', false);
                    $("#add_category .spinner-border").css('display', 'none');
                }
            });
        });
    </script>
@endsection