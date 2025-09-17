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
                    <a class="btn btn-primary btn-lg pull-right" href="{{url('admin/add-payment')}}">Add New Payment</a>
                </div>
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
                    <label class="control-label">Statement Type</label>
                    <select class="form-control" name="statement_type"> 
                        <option value="">Select Type</option>
                        <option value="1">Credit</option>
                        <option value="0">Debit</option>
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
                <table class="table table-striped custom-table m-b-0" id="table">
                    <thead class="thead-dark">
                        <tr>
                            <th>S.no.</th>
                            <th>Client</th>
                            <th>Project Name</th>
                            <th>Payment Mode</th>
                            <th>Credit Amount</th>
                            <th>Debit Amount</th>
                            <th>Statement Type</th>
                            <th>Purpose</th>
                            <th>Description</th>
                            <th>Paid At</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
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
            readPayments();
        });

        $("#filter").submit(function(e) {
            e.preventDefault();
            $('#table').DataTable().destroy();
            readPayments();
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
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        },
                    },
                ]
            });

            table.buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');
        }

        function readPayments() {
            $("#table tbody").html('<tr colspan="8"><td><h2>Loading...</h2></td></tr>');
            $.ajax({
                url: base_url+'/admin/payments-ajax',
                method: "post",
                dataType: 'json',
                data: $("#filter").serialize(),
                success: function(data) {
                    $("#table tbody").html(data.view);
                    $("#table tfoot").html(data.tfoot);
                    load_datatable();
                }
            });
        }

        function deletePayment(id) {
            swal({
                title: "Are you sure?",
                text: "Are you sure you want to delete this payment record?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: base_url+'/admin/delete-payment/'+id,
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
                                readPayments();
                                swal("Payment deleted!", {
                                    icon: "success",
                                    title: "Success",
                                });
                            }
                        }
                    });
                }
            });
        }
    </script>
@endsection