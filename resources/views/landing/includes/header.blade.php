<header class="header-area">
    <div class="navgition navgition-transparent">
        <div class="container-fluid px-5">
            <div class="row">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg">
                        <a class="navbar-brand" href="#">
                            <img src="{{ asset('wide-logo-l.png') }}" alt="Logo" style="height: 30px;">
                        </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarOne"
                            aria-controls="navbarOne" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse sub-menu-bar" id="navbarOne">
                            <ul class="navbar-nav m-auto">
                                <li class="nav-item active">
                                    <a class="page-scroll" href="#home">HOME</a>
                                </li>
                                <li class="nav-item">
                                    <a class="page-scroll" href="#service">SERVICES</a>
                                </li>
                                @if (!auth()->user())
                                    <li class="nav-item">
                                        <a class="page-scroll" href="{{route('login')}}">Login</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="page-scroll" href="{{route('register')}}">Register</a>
                                    </li>
                                @else
                                    <li class="nav-item">
                                        <a class="page-scroll" href="{{route('admin.home.index')}}">Admin Panel</a>
                                    </li>  
                                @endif
                                
                            </ul>
                        </div>
                        <div class="navbar-social d-none d-sm-flex align-items-center">
                            <span>FOLLOW US</span>
                            <ul>
                                <li><a href="#"><i class="lni-facebook-filled"></i></a></li>
                                <li><a href="#"><i class="lni-twitter-original"></i></a></li>
                                <li><a href="#"><i class="lni-instagram-original"></i></a></li>
                                <li><a href="#"><i class="lni-linkedin-original"></i></a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div id="home" class="header-hero bg_cover"
        style="background-image: url({{ asset('landing/images/header-bg.jpg') }})">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10">
                    <div class="header-content text-center">
                        <h3 class="header-title">Update your portfolio, resume, profiles. In just a second.</h3>
                        <p class="text">A simple, customizable and beautiful web tool to keep your professional
                            profile updated on the go.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-shape">
            <img src="{{ asset('landing/images/header-shape.svg') }}" alt="shape">
        </div>
    </div>
</header>
