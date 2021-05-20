
  <!-- ======= Mobile nav toggle button ======= -->
  <!-- <button type="button" class="mobile-nav-toggle d-xl-none"><i class="bi bi-list mobile-nav-toggle"></i></button> -->
  <i class="bi bi-list mobile-nav-toggle d-xl-none"></i>
  <!-- ======= Header ======= -->
  <header id="header" class="d-flex flex-column justify-content-center">

    <nav id="navbar" class="navbar nav-menu">
      <ul>
        <li><a href="#hero" class="nav-link scrollto active"><i class="bx bx-home"></i> <span>Home</span></a></li>
        <li><a href="#about" class="nav-link scrollto"><i class="bx bx-user"></i> <span>About</span></a></li>
        @if(isset($resume) && $resume->show_section == '1')
          <li><a href="#resume" class="nav-link scrollto"><i class="bx bx-file-blank"></i> <span>Resume</span></a></li>
        @endif
        @if(isset($portfolio_settings) && isset($portfolio_settings->hide_portfolio) && $portfolio_settings->hide_portfolio->value == '0')
          <li><a href="#portfolio" class="nav-link scrollto"><i class="bx bx-book-content"></i> <span>Portfolio</span></a></li>
        @endif
        @if(isset($service_settings) && isset($service_settings->hide_service) && $service_settings->hide_service->value == '0')
          <li><a href="#services" class="nav-link scrollto"><i class="bx bx-server"></i> <span>Services</span></a></li>
        @endif
        @if (isset($contact_settings) && isset($contact_settings->hide_contact_form) && $contact_settings->hide_contact_form->value == '0')

        <li><a href="#contact" class="nav-link scrollto"><i class="bx bx-envelope"></i> <span>Contact</span></a></li>
        @endif
      </ul>
    </nav><!-- .nav-menu -->

  </header><!-- End Header -->

