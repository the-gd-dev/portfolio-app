@if(isset($portfolio_settings) && isset($portfolio_settings->hide_portfolio) && $portfolio_settings->hide_portfolio->value == '0')
    <section id="portfolio" class="portfolio section-bg">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>Portfolio</h2>
                <p></p>
            </div>

            <div class="row">
                <div class="col-lg-12 d-flex justify-content-center" data-aos="fade-up" data-aos-delay="100">
                    <ul id="portfolio-flters">
                        @if ($pcats->count() > 0)
                            <li data-filter="*" class="filter-active">All</li>
                            @foreach ($pcats as $pcat)
                                <li data-filter=".{{ str_replace(' ', '-', strtolower($pcat->name)) }}">
                                    {{ $pcat->name }}</li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>

            <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">
                @if ($portfolios->count() > 0)
                    @foreach ($portfolios as $portfolio)
                        <div class="col-lg-4 col-md-6 portfolio-item {{ str_replace(' ', '-', strtolower($portfolio->category->name)) }}">
                            <div class="portfolio-wrap">
                                @php
                                    $porfolioCoverImage = (isset($portfolio->portfolio_image) && !empty($portfolio->portfolio_image)) ? $portfolio->portfolio_image->name : '';
                                @endphp
                                <img src="{{ asset('storage/portfolio-images/'.$user_id.'/'. $porfolioCoverImage) }}" class="img-fluid" alt="">
                                <div class="portfolio-info">
                                    <h4>{{$portfolio->name ?? ''}}</h4>
                                    {{-- <p>{{$portfolio->description ?? ''}}</p> --}}
                                    <div class="portfolio-links">
                                        <a href="{{ asset('storage/portfolio-images/'.$user_id.'/'. $porfolioCoverImage) }}"
                                            data-gallery="portfolioGallery" class="portfolio-lightbox" title="{{$portfolio->name ?? ''}}"><i
                                                class="bx bx-plus"></i></a>
                                        <a href="{{route('project.show',$portfolio->id)}}" class="portfolio-details-lightbox"
                                            data-glightbox="type: external" title="Portfolio Details"><i
                                                class="bx bx-link"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif


            </div>

        </div>
    </section>
@endif
