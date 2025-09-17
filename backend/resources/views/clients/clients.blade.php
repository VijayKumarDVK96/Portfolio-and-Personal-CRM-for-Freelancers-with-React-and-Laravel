@extends('includes.admin-layout')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{url('plugins/jquery-ui/css/jquery-ui.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('plugins/sweetalert/sweetalert2.css')}}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                @include('includes.admin-breadcrumb')

                <div class="col-lg-6">
                    <a class="btn btn-primary btn-lg pull-right" href="{{url('admin/add-client')}}">Add Client</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="email-right-aside bookmark-tabcontent contacts-tabs">
                <div class="card email-body radius-left">
                    <div class="pl-0">
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="pills-personal" role="tabpanel"
                                aria-labelledby="pills-personal-tab">
                                <div class="card mb-0">
                                    <div class="card-header d-flex">
                                        <h5><span class="client-count"></span> Contacts</h5>
                                    </div>

                                    <div class="col-md-6">
                                        <form class="form-inline" action="" id="filter">
                                            <div class="form-group mb-2">
                                                <input type="text" class="form-control" id="client" placeholder="Type & Select Client Name to Search">
                                            </div>
                                            <input type="hidden" name="client_id" id="client_id">
                                            <button type="button" id="reset" class="btn btn-danger btn-lg mb-2">Clear</button>
                                        </form>
                                    </div>

                                    <div class="col-md-12">
                                        @if (session('success'))
                                            <div class="alert alert-success">
                                                <a href="javascript::void()" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <ul>
                                                    <li>{!! session('success') !!}</li>
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="row list-persons" id="addcon">
                                            {{-- @include('admin.clients-ajax') --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{url('plugins/jquery-ui/js/jquery-ui.js')}}"></script>
    <script src="{{url('plugins/sweetalert/sweetalert.min.js')}}"></script>

    <script>
        readClients();

        function activeDiv(index) {
            $('.contacts-tabs .nav-link').removeClass('active show');
            $('.contacts-tabs .tab-content .tab-content-child ').removeClass('active show');
            $('.contact-tab-'+index).addClass('active show');
            $("#v-pills-tabContent").show();
            $(".contact-editform").hide();
        }

        function cancel_contact() {
            $("#v-pills-tabContent").show();
            $(".contact-editform").hide();
        }

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

        function readClients(pageno='') {
            if(pageno=='')
            $(".list-persons").html('<div class="col-md-12"><h3 style="padding: .75rem 1.25rem;">Loading...</h3></div>');
            
            var link = (pageno=='') ? base_url+"/admin/read-clients-ajax/" : base_url+"/admin/read-clients-ajax/?page="+pageno;

            $.ajax({
                url: link,
                dataType: 'json',
                data: $("#filter").serialize(),
                method: "post",
                success: function(data) {
                    $(".list-persons").html(data.view);
                    $(".client-count").html(data.count);
                }
            });
        }

        function editClient(index) {
            $("#updateClient").trigger("reset");
            $("#v-pills-tabContent").hide();
            $(".contact-editform").show();
            $("#id").val(index);
            $("#full_name").val($(".full_name_"+index).text());
            $("#company_name").val($(".company_name_"+index).text());
            $("#company_website").val($(".company_website_"+index).text());
            $("#gender").val($(".gender_"+index).text());
            $("#role").val($(".role_"+index).text());
            $("#email").val($(".email_add_"+index).text());
            $("#mobile").val($(".mobile_"+index).text());
            $("#address").val($(".address_"+index).text());
            $("#state").val($(".state_id_"+index).text());
            var city = $(".city_id_"+index).text();
            changeCity(city);
        }

        function updateClient() {
            $("#update_client").attr('disabled', true);
            $("#update_client .spinner-border").css('display', 'inline-block');
            $(".error-message").hide();
            $(".success-message").hide();
            var id = $("#id").val();
            
            $.ajax({
                url: base_url+"/admin/update-client/"+id,
                method: 'post',
                dataType: 'json',
                data: $("#updateClient").serialize(),
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
                    $("#update_client").attr('disabled', false);
                    $("#update_client .spinner-border").css('display', 'none');
                }
            });
        }

        function deleteClient(id) {
            swal({
                title: "Are you sure?",
                text: "Are you sure you want to delete this client details?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: base_url+'/admin/delete-client/'+id,
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
                                readClients();
                                swal("Client details deleted!", {
                                    icon: "success",
                                    title: "Success",
                                });
                            }
                        }
                    });
                }
            });
        }

        $("#reset").click(function(e) {
            e.preventDefault();
            $("#client").val('');
            $("#client_id").val('');
            readClients();
        });

        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            $('li').removeClass('active');
            $(this).parent('li').addClass('active');
            var myurl = $(this).attr('href');
            var page=$(this).attr('href').split('page=')[1];
            readClients(page);
        });

        $("#client").keyup(function() {
            $(this).autocomplete({
              source: base_url+"/admin/fetch-clients",
              minLength: 1,
              autoFocus: true,
              select: function(event, ui) {
                  if(ui.item.value =="") {
                      event.preventDefault();
                  } else if(ui.item.value =="No Result") {
                    $(this).val('');
                  } else {
                    $(this).val(ui.item.full_name);
                    $("#client_id").val(ui.item.id);

                    readClients();
                  }
                  return false;
              },
              change: function (event, ui) {
               if (ui.item === null) {
                  $(this).val('');
               }
              }
            }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
                return $( "<li>" ).data( "ui-autocomplete-item", item ).append(item.full_name).appendTo(ul);
            };
        });
    </script>
@endsection