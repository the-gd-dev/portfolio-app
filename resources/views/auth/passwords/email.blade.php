@extends('layouts.admin')

@section('content')
    <script>
        const loginResponseHandle = {
            handleSuccess: function(response) {
                if (response.message) {
                    toasterMsg({
                        heading: 'Reset Successfully.',
                        text: "Please check your registered email.",
                        bg_color: '#62f764'
                    });
                }

            }
        }
       
    </script>

    <div class="container py-50">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                            <p class="mb-4">We get it, stuff happens. Just enter your email address below
                                and we'll send you a link to reset your password!</p>
                        </div>
                        <form class="user" id="thisForm" method="POST" action="{{ route('password.email') }}">
                            <div class="form-group">
                                <input type="email" name="email" class="form-control form-control-user show-email-services"
                                    required
                                    id="exampleInputEmail" aria-describedby="emailHelp"
                                    placeholder="Enter Email Address...">
                            </div>
                            
                            <button class="btn btn-primary btn-user btn-block"
                                onclick="$('#thisForm').ajaxForm(loginResponseHandle);">
                                <div class="spinner-border spinner-border-sm" role="status" style="display:none;">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                Reset Password
                            </button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="{{route('register')}}">I am in wrong place let me register.</a>
                        </div>

                        <div class="text-center">
                            <a class="small" href="{{route('login')}}">Let me try once again.</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
