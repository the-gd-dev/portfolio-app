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
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Leaving So Soon ?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Please logout by clicking on "Logout" button.
                    <br />
                    We'll be waiting for you.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <input class="btn btn-primary" type="submit" value="Logout" />
                    </form>
                </div>
            </div>
        </div>
    </div>
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
