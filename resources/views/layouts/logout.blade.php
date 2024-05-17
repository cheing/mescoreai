<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('vendor/mdi/css/materialdesignicons.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('css/vendor.bundle.base.css')}}" />
    <link rel="stylesheet" href="{{ asset('css/vendor.bundle.addons.css')}}" />
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('css/shared/style.css')}}" />
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{asset('css/style.css')}}" />
    @yield('header')
</head>
<body>

<div class="container-scroller">
   <div class="container-fluid page-body-wrapper full-page-wrapper">
     <div class="content-wrapper auth p-0 theme-two">

       <div class="row d-flex align-items-stretch">
           <div class="col-md-4 banner-section d-none d-md-flex align-items-stretch justify-content-center">
             <div class="slide-content bg-1"> </div>
           </div>
           <div class="col-12 col-md-8 h-100 bg-white">
             <div class="auto-form-wrapper d-flex align-items-center justify-content-center flex-column">

          @yield('content')


          </div>
       </div>
     </div>
   </div>
   </div>
 <!-- page-body-wrapper ends -->
</div>




 <script src="{{asset('js/vendor.bundle.base.js')}}"></script>
 <script src="{{asset('js/vendor.bundle.addons.js')}}"></script>

 <script src="{{asset('js/off-canvas.js')}}"></script>
 <script src="{{asset('js/hoverable-collapse.js')}}"></script>

 <script src="{{asset('js/misc.js')}}"></script>
 <script src="{{ asset('/js/settings.js') }}"></script>
@yield('footer')
</body>
</html>
