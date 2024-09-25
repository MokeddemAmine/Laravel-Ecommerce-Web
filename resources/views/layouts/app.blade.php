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

    <link rel="stylesheet" href="{{asset('css/all.min.css')}}">
</head>
<body>
    <div id="app">
        
      @include('layouts.navbar')
    

        <main class="py-4">
            @yield('content')
        </main>

        <section class="info_section  layout_padding2-top">
            <div class="info_container ">
              <div class="container">
                <div class="row">
                  @if ($about)
                    <div class="col-md-6 col-lg-4">
                      <h6>
                        ABOUT US
                      </h6>
                      <p>
                        {{$about->description}}
                      </p>
                    </div>
                  @endif
                  @if ($contact && count($contact))
                  <div class="col-md-6 col-lg-4">
                    <h6>
                      CONTACT US
                    </h6>
                    
                    <div class="info_link-box">
                      @foreach ($contact as $item)
                        @if ($item->title == 'map')
                          <a href="">
                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                            <span>{{$item->description}}</span>
                          </a>
                        @elseif($item->title == 'phone')
                          <a href="">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                            <span>{{$item->description}}</span>
                          </a>
                        @else 
                          <a href="">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                            <span>{{$item->description}}</span>
                          </a>
                        @endif
                      @endforeach
                    </div>
                  </div>
                  @endif
                  @if ($media && count($media))
                  <div class="col-md-6 col-lg-4">
                    <h6>
                      social media
                    </h6>

                      <div class="social_box">
                        <ul class="list-unstyled">
                          @foreach ($media as $social)
                              <li>
                                  <a href="{{$social->description}}" target="_blank">
                                    <i class="fa-brands 
                                      @if($social->title == 'facebook')
                                        fa-facebook
                                      @elseif($social->title == 'x_twitter')
                                        fa-x-twitter 
                                      @elseif($social->title == 'instagram')
                                        fa-instagram 
                                      @else 
                                        fa-youtube
                                      @endif
                                    " aria-hidden="true"></i>
                                  </a>
                              </li>
                          @endforeach
                        </ul>
                      </div>
                  </div>
                  @endif
                  
                </div>
              </div>
            </div>
            <!-- footer section -->
            <footer class=" footer_section">
              <div class="container">
                <p class="text-uppercase">
                  &copy; <span id="displayYear"></span> All Rights Reserved By
                  amine mokeddem
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
    <script src="{{asset('js/main.js')}}"></script>
    @yield('js-special')

</body>
</html>
