@extends('includes.admin-layout')

@section('styles')
	<link rel="stylesheet" href="{{url('plugins/notifications/css/lobibox.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{url('plugins/sweetalert/sweetalert2.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('plugins/jquery-ui/css/jquery-ui.css')}}">

    <link rel='stylesheet' href="{{url('plugins/datatables/css/dataTables.bootstrap4.min.css')}}">
    <link rel='stylesheet' href="{{url('plugins/datatables/css/buttons.bootstrap4.min.css')}}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                @include('includes.admin-breadcrumb')
            </div>
        </div>
    </div>

    <form action="" method="post" id="filter">
        <div class="row filter-row">
            <div class="col-sm-4 col-xs-6">  
                <div class="form-group">
                    <label class="control-label">From</label>
                    <div class="cal-icon">
                        <input class="form-control from date" type="text" name="from" readonly placeholder="From Date">
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-xs-6">  
                <div class="form-group">
                    <label class="control-label">To</label>
                    <div class="cal-icon">
                        <input class="form-control to date" type="text" name="to" readonly placeholder="To Date">
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-xs-6"> 
                <div class="form-group">
                    <label class="control-label">Status</label>
                    <select class="form-control" name="status"> 
                        <option value="">Select Status</option>
                        <option value="0">Pending</option>
                        <option value="1">Confirmed</option>
                        <option value="2">Invoiced</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-2 col-xs-6 form-group">  
                <button type="submit" class="btn btn-success btn-block"> Search </button>  
            </div>
            <div class="col-sm-2 col-xs-6 form-group">  
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
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone no.</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Notes</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="enquiry">
                        
                    </tbody>
                </table>
                </div>
        </div>

        <div class="modal fade" id="editEnquiry">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <form>
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Enquiry</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" name="enquiry_id" id="enquiry_id">
                                <div class="col-md-4 form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control" id="status">
                                        <option value="0">Pending</option>
                                        <option value="1">Confirmed</option>
                                        <option value="2">Invoiced</option>
                                    </select>
                                </div>

                                <div class="col-md-8 form-group">
                                    <label for="notes">Notes</label>
                                    <textarea name="notes" id="notes" class="form-control" cols="30" rows="10"></textarea>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <span class="success-message"></span>
                            <span class="add-vault-error error-message"></span>
                            
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary" type="submit" id="edit_enquiry">
                                <span class="spinner-border spinner-border-sm"></span>
                                <span>Update</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

<script src="{{url('plugins/jquery-ui/js/jquery-ui.js')}}"></script>
<script src="{{url('plugins/notifications/js/notifications.min.js')}}"></script>
<script src="{{url('plugins/sweetalert/sweetalert.min.js')}}"></script>

<!--Data Tables js-->
<script src="{{url('plugins/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{url('plugins/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{url('plugins/datatables/js/dataTables.buttons.min.js')}}"></script>
<script src="{{url('plugins/datatables/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{url('plugins/datatables/js/jszip.min.js')}}"></script>
<script src="{{url('plugins/datatables/js/pdfmake.min.js')}}"></script>
<script src="{{url('plugins/datatables/js/vfs_fonts.js')}}"></script>
<script src="{{url('plugins/datatables/js/buttons.html5.min.js')}}"></script>
<script src="{{url('plugins/datatables/js/buttons.print.min.js')}}"></script>
<script src="{{url('plugins/datatables/js/buttons.colVis.min.js')}}"></script>

<script>
    $(".from").datepicker({
        dateFormat: 'yy-mm-dd',
        onSelect: function(dateStr) {
            $(".to").datepicker("destroy");
            $(".to").datepicker({
                dateFormat: 'yy-mm-dd',
                minDate: new Date(dateStr)
            });
        }
    });

    $(document).ready(function() {
        readEnquiries();
    });

    $("#filter").submit(function(e) {
        e.preventDefault();
        $('#table').DataTable().destroy();
        readEnquiries();
    });

    $("#reset").click(function(e) {
        $("#filter").find('input:text, input:password, input:file, select, textarea').val('');
        $("#filter").find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');

        $("#filter").trigger("reset");
        $("#filter").trigger("submit");
    });

    function load_datatable() {
        var table = $('#table').DataTable({
            lengthChange: true,
            pageLength: 25,
            buttons: [
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                    },
                },
            ]
        });

        table.buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');
    }

    function readEnquiries(pageno='') {
        if(pageno=='')
        $(".vault").html('<div class="col-md-12"><h3 style="padding: .75rem 1.25rem;">Loading...</h3></div>');
        
        var link = base_url+"/admin/read-enquiries-ajax/"+pageno;

        $.ajax({
            url: link,
            dataType: 'json',
            method: "post",
            data: $("#filter").serialize(),
            success: function(data) {
                $(".enquiry").html(data.view);
                load_datatable();
                // $(".client-count").html(data.count);
            }
        });
    }

    function editEnquiry(id) {
        $("input[name=enquiry_id]").val(id);
        $.ajax({
            url: base_url+'/admin/edit-enquiry/'+id,
            dataType: 'json',
            success: function(obj) {
                $("#editEnquiry select[name=status] option").attr('selected', false);
                $("#editEnquiry select[name=status] option[value="+obj.data.status+"]").attr('selected', true);
                $("#editEnquiry textarea[name=notes]").text(obj.data.notes);
            }
        });
    }

    function deleteEnquiry(id) {
        swal({
            title: "Are you sure?",
            text: "Are you sure you want to delete this enquiry?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: base_url+'/admin/delete-enquiry/'+id,
                    dataType: 'json',
                    error: function (xhr, exception, thrownError) {
                        swal("Something went wrong", {
                            icon: "error",
                            title: "Error",
                        });
                    },
                    success: function (data) {
                        if (data.status == "success") {
                            $('#table').DataTable().destroy();
                            readEnquiries();
                            swal("Enquiry deleted!", {
                                icon: "success",
                                title: "Success",
                            });
                        }
                    }
                });
            }
        });
    }

    $("#edit_enquiry").click(function(e) {
        e.preventDefault();
        $("#edit_enquiry").attr('disabled', true);
        $("#edit_enquiry .spinner-border").css('display', 'inline-block');
        $(".error-message").hide();
        $(".success-message").hide();

        var request = $("#editEnquiry form").serializeArray();
        var enquiry_id = $("input[name=enquiry_id]").val();

        $.ajax({
            url: base_url+"/admin/update-enquiry/"+enquiry_id,
            method: 'post',
            data: request,
            success: function(data) {
                if (data.status == "success") {
                    $(".error-message").hide();
                    $(".success-message").show();
                    $(".success-message").text(data.message);
                    $('#table').DataTable().destroy();
                    readEnquiries();
                }
            },
            complete: function() {
                $("#edit_enquiry").attr('disabled', false);
                $("#edit_enquiry .spinner-border").css('display', 'none');
            }
        });
    });
</script>
@endsection