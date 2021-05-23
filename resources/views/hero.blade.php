<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex flex-column justify-content-center"
    style="background-image: url('{{ isset($bg_banner) ? asset('storage/home-banners/' . $bg_banner) : '' }}')">
    <div class="container" data-aos="zoom-in" data-aos-delay="100">
        <h1>{{ $display_name ?? '' }}</h1>
        @if(isset($work_profiles)) 
        <p>I'm <span class="typed" style="text-transform: capitalize;" data-typed-items="{{  isset($work_profiles) ? implode(', ', $work_profiles) : '' }}"></span></p>
        @endif
        <div class="social-links">
            @if (isset($facebook ) && !empty($facebook ))
                <a href="{{ $facebook  ?? 'Javascript:void(0);' }}" class="facebook"><i class="bx bxl-facebook"></i></a>
            @endif
            @if (isset($twitter) && !empty($twitter))
                <a href="{{ $twitter ?? 'Javascript:void(0);' }}" class="twitter"><i class="bx bxl-twitter"></i></a>
            @endif
            
            @if (isset($instagram) && !empty($instagram))
                <a href="{{ $instagram ?? 'Javascript:void(0);' }}" class="instagram"><i class="bx bxl-instagram"></i></a>
            @endif
            @if (isset($skype) && !empty($skype))
                <a href="{{ $skype ?? 'Javascript:void(0);' }}" class="skype"><i class="bx bxl-skype"></i></a>
            @endif
            @if (isset($linkedin) && !empty($linkedin))
                <a href="{{ $linkedin ?? 'Javascript:void(0);' }}" class="linkedin"><i class="bx bxl-linkedin"></i></a>
            @endif
       </div>
    </div>
</section><!-- End Hero -->
