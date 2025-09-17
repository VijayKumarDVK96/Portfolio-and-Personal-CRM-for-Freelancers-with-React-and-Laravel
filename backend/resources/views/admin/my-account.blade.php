@extends('includes.admin-layout')

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                @include('includes.admin-breadcrumb')
                <div class="col-lg-6">
                    <!-- Bookmark Start-->
                    <div class="bookmark pull-right">
                        <a class="btn btn-primary btn-lg pull-right" href="{{url('admin/edit-profile')}}">Edit Profile</a>
                    </div>
                    <!-- Bookmark Ends-->
                </div>
            </div>
        </div>
    </div>

    <div class="user-profile">
        <div class="row">
            <div class="col-sm-12">
                <div class="card hovercard text-center" style="margin-top: 95px;">
                    <div class="user-image">
                        <div class="avatar"><img alt="" src="{{url('images/'.$details->profile_image)}}"
                                data-original-title="" title=""></div>
                    </div>
                    <div class="info">
                        <div class="row">
                            <div class="col-sm-6 col-lg-4 order-sm-1 order-xl-0">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="ttl-info text-left">
                                            <h6><i class="fa fa-envelope"></i>&nbsp;&nbsp;&nbsp;Email</h6>
                                            <span>{{$details->email}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="ttl-info text-left">
                                            <h6><i class="fa fa-calendar"></i>&nbsp;&nbsp;&nbsp;DOB</h6><span>{{date('d M, Y', strtotime($details->dob))}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-4 order-sm-0 order-xl-1">
                                <div class="user-designation">
                                    <div class="title"><a target="_blank" href="#" data-original-title="" title="">Vijayakumar D</a></div>
                                    <div class="desc mt-2">Senior Software Developer</div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4 order-sm-2 order-xl-2">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="ttl-info text-left">
                                            <h6><i class="fa fa-phone"></i>&nbsp;&nbsp;&nbsp;Contact Us</h6><span>{{$details->mobile}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="ttl-info text-left">
                                            <h6><i class="fa fa-location-arrow"></i>&nbsp;&nbsp;&nbsp;Location</h6>
                                            <span>{{$details->city}}, {{$details->state}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="social-media">
                            <ul class="list-inline">
                                <li class="list-inline-item"><a href="{{$details->linkedin}}" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
                                <li class="list-inline-item"><a href="{{$details->instagram}}" title="Instagram"><i class="fa fa-instagram"></i></a></li>
                                <li class="list-inline-item"><a href="{{$details->github}}" title="GitHub"><i class="fa fa-github"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection