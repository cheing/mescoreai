<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="robots" content="noindex, nofollow">

  <title>me scoreAI: Eurocup Live Streaming 2024</title>
  <meta name="description"
    content="Join me scoreAI now and gain exclusive lifetime access to AI-driven sports predictions and watch Eurocup Live Streaming 2024.">

  <meta name="google-site-verification" content="IRnva_WSWrMdskIk94nIzCviGQST13l6igiOIhs5v2s" />
  <!-- Scripts -->
  <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">

  <!-- Styles -->

  <!-- Favicons -->
  <link rel="icon" href="{{ asset('images/favicon.png?v=1') }}" type="image/png" />
  {{--
  <link href="{{ asset('images/favicon.png') }}" rel="icon"> --}}
  {{--
  <link href="{{ asset('images/favicon.png') }}" rel="apple-touch-icon"> --}}

  <!-- Vendor CSS Files -->
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/fontawesome.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('vendor/jquery-confirm-master/css/jquery-confirm.css') }}" />
  <!-- Template Main CSS File -->
  <link href="{{ asset('css/custom.css?v=9') }}" rel="stylesheet">
  <link href="{{ asset('css/responsive.css?v=6') }}" rel="stylesheet">
  <link href="{{ asset('css/color.css') }}" rel="stylesheet">
</head>

<body>
  <!--Wrapper Start-->
  <div class="wrapper">


    <!--Header Start-->
    <header id="main-header" class="main-header">
      <!--topbar-->
      <div class="topbar">
        <div class="container">
          <div class="d-flex justify-content-end align-items-center">
            <ul class="toplinks">
              <li class="lang-btn">
                <div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ App::getLocale() == 'en' ? 'ENG' : '中文' }}
                  </button>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="{{ url('lang/en') }}">ENG</a>
                    <a class="dropdown-item" href="{{ url('lang/zh') }}">中文</a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!--topbar end-->
      <!--Logo + Navbar Start-->
      <div class="logo-navbar">
        <div class="container">
          <div class="row">
            <div class="col-md-2 col-sm-5">
              <div class="logo">
                <a href="{{route('home')}}"><img src="{{ asset('images/logo-white.svg') }}" alt=""></a>

              </div>
            </div>
            <div class="col-md-7 col-sm-4">
              <nav class="main-nav">
                <ul>
                  <li class="nav-item">
                    <a href="{{route('home')}}"
                      class="{{ request()->routeIs('home') || request()->is('/') ? 'active' : '' }}">{{
                      __('messages.nav_home')
                      }}</a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('matches')}}" class="{{ request()->routeIs('matches') ? 'active' : '' }}">{{
                      __('messages.nav_match')
                      }}
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="{{route('subscription')}}"
                      class="{{ request()->routeIs('subscription')  ? 'active' : '' }}">{{
                      __('messages.nav_subscription')
                      }}</a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('faq')}}" class="{{ request()->routeIs('faq') ? 'active' : '' }}">{{
                      __('messages.nav_faq')
                      }}
                    </a>
                  </li>
                  @auth
                  {{-- <li class="nav-item d-block d-sm-none">
                    <button type="button" class="dropdown-item" data-toggle="modal" data-target="#modalPassword">{{
                      __('messages.btn_change_password')
                      }}
                    </button>
                  </li> --}}
                  <li class="nav-item d-block d-sm-none">
                    <button type="button" class="dropdown-item"
                      onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{
                      __('messages.btn_logout')
                      }}</button>
                  </li>
                  @endauth
                  @guest
                  <li class="nav-item login d-block d-sm-none">
                    <a data-toggle="modal" data-target="#modalLogin">
                      {{
                      __('messages.btn_login')
                      }}
                    </a>
                  </li>

                  <li class="nav-item register d-block d-sm-none">
                    <a data-toggle="modal" data-target="#modalRegister">{{
                      __('messages.btn_register')
                      }}</a>
                  </li>
                  @endguest
                  <li class="nav-item d-block d-sm-none">

                    <div class="d-flex justify-content-center align-items-center pt-2">
                      <span class="text-white">
                        {{
                        __('messages.text_language')
                        }}
                      </span>
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                      <a href="{{ url('lang/en') }}">ENG</a>
                      <a href="{{ url('lang/zh') }}">中文</a>
                    </div>
                  </li>
                </ul>
              </nav>
            </div>
            <div class="col-md-3 col-sm-3">
              <nav class="main-nav2">
                <ul>
                  <!-- 如果用户已登录 -->
                  @auth
                  <li class="nav-item">
                    <div class="dropdown">
                      <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false"> {{
                        __('messages.text_account')
                        }} </button>
                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        {{-- <button type="button" class="dropdown-item" data-toggle="modal"
                          data-target="#modalPassword">{{
                          __('messages.btn_change_password')
                          }} </button> --}}
                        <button type="button" class="dropdown-item"
                          onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{
                          __('messages.btn_logout')
                          }}</button>
                      </div>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                    </form>
                  </li>
                  @endauth
                  <!-- 如果用户未登录 -->


                  @guest
                  <li class="nav-item login">
                    <a data-toggle="modal" data-target="#modalLogin">
                      {{
                      __('messages.btn_login')
                      }}
                    </a>
                  </li>

                  <li class="nav-item register">
                    <a data-toggle="modal" data-target="#modalRegister">{{
                      __('messages.btn_register')
                      }}</a>
                  </li>


                  @endguest


                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
      <!--Logo + Navbar End-->
    </header>
    <!--Header End-->

    @yield('content')

    <!--Main Footer Start-->
    <footer class="wf100 main-footer">
      <div class="container">
        <div class="row">
          <!--Footer Widget Start-->
          <div class="col-lg-4 col-md-6">
            <div class="footer-widget about-widget">
              <img src="{{asset('images/logo.png')}}" />

              <p>{{ __('messages.text_footer')
                }}

              </p>
            </div>
          </div>
          <!--Footer Widget End-->
          <!--Footer Widget Start-->
          <div class="col-lg-4 col-md-6">
            <div class="footer-widget">
              <h4 class="text-uppercase">{{
                __('messages.text_sponsor')
                }}</h4> <a href="https://me88cash.com/register?affid=5678">
                <div class="d-flex justify-content-center align-items-center">

                  <img src="{{asset('images/logo-me88.png')}}" class="flex-img" /><img
                    src="{{asset('images/me88-sports-live-tv.png')}}" class="flex-img" /><img
                    src="{{asset('images/seed-sport-logo.svg')}}" class="flex-img" />
                </div>
              </a>

            </div>
          </div>
          <!--Footer Widget End-->
        </div>
      </div>
      <div class="container brtop">
        <div class="row">
          <div class="col-lg-6 col-md-6">
            <p class="copyr">
              {{
              __('messages.text_copyright')
              }}
            </p>
          </div>
          <div class="col-lg-6 col-md-6">
            <ul class="quick-links">
              <li><a href="{{route('home')}}">{{
                  __('messages.nav_home')
                  }}</a></li>
              <li><a href="{{route('matches')}}">
                  {{
                  __('messages.nav_match')
                  }}</a></li>
            </ul>
          </div>
        </div>
      </div>
    </footer>

    <!--Main Footer End-->
    @auth
    @include('components.modal-upload')
    @include('components.modal-password')
    @endauth
    @guest
    @include('components.modal-login')
    @include('components.modal-register')
    @endguest
    <div class="chat-tg">
      <a href="https://t.me/mescoreaiofficial/" target="_blank">
        <img src="{{ asset('images/icons8-telegram-app.svg')}}" style="width:30px;margin-left:8px" />
        <span class="text"> {{
          __('messages.text_chat_with_us')
          }}</span>

      </a>
    </div>




  </div>
  <!--Wrapper End-->

  <!-- Vendor JS Files -->
  <script src=" {{ asset('vendor/jquery/jquery-3.3.1.min.js')}}"></script>
  <script src="{{ asset('js/jquery-migrate-3.0.1.js')}}"></script>
  <script src="{{ asset('js/popper.min.js')}}"></script>
  <script src="{{ asset('js/bootstrap.min.js')}}"></script>
  <script src="{{ asset('js/mobile-nav.js')}}"></script>
  <script src="{{asset('vendor/jquery-confirm-master/js/jquery-confirm.js') }}"></script>
  <script src="{{asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>

  <script src="{{ asset('js/custom.js')}}"></script>
  <!-- Template Main JS File -->
  @yield('footer')

  {!! JsValidator::formRequest('App\Http\Requests\StoreMemberRequest', '#form-register'); !!}
  {!! JsValidator::formRequest('App\Http\Requests\LoginRequest', '#form-login'); !!}
  {!! JsValidator::formRequest('App\Http\Requests\ChangePasswordRequest', '#form-password'); !!}
  {!! JsValidator::formRequest('App\Http\Requests\UploadReceiptRequest', '#form-upload'); !!}

  <script>
    $(document).ready(function() {
        // Show the modal after 5 seconds
        // setTimeout(function() {
        //     $('#popup').style.display = 'block';
        // }, 5000);

        setTimeout(function() {
                $('#imagePopup').modal('show');
            }, 5000);

        // $('#popup').css('display','block');

    });
    // function closePopup() {
    //   // $('#popup').style.display = 'none';
    //   $('#popup').css('display','none');
    // }

    $('#form-register').submit(function(e) {
      e.preventDefault();
      var _btn = $('#btn-register');
      if (!$(this).valid()) return false;
      startSpin($(_btn));
      var formData = $(this).serialize();
      $.ajax({
        url: $(this).attr('action'),
        type: $(this).attr('method'),
        data: formData,
      }).fail(function(xhr, text, err) {
         notifySystemError(err);
      }).done(function(data) {
        notifySuccess('Successfully Register');
        $('#modalRegister').hide();
        setTimeout(() => {
            location.reload();
          }, 2000);
      }).always(function() {
          stopSpin($(this));
      });
  });


  $('#form-login').submit(function(e) {
      e.preventDefault();
      var _btn = $('#btn-login');
      if (!$(this).valid()) return false;
      startSpin($(_btn));
      var formData = $(this).serialize();
      $.ajax({
        url: $(this).attr('action'),
        type: $(this).attr('method'),
        data: formData,
      }).fail(function(xhr, text, err) {
         notifySystemError(err);
      }).done(function(data) {

        if(data['result']){
          notifySuccess('Login successfully');
          $('#modalLogin').hide();
          setTimeout(() => {
            location.reload();
          }, 2000);
        }else {
          if(data['error']){
            notifyError(data['error']);
          }
        }
        stopSpin($(this));

        
      }).always(function() {
          stopSpin($(this));
      });
  });

  $('#form-password').submit(function(e) {
      e.preventDefault();
      var _btn = $('#btn-password');
      if (!$(this).valid()) return false;
      startSpin($(_btn));
      var formData = $(this).serialize();
      $.ajax({
        url: $(this).attr('action'),
        type: $(this).attr('method'),
        data: formData,
      }).fail(function(xhr, text, err) {
         notifySystemError(err);
      }).done(function(data) {

        if(data['message']){
          notifySuccess('Password change successfully');
          $('#modalSubscription').hide();
        }else {
          if(data['error']){
            notifyError(data['error']);
          }
        }
        stopSpin($(this));

        
      }).always(function() {
          stopSpin($(this));
      });
  });

  $('#form-upload').submit(function(e) {
      e.preventDefault();
      var _btn = $('#btn-upload');
      if (!$(this).valid()) return false;
      startSpin($(_btn));
      // Use FormData for file upload
      var formData = new FormData(this);
      $.ajax({
        url: $(this).attr('action'),
        type: $(this).attr('method'),
        data: formData,
        processData: false, // Important for file uploads
        contentType: false, // Important for file uploads
        success: function(data) {
            // notifySuccess('Upload receipt done');
            // Additional actions on success
            if(data.message) {
                notifySuccess(data.message);
                $('#modalSubscription').modal('hide'); // Assuming you have a modal to hide
            } else if (data.error) {
                notifyError(data.error);
            }
        },
        error: function(xhr) {
            var error = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Error';
            notifyError(error);
        },
        complete: function() {
            stopSpin(_btn);
        }
      });
  });
  $('#btnSignUp').on('click', function() {
    $('#modalLogin').modal('hide');
    $('#modalRegister').modal('show');
  });

  
  $('#btnSignIn').on('click', function() {
    $('#modalRegister').modal('hide');
    $('#modalLogin').modal('show');
  });

  $('#modalInfo #btnUpload').on('click', function() {
    $('#modalInfo').modal('hide');
    $('#modalSubscription').modal('show');
  });

  // This function gets a parameter by name from the URL.
function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

// Store the code in local storage if it's not already stored.
var existingCode = localStorage.getItem('affiliateCode');
var currentCode = getUrlParameter('code');
if (currentCode && (!existingCode || existingCode !== currentCode)) {
    localStorage.setItem('affiliateCode', currentCode);
}
// Retrieve the affiliate code from local storage when needed.
var affiliateCode = localStorage.getItem('affiliateCode');
if (affiliateCode) {
    // Use the affiliate code as needed, for example, update links.
    $("a.afflink").attr("href", "https://me88cash.com/register?affid=" + affiliateCode);
}


//   function updateAffiliateLinks() {
//     var getUrlParameter = function(sParam) {
//         var sPageURL = window.location.search.substring(1),
//             sURLVariables = sPageURL.split('&'),
//             sParameterName,
//             i;

//         for (i = 0; i < sURLVariables.length; i++) {
//             sParameterName = sURLVariables[i].split('=');

//             if (sParameterName[0] === sParam) {
//                 return sParameterName[1] === undefined ? '' : decodeURIComponent(sParameterName[1]);
//             }
//         }
//         return '';
//     };

//     var affiliate = getUrlParameter('aff') || getUrlParameter('code');
//     $("a.afflink").attr("href", "https://me88cash.com/register?affid=" + affiliate);
//     $("a.afflink").attr("target", "_top");
// }

// jQuery(document).ready(function($) {
//     updateAffiliateLinks();
// });
  </script>
</body>

</html>