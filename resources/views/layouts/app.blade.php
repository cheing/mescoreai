<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'me88scoreAI') }}</title>

  <!-- Scripts -->
  <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">

  <!-- Styles -->

  <!-- Favicons -->
  <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png" />
  {{--
  <link href="{{ asset('images/favicon.png') }}" rel="icon"> --}}
  {{--
  <link href="{{ asset('images/favicon.png') }}" rel="apple-touch-icon"> --}}

  <!-- Vendor CSS Files -->
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/fontawesome.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('vendor/jquery-confirm-master/css/jquery-confirm.css') }}" />
  <!-- Template Main CSS File -->
  <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
  <link href="{{ asset('css/responsive.css') }}" rel="stylesheet">
  <link href="{{ asset('css/color.css') }}" rel="stylesheet">
</head>

<body>
  <!--Wrapper Start-->
  <div class="wrapper">
    <!--Header Start-->
    <header id="main-header" class="main-header">
      <!--Logo + Navbar Start-->
      <div class="logo-navbar">
        <div class="container">
          <div class="row">
            <div class="col-md-2 col-sm-5">
              <div class="logo">
                <a href="{{route('home')}}"><img src="{{ asset('images/logo-white.svg') }}" alt=""></a>

              </div>
            </div>
            <div class="col-md-5 col-sm-4">
              <nav class="main-nav">
                <ul>
                  <li class="nav-item">
                    <a href="{{route('home')}}"
                      class="{{ request()->routeIs('home') || request()->is('/') ? 'active' : '' }}">Home</a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('home2')}}" class="{{ request()->routeIs('home2')  ? 'active' : '' }}">Home 2</a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('matches')}}" class="{{ request()->routeIs('matches') ? 'active' : '' }}">Match
                      Prediction</a>
                  </li>
                </ul>
              </nav>
            </div>
            <div class="col-md-5 col-sm-3">
              <nav class="main-nav2">
                <ul>
                  <!-- 如果用户已登录 -->
                  @auth
                  <li class="nav-item">
                    <div class="dropdown">
                      <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false"> Account </button>
                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        <button type="button" class="dropdown-item" data-toggle="modal"
                          data-target="#modalPassword">Change Password</button>
                        <button type="button" class="dropdown-item"
                          onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</button>
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
                      Login
                    </a>
                  </li>

                  <li class="nav-item register">
                    <a data-toggle="modal" data-target="#modalRegister">Register</a>
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

              <p>
                Our advanced AI algorithms analyze thousands of data points to
                provide precise football predictions and insightful betting
                suggestions.
              </p>
            </div>
          </div>
          <!--Footer Widget End-->
          <!--Footer Widget Start-->
          <div class="col-lg-8 col-md-6">
            <div class="footer-widget">
              <h4>Sponsor</h4>
              <ul class="footer-sponsor">
                <li>
                  <img src="{{asset('images/me88.png')}}" />
                </li>
                <li>
                  <img src="{{asset('images/me88.png')}}" />
                </li>
                <li>
                  <img src="{{asset('images/me88.png')}}" />
                </li>
              </ul>
            </div>
          </div>
          <!--Footer Widget End-->
        </div>
      </div>
      <div class="container brtop">
        <div class="row">
          <div class="col-lg-6 col-md-6">
            <p class="copyr">
              Copyright &copy; {{date('Y')}} by me scoreAI. All Rights Reserved.
            </p>
          </div>
          <div class="col-lg-6 col-md-6">
            <ul class="quick-links">
              <li><a href="{{route('home')}}">Home</a></li>
              <li><a href="{{route('matches')}}">Match
                  Prediction</a></li>
            </ul>
          </div>
        </div>
      </div>
    </footer>
    <!--Main Footer End-->
    @include('components.modal-upload')
    @include('components.modal-login')
    @include('components.modal-register')
    @include('components.modal-password')
  </div>
  <!--Wrapper End-->
  <!-- Vendor JS Files -->
  <script src="{{ asset('vendor/jquery/jquery-3.3.1.min.js')}}"></script>
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

  <script>
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
  $('#modalInfo #btnUpload').on('click', function() {
    $('#modalInfo').modal('hide');
    $('#modalSubscription').modal('show');
  });
  </script>
</body>

</html>