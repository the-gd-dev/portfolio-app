<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="">
    <link rel="shortcut icon" href="{{ asset('logo-b-s.png') }}" type="image/x-icon">
    <title>{{ isset($title) ? $title . ' | ' : '' }} {{ config('app.name') }}</title>
    <!-- Custom fonts for this template-->
    <link href="{{ asset('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/devicons/devicon@v2.11.0/devicon.min.css">

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('vendor/swal2.v11/sweetalert2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/jquery.toast/jquery.toast.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/jquery-ui/jquery-ui.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/select2/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/TeleInput/css/intlTelInput.min.css') }}">

    <!-- Custom styles for this template-->
    <link href="{{ asset('backend/css/sb-admin-2.css') }}" rel="stylesheet">
    <link href="{{ asset('common/common.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/vendor/color-picker/css/bcPicker.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/custom.css') }}" rel="stylesheet">
    <style>
        button .spinner-border-sm {
            position: relative;
            top: -3px;
        }
    </style>
    <script>var getEmailServices = "{{ route('email-services.index') }}";</script>
    <script src="{{ asset('backend/vendor/jquery/jquery.min.js') }}"></script>
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        @include('admin.include.sidebar')
        <!-- End of Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                @include('admin.include.header')
                <!-- End of Topbar -->
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

    <!-- Bootstrap core JavaScript-->
  
    <script src="{{ asset('vendor/TeleInput/js/intlTelInput-jquery.js') }}"></script>
    <script src="https://cdn.ckeditor.com/4.16.0/basic/ckeditor.js"></script>
    <script src="{{ asset('backend/vendor/color-picker/js/bcPicker.js') }}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{ asset('backend/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('backend/js/sb-admin-2.min.js') }}"></script>
    <!-- Page level plugins -->
    <script type="text/javascript" src='{{ asset('vendor/swal2.v11/sweetalert2.min.js') }}'></script>
    <script type="text/javascript" src='{{ asset('vendor/jquery.validate/jquery.validate.min.js') }}'></script>
    <script type="text/javascript" src='{{ asset('vendor/jquery.validate/additional-methods.min.js') }}'></script>
    <script src="{{ asset('vendor/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery.toast/jquery.toast.min.js') }}"></script>
    <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" ></script>
    <script src="{{ asset('backend/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('common/helpers.js') }}"></script>
    <script src="{{ asset('backend/js/custom.js') }}"></script>
    <script src="{{ asset('backend/js/custom-admin.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
            $(".dropzone").on("dragover", function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).removeClass('dropzone-remove');
                $('label.is-invalid-file').remove();
                $(this).find('.dropzone-message').html('Drop it here.');
            });
            $("html").on("dragover", function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).find('.dropzone-message').html('Click Or Drop Your file Here');
            });
            $('.dropzone').on('drop', function(e) {
                e.stopPropagation();
                e.preventDefault();
                $(this).addClass('has-file');
                $(this).find('.dropzone-message').html('Click Or Drop Your file Here').hide();
                $(this).find('input[type="file"]')[0].files = e.originalEvent.dataTransfer.files;
                $(this).find('input[type="file"]').trigger('change');
            });
        })

    </script>

    @yield('scripts')
</body>

</html>
