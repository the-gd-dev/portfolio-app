
  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="container">
      <h3>{{ $display_name ?? '' }}</h3>
      <p>{!! $about->about_summery ?? '' !!}</p>
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
      <div class="copyright">
        &copy; Copyright <strong><span>UrPortfolio</span></strong>. All Rights Reserved
      </div>
    </div>
  </footer><!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
