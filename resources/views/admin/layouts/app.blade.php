<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="robots" content="all,follow">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title','Admin')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Bootstrap CSS-->
    {{-- <link rel="stylesheet" href="{{asset('admin/vendor/bootstrap/css/bootstrap.min.css')}}"> --}}
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="{{asset('admin/vendor/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom Font Icons CSS-->
    <link rel="stylesheet" href="{{asset('admin/css/font.css')}}">
    <!-- Google fonts - Muli-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{asset('admin/css/style.default.css')}}" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{asset('admin/css/custom.css')}}">
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{asset('admin/img/favicon.ico')}}">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>
<body>
    <div id="app">
        @include('admin.layouts.navbar')
        
        <div class="d-flex align-items-stretch">
            @include('admin.layouts.sidebar')
            <div class="page-content">

                @yield('content')

                <footer class="footer">
                    <div class="footer__block block no-margin-bottom">
                      <div class="container-fluid text-center">
                        <!-- Please do not remove the backlink to us unless you support us at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
                         <p class="no-margin-bottom">2018 &copy; Your company. Download From <a target="_blank" href="https://templateshub.net">Templates Hub</a>.</p>
                      </div>
                    </div>
                </footer>

            </div>
            
        </div>
    </div>
    
  <!-- JavaScript files-->
  <script src="{{asset('admin/vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('admin/vendor/popper.js/umd/popper.min.js')}}"> </script>
  {{-- <script src="{{asset('admin/vendor/bootstrap/js/bootstrap.min.js')}}"></script> --}}
  <script src="{{asset('admin/vendor/jquery.cookie/jquery.cookie.js')}}"> </script>
  <script src="{{asset('admin/vendor/chart.js/Chart.min.js')}}"></script>
  <script src="{{asset('admin/vendor/jquery-validation/jquery.validate.min.js')}}"></script>
  <script src="{{asset('admin/js/charts-home.js')}}"></script>
  <script src="{{asset('admin/js/front.js')}}"></script>
  
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script src="{{asset('admin/js/main.js')}}"></script>
  <script>
    // get message
    $(document).ready(function(){
        setInterval(() => {
            get_unread_messages()
        }, 3000);

        function get_unread_messages(){
            $.ajax({
                method:'POST',
                url:"{{route('admin.dashboard.messages.unread_messages')}}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success:function(data){
                    if(data.messages.length){
                        $('.messages-toggle').html('<i class="icon-email"></i>');
                        $('.messages-toggle').append('<span class="badge dashbg-1">'+data.messages.length+'</span>');
                        $('.messages').html('');
                        data.messages.forEach(function(msg){
                            let message =  msg.message.substring(0, 30);
                            message +='...';
                            $('.messages').append(`
                                        <a href="/admin/dashboard/messages/${msg.id}" class="p-0 m-0 d-block">
                                            <div class="p-1 m-1 bg-secondary text-white rounded">
                                                <h6 class="text-capitalize mb-1">${msg.name}</h6>
                                                <p class="mb-0">${message}</p>
                                            </div>
                                        </a>
                            `)
                        })
                    }else{
                        $('.messages').html('<div class="p-1">No Message</div>');
                    }
                },
                error:function(xhr,status,err){
                    console.log(err);
                }
            })
        }
        get_unread_messages();
        
    })
  </script>
  
  @yield('js-special')

</body>
</html>
