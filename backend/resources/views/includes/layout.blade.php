<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<title> {{$title}} </title>
	<meta name="description" content="{{$description}}">
	<meta name="keywords" content="{{$keywords}}">
	<link rel="canonical" href="{{url()->current()}}">

	
	@if(request()->ip() != '127.0.0.1' && request()->ip() != '::1')
	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-JVW2TE5WDD"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'G-JVW2TE5WDD');
	</script>
	@endif

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.7.2/css/all.min.css" integrity="sha512-3M00D/rn8n+2ZVXBO9Hib0GKNpkm8MSUU/e2VNthDyBYxKWG+BftNYYcuEjXlyrSO637tidzMBXfE7sQm0INUg==" crossorigin="anonymous" referrer-policy="no-referrer">

	<link rel="shortcut icon" href="{{url('images/favicon.png')}}" type="image/x-icon">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	{{-- <link rel="stylesheet" href="{{url('css/bootstrap.min.css')}}"> --}}
	<link rel="stylesheet" href="{{url('css/plugin.css')}}">
	<link rel="stylesheet" href="{{url('css/style.css')}}">
	<link rel="stylesheet" href="{{url('css/responsive.css')}}">

	@if(request()->ip() != '127.0.0.1' && request()->ip() != '::1')
	<!-- Open Graph / Facebook -->
	<meta property="og:type" content="website">
	<meta property="og:url" content="https://www.vijaykumardvk.com/">
	<meta property="og:title" content="Find the Best Web Developer in Madurai | Vijay Kumar DVK">
	<meta property="og:description" content="Vijay Kumar DVK: Expert Web Developer with 6+ years in Madurai, India. Specializing in PHP, MySQL, HTML, CSS, Jquery, and JavaScript for top-notch web development services.">
	<meta property="og:image" content="{{url('images/index.png')}}">

	<!-- Twitter -->
	<meta property="twitter:card" content="summary_large_image">
	<meta property="twitter:url" content="https://www.vijaykumardvk.com/">
	<meta property="twitter:title" content="Find the Best Web Developer in Madurai | Vijay Kumar DVK">
	<meta property="twitter:description" content="Vijay Kumar DVK: Expert Web Developer with 6+ years in Madurai, India. Specializing in PHP, MySQL, HTML, CSS, Jquery, and JavaScript for top-notch web development services.">
	<meta property="twitter:image" content="{{url('images/index.png')}}">
	<meta name="author" content="Vijay Kumar DVK">

	<script type='application/ld+json'> 
	{
		"@context": "http://www.schema.org",
		"@type": "WebSite",
		"name": "Vijay Kumar DVK",
		"alternateName": "Find the Best Web Developer in Madurai | Vijay Kumar DVK",
		"url": "https://www.vijaykumardvk.com/"
	}
	</script>
	@endif

	@yield('styles')
</head>

<body>
	<!-- preloader area start -->
	<div class="preloader" id="preloader">
		<div class="loader loader-1">
			<div class="loader-outter"></div>
			<div class="loader-inner"></div>
		</div>
	</div>
	<!-- preloader area end -->

	<!--Main-Menu Area Start-->
	<div class="side-menu-wrapper">
		<div class="menu-toogle-icon">
			<div id="nav-icon3">
				<span></span>
				<span></span>
				<span></span>
				<span></span>
			</div>
		</div>
		<div class="side-menu">
			<div class="heading-area">
				<a href="{{url('/')}}" class="profile-photo">
					<img src="{{url('images/logo.jpg')}}" alt="Vijay Kumar DVK" class="wow zoomIn" data-wow-delay="0.2s" width="130" height="130">
				</a>
				<div class="name wow fadeInUp" data-wow-delay="0.3s">Vijay Kumar DVK</div>
			</div>
			<ul id="mainmenu-area">
				<li class="current">
					<a href="#home" class="wow fadeInUp" data-wow-delay="0.4s"><i class="fas fa-home"></i>Home</a>
				</li>
				<li>
					<a href="#about" class="wow fadeInUp" data-wow-delay="0.4s"><i class="fas fa-user"></i>About</a>
				</li>
				<li>
					<a href="#service" class="wow fadeInUp" data-wow-delay="0.4s"><i class="fas fa-briefcase"></i>Services</a>
				</li>
				<li>
					<a href="#project-gallery" class="wow fadeInUp" data-wow-delay="0.4s"><i class="fas fa-layer-group"></i>Portfolio</a>
				</li>
				<li>
					<a href="#certification" class="wow fadeInUp" data-wow-delay="0.4s"><i class="fas fa-award"></i>Certifications</a>
				</li>
				<li>
					<a href="#resume" class="wow fadeInUp" data-wow-delay="0.4s"><i class="fas fa-file-alt"></i>Resume</a>
				</li>
				<li>
					<a href="#contact" class="wow fadeInUp" data-wow-delay="0.4s"><i class="fab fa-whatsapp"></i>Contact</a>
				</li>
			</ul>
		</div>
	</div>
    <!--Main-Menu Area Start-->
    
    @yield('content')

    <!-- Back to Top Start -->
	<div class="bottomtotop">
		<i class="fas fa-chevron-right"></i>
	</div>
	<!-- Back to Top End -->
	
	<script src="{{url('js/jquery.js')}}"></script>
	<script src="{{url('js/popper.min.js')}}"></script>
	<script src="{{url('js/bootstrap.min.js')}}"></script>
	<script src="{{url('js/plugin.js')}}"></script>
	<script src="{{url('js/jQuery-plugin-progressbar.js')}}"></script>
	<script src="{{url('js/typed.min.js')}}"></script>
	<script src="{{url('js/wow.js')}}"></script>
	<script src="{{url('js/main.js')}}"></script>

	@yield('scripts')

	<script>
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': '{{ csrf_token() }}'
			}
		});

		const base_url = "{{ url('/') }}";

		$("#contact-form").submit(function(e) {
			e.preventDefault();
			$("#contact-form button").attr("disabled", true);
			$("#contact-form button .text").text("Please wait");
			$("#contact-form .spinner-border").removeClass('d-none');
			$("#contact-form .alert-danger").hide();
			$("#contact-form .alert-success").hide();
			
			$.ajax({
				url: base_url+"/send-enquiry",
				method: 'post',
				dataType: 'json',
				data: $("#contact-form").serialize(),
				error: function(data) {
					if(data.status === 422) {
						var message = JSON.parse(data.responseText);

						$.each(message, function(key, value) {
							name = value.name ?? '';
							email = value.email ?? '';
							phone = value.phone ?? '';
							subject = value.subject ?? '';
							message = value.message ?? '';
						});

						$(".name-error").text(name);
						$(".email-error").text(email);
						$(".phone-error").text(phone);
						$(".subject-error").text(subject);
						$(".message-error").text(message);
					} else {
						$("#contact-form .alert-danger").show();
					}
				},
				success: function(data) {
					if (data.status == "success") {
						$("#contact-form .error-message").hide();
						$("#contact-form .alert-success").show();
						$("#contact-form").trigger("reset");
					}
				},
				complete: function() {
					$("#contact-form button").attr("disabled", false);
					$("#contact-form button .text").text("Send Message");
					$("#contact-form .spinner-border").addClass('d-none');
				}
			});
		});
	</script>

	@if(request()->ip() != '127.0.0.1' && request()->ip() != '::1')
	<!--Start of Tawk.to Script-->
    <script>
		var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
		(function(){
		var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
		s1.async=true;
		s1.src='https://embed.tawk.to/633541c437898912e96be7f2/1ge40hqsp';
		s1.charset='UTF-8';
		s1.setAttribute('crossorigin','*');
		s0.parentNode.insertBefore(s1,s0);
		})();
    </script>
    <!--End of Tawk.to Script-->
	@endif
	
</body>

</html>