@if(isset($skills) && $skills->count() > 0)
<section id="skills" class="skills section-bg">
    <div class="container" data-aos="fade-up">
  
      <div class="section-title">
        <h2>Skills</h2>
        <p>{!! $about->skills_summery ?? '' !!}</p>
      </div>
      <div class="row skills-content">
        @if($skills->count() > 0)
            @foreach ($skills as $skil)
              <?php 
                $rskil = $skil->skill; 
                $backGround  = (!empty($rskil->background_color) && $rskil->background_color != 'rgb(255, 255, 255)' ) ? $rskil->background_color : 'current';
              ?>
              <div class="col-lg-6">
                <div class="progress">
                  <span class="skill" style="color: {{$backGround}}"> <i class="{{$rskil->icon ?? ''}}"></i> {{ $rskil->skill ?? '' }} <i class="val">{{$skil->skill_accuracy ?? '' }}%</i></span>
                  <div class="progress-bar-wrap">
                    <div class="progress-bar" style="background-color: {{$backGround}} " role="progressbar" aria-valuenow="{{$skil->skill_accuracy}}" aria-valuemin="0" aria-valuemax="100">
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