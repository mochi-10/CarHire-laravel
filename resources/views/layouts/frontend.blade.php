<!doctype html>
<html lang="en">

<head>
  <title>Car Hire Management System</title>
  <link rel="icon" href="{{ asset('images/car-wash.png') }}">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('frontend/fonts/icomoon/style.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap-datepicker.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/css/jquery.fancybox.min.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/css/owl.carousel.min.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/css/owl.theme.default.min.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/fonts/flaticon/font/flaticon.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/css/aos.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
</head>

<style>
  .btn {
    border-radius: 50px;
  }
</style>

<body>
  <div class="site-wrap" id="home-section">
    <div class="site-mobile-menu site-navbar-target">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>
    <!-- Navigation -->
    <header class="site-navbar site-navbar-target" role="banner">
      <div class="container">
        <div class="row align-items-center position-relative">
          <div class="col-3">
            <div class="site-logo">
              <a href="{{ route('welcome') }}"><strong>CarHire</strong></a>
            </div>
          </div>
          <div class="col-9  text-right">
            <span class="d-inline-block d-lg-none">
              <a href="#" class=" site-menu-toggle js-menu-toggle py-5 ">
                <span class="icon-menu h3 text-black"></span>
              </a>
            </span>
            <nav class="site-navigation text-right ml-auto d-none d-lg-block" role="navigation">
              <ul class="site-menu main-menu js-clone-nav ml-auto ">

                <li class="active"><a href="{{ route('welcome') }}" class="nav-link">Home</a></li>
                @if(Auth::check() && Auth::user()->role === 'Admin')

                <li><a href="{{ route('adminDashboard') }}" class="nav-link">Admin</a></li>
                @endif
                <li><a href="{{ route('carListings') }}" class="nav-link">Available Cars</a></li>

                @if(Auth::check())
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="bookingsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Bookings
                  </a>
                  <div class="dropdown-menu" aria-labelledby="bookingsDropdown">
                    <a class="dropdown-item" href="{{ route('customerBookings') }}">My Bookings</a>

                    @if(Auth::check() && Auth::user()->role === 'Admin')
                    <a class="dropdown-item" href="{{ route('allBookings') }}">Customer Bookings</a>
                    @endif
                    
                  </div>
                </li>
                @endif

                <li><a href="{{ route('about') }}" class="nav-link">About</a></li>
                <li><a href="{{ route('contact') }}" class="nav-link">Contact</a></li>
                @if(Auth::check() && Auth::user()->role === 'Admin')
                <li><a href="{{ route('contact.messages') }}" class="nav-link">Messages</a></li>
                @endif

                @if(Auth::check())
                <li class="nav-link">
                  <a class="btn btn-default btn-flat" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <b>{{ Auth::user()->firstname }}</b> (Sign Out)
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                  </form>
                </li>
                @else
                <li><a href="{{ route('login') }}" class="nav-link">Login</a></li>
                <li><a href="{{ route('customerRegistration') }}" class="nav-link">Register</a></li>
                @endif

              </ul>
            </nav>
          </div>
        </div>
      </div>
    </header>
    <!-- Main Content -->
    @include('sweetalert::alert')
    @yield('content')
    <!-- Footer -->
    <footer class="site-footer" style="background:hsl(221, 91.90%, 61.40%); color:white; padding:20px 10px; font-size:13px;">
      <div class="container" style="color:white;">
        <div class="row">
          <div class="col-lg-3" style="margin-bottom:15px;">
            <h2 class="footer-heading" style="margin-bottom:10px;">About Us</h2>
            <p style="margin:0 0 10px; color:black;">This Car Hire Management System offers reliable, affordable, and convenient car rental services. Our mission is to provide a seamless experience for customers looking to hire vehicles for any occasion.</p>
            <ul style="list-style:none; padding-left:0; display:flex; gap:10px;">
              <li><a href="#" style="color:white;"><span class="icon-facebook"></span></a></li>
              <li><a href="#" style="color:white;"><span class="icon-instagram"></span></a></li>
              <li><a href="#" style="color:white;"><span class="icon-twitter"></span></a></li>
              <li><a href="#" style="color:white;"><span class="icon-linkedin"></span></a></li>
            </ul>
          </div>

          <div class="col-lg-3" style="margin-bottom:15px;">
            <h2 class="footer-heading" style="margin-bottom:10px;">Quick Links</h2>
            <ul style="list-style:none; padding-left:0;">
              <li><a href="{{route('welcome')}}" style="color:black; text-decoration:none;">Home</a></li>
              <li><a href="{{route('login')}}" style="color:black; text-decoration:none;">Login</a></li>
              <li><a href="{{route('customerRegistration')}}" style="color:black; text-decoration:none;">Register</a></li>
              <li><a href="{{route('about')}}" style="color:black; text-decoration:none;">About Us</a></li>
              <li><a href="{{route('contact')}}" style="color:black; text-decoration:none;">Contact Us</a></li>
            </ul>
          </div>
        </div>
      </div>
    </footer>
  </div>
  <script src="{{ asset('frontend/js/jquery-3.3.1.min.js') }}"></script>
  <script src="{{ asset('frontend/js/popper.min.js') }}"></script>
  <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('frontend/js/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('frontend/js/jquery.sticky.js') }}"></script>
  <script src="{{ asset('frontend/js/jquery.waypoints.min.js') }}"></script>
  <script src="{{ asset('frontend/js/jquery.animateNumber.min.js') }}"></script>
  <script src="{{ asset('frontend/js/jquery.fancybox.min.js') }}"></script>
  <script src="{{ asset('frontend/js/jquery.easing.1.3.js') }}"></script>
  <script src="{{ asset('frontend/js/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ asset('frontend/js/aos.js') }}"></script>
  <script src="{{ asset('frontend/js/main.js') }}"></script>
</body>

</html>