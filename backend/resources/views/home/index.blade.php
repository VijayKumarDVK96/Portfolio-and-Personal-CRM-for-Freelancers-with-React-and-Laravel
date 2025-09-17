﻿@extends('includes.layout')

@section('content')

<!-- Main Content Area Start -->
<div class="main-content">
	<div class="main-content-inner">
		
		<!-- About div Start -->
		<div class="home-section" id="home" style='background: url("{{cdn_img_url('images/home-bg.jpg')}}") no-repeat center/cover;'>
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-6">
						<div class="home-content">
							<div class="home-image">
								<img src="{{cdn_img_url('images/'.$details->profile_image)}}" alt="Vijay Kumar DVK" class="wow zoomIn" data-wow-delay="0.2s" width="160" height="160">
							</div>
							<div class="home-main-content">
								<h1 class="heading wow fadeInUp" data-wow-delay="0.3s">Vijayakumar D</h1>
								<div class="designation wow zoomIn" data-wow-delay="0.4s">
									<span>
										I'm a <span class="typed"></span>
									</span>
								</div>
								<div class="social-info wow fadeInUp" data-wow-delay="0.5s">
									<ul>
										<li>
											<a href="{{$details->linkedin}}" target="_blank">
												<i class="fab fa-linkedin-in"></i>
											</a>
										</li>
										<li>
											<a href="{{$details->github}}" target="_blank">
												<i class="fab fa-github"></i>
											</a>
										</li>
										<li>
											<a href="{{$details->instagram}}" target="_blank">
												<i class="fab fa-instagram"></i>
											</a>
										</li>
									</ul>
								</div>
								<div class="about-links wow fadeInUp" data-wow-delay="0.6s">
									<a href="#contact" class="mybtn3 mybtn-bg')}}"> <span>Contact Me</span></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- About div End -->

		<!-- About div Start -->
		<div class="about-section" id="about">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-12">
						<div class="section-heading wow fadeInUp" data-wow-delay="0.2s">
							<h2 class="title">
								About <span class="color">Me</span>
								<span class="bg-text">About</span>
							</h2>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="about">
							<div class="row">
								<div class="col-lg-5">
									<div class="about-content wow fadeInUp">
										<div class="personal-info">
											<ul>
												<li>
													<span><label>Birthday:</label> {{date('d M, Y', strtotime($details->dob))}}</span>
												</li>
												<li>
												<span><label>Age:</label> {{date_diff(date_create('1996-01-30'), date_create('today'))->y}}</span>
												</li>
												<li>
													<span><label>City:</label> {{$details->city}}, {{$details->state}}</span>
												</li>
												<li>
													<span><label>Country:</label> India</span>
												</li>
												<li>
													<span><label>Experience:</label> {{date_diff(date_create('2017-08-09'), date_create('today'))->y}}+ years</span>
												</li>
												<li>
													<span><label>Qualification:</label> B.E. - Computer Science</span>
												</li>
											</ul>
										</div>
									</div>
									
								</div>
								<div class="col-lg-7 align-self-center">
									<div class="short-description wow fadeInUp text-justify">
										<p>{!!$details->about_me!!}</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- About div End -->
		
		<!-- My service Start --> 
		<div class="service-wrapper" id="service">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-12">
						<div class="section-heading wow fadeInUp" data-wow-delay="0.2s">
							<h2 class="title">
								My <span class="color">Services</span>
								<span class="bg-text">Services</span>
							</h2>
						</div>
					</div>
				</div>
				<div class="row justify-content-center">
					<div class="col-lg-4 col-md-6">
						<a href="javascript::void()" class="single-feature wow fadeInUp">
							<img src="{{cdn_img_url('images/custom-web-development.png')}}" alt="custom-web-development" width="80" height="80">
							<div class="content">
								<h3 class="title">Custom Web Development</h3>
								<p>Starts with an idea and ends with a fully functional website according to user requirements.</p>
							</div>
						</a>
					</div>
					<div class="col-lg-4 col-md-6">
						<a href="javascript::void()" class="single-feature wow fadeInUp">
							<img src="{{cdn_img_url('images/fast-and-optimised.png')}}" alt="fast-and-optimised" width="80" height="80">
							<div class="content">
								<h3 class="title">Fast & Optimized</h3>
								<p>I am a professional developer that passionate about web design and development. I can create websites that are fast, optimized, and easy to use.</p>
							</div>
						</a>
					</div>
					<div class="col-lg-4 col-md-6">
						<a href="javascript::void()" class="single-feature wow fadeInUp">
							<img src="{{cdn_img_url('images/lifetime-support.png')}}" alt="lifetime-support" width="80" height="80">
							<div class="content">
								<h3 class="title">Tech Enthusiastic</h3>
								<p>Passionate about technology, I embrace consistent and continuous learning to drive my career.</p>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
		<!-- My service End -->

		<!-- Portfolio Area Start -->
		<div class="project-gallery" id="project-gallery">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-12">
						<div class="section-heading wow fadeInUp" data-wow-delay="0.2s">
							<h2 class="title">
								My <span class="color">Portfolio</span>
								<span class="bg-text">Portfolio</span>
							</h2>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="project-gallery-filter d-flex justify-content-center">
							<ul class="project-gallery-menu d-inline-block wow fadeInUp" data-wow-delay="0.3s">
								<li class="filter active" data-filter="all">All Categories</li>
								@foreach ($projects_category as $category)
									@foreach ($projects as $project)
										@if($category->id == $project->projects_category_id)
										<li class="filter" data-filter=".cat-{{$category->id}}">{{$category->name}}</li>
										@endif
									@endforeach
								@endforeach
							</ul>
						</div>

						<div class="row project-gallery-item">
							@foreach ($projects as $value)
							<div class="mix col-md-6 col-lg-4 gallery-item cat-{{$value->projects_category_id}}">
								<div class="gallery-item-content wow fadeInUp">
									<div class="item-thumbnail">
										<img src="{{url('images/projects/thumbnail/'.$value->thumbnail_image)}}" alt="{{$value->name}}" width="350" height="170">
										<div class="content-overlay">
											<div class="content">
												<div class="links">
													<a href="{{url('portfolio', $value->slug)}}" target="_blank" class="link"><i class="fas fa-link"></i></a>
													<a class="img-popup image-preview" href="{{url('images/projects/thumbnail/'.$value->thumbnail_image)}}">
														<i class="fas fa-eye"></i>
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							@endforeach
						</div>
					</div>
				</div>
				<!-- <div class="row">
					<div class="col-lg-12 text-center">
						<a href="javascript::void()" class="mybtn3 mybtn-bg wow fadeInUp"><span>View All</span></a>
					</div>
				</div> -->
			</div>
		</div>
		<!-- Portfolio Area End -->

		<!-- Resume Area Start -->
		<div class="resume-wrapper" id="resume">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-12">
						<div class="section-heading wow fadeInUp" data-wow-delay="0.2s">
							<h2 class="title">
								My <span class="color">Resume</span>
								<span class="bg-text">Resume</span>
							</h2>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6">
						<div class="resume-box">
							<div class="resume-title">
								<h4 class="title">Education</h4>
							</div>
							<div class="education-list">
								<div class="single-education  wow fadeInUp">
										<div class="year">
											<span>2013-2017</span>
										</div>
									<h4 class="university-name">PSNA College of Engineering & Technology</h4>
									<p class="degree">B.E. - Computer Science </p>
								</div>
								<div class="single-education wow fadeInUp">
										<div class="year">
											<span>2011-2013</span>
										</div>
										<h4 class="university-name">Ideal Hr. Sec. School</h4>
										<p class="degree">12th Std</p>
								</div>
								<div class="single-education wow fadeInUp">
									<div class="year">
										<span>2010-2011</span>
									</div>
									<h4 class="university-name">TVS Matric. Hr. Sec. School</h4>
									<p class="degree">10th Std</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="resume-box">
							<div class="resume-title">
								<h4 class="title">Experience</h4>
							</div>
							<div class="education-list">
								<div class="single-education wow fadeInUp">
										<div class="year">
											<span>2023-Present</span>
										</div>
									<h4 class="university-name">CloudFX, Bangalore</h4>
									<p class="degree">Senior Software Developer</p>
								</div>
								<div class="single-education wow fadeInUp">
										<div class="year">
											<span>2019-2023</span>
										</div>
									<h4 class="university-name">Trawex Technologies, Bangalore</h4>
									<p class="degree">PHP Developer</p>
								</div>
								<div class="single-education wow fadeInUp">
										<div class="year">
											<span>2017-2019</span>
										</div>
										<h4 class="university-name">3P Web Technologies, Madurai</h4>
										<p class="degree">Web Developer</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="resume-box">
							<div class="resume-title">
								<h4 class="title">
									My Skills 
								</h4>
							</div>
							<div class="skill-list">
								<img src="{{url('images/full-stack-developer.png')}}" alt="skills" width="480" height="368">
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="resume-box">
							<div class="resume-title">
								<h4 class="title">
									Knowledge
								</h4>
							</div>
							<div class="knowledge-list wow fadeInUp">
								<div class="single-knowledge">
									<p>Web Design and Development</p>
								</div>
								<div class="single-knowledge">
									<p>On Page SEO</p>
								</div>
								<div class="single-knowledge">
									<p>API Integration and Development</p>
								</div>
								<div class="single-knowledge">
									<p><strong>FRONT END :</strong> HTML5, CSS, JavaScript, React, jQuery, Bootstrap</p>
								</div>
								<div class="single-knowledge">
									<p><strong>BACK END :</strong> Nodejs, Express, PHP, Laravel, CodeIgniter, Python for Webscrapping, JSON, OOPS, REST APIs</p>
								</div>
								<div class="single-knowledge">
									<p><strong>DATABASE :</strong> MySQL, MongoDB</p>
								</div>
								<div class="single-knowledge">
									<p><strong>DEVOPS :</strong> Git, Github, BitBucket, Docker</p>
								</div>
								<div class="single-knowledge">
									<p><strong>HANDS ON :</strong> Redis</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Resume Area End -->

		<!-- Certifications Area Start -->
		<div class="project-gallery" id="certification">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-12">
						<div class="section-heading wow fadeInUp" data-wow-delay="0.2s">
							<h2 class="title">
								My <span class="color">Certifications</span>
								<span class="bg-text">Certifications</span>
							</h2>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="row project-gallery-item">
							<div class="mix col-md-6 col-lg-4 gallery-item cat">
								<div class="gallery-item-content wow fadeInUp">
									<div class="item-thumbnail">
										<img src="{{url('images/certifications/certificate-mern-stack-developer-e-degree.jfif')}}" alt="MERN">
										<div class="content-overlay">
											<div class="content">
												<div class="links">
													<a class="img-popup image-preview" href="{{url('images/certifications/certificate-mern-stack-developer-e-degree.jfif')}}">
														<i class="fas fa-eye"></i>
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="mix col-md-6 col-lg-4 gallery-item cat">
								<div class="gallery-item-content wow fadeInUp">
									<div class="item-thumbnail">
										<img src="{{url('images/certifications/ibm-docker.png')}}" alt="Docker">
										<div class="content-overlay">
											<div class="content">
												<div class="links">
													<a class="img-popup image-preview" href="{{url('images/certifications/ibm-docker.png')}}">
														<i class="fas fa-eye"></i>
													</a>
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
		</div>
		<!-- Certifications Area End -->

		<!-- Contact Area Start -->
		<div class="contact" id="contact">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-12">
						<div class="section-heading wow fadeInUp" data-wow-delay="0.2s">
							<h2 class="title">
								Get In <span class="color">Touch</span>
								<span class="bg-text">Contact</span>
							</h2>
						</div>
					</div>
				</div>
				
				<div class="row cAndm">
					<div class="col-lg-6">
						<div class="home-page-form">
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
													<strong>Thank you for reaching us, we'll get back to you soon.</strong>
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>

					<div class="col-lg-6">
						<div class="single-info wow fadeInUp">
							<div class="info-icon">
								<img src="{{url('images/mail.png')}}" alt="mail" width="40" height="32">
							</div>
							<div class="info-contentr">
								<h5>Email Address:</h5>
								<p>{{$details->email}}</p>
							</div>
						</div>

						<div class="single-info wow fadeInUp">
							<script src="https://platform.linkedin.com/badges/js/profile.js" type="text/javascript" async defer></script>
							<div class="badge-base LI-profile-badge" data-locale="en_US" data-size="medium" data-theme="light" data-type="VERTICAL" data-vanity="vijaykumardvk" data-version="v1">
								<a class="badge-base__link LI-simple-link" href="https://in.linkedin.com/in/vijaykumardvk?trk=profile-badge"></a>
							</div>
						</div>
			
					</div>
				</div>
				<!--/.row-->
			</div>
			<!--/.container-->
		</div>
		<!-- Contact Area End -->

	</div>
</div>
<!-- Main Content Area End -->

@endsection