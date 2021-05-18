@extends('layouts.app')
@section('content')
    <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details bg-light">
      <div class="container">

        <div class="row gy-4 justify-content-center">

          <div class="col-lg-8">
            <div class="portfolio-details-slider swiper-container">
              <div class="swiper-wrapper align-items-center">
                @if (isset($portfolio->images) && $portfolio->images->count() > 0)
                    @foreach ($portfolio->images as $image)
                        <div class="swiper-slide">
                          <img src="{{ asset('storage/portfolio-images/' .$portfolio->user_id . '/' . $image->name) }}" alt="">
                        </div>
                    @endforeach
                @endif
              </div>
              <div class="swiper-pagination"></div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="portfolio-info">
              <h3>Project information</h3>
              <ul>
                <li><strong>Category</strong>: {{  $portfolio->category->name }}</li>
                <li><strong>Client</strong>: {{$portfolio->client_name ?? ''}}</li>
                <li><strong>Project date</strong>: {{ !empty($portfolio->project_date) ? date('d M Y',strtotime($portfolio->project_date)) : 'N/A' }}</li>
                <li><strong>Project URL</strong>: <a href="{{$portfolio->link}}" target="_page">{{  $portfolio->link }}</a></li>
              </ul>
            </div>
            <div class="portfolio-description">
              <h2>Portfolio details</h2>
              <p>
                {!! $portfolio->description ?? '' !!}
              </p>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Portfolio Details Section -->

  </main><!-- End #main -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
@endsection
  