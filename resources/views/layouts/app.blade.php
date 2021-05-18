<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>{{$title ?? ''}} </title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{asset('frontend/img/favicon.png')}}" rel="icon">
  <link href="{{asset('frontend/img/apple-touch-icon.png')}}" rel="apple-touch-icon">
  <link href="{{ asset('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/devicons/devicon@v2.11.0/devicon.min.css">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.css"
        crossorigin="anonymous" />
  <link href="{{asset('frontend/vendor/aos/aos.css')}}" rel="stylesheet">
  <link href="{{asset('frontend/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('frontend/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('frontend/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('frontend/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <link href="{{asset('frontend/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">
  <link href="{{ asset('common/common.css') }}" rel="stylesheet">
  <link href="{{asset('frontend/css/style.css')}}" rel="stylesheet">
  <script src="{{ asset('backend/vendor/jquery/jquery.min.js') }}"></script>
  
</head>

<body>
    <div id="app">
        <main class="">
            @yield('content')
        </main>
  <!-- Vendor JS Files -->
  <script src="{{asset('frontend/vendor/aos/aos.js')}}"></script>
  <script src="{{asset('frontend/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('frontend/vendor/glightbox/js/glightbox.min.js')}}"></script>
  <script src="{{asset('frontend/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
  <script src="{{asset('frontend/vendor/purecounter/purecounter.js')}}"></script>
  <script src="{{asset('frontend/vendor/swiper/swiper-bundle.min.js')}}"></script>
  <script src="{{asset('frontend/vendor/typed.js/typed.min.js')}}"></script>
  <script src="{{asset('frontend/vendor/waypoints/noframework.waypoints.js')}}"></script>
  <!-- Template Main JS File -->
  <script type="text/javascript"
  src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js'></script>
<script type="text/javascript"
  src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"
  crossorigin="anonymous"></script>
<script src="{{asset('common/hf.js')}}"></script>
  <script src="{{asset('frontend/js/main.js')}}"></script>
  @yield('scripts')
</body>

</html>