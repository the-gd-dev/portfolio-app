@extends('layouts.admin')
@section('content')
    <script>
        const loginResponseHandle = {
            handleSuccess: function(response) {
                if (response.status) {
                    toasterMsg({
                        heading: 'Registered Successfully.',
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
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-6  col-xl-4">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                    </div>
                    <form class="user" action="{{route('register')}}" id="registerForm" method="POST">
                        
                        <div class="form-group">
                            <input type="text" name="first_name" required autocomplete="" class="form-control form-control-user" id="exampleFirstName"
                                placeholder="First Name">
                        </div>
                        <div class="form-group">
                            <input type="text" name="last_name" required autocomplete="" class="form-control form-control-user" id="exampleLastName"
                                placeholder="Last Name">
                        </div>
                        <div class="form-group">
                            <input type="text" name="username" required autocomplete="" class="form-control form-control-user" id="exampleLastName"
                                placeholder="Username">
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" required autocomplete="" class="form-control form-control-user" id="exampleInputEmail"
                                placeholder="Email Address">
                        </div>
                        
                        <div class="form-group">
                            <input name="password" required autocomplete="" type="password" class="form-control form-control-user" id="exampleInputPassword"
                                placeholder="Password">
                        </div>
                        <div class="form-group">
                            <input name="password_confirmation" required autocomplete="" type="password" class="form-control form-control-user" id="exampleRepeatPassword"
                                placeholder="Repeat Password">
                        </div>
                     
                        <button class="btn btn-primary btn-user btn-block" onclick="$('#registerForm').ajaxForm(loginResponseHandle);">
                            <div class="spinner-border spinner-border-sm" role="status" style="display:none;">
                                <span class="sr-only">Loading...</span>
                            </div>
                            Register
                        </button>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <a data-toggle="tooltip" title="register with google" href="Javascript:void(0);" data-href="{{ route('social.oauth', 'google') }}"  class="btn btn-google btn-user btn-block social-btn">
                                    <i class="fab fa-google fa-fw"></i>  
                                            <span class="text-google">Google</span>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a data-toggle="tooltip" title="register with facebook" href="Javascript:void(0);" data-href="{{ route('social.oauth', 'facebook') }}" class="btn btn-facebook btn-user btn-block social-btn">
                                    <i class="fab fa-facebook fa-fw"></i>
                                    <span class="text-facebook">Facebook</span>
                                </a>
                            </div>
                            {{-- <div class="col-md-4">
                                <a data-toggle="tooltip" title="register with linkedin" 
                                    href="Javascript:void(0);" data-href="{{ route('social.oauth', 'linkedin') }}" class="btn btn-facebook btn-user btn-block social-btn">
                                    LinkedIn <i class="fab fa-linkedin fa-fw"></i>
                                </a>
                            </div> --}}
                        </div>
                       
                       
                    </form>
                    <hr>
                    <div class="text-center">
                        <a class="small" href="{{route('login')}}">Already have an account? Login!</a>
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
                    win = window.open(oAuthURL, 'SomeAuthentication', 'width=972,height=660,modal=yes,alwaysRaised=yes');
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
