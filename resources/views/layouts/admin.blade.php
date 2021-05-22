<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="{{ asset('logo.png') }}" type="image/x-icon">
    <title>{{ isset($title) ? $title . ' | ' : '' }} {{ config('app.name') }} </title>
    <!-- Custom fonts for this template-->
    <link href="{{ asset('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/swal2.v11/sweetalert2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/jquery.toast/jquery.toast.min.css') }}" />
    <!-- Custom styles for this template-->
    <link href="{{ asset('common/common.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/sb-admin-2.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/custom-admin.css') }}" rel="stylesheet">
    <script>
        var getEmailServices = "{{ route('email-services.index') }}";

    </script>
</head>

<body id="page-top">
    <header class="urp_header">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container-fluid px-5 justify-content-between">
                <div class="d-flex justify-content-between w-100">
                    <a class="navbar-brand" href="#">
                        <img src="{{ asset('logo-t.png') }}" width="35" height="35" class="d-inline-block align-top"
                            alt="">
                        {{ config('app.name') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
                        aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
                <div class="d-block d-md-inline header-inner">
                    <div class="collapse navbar-collapse" id="navbarText">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="{{\URL::to('/')}}">Welcome</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('login')}}">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('register')}}">Register</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Begin Page Content -->
                @yield('content')
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
            @include('admin.include.footer')
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('backend/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Core plugin JavaScript-->
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('backend/js/sb-admin-2.min.js') }}"></script>
    <!-- Page level plugins -->
    <script type="text/javascript" src='{{ asset('vendor/swal2.v11/sweetalert2.min.js') }}'></script>
    <script type="text/javascript" src='{{ asset('vendor/jquery.validate/jquery.validate.min.js') }}'></script>
    <script type="text/javascript" src='{{ asset('vendor/jquery.validate/additional-methods.min.js') }}'></script>
    <script src="{{ asset('vendor/jquery.toast/jquery.toast.min.js') }}"></script>
    <script src="{{ asset('common/helpers.js') }}"></script>
    <script src="{{ asset('backend/js/custom-admin.js') }}"></script>
    @yield('scripts')
</body>

</html>
