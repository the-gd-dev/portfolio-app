<section id="about" class="about">
    <div class="container" data-aos="fade-up">

        <div class="section-title">
            <h2>About</h2>
            <p>{!! $about->about_summery ?? '' !!}</p>
        </div>

        <div class="row">
            <div class="col-lg-4 justify-content-end text-right">
                <img style="
                object-fit: scale-down;
            " src="{{ isset($about->about_image) ?  asset('storage/about-images/' . $about->about_image) : '' }}" height="350" width="300" alt="">
            </div>
            <div class="col-lg-8 pt-4 pt-lg-0 content">
                <h3 class="text-capitalize">{{  isset($work_profiles) ? implode(', ', $work_profiles) : ''}}</h3>
                <p class="fst-italic">
                    {!! $about->work_profiles_summery ?? '' !!}
                </p>
                <div class="row">
                    <div class="col-lg-6">
                        <ul>
                            @if (isset($about->birthday))
                            <li><i class="bi bi-chevron-right"></i> <strong>Birthday:</strong>
                                <span>{!! $about->birthday !!}</span>
                            </li>
                            @endif
                            @if (isset($about->website))
                                <li><i class="bi bi-chevron-right"></i> <strong>Website:</strong>
                                    <span>{{ $about->website }}</span>
                                </li>
                            @endif
                            @if (isset($about->phone))
                                <li><i class="bi bi-chevron-right"></i> <strong>Phone:</strong>
                                    <span>+{{ json_decode($about->country_code)->dialCode }} {{ $about->phone }}</span></li>
                            @endif
                            @if (isset($about->city))
                                <li><i class="bi bi-chevron-right"></i> <strong>City:</strong>
                                    <span>{{ $about->city }}, {{ json_decode($about->country_code)->name }}</span></li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <ul>
                            <li><i class="bi bi-chevron-right"></i> <strong>Age:</strong> <span>{{ $about->age }}</span></li>
                            @if (isset($about->degree))
                                <li><i class="bi bi-chevron-right"></i> <strong>Degree:</strong>
                                    <span>{{ $about->degree }}</span>
                                </li>
                            @endif
                            @if (isset($about->email))
                                <li><i class="bi bi-chevron-right"></i> <strong>Email:</strong>
                                    <span>{{ $about->email }}</span>
                                </li>
                            @endif
                            @if (isset($about->freelancer))
                                <li><i class="bi bi-chevron-right"></i> <strong>Freelance:</strong>
                                    <span>
                                        @switch($about->freelancer)
                                            @case(0)
                                                Not Available
                                            @break
                                            @case(1)
                                                Available
                                            @break
                                            @case(2)
                                                Sometimes
                                            @break
                                            @default
                                        @endswitch
                                    </span>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>
