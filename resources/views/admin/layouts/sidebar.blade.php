<!-- Sidebar Navigation-->
<nav id="sidebar">
    <!-- Sidebar Header-->
    <div class="sidebar-header d-flex align-items-center">
      <div class="avatar"><img src="{{asset('admin/img/avatar-6.jpg')}}" alt="..." class="img-fluid rounded-circle"></div>
      <div class="title">
        <h1 class="h5">Mark Stephen</h1>
        <p>Web Designer</p>
      </div>
    </div>
    <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
    <ul class="list-unstyled" id="sidebar-links-icons">
            <li><a href="{{route('admin.dashboard.index')}}"> <i class="icon-home"></i>Home </a></li>
            <li><a href="{{route('admin.dashboard.tables')}}"> <i class="icon-grid"></i>Tables </a></li>
            <li><a href="{{route('admin.dashboard.charts')}}"> <i class="fa fa-bar-chart"></i>Charts </a></li>
            <li><a href="{{route('admin.dashboard.forms')}}"> <i class="icon-padnote"></i>Forms </a></li>
            <li><a href="#exampledropdownDropdown" aria-expanded="false" data-toggle="collapse"> <i class="icon-windows"></i>Example dropdown </a>
              <ul id="exampledropdownDropdown" class="collapse list-unstyled ">
                <li><a href="#">Page</a></li>
                <li><a href="#">Page</a></li>
                <li><a href="#">Page</a></li>
              </ul>
            </li>
            <li><a href="{{route('admin.dashboard.login')}}"> <i class="icon-logout"></i>Login page </a></li>
    </ul><span class="heading">Extras</span>
    <ul class="list-unstyled">
      <li> <a href="#"> <i class="icon-settings"></i>Demo </a></li>
      <li> <a href="#"> <i class="icon-writing-whiteboard"></i>Demo </a></li>
      <li> <a href="#"> <i class="icon-chart"></i>Demo </a></li>
    </ul>
  </nav>
  <!-- Sidebar Navigation end-->