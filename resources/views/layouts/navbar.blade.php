
<!-- header section strats -->
<header class="header_section mt-3">
    <nav class="navbar navbar-expand-lg custom_nav-container ">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class=""></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav  ">
          <li class="nav-item ">
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
                            <a class="dropdown-item" href="{{ route('user.profile') }}">
                                {{ __('Profile') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('orders.index') }}">
                              {{ __('My Orders') }}
                          </a>
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
                    <a href="{{route('carts.show',Auth::user()->id)}}" id="shopping-cart">
                      <i class="fa fa-shopping-bag" aria-hidden="true" >
                        @if ($cart_count)
                          <span class="d-inline-block bg-warning rounded-circle p-1 fw-bold">{{$cart_count}}</span>
                        @endif
                      </i>
                    </a>
            @endguest
          
          <form class="form-inline ">
            <button class="btn nav_search-btn" type="submit">
              <i class="fa fa-search" aria-hidden="true"></i>
            </button>
          </form>
        </div>
      </div>
    </nav>
  </header>