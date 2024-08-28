<!-- Sidebar Navigation-->
<nav id="sidebar">
    <!-- Sidebar Header-->
    <div class="sidebar-header d-flex align-items-center">
      <div class="avatar"><img src="{{asset('admin/img/avatar-6.jpg')}}" width="50" alt="..." class=" rounded-circle"></div>
      <div class="title">
        <h1 class="h5">Mark Stephen</h1>
        <p>Web Designer</p>
      </div>
    </div>
    <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
    <ul class="list-unstyled" id="sidebar-links-icons">
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
    </ul>
  </nav>
  <!-- Sidebar Navigation end-->