<header class="header">   
    <nav class="navbar navbar-expand-lg">
      <div class="search-panel">
        <div class="search-inner d-flex align-items-center justify-content-center">
          <div class="close-btn">Close <i class="fa fa-close"></i></div>
          {{-- search form --}}
          <form id="searchForm" action="{{route('admin.dashboard.products.search')}}" method="GET">
            @csrf
            <div class="form-group">
              <input type="search" name="search" placeholder="What are you searching for...">
              <button type="submit" class="submit">Search</button>
            </div>
          </form>
        </div>
      </div>

      <div class="container-fluid">
        <div class="navbar-header">
          <!-- Navbar Header--><a href="{{route('admin.dashboard.index')}}" class="navbar-brand">
            <div class="brand-text brand-big visible text-uppercase"><strong class="text-primary">Dark</strong><strong>Admin</strong></div>
            <div class="brand-text brand-sm"><strong class="text-primary">D</strong><strong>A</strong></div></a>
          <!-- Sidebar Toggle Btn-->
          <button class="sidebar-toggle"><i class="fa fa-long-arrow-left"></i></button>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">  
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0"> 
            @auth('admin')
            <li class="nav-item"> 
              <div class="list-inline-item"><a href="#" class="search-open nav-link"><i class="icon-magnifying-glass-browser"></i></a></div>
            </li>
            <li class="nav-item">
              <div class="list-inline-item dropdown"><a id="navbarDropdownMenuLink1" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link messages-toggle"><i class="icon-email"></i></a>
                <div aria-labelledby="navbarDropdownMenuLink1" class="dropdown-menu messages">
                  
                </div>
              </div>
            </li>
            <!-- Languages dropdown    -->
            <li class="nav-item">
              <div class="list-inline-item dropdown"><a id="languages" rel="nofollow" data-target="#" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link language dropdown-toggle"><img src="{{asset('admin/img/flag/GB.png')}}" width="35" alt="English"><span class="d-none d-sm-inline-block">English</span></a>
                <div aria-labelledby="languages" class="dropdown-menu"><a rel="nofollow" href="#" class="dropdown-item"> <img src="{{asset('admin/img/flag/DE.png')}}" width="35" alt="English" class="mr-2"><span>German</span></a><a rel="nofollow" href="#" class="dropdown-item"> <img src="{{asset('admin/img/flag/FR.png')}}" width="35" alt="English" class="mr-2"><span>French  </span></a></div>
              </div>
            </li>
            <!-- Log out               -->
            @endauth
            <li class="nav-item">
              <div class="list-inline-item">
                <ul class="navbar-nav ">
                    <!-- Authentication Links -->
                    @guest('admin')
                        @if (Route::has('admin.login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('admin.register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::guard('admin')->user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('admin.dashboard.profile') }}">
                                  {{ __('Profile') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('admin.logout') }}"
                                  onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                                
                            </div>
                        </li>
                    @endguest
                </ul>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>