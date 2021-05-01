@extends('layouts.admin')
@section('content')
@section('scripts')
    <script>
        const loginResponseHandle = {
            handleSuccess: function(response) {
                if (response.status) {
                    toasterMsg({
                        heading: 'Login Successfully.',
                        text: "Redirecting you to the home page please wait...",
                        bg_color: '#ce849b'
                    });
                    setTimeout(() => {
                        window.location.replace(response.data.url)
                    }, 3000)
                }

            }
        }
    </script>
@endsection
<div class="row justify-content-center">

    <div class="col-md-6 col-lg-4">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-left pl-1">
                                <h1 class="h4 text-gray-900 mb-3">Welcome Back User</h1>
                            </div>
                            <form class="user" id="loginForm" method="POST" action="{{route('login')}}">
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
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" class="custom-control-input" id="customCheck">
                                        <label class="custom-control-label" for="customCheck">Remember
                                            Me</label>
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-user btn-block" onclick="$('#loginForm').ajaxForm(loginResponseHandle);">
                                    <div class="spinner-border spinner-border-sm" role="status" style="display:none;">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    Login
                                </button>
                                {{-- <hr>
                                <div class="form-group row">
                                    <div class="col-6">

                                        <a href="index.html" class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> Login Google
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                            <i class="fab fa-facebook-f fa-fw"></i> Login Facebook
                                        </a>
                                    </div>
                                </div> --}}

                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="forgot-password.html">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="register.html">Create an Account!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection