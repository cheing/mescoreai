@extends('layouts.app')

@section('content')
<div class="hero_main wf100">
  <div class="container text-center">
    <h2>{{ __('messages.text_football_livestream') }}</h2>
    <div class="iframe-container">

      <iframe src="https://me88livestreaming.com/live?mode=s1" title="Live Streaming" frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
        scrolling="no" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
      </iframe>

    </div>
    <img src="{{asset('images/banner.gif')}}" class="banner" />

    <div class="d-flex justify-content-center align-items-center mt-4">
      <a href="https://playme1.asia/register?affid=5678" class="btn btn-primary text-uppercase mr-4">{{
        __('messages.btn_bet_now')
        }}<div class="fill-one">
        </div>
      </a>
      <a href="{{route('matches')}}" class="btn btn-primary text-uppercase">{{ __('messages.btn_match_prediction')
        }} <div class="fill-two">
        </div>
      </a>
    </div>
  </div>
</div>
<!--Main Content Start-->
<div class="main-content wf100">
  <!--Sports Intro Start-->
  <section class="wf100 p80 bg-dark">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12">
          <div class="section-title white">
            <h2>{{ __('messages.text_welcome_to_me_scoreAI')
              }} </h2>
          </div>
          <ul class="list-1 text-white">
            {!! __('messages.text_welcome_content') !!}

            {{-- <li>
              99% of fans don't know about this AI football prediction
            </li>
            <li>This prediction has an accuracy rate of over 85%</li>
            <li>
              After extensive research and testing, AI football
              predictions, me scoreAI have been launched
            </li>
            <li>
              Currently, me scoreAI relies on big data analysis and AI
              filtering algorithms, achieving a hit rate of over 85%
            </li>
            <li>
              Most of the data comes from the API-Football provided by the
              Rapid API platform
            </li>
            <li>
              Through AI algorithm deductions, me scoreAI directly
              provides predictions and explanations in a simplified form.
            </li>
            <li>
              Some players have already earned a good income through AI
              football predictions.
            </li>
            <li>
              Joining me scoreAI, you can get accurate football
              predictions and watch live football matches for free.
            </li> --}}
          </ul>
          <div class="d-flex align-items-center justify-content-center">
            <a href="https://t.me/mescoreai/" class="m-4 btn-primary text-uppercase">{{ __('messages.btn_hurry')
              }}</a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--Sports Intro End-->
  <!--Sports Video Start-->
  <section class="team-squad wf100 p80-50">
    <div class="container">
      <div class="d-flex justify-content-center align-items-center">
        <video controls class="video" muted poster="{{asset(__('media.poster'))}}">
          <source src="{{ asset(__('media.videoSrc')) }}?v=20240521" type="video/mp4" />
        </video>
      </div>
    </div>
  </section>
  <!--Sports Video End-->

  <!--Plan Start-->
  <section class="plan wf100 p80">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12">
          <div class="text-center">
            <h2 class="text-uppercase">{{ __('messages.text_our_plan')
              }} </h2>
            <p>{{ __('messages.text_plan_desc')
              }}
            </p>
          </div>
        </div>
      </div>
      <table class="tb-plan mt-4">
        <thead>
          <tr>
            <th>{{ __('messages.text_lifetime_subscription')
              }} <br />
              <img src="images/logo-white.png" style="max-height: 24px" />
            </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th>
              {{
              __('messages.text_deposit_50')
              }}
              <hr />
              {{
              __('messages.text_full_access')
              }}
            </th>
          </tr>
          <tr>
            <td><br /> {{
              __('messages.text_package_info_1')
              }}</td>
          </tr>
          <tr>
            <td> {{
              __('messages.text_package_info_2')
              }}</td>
          </tr>
          <tr>
            <td> {{
              __('messages.text_package_info_3')
              }}</td>
          </tr>
          <tr>
            <td>{{
              __('messages.text_package_info_4')
              }}</td>
          </tr>
          <tr>
            <td>{{
              __('messages.text_package_info_5')
              }}</td>
          </tr>
          <tr>
            <td>{{
              __('messages.text_package_info_6')
              }}</td>
          </tr>
          <tr>
            <td>{{
              __('messages.text_package_info_7')
              }}</td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td>
              <a href="https://playme1.asia/register?affid=5678" class="btn btn-primary btn-animate"
                style="text-transform: inherit">
                {{
                __('messages.btn_deposit')
                }}
              </a>
            </td>
          </tr>
        </tfoot>
      </table>
    </div>
  </section>

  <!--Subscription start-->
  <section class="subscription wf100 p40">
    <div class="container">
      <div class="d-flex  flex-column flex-md-row  justify-content-between align-items-center">
        <div class="title d-flex flex-column justify-content-center text-center text-md-left">
          <h1>{{
            __('messages.text_subscription')
            }}</h1>
          <p>{{
            __('messages.text_subscription_desc')
            }}</p>
        </div>
        <div class="button">
          @auth
          <a data-toggle="modal" data-target="#modalSubscription" class="btn btn-primary text-uppercase">{{
            __('messages.btn_subscription')
            }}</a>
          @endauth
          @guest
          <a data-toggle="modal" data-target="#modalLogin" class="btn btn-primary text-uppercase">{{
            __('messages.btn_subscription')
            }}</a>
          @endguest
        </div>
      </div>
    </div>
  </section>
  <!--Subscription end-->
</div>
<!--Main Content End-->
@endsection

@section('footer')
<script src="https://polyfill.io/v3/polyfill.min.js?features=IntersectionObserver"></script>

<script>
  document.addEventListener("DOMContentLoaded", function() {
      var videoElement = document.querySelector('video');
  
      // Options for the observer (which part of the screen to observe)
      var options = {
          root: null, // Observing in relation to the viewport
          rootMargin: '0px',
          threshold: 0.5 // Trigger if 50% of the video is visible
      };
  
      // Callback function to execute when visibility changes
      var observer = new IntersectionObserver(function(entries, observer) {
          entries.forEach(entry => {
              if (entry.isIntersecting) {
                  // Play the video if the video is visible
                  videoElement.play();
              } else {
                  // Pause the video if the video is not visible
                  videoElement.pause();
              }
          });
      }, options);
  
      // Observe the video element
      observer.observe(videoElement);
  });
</script>


@endsection