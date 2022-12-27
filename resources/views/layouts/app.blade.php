<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <meta name="description" content=""/>
  <meta name="author" content=""/>
  <title>{{ config('app.name', 'Laravel') }}</title>
  <!-- loader-->
  <link href="{{ asset('frontend/assets/css/pace.min.css') }}" rel="stylesheet"/>
  <script src="{{ asset('frontend/assets/js/pace.min.js') }}"></script>
  <!--favicon-->
  <link rel="icon" href="{{ asset('frontend/assets/images/favicon.ico') }}" type="image/x-icon">
  <!-- Vector CSS -->
  <!--<link href="{{ asset('frontend/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet"/>-->
  <!-- simplebar CSS-->
  <link href="{{ asset('frontend/assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet"/>
  <!-- Bootstrap core CSS-->
  <link href="{{ asset('frontend/assets/css/bootstrap.min.css') }}" rel="stylesheet"/>
  <!-- animate CSS-->
  <link href="{{ asset('frontend/assets/css/animate.css') }}" rel="stylesheet" type="text/css"/>
  <!-- Sidebar CSS-->
  <link href="{{ asset('frontend/assets/css/sidebar-menu.css') }}" rel="stylesheet"/>
  <!-- Icons CSS-->
  <link href="{{ asset('frontend/assets/css/icons.css') }}" rel="stylesheet" type="text/css"/>
  <!-- Custom Style-->
  <link href="{{ asset('frontend/assets/css/app-style.css') }}" rel="stylesheet"/>
  <script src="{{ asset('frontend/assets/js/jquery.min.js') }}"></script>
  
</head>

<body class="bg-theme bg-theme1">
 
    <!-- Start wrapper-->
    <div id="wrapper">
    @include('layouts.sidebar')
    @include('layouts.header')
    <div class="clearfix"></div>
    <div class="content-wrapper">
    @yield('content')
    </div>
    @include('layouts.footer')
    </div>
    
    <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('frontend/assets/js/popper.min.js') }}"></script>
  <script src="{{ asset('frontend/assets/js/bootstrap.min.js') }}"></script>
  <!-- simplebar js -->
  <script src="{{ asset('frontend/assets/plugins/simplebar/js/simplebar.js') }}"></script>
  <!-- sidebar-menu js -->
  <script src="{{ asset('frontend/assets/js/sidebar-menu.js') }}"></script>
  <!-- loader scripts -->
  <!--<script src="{{ asset('frontend/assets/js/jquery.loading-indicator.js') }}"></script>-->
  <!-- Custom scripts -->
  <script src="{{ asset('frontend/assets/js/app-script.js') }}"></script>
  <!-- Chart js -->
  
  <script src="{{ asset('frontend/assets/plugins/Chart.js/Chart.min.js') }}"></script>
 
  <!-- Index js -->
  <script src="{{ asset('frontend/assets/js/index.js') }}"></script>
  
</body>
</html>
