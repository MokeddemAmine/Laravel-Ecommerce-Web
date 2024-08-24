<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="{{asset('images/favicon.png')}}" type="image/x-icon">

    <title>
        @yield('title','eCommerce')
    </title>

    <!-- Scripts -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <!-- responsive style -->
    <link href="{{asset('css/responsive.css')}}" rel="stylesheet" />
</head>
<body>
    <div id="app">
        <!-- header section strats -->
    <header class="header_section mt-3">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""></span>
          </button>
  
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav  ">
              <li class="nav-item active">
                <a class="nav-link" href="{{route('home')}}">Home <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{route('shop')}}">
                  Shop
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{route('why')}}">
                  Why Us
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{route('testimonial')}}">
                  Testimonial
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{route('contact')}}">Contact Us</a>
              </li>
            </ul>
            <div class="user_option">
                @guest
                    @if (Route::has('login'))
                            
                                <a href="{{ route('login') }}"><i class="fa fa-user"></i> {{ __('Login') }}</a>
                            
                        @endif

                        @if (Route::has('register'))
                            
                                <a href="{{ route('register') }}"><i class="fa fa-user-plus"></i> {{ __('Register') }}</a>
                            
                        @endif
                    @else
                        <div class="dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                @endguest
              <a href="">
                <i class="fa fa-shopping-bag" aria-hidden="true"></i>
              </a>
              <form class="form-inline ">
                <button class="btn nav_search-btn" type="submit">
                  <i class="fa fa-search" aria-hidden="true"></i>
                </button>
              </form>
            </div>
          </div>
        </nav>
      </header>

        <main class="py-4">
            @yield('content')
        </main>

        <section class="info_section  layout_padding2-top">
            <div class="social_container">
              <div class="social_box">
                <a href="">
                  <i class="fa fa-facebook" aria-hidden="true"></i>
                </a>
                <a href="">
                  <i class="fa fa-twitter" aria-hidden="true"></i>
                </a>
                <a href="">
                  <i class="fa fa-instagram" aria-hidden="true"></i>
                </a>
                <a href="">
                  <i class="fa fa-youtube" aria-hidden="true"></i>
                </a>
              </div>
            </div>
            <div class="info_container ">
              <div class="container">
                <div class="row">
                  <div class="col-md-6 col-lg-3">
                    <h6>
                      ABOUT US
                    </h6>
                    <p>
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed doLorem ipsum dolor sit amet, consectetur adipiscing elit, sed doLorem ipsum dolor sit amet,
                    </p>
                  </div>
                  <div class="col-md-6 col-lg-3">
                    <div class="info_form ">
                      <h5>
                        Newsletter
                      </h5>
                      <form action="#">
                        <input type="email" placeholder="Enter your email">
                        <button>
                          Subscribe
                        </button>
                      </form>
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-3">
                    <h6>
                      NEED HELP
                    </h6>
                    <p>
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed doLorem ipsum dolor sit amet, consectetur adipiscing elit, sed doLorem ipsum dolor sit amet,
                    </p>
                  </div>
                  <div class="col-md-6 col-lg-3">
                    <h6>
                      CONTACT US
                    </h6>
                    <div class="info_link-box">
                      <a href="">
                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                        <span> Gb road 123 london Uk </span>
                      </a>
                      <a href="">
                        <i class="fa fa-phone" aria-hidden="true"></i>
                        <span>+01 12345678901</span>
                      </a>
                      <a href="">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                        <span> demo@gmail.com</span>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- footer section -->
            <footer class=" footer_section">
              <div class="container">
                <p>
                  &copy; <span id="displayYear"></span> All Rights Reserved By
                  <a href="https://html.design/">Web Tech Knowledge</a>
                </p>
              </div>
            </footer>
            <!-- footer section -->
        
          </section>
    </div>

    <script src="{{asset('js/jquery-3.4.1.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{asset('js/custom.js')}}"></script>

</body>
</html>
