@extends('layouts.landing')
@section('content')
    <!--====== SERVICES PART START ======-->
    <section id="service" class="services-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-title pb-10 text-center text-md-left">
                        <h4 class="title">Crafted For</h4>
                        <p class="text">Stop wasting time on  creating multiple resume and portfolios. Try this its new. Its cool efficient and value of time.</p>
                    </div> 
                </div>
            </div> 
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-left">
                            <div class="services-content mt-40 d-sm-flex">
                                <div class="services-icon">
                                    <i class="lni-user"></i>
                                </div>
                                <div class="services-content media-body">
                                    <h4 class="services-title">Individual</h4>
                                    <p class="text">Employees, Professionals Or just a student.</p>
                                </div>
                            </div> 
                        </div>
                        <div class="col-md-6 text-center text-md-left">
                            <div class="services-content mt-40 d-sm-flex">
                                <div class="services-icon">
                                    <i class="lni-bar-chart"></i>
                                </div>
                                <div class="services-content media-body">
                                    <h4 class="services-title">Business</h4>
                                    <p class="text">Startups, Well established businesses.</p>
                                </div>
                            </div> 
                        </div>
                        <div class="col-md-6 text-center text-md-left">
                            <div class="services-content mt-40 d-sm-flex">
                                <div class="services-icon">
                                    <i class="lni-brush"></i>
                                </div>
                                <div class="services-content media-body">
                                    <h4 class="services-title">Agency</h4>
                                    <p class="text">Service providing agancies.</p>
                                </div>
                            </div> 
                        </div>
                        <div class="col-md-6 text-center text-md-left">
                            <div class="services-content mt-40 d-sm-flex">
                                <div class="services-icon">
                                    <i class="lni-users"></i>
                                </div>
                                <div class="services-content media-body">
                                    <h4 class="services-title">People Group</h4>
                                    <p class="text">Small group of people, joint ventures.</p>
                                </div>
                            </div> 
                        </div>
                    </div> 
                </div> 
            </div> 
        </div>
        <div class="services-image d-lg-flex align-items-center">
            <div class="image">
                <img src="{{asset('landing/images/services.png')}}" alt="Services">
            </div>
        </div> 
    </section>
    <!--====== SERVICES PART ENDS ======-->
    @include('landing.includes.landing-form');
@endsection