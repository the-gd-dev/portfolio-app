<!doctype html>
<html lang="en">
<head>
    <!--====== Required meta tags ======-->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--====== Title ======-->
    <title>{{ isset($title) ? $title.' | ' : '' }} {{ config('app.name') }} </title>
    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="{{asset('logo-b-s.png')}}" type="image/png">
    <!--====== Bootstrap css ======-->
    <link rel="stylesheet" href="{{asset('landing/css/bootstrap.min.css')}}">
    <!--====== Line Icons css ======-->
    <link rel="stylesheet" href="{{asset('landing/css/LineIcons.css')}}">
    <!--====== Magnific Popup css ======-->
    <link rel="stylesheet" href="{{asset('landing/css/magnific-popup.css')}}">
    <!--====== Default css ======-->
    <link rel="stylesheet" href="{{asset('landing/css/default.css')}}">
    <!--====== Style css ======-->
    <link rel="stylesheet" href="{{asset('landing/css/style.css')}}">
</head>
<body>
    <!--====== HEADER PART START ======-->
    @include('landing.includes.header')
    <!--====== HEADER PART ENDS ======-->
    @yield('content')
    <!--====== FOOTER PART START ======-->
    @include('landing.includes.footer')
    <!--====== FOOTER PART ENDS ======-->
    <!--====== BACK TO TOP PART START ======-->
    <a class="back-to-top" href="#"><i class="lni-chevron-up"></i></a>
    <!--====== BACK TO TOP PART ENDS ======-->
    <!--====== jquery js ======-->
    <script src="{{asset('landing/js/vendor/modernizr-3.6.0.min.js')}}"></script>
    <script src="{{asset('landing/js/vendor/jquery-1.12.4.min.js')}}"></script>
    <!--====== Bootstrap js ======-->
    <script src="{{asset('landing/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('landing/js/popper.min.js')}}"></script>
    <!--====== Scrolling Nav js ======-->
    <script src="{{asset('landing/js/jquery.easing.min.js')}}"></script>
    <script src="{{asset('landing/js/scrolling-nav.js')}}"></script>
    <!--====== Magnific Popup js ======-->
    <script src="{{asset('landing/js/jquery.magnific-popup.min.js')}}"></script>
    <!--====== Main js ======-->
    <script src="{{asset('landing/js/main.js')}}"></script>
</body>

</html>
