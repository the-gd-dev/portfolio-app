<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>{{ isset($title) ? $title . ' | ' : '' }} {{ config('app.name') }} </title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link rel="shortcut icon" href="{{asset('logo-b-s.png') }}" type="image/x-icon">
    <link href="{{ asset('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/devicons/devicon@v2.11.0/devicon.min.css">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="{{ asset('vendor/jquery.toast/jquery.toast.min.css') }}" />
    <link href="{{ asset('frontend/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('common/common.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">
    <script src="{{ asset('backend/vendor/jquery/jquery.min.js') }}"></script>
</head>

<body>
    <div id="app">
        @if (auth()->user())
        <header class="sticky-header-auth p-2 hide">
            <div class="container-fluid px-4">
                <div class="d-flex justify-content-between">
                    <span><i class="bi bi-list mobile-nav-toggle d-xl-none text-white" style="position: relative;background:transparent;top:0;"></i></span>
                    <div>
                        {{-- <a href="Javascript:void(0);" onclick="window.print();" class="text-white">Print <i class="fa fa-print"></i></a> --}}
                        {{-- <a href="Javascript:void(0);" class="text-white mx-4">Download <i class="fa fa-file-pdf"></i></a> --}}
                        <a href="{{route('admin.my.profile')}}" class="text-white goto-panel"><span><i class="fa fa-user" style="position: initial;"></i></span>  Edit Profile <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </header>
        @endif
        <main class="">
            @yield('content')
        </main>
        <!-- Vendor JS Files -->
        <script src="{{ asset('frontend/vendor/aos/aos.js') }}"></script>
        <script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('frontend/vendor/glightbox/js/glightbox.min.js') }}"></script>
        <script src="{{ asset('frontend/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
        <script src="{{ asset('frontend/vendor/purecounter/purecounter.js') }}"></script>
        <script src="{{ asset('frontend/vendor/swiper/swiper-bundle.min.js') }}"></script>
        <script src="{{ asset('frontend/vendor/typed.js/typed.min.js') }}"></script>
        <script src="{{ asset('frontend/vendor/waypoints/noframework.waypoints.js') }}"></script>
        <!-- Template Main JS File -->
        <script type="text/javascript" src='{{ asset('vendor/jquery.validate/jquery.validate.min.js') }}'></script>
        <script type="text/javascript" src='{{ asset('vendor/jquery.validate/additional-methods.min.js') }}'>
        </script>
        <script src="{{ asset('vendor/jquery.toast/jquery.toast.min.js') }}"></script>
        <script src="{{ asset('common/hf.js') }}"></script>
        <script src="{{ asset('frontend/js/main.js') }}"></script>
        @if (auth()->user())
            <script>
                $(window).on('scroll', function(){
                    const scroll_pos = window.scrollY;
                    $('.sticky-header-auth').removeClass('show').addClass('hide')
                    if(scroll_pos > 0){
                        $('.sticky-header-auth').removeClass('hide').addClass('show')
                        let body = $('body')
                        body.removeClass('mobile-nav-active')
                        $('.mobile-nav-toggle').removeClass('bi-x').addClass('bi-list');
                    }
                })
            </script> 
        @endif
        
        @yield('scripts')
</body>

</html>
