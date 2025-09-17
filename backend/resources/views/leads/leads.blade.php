@extends('includes.admin-layout')

@section('styles')
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

                <div class="col-lg-6">
                    <a class="btn btn-primary btn-lg pull-right" href="{{url('admin/add-lead')}}">Add New Lead</a>
                    <a class="btn btn-secondary btn-lg pull-right" href="javascript::void()" data-toggle="modal" data-target="#importLeads" style="margin: 0 10px">Import Leads</a>
                </div>

                <div class="col-md-12" style="margin-top: 10px">
                    @if(Session::has('success'))
                        <h5 class="success-message">{{session('success')}}</h5>
                    @endif

                    @if(Session::has('error'))
                        <h5 class="error-message">{{session('error')}}</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <form action="" method="post" id="filter" style="background: #fab1a0; padding: 15px;">
        <div class="row filter-row">
            <div class="col-sm-3 col-xs-6">  
                <div class="form-group">
                    <label class="control-label">From</label>
                    <div class="cal-icon">
                        <input class="form-control from date" type="text" name="from" readonly placeholder="From Date">
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-xs-6">  
                <div class="form-group">
                    <label class="control-label">To</label>
                    <div class="cal-icon">
                        <input class="form-control to date" type="text" name="to" readonly placeholder="To Date">
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-xs-6"> 
                <div class="form-group">
                    <label class="control-label">Status</label>
                    <select class="form-control" name="status"> 
                        <option value="">Select Status</option>
                        <option value="0">Pending</option>
                        <option value="1">Follow Up 1</option>
                        <option value="2">Follow Up 2</option>
                        <option value="3">Follow Up 3</option>
                        <option value="4">Not Interested</option>
                        <option value="5">Closed</option>
                        <option value="6">Invoiced</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-3 col-xs-6"> 
                <div class="form-group">
                    <label class="control-label">Category</label>
                    <select class="form-control" name="lead_category_id"> 
                        <option value="">Select Category</option>
                        @forelse ($categories as $value)
                            <option value="{{$value->id}}">{{$value->name}}</option>
                        @empty
                            <option value="">Select Category</option>
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="col-sm-3 col-xs-6"> 
                <div class="form-group">
                    <label class="control-label">Sort By (ASC/DESC)</label>
                    <select class="form-control" name="sort"> 
                        <option value="">Select Sort By</option>
                        <option value="created_at/asc">Created At (Asc)</option>
                        <option value="created_at/desc" selected>Created At (Desc)</option>
                        <option value="name/asc">Name (Asc)</option>
                        <option value="name/desc">Name (Desc)</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-2 col-xs-6 form-group"> 
                <label class="control-label invisible">Search</label>
                <button type="submit" class="btn btn-success btn-block"> Search </button>  
            </div>
            <div class="col-sm-2 col-xs-6 form-group"> 
                <label class="control-label invisible">Reset</label>
                <button type="button" id="reset" class="btn btn-danger btn-block"> Reset </button>  
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <button class="btn btn-primary" style="margin-top: 35px; margin-bottom: 15px;"  data-toggle="modal" data-target="#UpdateBulkStatus">Update Status</button>
                <button class="btn btn-danger" style="margin-top: 35px; margin-bottom: 15px;" id="bulk_delete">Delete</button>

                <form method="post" action="{{url('admin/bulk-action-leads')}}" id="bulk-action-leads">
                    @csrf
                    <input type="hidden" name="type" class="bulk_type">
                    <input type="hidden" name="status" class="bulk_status">

                    <table class="table table-striped custom-table m-b-0" id="table">
                        <thead class="thead-dark">
                            <tr>
                                <th><input type="checkbox" class="select-all" name="select-all"></th>
                                <th>S.no.</th>
                                <th>Name</th>
                                <th>Contact Number</th>
                                <th>Address</th>
                                <!-- <th>Website</th> -->
                                <th>Category</th>
                                <th>Remarks</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="leadStatus">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Lead Progress</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <span class="success-message"></span>
                    <span class="add-status-error error-message"></span>
                    
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="importLeads">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Leads</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{url('admin/import-leads')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <input type="file" name="file" class="form-control">
                                </div>

                                <div class="form-group">
                                    <p>* Upload only .csv file <strong><a href="{{url('public/files/sample-format.csv')}}">Click here to download the sample format</a></strong></p>
                                </div>

                                <button class="btn btn-success" type="submit">Upload</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <span class="import-lead-success success-message"></span>
                    <span class="import-lead-error error-message"></span>
                    
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="UpdateBulkStatus">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Bulk Leads</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="col-sm-6 col-xs-6"> 
                        <div class="form-group">
                            <label class="control-label">Choose Status and Update</label>
                            <select class="form-control" id="bulk_lead_status"> 
                                <option value="">Select Status</option> 
                                <option value="0">Pending</option>
                                <option value="1">Follow Up 1</option>
                                <option value="2">Follow Up 2</option>
                                <option value="3">Follow Up 3</option>
                                <option value="4">Not Interested</option>
                                <option value="5">Closed</option>
                                <option value="6">Invoiced</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button" id="bulk_update">Update Status</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{url('plugins/jquery-ui/js/jquery-ui.js')}}"></script>
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
    >
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
            readLeads();
        });

        $("#filter").submit(function(e) {
            e.preventDefault();
            $('#table').DataTable().destroy();
            readLeads();
        });

        $("#reset").click(function(e) {
            $("#filter").find('input:text, input:password, input:file, select, textarea').val('');
            $("#filter").find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
            $("#filter").find('select').removeAttr('selected');

            $("#filter").trigger("reset");
            $("#filter").trigger("submit");
        });

        function readLeads() {
            $("#table tbody").html('<tr colspan="8"><td><h2>Loading...</h2></td></tr>');
            $.ajax({
                url: base_url+'/admin/leads-ajax',
                method: "post",
                dataType: 'json',
                data: $("#filter").serialize(),
                success: function(data) {
                    $("#table tbody").html(data.view);
                    load_datatable();
                }
            });
        }

        function load_datatable() {
            var table = $('#table').DataTable({
                lengthChange: true,
                pageLength: 25,
                buttons: [
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                        },
                    },
                ]
            });

            table.buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');
        }

        function deleteLead(id) {
            swal({
                title: "Are you sure?",
                text: "Are you sure you want to delete this lead?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: base_url+'/admin/delete-lead/'+id,
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
                                $('#table').DataTable().destroy();
                                readLeads();
                                swal("Lead deleted!", {
                                    icon: "success",
                                    title: "Success",
                                });
                            }
                        }
                    });
                }
            });
        }

        function triggerStatus(id) {
            // url1 = "{{url('plugins/todo/todo.css')}}";
            // if (document.createStyleSheet){ document.createStyleSheet(url);}
            // else{
            //     $('<link rel="stylesheet" type="text/css" href="' + url1 + '" />').appendTo('head');
            // }

            $.ajax({
                url: base_url+'/admin/leads-status-ajax/'+id,
                method: "get",
                dataType: "json",
                success: function(data) {
                    $("#leadStatus .modal-body").html(data.view);
                }
            });
        }

        $(".select-all").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        $("#bulk_update").click(function() {
            $(".bulk_type").val('Update');
            $(".bulk_status").val($("#bulk_lead_status").val());
            $("#bulk-action-leads").submit();
        });

        $("#bulk_delete").click(function(e) {
            e.preventDefault();

            swal({
                title: "Are you sure?",
                text: "Are you sure you want to delete all this selected lead?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $(".bulk_type").val('Delete');
                    $("#bulk-action-leads").submit();
                }
            });
        });
    </script>
@endsection