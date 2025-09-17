@extends('includes.admin-layout')

@section('styles')
	<link rel="stylesheet" href="{{url('plugins/notifications/css/lobibox.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{url('plugins/sweetalert/sweetalert2.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('plugins/summernote/dist/summernote-bs4.css')}}"/>

    <link rel='stylesheet' href="{{url('plugins/datatables/css/dataTables.bootstrap4.min.css')}}">
    <link rel='stylesheet' href="{{url('plugins/datatables/css/buttons.bootstrap4.min.css')}}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                @include('includes.admin-breadcrumb')

                <div class="col-lg-6">
                    <a class="btn btn-primary btn-lg pull-right" href="javascript::void()" data-toggle="modal" data-target="#addVault">Add New</a>
                </div>
            </div>
        </div>
    </div>

    <form action="" method="post" id="filter">
        <div class="row filter-row">
            <div class="col-sm-3 col-xs-6"> 
                <div class="form-group">
                    <label class="control-label">Category</label>
                    <select class="form-control" name="category"> 
                        <option value="">Select Category</option>
                        @foreach ($categories as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-2 col-xs-6 form-group">  
                <label class="control-label" style="color: #fff">Search</label>
                <button type="submit" class="btn btn-success btn-block"> Search </button>  
            </div>
            <div class="col-sm-2 col-xs-6 form-group"> 
                <label class="control-label" style="color: #fff">Reset</label> 
                <button type="button" id="reset" class="btn btn-danger btn-block"> Reset </button>  
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-sm" id="table">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>URL</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Notes</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="vault">
                        
                    </tbody>
                </table>
                </div>
        </div>

        <div class="modal fade" id="addVault">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <form>
                        <div class="modal-header">
                            <h5 class="modal-title">Add New Credentials</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <input type="hidden" name="project_id" value="">
                                    <label for="">Category <span class="mandatory">*</span></label>
                                    <select name="vaults_category_id" class="form-control">
                                        <option value="">Select</option>
                                        @foreach ($categories as $value)
                                            <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="category-error error-message"></span>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="">Url <span class="mandatory">*</span></label>
                                    <input type="url" name="url" class="form-control">
                                    <span class="url-error error-message"></span>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="">Username <span class="mandatory">*</span></label>
                                    <input type="text" name="username" class="form-control">
                                    <span class="username-error error-message"></span>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="">Password <span class="mandatory">*</span></label>
                                    <input type="text" name="password" class="form-control">
                                    <span class="password-error error-message"></span>
                                </div>

                                <div class="col-md-12 form-group">
                                    <label for="">Notes <span class="mandatory">*</span></label>
                                    <textarea name="notes" class="form-control" id="add_notes" cols="30" rows="5"></textarea>
                                    <span class="notes-error error-message"></span>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <span class="success-message"></span>
                            <span class="edit-vault-error error-message"></span>
                            
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary" type="submit" id="add_vault">
                                <span class="spinner-border spinner-border-sm"></span>
                                <span>Add</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editVault">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <form>
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Credentials</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <input type="hidden" name="vault_id">
                                    <label for="">Category <span class="mandatory">*</span></label>
                                    <select name="vaults_category_id" class="form-control">
                                        <option value="">Select</option>
                                        @foreach ($categories as $value)
                                            <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="category-error error-message"></span>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="">Url <span class="mandatory">*</span></label>
                                    <input type="url" name="url" class="form-control">
                                    <span class="url-error error-message"></span>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="">Username <span class="mandatory">*</span></label>
                                    <input type="text" name="username" class="form-control">
                                    <span class="username-error error-message"></span>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="">Password <span class="mandatory">*</span></label>
                                    <input type="text" name="password" class="form-control">
                                    <span class="password-error error-message"></span>
                                </div>

                                <div class="col-md-12 form-group">
                                    <label for="">Notes <span class="mandatory">*</span></label>
                                    <textarea name="notes" class="form-control" id="edit_notes" cols="30" rows="5"></textarea>
                                    <span class="notes-error error-message"></span>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <span class="success-message"></span>
                            <span class="add-vault-error error-message"></span>
                            
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary" type="submit" id="edit_vault">
                                <span class="spinner-border spinner-border-sm"></span>
                                <span>Update</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="vaultNotes">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <form>
                        <div class="modal-header">
                            <h5 class="modal-title">Vault Notes</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12 vault_notes">
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

<script src="{{url('plugins/notifications/js/notifications.min.js')}}"></script>
<script src="{{url('plugins/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{url('plugins/summernote/dist/summernote-bs4.min.js')}}"></script>

<!--Data Tables js-->
<script src="{{url('plugins/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{url('plugins/datatables/js/dataTables.bootstrap4.min.js')}}"></script>

<script>

    var project_id = '{{$id}}';

    $(document).ready(function() {
        readVault();
    });

    $('#add_notes').summernote({
        height: 200,
        tabsize: 2
    });

    $('#edit_notes').summernote({
        height: 200,
        tabsize: 2
    });

    function readVault(pageno='') {
        if(pageno=='')
        $(".vault").html('<div class="col-md-12"><h3 style="padding: .75rem 1.25rem;">Loading...</h3></div>');
        
        let category = $("select[name=category]").val();
        var link = base_url+"/admin/read-vault-ajax/"+project_id+'/'+category;
        // var link = (pageno=='') ? base_url+"/admin/read-vault-ajax/" : base_url+"/admin/read-vault-ajax/?page="+pageno;

        $.ajax({
            url: link,
            dataType: 'json',
            beforeSend: function() {
                $('#table').DataTable().destroy();
            },
            success: function(data) {
                $(".vault").html(data.view);
                $('#table').DataTable();
                // $(".client-count").html(data.count);
            }
        });
    }

    function editVault(id) {
        $("input[name=vault_id]").val(id);
        $.ajax({
            url: base_url+'/admin/edit-vault/'+id,
            dataType: 'json',
            success: function(obj) {
                $("#editVault select[name=vaults_category_id] option").attr('selected', false);
                $("#editVault select[name=vaults_category_id] option[value="+obj.data.vaults_category_id+"]").attr('selected', true);
                $("#editVault input[name=url]").val(obj.data.url);
                $("#editVault input[name=username]").val(obj.data.username);
                $("#editVault input[name=password]").val(obj.data.password);
                $('#editVault textarea[name=notes]').summernote('code', obj.data.notes)
            }
        });
    }

    function toggleCredentials(credentials, el) {
        var credential = $(el).parent().find(".credentials");
        $(el).parent().find(".credentials").remove();

        if(credential.text() == '*****') {
            $(el).parent().prepend('<span class="credentials" onclick="copyCredentials(this)">'+credentials+'</span>');
            $(el).html('<i class="fa fa-eye-slash"></i>');
            $(el).removeClass('toggle-credentials-open');
            $(el).addClass('toggle-credentials-close');
        } else {
            $(el).parent().prepend('<span class="credentials">*****</span>');
            $(el).html('<i class="fa fa-eye"></i>');
            $(el).removeClass('toggle-credentials-close');
            $(el).addClass('toggle-credentials-open');
        }
    }

    function copyCredentials(el) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(el).text()).select();
        document.execCommand("copy");
        $temp.remove();
        notification('success', "Copied To Clipboard");
    }

    function deleteCredentials(id) {
        swal({
            title: "Are you sure?",
            text: "Are you sure you want to delete this credentials?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {

                $.ajax({
                    url: base_url+'/admin/delete-vault/'+id,
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
                            readVault();
                            swal("Credentials deleted!", {
                                icon: "success",
                                title: "Success",
                            });
                        }
                    }
                });
            }
        });
    }

    $("#add_vault").click(function(e) {
        e.preventDefault();
        $("#add_vault").attr('disabled', true);
        $("#add_vault .spinner-border").css('display', 'inline-block');
        $(".error-message").hide();
        $(".success-message").hide();

        var request = $("#addVault form").serializeArray();

        $.ajax({
            url: base_url+"/admin/add-new-vault/"+project_id,
            method: 'post',
            data: request,
            error: function(data) {
                $(".error-message").show();
                var object = JSON.parse(data.responseText);

                if(data.status === 422) {
                    $.each(object, function(key, value) {
                        $(".category-error").text(value.vaults_category_id ?? '');
                        $(".url-error").text(value.url ?? '');
                        $(".username-error").text(value.username ?? '');
                        $(".password-error").text(value.password ?? '');
                    });
                } else {
                    $(".add-vault-error").text(object.message);
                }
            },
            success: function(data) {
                if (data.status == "success") {
                    $(".error-message").hide();
                    $(".success-message").show();
                    $(".success-message").text(data.message);
                    $("#addVault form").trigger("reset");
                    readVault();
                    $("#addVault").modal('hide');
                }
            },
            complete: function() {
                $("#add_vault").attr('disabled', false);
                $("#add_vault .spinner-border").css('display', 'none');
            }
        });
    });

    $("#edit_vault").click(function(e) {
        e.preventDefault();
        $("#edit_vault").attr('disabled', true);
        $("#edit_vault .spinner-border").css('display', 'inline-block');
        $(".error-message").hide();
        $(".success-message").hide();

        var request = $("#editVault form").serializeArray();
        var vault_id = $("input[name=vault_id]").val();

        $.ajax({
            url: base_url+"/admin/update-vault/"+vault_id,
            method: 'post',
            data: request,
            error: function(data) {
                $(".error-message").show();
                var object = JSON.parse(data.responseText);

                if(data.status === 422) {
                    $.each(object, function(key, value) {
                        $(".category-error").text(value.vaults_category_id ?? '');
                        $(".url-error").text(value.url ?? '');
                        $(".username-error").text(value.username ?? '');
                        $(".password-error").text(value.password ?? '');
                    });
                } else {
                    $(".edit-vault-error").text(object.message);
                }
            },
            success: function(data) {
                if (data.status == "success") {
                    $(".error-message").hide();
                    $(".success-message").show();
                    $(".success-message").text(data.message);
                    readVault();
                }
            },
            complete: function() {
                $("#edit_vault").attr('disabled', false);
                $("#edit_vault .spinner-border").css('display', 'none');
            }
        });
    });

    $("#filter").submit(function(e) {
        e.preventDefault();
        readVault();
    });

    function appendNotes(id) {
        $(".vault_notes").html('<h2>Loading...</h2>');

        $.ajax({
            url: base_url+'/admin/edit-vault/'+id,
            dataType: 'json',
            success: function(obj) {
                $(".vault_notes").html(obj.data.notes);
            }
        });
    }

    $("#reset").click(function(e) {
        $("#filter").find('select').val('');
        $("#filter").trigger("reset");
        $("#filter").trigger("submit");
    });
</script>
@endsection