<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{url('images/favicon.png')}}" type="image/x-icon">
    <title>{{$title}} - Vijay Kumar DVK</title>

    @include('includes.styles')
    @yield('styles')
</head>

<body>
    <!-- Loader starts-->
    <div class="loader-wrapper">
        <div class="loader-index"><span></span></div>
        <svg>
            <defs></defs>
            <filter id="goo">
                <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
                <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo">
                </fecolormatrix>
            </filter>
        </svg>
    </div>
    <!-- Loader ends-->

    <?php

    $details = App\Http\Models\UserDetail::read_user_details(auth()->id());
    ?>

    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <!-- Page Header Start-->
        <div class="page-main-header">
            <div class="main-header-right row m-0">
                <div class="main-header-left">
                    <div class="logo-wrapper"><a href="{{url('admin')}}"><img class="img-fluid"
                                src="{{url('images/admin-logo.jpg')}}" alt=""></a></div>
                </div>
                <div class="toggle-sidebar"><i class="status_toggle middle" data-feather="grid" id="sidebar-toggle"></i>
                </div>
                <div class="nav-right col pull-right right-menu">
                    <ul class="nav-menus">
                        <li class="onhover-dropdown p-0">
                            <div class="media profile-media">
                                <img class="b-r-10" src="{{url('images/'.$details->profile_image)}}" alt="" data-original-title="" title="">
                                <div class="media-body">
                                    <span>{{Auth::user()->name}}</span>
                                    <p class="mb-0 font-roboto">Admin <i class="middle fa fa-angle-down"></i></p>
                                </div>
                            </div>
                            <ul class="profile-dropdown onhover-show-div">
                                <li><a href="{{url('admin/my-account')}}"><i data-feather="user"></i><span>My Account </span></a></li>
                                <li><a href="javascript::void()" onclick="$('#logout-form').submit();"><i data-feather="log-in"> </i><span>Log Out</span></a></li>
                            </ul>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        </li>
                    </ul>
                </div>
                <div class="d-lg-none mobile-toggle pull-right"><i data-feather="more-horizontal"></i></div>
            </div>
        </div>
        <!-- Page Header Ends                              -->
        <!-- Page Body Start-->
        <div class="page-body-wrapper sidebar-icon">
            <!-- Page Sidebar Start-->
            <header class="main-nav">
                <div class="logo-wrapper">
                    <a href="{{url('admin')}}">
                        <img class="img-fluid" src="{{url('images/admin-logo.jpg')}}" alt="">
                    </a>
                </div>
                <div class="logo-icon-wrapper">
                    <a href="{{url('admin')}}">
                        <img src="{{url('images/admin-logo-small.jpg')}}" alt="">
                    </a>
                </div>
                <nav>
                    <div class="main-navbar">
                        <div id="mainnav">
                            <ul class="nav-menu custom-scrollbar">
                                <li class="back-btn">
                                    <div class="mobile-back text-right"><span>Back</span><i class="fa fa-angle-right pl-2" aria-hidden="true"></i></div>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title" href="{{url('admin')}}"><i class="fa fa-th-large"></i><span>Dashboard</span> 
                                    </a>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title" href="javascript::void()"><i class="fa fa-group (alias)"></i><span>Clients</span><i class="fa fa-angle-right"></i></a>
                                    <ul class="nav-submenu menu-content">
                                        <li><a href="{{url('admin/clients')}}">Manage Clients</a></li>
                                        <li><a href="{{url('admin/add-client')}}">Add New Client</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title" href="javascript::void()"><i class="fa fa-tasks"></i><span>Projects</span><i class="fa fa-angle-right"></i></a>
                                    <ul class="nav-submenu menu-content">
                                        <li><a href="{{url('admin/projects')}}">Manage Projects</a></li>
                                        <li><a href="{{url('admin/project-categories')}}">Projects Category</a></li>
                                        <li><a href="{{url('admin/project-technologies')}}">Projects Technology</a></li>
                                        <li><a href="{{url('admin/vault-categories')}}">Vault Category</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title" href="javascript::void()"><i class="fa fa-money"></i><span>Accounts</span><i class="fa fa-angle-right"></i></a>
                                    <ul class="nav-submenu menu-content">
                                        <li><a href="{{url('admin/estimates')}}">Estimates</a></li>
                                        <li><a href="{{url('admin/invoices')}}">Invoices</a></li>
                                        <li><a href="{{url('admin/payments')}}">Payments</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title" href="{{url('admin/personal-vault')}}"><i class="fa fa-lock"></i><span>Personal Vault</span> 
                                    </a>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title" href="{{url('admin/enquiries')}}"><i class="fa fa-tags"></i><span>Enquiries</span> 
                                    </a>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title" href="{{url('admin/resume')}}"><i class="fa fa-mortar-board"></i><span>Resume</span> 
                                    </a>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title" href="{{url('admin/certifications')}}"><i class="fa fa-thumb-tack"></i><span>Certifications</span></a>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title" href="javascript::void()"><i class="fa fa-briefcase"></i><span>Leads</span><i class="fa fa-angle-right"></i></a>
                                    <ul class="nav-submenu menu-content">
                                        <li><a href="{{url('admin/leads')}}">Leads</a></li>
                                        <li><a href="{{url('admin/lead-categories')}}">Leads Categories</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>
            <!-- Page Sidebar Ends-->
            <div class="page-body">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- Container-fluid Ends-->
            </div>
            
        </div>
        
        <!-- footer start-->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 footer-copyright">
                        <p class="mb-0">Copyright 2021 © Vijay Kumar DVK All rights reserved.</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="{{url('admin-assets/js/jquery-3.5.1.min.js')}}"></script>
    <script src="{{url('admin-assets/js/bootstrap/popper.min.js')}}"></script>
    <script src="{{url('admin-assets/js/bootstrap/bootstrap.js')}}"></script>
    <script src="{{url('admin-assets/js/icons/feather-icon/feather.min.js')}}"></script>
    <script src="{{url('admin-assets/js/icons/feather-icon/feather-icon.js')}}"></script>
    <script src="{{url('admin-assets/js/sidebar-menu.js')}}"></script>
    <script src="{{url('admin-assets/js/config.js')}}"></script>
    <script src="{{url('admin-assets/js/script.js')}}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        const base_url = "{{ url('/') }}";
    </script>
    @yield('scripts')
</body>

</html>