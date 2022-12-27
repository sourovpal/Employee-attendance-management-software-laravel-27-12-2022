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
  <link href="{{ asset('frontend/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet"/>
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
  
</head>

<body class="bg-theme bg-theme1">

<!-- start loader -->
   <div id="pageloader-overlay" class="visible incoming"><div class="loader-wrapper-outer"><div class="loader-wrapper-inner" ><div class="loader"></div></div></div></div>
        <!-- Start wrapper-->
         <div id="wrapper">
        
         <div class="loader-wrapper"><div class="lds-ring"><div></div><div></div><div></div><div></div></div></div>
        	<div class="card card-authentication1 mx-auto my-5">
        		<div class="card-body">
        		 <div class="card-content p-2">
        		 	<div class="text-center">
        		 		<img src="{{ asset('frontend/assets/images/logo-icon.png') }}" alt="logo icon">
        		 	</div>
        		  <div class="card-title text-uppercase text-center py-3">Sign In</div>
        		    <form method="POST" action="{{ route('login') }}">
                      @csrf
        			  <div class="form-group">
        			  <label for="exampleInputUsername" class="sr-only">Email</label>
        			   <div class="position-relative has-icon-right">
        				  <input placeholder="Enter Username" id="email" type="email" class="input-shadow form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
        
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
        				  <div class="form-control-position">
        					  <i class="icon-user"></i>
        				  </div>
        			   </div>
        			  </div>
        			  <div class="form-group">
        			  <label for="exampleInputPassword" class="sr-only">Password</label>
        			   <div class="position-relative has-icon-right">
        				  <input  placeholder="Enter Password" id="password" type="password" class="input-shadow form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
        
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
        				  <div class="form-control-position">
        					  <i class="icon-lock"></i>
        				  </div>
        			   </div>
        			  </div>
        			<div class="form-row">
        			 <div class="form-group col-6">
        			   <div class="icheck-material-white">
                        <input class="form-check-input" type="checkbox" name="remember" id="user-checkbox" {{ old('remember') ? 'checked' : '' }}>
                        <label for="user-checkbox">Remember me</label>
        			  </div>
        			 </div>
        			 <div class="form-group col-6 text-right">
        			  <a href="reset-password.html">Reset Password</a>
        			 </div>
        			</div>
        			 <button type="submit" class="btn btn-light btn-block">Sign In</button>
        			 
        			 </form>
        		   </div>
        		  </div>
        	     </div>
            
             <!--Start Back To Top Button-->
            <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
            <!--End Back To Top Button-->
        	
        	<!--start color switcher-->
           <div class="right-sidebar">
            <div class="switcher-icon">
              <i class="zmdi zmdi-settings zmdi-hc-spin"></i>
            </div>
            <div class="right-sidebar-content">
        
              <p class="mb-0">Gaussion Texture</p>
              <hr>
              
              <ul class="switcher">
                <li id="theme1"></li>
                <li id="theme2"></li>
                <li id="theme3"></li>
                <li id="theme4"></li>
                <li id="theme5"></li>
                <li id="theme6"></li>
              </ul>
        
              <p class="mb-0">Gradient Background</p>
              <hr>
              
              <ul class="switcher">
                <li id="theme7"></li>
                <li id="theme8"></li>
                <li id="theme9"></li>
                <li id="theme10"></li>
                <li id="theme11"></li>
                <li id="theme12"></li>
        		<li id="theme13"></li>
                <li id="theme14"></li>
                <li id="theme15"></li>
              </ul>
              
             </div>
           </div>
          <!--end color switcher-->
        	
        </div><!--wrapper-->

<!-- Bootstrap core JavaScript-->
  <script src="{{ asset('frontend/assets/js/jquery.min.js') }}"></script>
  <script src="{{ asset('frontend/assets/js/popper.min.js') }}"></script>
  <script src="{{ asset('frontend/assets/js/bootstrap.min.js') }}"></script>
  <!-- simplebar js -->
  <script src="{{ asset('frontend/assets/plugins/simplebar/js/simplebar.js') }}"></script>
  <!-- sidebar-menu js -->
  <script src="{{ asset('frontend/assets/js/sidebar-menu.js') }}"></script>
  <!-- loader scripts -->
  <script src="{{ asset('frontend/assets/js/jquery.loading-indicator.js') }}"></script>
  <!-- Custom scripts -->
  <script src="{{ asset('frontend/assets/js/app-script.js') }}"></script>
  <!-- Chart js -->
  
  <script src="{{ asset('frontend/assets/plugins/Chart.js/Chart.min.js') }}"></script>
 
  <!-- Index js -->
  <script src="{{ asset('frontend/assets/js/index.js') }}"></script>
  
</body>
</html>
