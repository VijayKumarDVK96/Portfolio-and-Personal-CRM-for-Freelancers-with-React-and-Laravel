    @extends('includes.layout')

    @section('styles')
        <style>
            table {
                border-collapse: collapse;
                width: 100%;
                border: 2px solid black;
            }

            th, td {
                border: 1px solid black;
                padding: 8px;
                text-align: left;
            }

            .portfolio-details a {
                color: #4285F4 !important;
            }
        </style>
    @endsection

	@section('content')

    <!-- Main Content Area Start -->
    <div class="main-content">
        <div class="main-content-inner">


            <!-- Portfolio Details Area Start -->
            <div class="portfolio-details section-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="main-image idgallery">
                                <div class="big-image popup-gallery">
                                    <a href="{{url('images/projects/thumbnail/'.$project->thumbnail_image)}}">
                                        <img src="{{url('images/projects/thumbnail/'.$project->thumbnail_image)}}" alt="">
                                    </a>
                                    @foreach ($project->galleries as $value)
                                    <a href="{{url('images/projects/'.$value->name)}}">
                                        <img src="{{url('images/projects/'.$value->name)}}" alt="">
                                    </a>
                                    @endforeach
                                </div>
                                <div class="slider-img owl-carousel">
                                    <div class="slid-item">
                                        <img src="{{url('images/projects/thumbnail/'.$project->thumbnail_image)}}" alt="">
                                    </div>
                                    @foreach ($project->galleries as $value)
                                    <div class="slid-item">
                                        <img src="{{url('images/projects/'.$value->name)}}" alt="">
                                    </div>
                                    @endforeach
                                </div>

                            </div>
                            <div class="content">
                                <h1 class="title">{{$project->name}}</h1>
                                {!!$project->description!!}
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="info">
                                <ul>
                                    <li style="overflow-wrap: break-word">
                                        <h4> URL :</h4> <a href="{{$project->url}}" target="_blank">{{$project->url}}</a>
                                    </li>
                                    <li>
                                        <h4> Category :</h4> <span>{{$project->projects_category->name}}</span>
                                    </li>
                                    <!-- <li>
                                        <h4>Client name :</h4> <span>{{$project->client->full_name}}</span>
                                    </li> -->
                                    <li>
                                        <h4>Technology :</h4>
                                        <span>
                                            @foreach($project->technologies as $technologies)
                                                <button class="btn btn-primary btn-xs" type="button">{{$technologies->name}}</button>
                                            @endforeach
                                        </span>
                                    </li>
                                    <!-- <li>
                                        <h4>Status :</h4> <span>{{($project->status == 1) ? 'Completed' : 'Pending'}}</span>
                                    </li> -->
                                </ul>
                            </div>
                            <div class="aside-contact-form">
                                <div class="heading">
                                    <h4 class="title">
                                        Contact Me
                                    </h4>
                                </div>
                                <div class="contact-form">
                                    <form action="#" id="contact-form">
										@csrf							
										<div class="controls">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<input name="name" type="text" class="form-control" placeholder="Name*">
														<div class="error-message name-error"></div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<input name="email" type="email" class="form-control" placeholder="Email*">
														<div class="error-message email-error"></div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<input name="phone" type="text" class="form-control" placeholder="Phone/Mobile No.*">
														<div class="error-message phone-error"></div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<input name="subject" type="text" class="form-control" placeholder="Subject*">
														<div class="error-message subject-error"></div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<textarea name="message" class="form-control" placeholder="Message*" rows="7"></textarea>
														<div class="error-message message-error"></div>
													</div>
												</div>
												<div class="col-md-12">
													<button type="submit" class="mybtn3 mybtn-bg">
														<span class="spinner-border d-none spinner-border-sm"></span>
														<span class="text">Send Message</span>
													</button>

													<div class="alert alert-danger alert-dismissible mt-3">
														<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
														<strong>Something went wrong!</strong>
													</div>

													<div class="alert alert-success alert-dismissible mt-3">
														<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
														<strong>Success!</strong> <span></span>
													</div>
												</div>
											</div>
										</div>
									</form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Portfolio Details Area End -->

        </div>
    </div>
    <!-- Main Content Area End -->
		
	@endsection