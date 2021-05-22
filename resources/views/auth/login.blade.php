@extends('layouts.admin')
@section('content')

    <script>
        const loginResponseHandle = {
            handleSuccess: function(response) {
                if (response.status) {
                    toasterMsg({
                        heading: 'Login Successfully.',
                        text: "Redirecting you to the home page please wait...",
                        bg_color: '#62f764'
                    });
                    setTimeout(() => {
                        window.location.replace(response.data.url)
                    }, 3000)
                }

            }
        }

    </script>
    <div class="py-40">
        <div class="row justify-content-center">

            <div class="col-md-6 col-lg-6 col-xl-4">
                <div class="card o-hidden border-0 shadow-lg my-5 rounded-quarter mx-4 mx-md-0">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-left pl-1">
                                        <h1 class="h4 text-gray-900 mb-3">Welcome Back User</h1>
                                    </div>
                                    <form class="user" id="loginForm" method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="exampleInputEmail"
                                                aria-describedby="emailHelp" placeholder="Email Or Username" name="email">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Password" name="password">
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="custom-control custom-checkbox small">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="customCheck">
                                                        <label class="custom-control-label" for="customCheck">Remember
                                                            Me</label>
                                                    </div>
                                                </div>
                                                <div class="col-6 text-right">

                                                    <a class="" href="{{ route('password.request') }}">Forgot
                                                        Password?</a>

                                                </div>
                                            </div>

                                        </div>
                                        <button class="btn btn-primary btn-user btn-block"
                                            onclick="$('#loginForm').ajaxForm(loginResponseHandle);">
                                            <div class="spinner-border spinner-border-sm" role="status"
                                                style="display:none;">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                            Login
                                        </button>
                                        <hr>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <a data-toggle="tooltip" title="login with google"
                                                    href="Javascript:void(0);"
                                                    data-href="{{ route('social.oauth', 'google') }}" class="social-btn">
                                                    @include('include.google-btn')
                                                    {{-- <span class="g-icon"><img src="{{asset('backend/img/google.png')}}" alt=""></span>
                                                    <span class="g-text">Sign In with Google</span> --}}
                                                </a>
                                            </div>
                                            <div class="col-lg-12">
                                                <a data-toggle="tooltip" title="login with facebook"
                                                    href="Javascript:void(0);" data-placement="bottom"
                                                    data-href="{{ route('social.oauth', 'facebook') }}"
                                                    class="btn btn-facebook  btn-block social-btn">
                                                    <i class="fab fa-facebook fa-fw"></i>
                                                    <span class="text-facebook">Login with Facebook</span>

                                                </a>
                                            </div>
                                            {{-- <div class="col-md-4">
                                            <a data-toggle="tooltip" title="login with linkedin" 
                                                href="Javascript:void(0);" data-href="{{ route('social.oauth', 'linkedin') }}" class="btn btn-facebook btn-user btn-block social-btn">
                                                LinkedIn <i class="fab fa-linkedin fa-fw"></i>
                                            </a>
                                            </div> --}}
                                        </div>

                                    </form>
                                    <hr>

                                    <div class="text-center">
                                        <a class="" href="{{ route('register') }}">Create an Account!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
@section('scripts')
    <script>
        $(function() {
            var win;
            var checkConnect;
            var $connect = $(".social-btn");


            $connect.click(function() {
                var oAuthURL = $(this).data('href');
                win = window.open(oAuthURL, 'SomeAuthentication',
                    'width=972,height=660,modal=yes,alwaysRaised=yes');
            });

            checkConnect = setInterval(function() {
                if (!win || !win.closed) return;
                clearInterval(checkConnect);
                window.location.reload();
            }, 100);
        });
        $('[data-toggle="tooltip"]').tooltip();

    </script>
@endsection
@endsection
