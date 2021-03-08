<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>{{ config('app.name', 'Laravel') }}</title>
      <!-- Scripts -->
      <script src="{{ asset('js/app.js') }}" defer></script>
      <!-- Fonts -->
      <link rel="dns-prefetch" href="https://fonts.gstatic.com">
      <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
      <!-- Styles -->
      <link href="{{ asset('css/app.css') }}" rel="stylesheet">
   </head>
   <body>
      <div >
         <nav class="navbar navbar-expand-md navbar-dark bg-dark navbar-laravel">
            <div class="container">
               <a class="navbar-brand" href="{{ url('/') }}">
               {{ config('app.name') }}
               </a>
               <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
               <span class="navbar-toggler-icon"></span>
               </button>
               <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <!-- Left Side Of Navbar -->
                  <ul class="navbar-nav mr-auto">
                  </ul>
                  <!-- Right Side Of Navbar -->
                  <ul class="navbar-nav ml-auto">
                     <!-- Authentication Links -->
                     @guest
                     <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                     </li>
                     <li class="nav-item">
                        @if (Route::has('register'))
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        @endif
                     </li>
                     @else
                     <li class="nav-item">
                        <a class="nav-link" href="/buses">Buses</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="/transports">Transports</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="/transport/add">Add a transport</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="/transport/pending">Pending requests</a>
                     </li>
                    
                    @if(Auth::user()->admin==1)
                     <li class="nav-item">
                        <a class="nav-link" href="/transport/_dispatch">Approval</a>
                     </li>
                     @endif


                     <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                           <a class="dropdown-item" href="{{ route('logout') }}"
                              onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                           {{ __('Logout') }}
                           </a>
                           <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                              @csrf
                           </form>
                        </div>
                     </li>
                     
                     @endguest
                  </ul>
               </div>
            </div>
         </nav>
         <div style="margin-top:60px;">
         @yield('content')
         </div>
      </div>
      <footer style="margin-top:700px">
         <div class="container">
            <div class="row">
               <div class="col-md-4 col-sm-6 col-xs-12">
                  <span class="logo">E-ticketing</span>
               </div>
               <div class="col-md-4 col-sm-6 col-xs-12">
                  <ul class="menu">
                     <span>Menu</span>    
                     <li>
                        <a href="/">Home</a>
                     </li>
                     <li>
                        <a href="/about">About</a>
                     </li>
                     <li>
                        <a href="#">Blog</a>
                     </li>
                     <li>
                        <a href="/gallery">Gallery</a>
                     </li>
                  </ul>
               </div>
               <div class="col-md-4 col-sm-6 col-xs-12">
                  <ul class="address">
                     <span>Contact</span>       
                     <li>
                        <i class="fa fa-phone" aria-hidden="true"></i> <a href="#">Phone</a>
                     </li>
                     <li>
                        <i class="fa fa-map-marker" aria-hidden="true"></i> <a href="#">Adress</a>
                     </li>
                     <li>
                        <i class="fa fa-envelope" aria-hidden="true"></i> <a href="mailto:sxs@sn.com">Email</a>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
      </footer>
      <style>
         @import url('https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900');
         body{
         font-family: 'Roboto', sans-serif;
         }
         .search-text{
         margin-top:50px;
         background-color: #272d33;
         padding-top:60px;
         padding-bottom:60px;
         }
         .search-text .input-search{
         height:45px;
         width:40%;
         padding-left:20px;
         color:#333;
         } 
         .search-text .btn-search{
         background: #da3e44;
         font-family:Roboto;
         border:none;
         color:#FFF;
         height: 45px;
         width: 80px;
         }
         .search-text h4{
         color: #FFF;
         font-weight: 700;
         }
         footer{
         background-color: #33383c;
         padding:30px 0px;
         }	       
         .logo{
         color:#FFF;
         font-weight:700;
         font-size:30px;
         }
         .address span , .menu span{
         color: #FFF; 
         font-weight: bold; 
         border-bottom: 1px solid #c7c7c7; 
         padding:10px 0px;
         display: block;
         text-transform: uppercase;
         font-size: 16px;
         letter-spacing: 3px;
         }
         .address li a , .menu li a{
         color:#FFF;
         letter-spacing: 3px;
         text-decoration:none;
         font-size:14px;
         }
         .address li, .menu li{
         margin:20px 0px;
         list-style: none;
         }
         .address li a:hover , .menu li a:hover{
         color: #da3e44;
         -webkit-transition: all 1s ease-in-out;
         -moz-transition: all 1s ease-in-out;
         -o-transition: all 1s ease-in-out;
         transition: all 1s ease-in-out;
         }
         .address .fa{
         color: #da3e44;
         margin-right: 10px;
         font-size:18px;
         }
      </style>
   </body>
</html>