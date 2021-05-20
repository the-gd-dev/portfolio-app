@if(isset($resume) && $resume->show_section == '1')
<section id="resume" class="resume">
    <div class="container" data-aos="fade-up">
        <div class="section-title">
            <h2>Resume</h2>
            <p>{!! $resume->resume_summery ?? '' !!}</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-6">
                <h3 class="resume-title">Sumary</h3>
                <div class="resume-item pb-0">
                    <h4 class="text-capitalized">{{ $display_name }}</h4>
                    <p><em> {!! $about->about_summery ?? '' !!}</em></p>
                    <ul>
                        @if (isset($about->city))
                            <li><span>{{ $about->city }}</span></li>
                        @endif
                        @if ($about->phone)
                            <li><span>+{{ json_decode($about->country_code)->dialCode }} {{ $about->phone }}</span>
                            </li>
                        @endif
                        @if ($about->email)
                            <li><span>{{ $about->email }}</span></li>
                        @endif
                    </ul>
                </div>
                @if ($resume->qualifications->where('is_shown', '1')->count() > 0)
                    <h3 class="resume-title">Education</h3>
                    @foreach ($resume->qualifications as $education)
                        @php
                            $fromDate = null;
                            $toDate = null;
                            if (!empty($education->from_date)) {
                                $fromDate = date('Y', strtotime($education->from_date));
                            }
                            if (!empty($education->to_date)) {
                                $toDate = date('Y', strtotime($education->to_date));
                            }
                        @endphp
                        @if ($education->is_valid)
                            <div class="resume-item">
                                <h4 class="text-uppercase">{{ $education->course }}</h4>
                                @if (!empty($fromDate))
                                    <h5>{{ $fromDate }} - {{ $toDate }}</h5>
                                @endif
                                <p><em>{{ $education->institute }}</em></p>
                                <p>{!! $education->course_description !!}</p>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
            <div class="col-lg-6">
                @if ($resume->experiences->where('is_shown', '1')->count() > 0)
                    <h3 class="resume-title">Professional Experience</h3>
                    @foreach ($resume->experiences as $experience)
                        @php
                            $fromDate = null;
                            $toDate = 'Present';
                            if (!empty($experience->from_date)) {
                                $fromDate = date('Y', strtotime($experience->from_date));
                            }
                            if (!empty($experience->to_date)) {
                                $toDate = date('Y', strtotime($experience->to_date));
                            }
                            
                        @endphp
                        @if ($experience->is_valid)
                            <div class="resume-item">
                                <h4>{{ $experience->position }}</h4>
                                @if (!empty($fromDate))
                                    <h5>{{ $fromDate }} - {{ $toDate }}</h5>
                                @endif
                                <p><em>{{ $experience->company_name }}</em></p>
                                {!! $experience->responsibilities !!}
                            </div>
                        @endif
                    @endforeach
                @endif

            </div>
        </div>

    </div>
</section>
@endif
