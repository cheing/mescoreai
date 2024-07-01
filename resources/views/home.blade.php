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
    <a href="https://me88cash.com/register?affid=5678" class="afflink">
      <img src="{{asset('images/adbanner20240524.gif')}}" class="banner" /></a>

    <div class="row justify-content-center mt-4">
      <div class="col-12 col-md-auto mb-2 mb-md-0">
        <!-- Stacks on small devices, inline on medium and up -->
        <a href="https://me88cash.com/register?affid=5678" class="afflink btn btn-primary text-uppercase w-100">
          {{ __('messages.btn_bet_now') }}
          <div class="fill-one"></div>
        </a>
      </div>
      <div class="col-12 col-md-auto">
        <a href="{{ route('matches') }}" class="btn btn-primary text-uppercase w-100">
          {{ __('messages.btn_match_prediction') }}
          <div class="fill-two"></div>
        </a>
      </div>
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
            @if(isset($text_welcome->title))
            @if(App::getLocale() == 'en')
            <h2> {{ $text_welcome->title}}</h2>
            @else
            <h2> {{$text_welcome->title_zh}}</h2>
            @endif
            @endif

          </div>

          @if(isset($text_welcome->content))
          @if(App::getLocale() == 'en')
          {!! $text_welcome->content !!}
          @else
          {!! $text_welcome->content_zh !!}
          @endif
          @endif
          {{-- <ul class="list-1 text-white">


            {!! __('messages.text_welcome_content') !!}
          </ul>
          <div class="d-flex align-items-center justify-content-center">
            <a href="https://t.me/mescoreai/" class="m-4 btn-primary text-uppercase">{{ __('messages.btn_hurry')
              }}</a>
          </div> --}}
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

      @foreach($packages as $package)
      <table class="tb-plan mt-4">
        <thead>
          <tr>
            <th>
              {{ $package->descriptions['display_name'][App::getLocale()] }}
              <br />
              <img src="images/logo-white.png" style="max-height: 24px" />
            </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th>
              {!! $package->descriptions['short_description'][App::getLocale()] !!}
            </th>
          </tr>
          {!! $package->descriptions['description'][App::getLocale()] !!}
        </tbody>
        <tfoot>
          <tr>
            <td>
              <a href="https://me88cash.com/register?affid=5678" class="btn btn-primary btn-animate afflink"
                style="text-transform: inherit">
                {{
                __('messages.btn_deposit')
                }}
              </a>
            </td>
          </tr>
        </tfoot>
      </table>
      @endforeach

    </div>
  </section>

  <!--Subscription start-->
  @if(auth()->check())
  @if(!auth()->user()->activeSubscription())
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
  @endif
  @else
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
  @endif
  <!--Subscription end-->
</div>
<!--Main Content End-->
<!-- Popup Modal -->
{{-- <div id="popup" class="popup" style="display:none;">
  <img src="{{ asset(__('media.banner_popout')) }}" alt="Popup Image">
  <button onclick="closePopup()">Close</button>
</div> --}}

<div class="modal fade" id="imagePopup" tabindex="-1" role="dialog" aria-labelledby="imagePopupLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="background: transparent">
      <div class="modal-body p-0" style="position: relative">
        <button type="button" class="close" style="color:#fff; position: absolute; right:15px; top:10px"
          data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <a href="https://me88cash.com/register?affid=5678" class="afflink"><img
            src="{{ asset(__('media.banner_popout')) }}" alt="" class="img-fluid"></a>
      </div>
    </div>
  </div>
</div>
@endsection

@section('footer')
<script src="https://polyfill.io/v3/polyfill.min.js?features=IntersectionObserver"></script>

<script>
  $(document).ready(function() {
    // 如果没有其他模态框显示，则延迟5秒显示imagePopup
    setTimeout(function() {
        if ($('.modal.show').length === 0 && $('#imagePopup').data('shown') !== true) {
            $('#imagePopup').modal('show');
            $('#imagePopup').data('shown', true); // 标记imagePopup已显示
        }
    }, 5000);

    // 每次模态框关闭时检查是否需要显示imagePopup
    $('.modal').on('hidden.bs.modal', function () {
        // 确保是imagePopup关闭，并且没有其他模态框是显示状态
        if (this.id === 'imagePopup') {
            // 如果是imagePopup被关闭，不再显示
            $('#imagePopup').data('shown', true); // 确保标记已设置，防止再次显示
        } else if ($('.modal.show').length === 0 && $('#imagePopup').data('shown') !== true) {
            // 如果是其他模态框被关闭，检查是否需要显示imagePopup
            $('#imagePopup').modal('show');
            $('#imagePopup').data('shown', true); // 标记imagePopup已显示
        }
    });
});

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