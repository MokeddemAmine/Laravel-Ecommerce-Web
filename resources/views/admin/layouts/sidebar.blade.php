<!-- Sidebar Navigation-->
<nav id="sidebar">
    <!-- Sidebar Header-->
    @auth
      @if (Auth::guard('admin')->user())
        <div class="sidebar-header d-flex align-items-center">
          <div class="avatar">
              <img src="{{asset('storage/'.Auth::guard('admin')->user()->profile_picture)}}" width="50" alt="..." class=" rounded-circle">
          </div>
          <div class="title">
            <h1 class="h5">{{Auth::guard('admin')->user()->name}}</h1>
            <p>Admin</p>
          </div>
        </div>
        @endif
    @endauth
    <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
    <ul class="list-unstyled" id="sidebar-links-icons">
          @guest('admin')
            <li><a href="{{route('admin.dashboard.login')}}"> <i class="icon-home"></i>Login </a></li>
            <li><a href="{{route('admin.dashboard.register')}}"> <i class="icon-home"></i>Register </a></li>
          @else
          
            <li><a href="{{route('admin.dashboard.index')}}"> <i class="icon-home"></i>Home </a></li>  
            <li><a href="#categoryDropdown" aria-expanded="false" data-bs-toggle="collapse"> <i class="icon-windows"></i>Categories </a>
              <ul id="categoryDropdown" class="collapse list-unstyled ">
                <li><a href="{{route('admin.dashboard.categories.index')}}">Show All </a></li>
                <li><a href="{{route('admin.dashboard.categories.create')}}">Create </a></li>
              </ul>
            </li>

            <li><a href="#productDropdown" aria-expanded="false" data-bs-toggle="collapse"> <i class="icon-windows"></i>Products </a>
              <ul id="productDropdown" class="collapse list-unstyled ">
                <li><a href="{{route('admin.dashboard.products.index')}}">Show All </a></li>
                <li><a href="{{route('admin.dashboard.products.create')}}">Create </a></li>
              </ul>
            </li>
            <li><a href="{{route('admin.dashboard.orders.index')}}"> <i class="icon-home"></i>Orders </a></li>
          @endguest
            
    </ul>
  </nav>
  <!-- Sidebar Navigation end-->