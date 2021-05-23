@extends('layouts.admin')
@section('content')
    <script>
        const loginResponseHandle = {
            handleSuccess: function(response) {
                if (response.status) {
                    toasterMsg({
                        heading: response.message,
                        text: "Redirecting to your profile please wait...",
                        bg_color: '#7abfff'
                    });
                    setTimeout(() => {
                        window.location.replace(response.data.url)
                    }, 3000)
                }

            }
        }

    </script>
    <div class="container py-50">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card o-hidden border-0 shadow-lg my-5 rounded-quarter mx-4 mx-md-0">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                            <p class="mb-4">We get it, stuff happens. Just enter your email address below
                                and we'll send you a link to reset your password!</p>
                        </div>
                        <form method="POST" action="{{ route('password.update') }}" id="thisForm"  class="user">
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="form-group">
                                <input id="email" readonly="readonly" type="email" class="form-control form-control-user " name="email"
                                    placeholder="email" value="{{ $email ?? old('email') }}" required autocomplete="email"
                                    autofocus>
                            </div>

                            <div class="form-group ">

                                <input id="password" type="password" class="form-control form-control-user"
                                    placeholder="New Password" name="password" required autocomplete="new-password">
                            </div>

                            <div class="form-group">
                                <input id="password-confirm" type="password" class="form-control form-control-user"
                                    placeholder="Re-Type Password" name="password_confirmation" required
                                    autocomplete="new-password">

                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-12">
                                    <button class="btn btn-primary btn-user btn-block"
                                        onclick="$('#thisForm').ajaxForm(loginResponseHandle);">
                                        <div class="spinner-border spinner-border-sm" role="status" style="display:none;">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        Reset Password
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
