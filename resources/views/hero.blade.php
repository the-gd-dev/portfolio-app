<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex flex-column justify-content-center"
    style="background-image: url('{{ asset('storage/home-banners/' . $bg_banner) ?? '' }}')">
    <div class="container" data-aos="zoom-in" data-aos-delay="100">
        <h1>{{ $display_name ?? '' }}</h1>
        <p>I'm <span class="typed" style="text-transform: capitalize;" data-typed-items="{{ implode(', ', $work_profiles) }}"></span></p>
        <div class="social-links">
            <a href="{{ $twitter ?? 'Javascript:void(0);' }}" class="twitter"><i class="bx bxl-twitter"></i></a>
            <a href="{{ $facebook ?? 'Javascript:void(0);' }}" class="facebook"><i class="bx bxl-facebook"></i></a>
            <a href="{{ $instagram ?? 'Javascript:void(0);' }}" class="instagram"><i class="bx bxl-instagram"></i></a>
            <a href="{{ $skype ?? 'Javascript:void(0);' }}" class="google-plus"><i class="bx bxl-skype"></i></a>
            <a href="{{ $linkedin ?? 'Javascript:void(0);' }}" class="linkedin"><i class="bx bxl-linkedin"></i></a>
        </div>
    </div>
</section><!-- End Hero -->
