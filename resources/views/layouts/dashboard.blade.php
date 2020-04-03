<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Reveal Bootstrap Template</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicons -->
  <link href="static/img/favicon.png" rel="icon">
  <link href="static/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800|Montserrat:300,400,700" rel="stylesheet">

  <!-- Bootstrap CSS File -->
  <link href="static/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Libraries CSS Files -->
  <link href="static/lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="static/lib/animate/animate.min.css" rel="stylesheet">
  <link href="static/lib/ionicons/css/ionicons.min.css" rel="stylesheet">
  <link href="static/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="static/lib/magnific-popup/magnific-popup.css" rel="stylesheet">
  <link href="static/lib/ionicons/css/ionicons.min.css" rel="stylesheet">

  <!-- Main Stylesheet File -->
  <link href="static/css/style.css" rel="stylesheet">

  <!-- =======================================================
    Theme Name: Reveal
    Theme URL: https://bootstrapmade.com/reveal-bootstrap-corporate-template/
    Author: BootstrapMade.com
    License: https://bootstrapmade.com/license/
  ======================================================= -->
</head>

<body id="body" style="background-image: url(static/img/pattern.jpg); ">

  <!--==========================
    Top Bar
  ============================-->
  <section id="topbar" class="d-none d-lg-block">
    <div class="container clearfix">
      <div class="contact-info float-left">

      </div>
      <div class="social-links float-right">
          @if (Route::has('login'))
                    @auth
                        @if($datos == 1)
                        <a href="{{ url('/cuenta') }}">Dashboard</a>
                        @else

                            <li class="nav-item dropdown" style="list-style: none;">
                                <a href="{{ url('/') }}">Inicio</a>
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                         {{ csrf_field() }}
                                    </form>
                                </div>
                            </li>
                        @endif

                    @else
                        <a href="{{ route('login') }}" class="twitter">Login</a>
                        <a href="{{ route('register') }}" class="facebook">Registro</a>
                    @endauth
            @endif

      </div>
    </div>
  </section>

  <!--==========================
    Header
  ============================-->
  <header id="header">
    <div class="container">

      <div id="logo" class="pull-left">
        <h1><a href="{{url('/')}}" class="scrollto">Mi<span>Banco</span></a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="#body"><img src="img/logo.png" alt="" title="" /></a>-->
      </div>

      <nav id="nav-menu-container">
        <ul class="nav-menu">
          @if($datos == 1)
          <li class="menu-active"><a href="{{url('/')}}">Inicio</a></li>
          <li><a href="{{url('/#about')}}">Funcion</a></li>
          <li><a href="{{url('/#services')}}">Servicios</a></li>
          <!--<li><a href="{{url('/#portfolio')}}">Portfolio</a></li>-->
          <li><a href="{{url('/#team')}}">Equipo</a></li>
          @else
          <li ><a href="{{url('/cuenta')}}">Dashboard</a></li>
          <li ><a href="{{url('/credito')}}">Credito</a></li>
          <!--<li><a href="{{url('/#portfolio')}}">Portfolio</a></li>-->
          @endif 
        </ul>
      </nav><!-- #nav-menu-container -->
    </div>
  </header><!-- #header -->


            @yield('content')


  <!-- JavaScript Libraries -->
  <script src="static/lib/jquery/jquery.min.js"></script>
  <script src="static/lib/jquery/jquery-migrate.min.js"></script>
  <script src="static/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="static/lib/easing/easing.min.js"></script>
  <script src="static/lib/superfish/hoverIntent.js"></script>
  <script src="static/lib/superfish/superfish.min.js"></script>
  <script src="static/lib/wow/wow.min.js"></script>
  <script src="static/lib/owlcarousel/owl.carousel.min.js"></script>
  <script src="static/lib/magnific-popup/magnific-popup.min.js"></script>
  <script src="static/lib/sticky/sticky.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8HeI8o-c1NppZA-92oYlXakhDPYR7XMY"></script>
  <!-- Contact Form JavaScript File -->
  <script src="static/contactform/contactform.js"></script>

  <!-- Template Main Javascript File -->
  <script src="static/js/main.js"></script>

</body>
</html>
