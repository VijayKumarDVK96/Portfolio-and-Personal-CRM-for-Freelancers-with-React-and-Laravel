<!DOCTYPE html>

<html lang="en-US">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,900" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('maintenance/css/style.css')}}" type="text/css">

    <title>Coming Soon</title>

</head>

<body class=" frame">

<div id="outer-wrapper" class="animate translate-z-in">
    <div id="inner-wrapper">
        <div id="table-wrapper" class="center">
            <div class="container">
                <div id="row-header">
                    <header><a href="#" id="brand" class="animate animate fade-in animation-time-3s"><img src="{{asset('images/logo.jpg')}}" width="200px" alt=""></a></header>
                </div>
                <!--end row-header-->
                <div id="row-content">
                    <div id="content-wrapper">
                        <div id="content" class="animate translate-z-in animation-time-2s delay-03s">
                            <h1>I am Coming Soon!</h1>
                            <h2 class="opacity-70">I am working hard to bring you new experience</h2>
                        </div>
                        <!--end content-->
                    </div>
                    <!--end content-wrapper-->
                </div>
                <!--end row-content-->
            </div>
            <!--end container-->
        </div>
        <!--end table-wrapper-->
        <div class="background-wrapper has-vignette">
            <div id="particles-js"></div>
            <div class="bg-transfer opacity-70"><img src="{{asset('maintenance/images/background.jpg')}}" alt=""></div>
        </div>
        <!--end background-wrapper-->
    </div>
    <!--end inner-wrapper-->
</div>
<!--end outer-wrapper-->

<div class="backdrop"></div>

<script src="{{asset('js/jquery.js')}}"></script>
<script src="{{asset('maintenance/js/particles.min.js')}}"></script>
<script src="{{asset('maintenance/js/custom.js')}}"></script>
<script>
    particlesJS.load("particles-js", "{{asset('maintenance/js/particles-spark.json')}}");
</script>



</body>

