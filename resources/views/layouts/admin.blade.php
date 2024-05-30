<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  {{-- <title>@yield('title') | {{ config('app.name') }}</title> --}}
  <title>{{ config('app.name', 'me scoreAI: Eurocup Live Streaming 2024') }}</title>
  <meta name="description"
    content="Join me scoreAI now and gain exclusive lifetime access to AI-driven sports predictions and watch Eurocup Live Streaming 2024.">

  <!-- Scripts -->
  <!-- Styles -->

  <link rel="stylesheet" href="{{ asset('vendor/mdi/css/materialdesignicons.min.css')}}" />
  <link rel="stylesheet" href="{{ asset('vendor/simple-line-icon/css/simple-line-icons.css')}}" />
  <link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/font-awesome.min.css')}}" />
  <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css')}}" />
  <link rel="stylesheet" href="{{ asset('backend/css/vendor.bundle.base.css')}}" />
  <link rel="stylesheet" href="{{ asset('backend/css/vendor.bundle.addons.css')}}" />
  <link rel="stylesheet" href="{{ asset('vendor/jquery-confirm-master/css/jquery-confirm.css') }}" />
  <link rel="stylesheet" href="{{ asset('vendor/lightbox2-master/css/lightbox.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('vendor/bootstrap4-datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css" />

  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset('backend/css/shared/style.css')}}" />
  <!-- endinject -->
  <!-- Layout styles -->
  <link rel="stylesheet" href="{{asset('backend/css/style.css')}}" />
  <link rel="stylesheet" href="{{asset('backend/css/custom.css')}}" />
  <!-- End Layout styles -->
  <link rel="shortcut icon" href="{{ asset('backend/images/favicon.png') }}" />
  <link rel="stylesheet" href="{{ asset('vendor/flag-icons-svg/css/flag-icons.css') }}" />

  @yield('header')
</head>

<body class="sidebar-icon-only sidebar-fixed">
  <div class="container-scroller">
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a class="navbar-brand brand-logo" href="{{url('admin/dashboard')}}">
          <img src="{{asset('backend/images/logo.svg')}}" alt="mescoreAI" /> </a>
        <a class="navbar-brand brand-logo-mini" href="{{url('admin/dashboard')}}">
          <img src="{{asset('backend/images/logo-mini.png')}}" alt="mescoreAI" /> </a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="mdi mdi-menu"></span>
        </button>
        <!-- <ul class="navbar-nav navbar-nav-left header-links">
           <li class="nav-item active d-none d-md-flex">
             <a href="{{url('#')}}" class="nav-link">
               <i class="mdi mdi-elevation-rise"></i>Report</a>
           </li>
         </ul> -->
        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown d-xl-inline-block user-dropdown">
            <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
              <img class="img-xs rounded-circle" src="{{asset('backend/images/avatar.png')}}" alt="Profile image"> </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
              <div class="dropdown-header text-center">
                <p class="mb-1 mt-3 font-weight-semibold">{{Auth::user()->name}}</p>
                <p class="font-weight-light text-muted mb-0">{{Auth::user()->email}}</p>
              </div>
              <a class="dropdown-item" href="{{url('admin/profile')}}">Profile</a>
              <a class="dropdown-item" href="{{url('admin/password')}}">Change password</a>
              <a class="dropdown-item" href="{{ route('admin.logout') }}">Logout</a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
          data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">

      <nav class="sidebar sidebar-offcanvas dynamic-active-class-disabled" id="sidebar">
        <ul class="nav">

          <li class="nav-item">
            <a class="nav-link" href="{{url('admin/dashboard')}}">
              <i class="menu-icon  icon-screen-desktop"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <!-- <li class="nav-item">
          <a class="nav-link" href="{{url('admin/predictions')}}">
            <i class="menu-icon mdi mdi-soccer"></i>
            <span class="menu-title">Prediction</span>
          </a>
       </li> -->
          <li class="nav-item">
            <a class="nav-link" href="{{url('admin/tournaments')}}">
              <i class="menu-icon icon-trophy"></i>
              <span class="menu-title">Tournaments</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{url('admin/countries')}}">
              <i class="menu-icon icon-flag"></i>
              <span class="menu-title">Countries</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{url('admin/teams')}}">
              <i class="menu-icon icon-emotsmile"></i>
              <span class="menu-title">Teams</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{url('admin/receipts')}}">
              <i class="menu-icon icon-notebook"></i>
              <span class="menu-title">Receipt</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{url('admin/subscriptions')}}">
              <i class="menu-icon icon-user-following"></i>
              <span class="menu-title">Subscription</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{url('admin/packages')}}">
              <i class="menu-icon icon-cup"></i>
              <span class="menu-title">Packages</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{url('admin/faqs')}}">
              <i class="menu-icon icon-question"></i>
              <span class="menu-title">FAQs</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{url('admin/informations')}}">
              <i class="menu-icon icon-info"></i>
              <span class="menu-title">Informations</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{url('admin/members')}}">
              <i class="menu-icon  icon-ghost"></i>
              <span class="menu-title">Members</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{url('admin/users')}}">
              <i class="menu-icon icon-user"></i>
              <span class="menu-title">Users</span>
            </a>
          </li>


        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          @yield('content')
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="container-fluid clearfix">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright &copy;
              {{date('Y')}}.</strong> All rights reserved.
            </span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Made with <i
                class="mdi mdi-heart text-danger"></i>
            </span>
          </div>
        </footer>
        <!-- partial -->

      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>

  <script src="{{asset('backend/js/vendor.bundle.base.js')}}"></script>
  <script src="{{asset('backend/js/vendor.bundle.addons.js')}}"></script>
  <script src="{{asset('backend/js/off-canvas.js')}}"></script>
  <script src="{{asset('backend/js/hoverable-collapse.js')}}"></script>
  <script src="{{asset('backend/js/misc.js')}}"></script>
  <script src="{{asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
  <script src="{{asset('vendor/bootstrap4-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
  <script src="{{asset('vendor/jquery-confirm-master/js/jquery-confirm.js') }}"></script>
  <script src="{{asset('vendor/select2/js/select2.min.js') }}"></script>
  <script src="{{asset('vendor/lightbox2-master/js/lightbox.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

  <script src="{{asset('backend/js/custom.js')}}"></script>
  @yield('footer')

</body>

</html>