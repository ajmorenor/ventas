<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"> -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
  <link rel="stylesheet" href="{{ asset('dist/sweetalert.css') }}">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

  <!--link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">

    <title>Ventas Isocineticas RM</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
            html, body {
                position: relative;
                width: 100%;
                height: 120%;
                background: url("{{ asset('img/Principal.png') }}") no-repeat center center scroll;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                background-size: cover;
                -o-background-size: cover;
            }
            a span{ color: white; } /* CSS link color */
            a:hover span{
                color: #FF0000;
            }
    </style>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand btn btn-warning btn-sm btn-flat" href="{{ url('/') }}">
                       <span><b> {{ config('app.name', 'Ventas Isocineticas RM') }} </b></span>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a class="navbar-brand btn btn-warning btn-sm btn-flat" href="{{ route('login') }}"><span>Sesion</span></a></li>
                            <!--<li><a href="{{ route('register') }}">Register</a></li> -->
                        @else
<!--
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle btn btn-primary btn-sm btn-flat" data-toggle="dropdown" role="button" aria-expanded="false">
                                   <span><b> Indicadores </b></span> <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/indicadoresfuentes') }}">Gestion Fuentes</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/indicadores') }}">Gestion Metodos</a>
                                    </li>
                                </ul>
                            </li>
-->                            
                            <li><a href="{{ url('/indicadores') }}" class="btn btn-primary btn-sm btn-flat"><span><b>Indicadores</b></span></a></li>

                            <li><span class="separador">&nbsp;</span></li>

                            <li><a href="{{ url('/home') }}" class="btn btn-primary btn-sm btn-flat"><span><b>Gestion Empresa</b></span></a></li>
                            <li><span class="separador">&nbsp;</span></li>

                            <li><a href="{{ url('/fuentev') }}" class="btn btn-primary btn-sm btn-flat"><span><b>Fuentes</b></span></a></li>                        
                            <li><span class="separador">&nbsp;</span></li>

                            <li><a href="{{ url('/metodov') }}" class="btn btn-primary btn-sm btn-flat"><span><b>Metodos</b></span></a></li>
                            <li><span class="separador">&nbsp;</span></li>

                            <li><a href="{{ url('/allservicios') }}" class="btn btn-primary btn-sm btn-flat"><span><b>Busquedas</b></span></a></li>

                            <li><span class="separador">&nbsp;</span></li>
                            
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle btn btn-primary btn-sm btn-flat" data-toggle="dropdown" role="button" aria-expanded="false">
                                   <span><b> Registros </b></span> <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/proyeccion') }}">Proyeccion Ventas</a>
                                    </li>
                                </ul>
                            </li>

                            <li><span class="separador">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></li>

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle btn btn-warning btn-sm btn-flat" data-toggle="dropdown" role="button" aria-expanded="false">
                                   <span><b> {{ Auth::user()->name }} </b></span> <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('register') }}">Crear Usuario</a>
                                    </li>
                                    <li>

                                    <a href="{{ url('mail/barra') }}">Salir del Sistema</a>
        <!--                                
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                           // {{ csrf_field() }}
                                        </form>
        -->
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
 
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="{{ asset('js/funciones.js') }}"></script>


<script src="//code.jquery.com/jquery-2.1.1.js"></script>

<script src="{{ asset('dist/sweetalert.js') }}"></script>
 

  <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
</body>
</html>
<script>

    $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')     
        }
    }); 

  $(document).ready(function() {
    $('#proceso').DataTable(
    {
        "searching": true, // Search box and search function will be actived
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "processing": true,  // Show processing 
        "pageLength": 7,    // 5 rows per page
    });
    $('#fuentesvw').DataTable(
    {
        "searching": true, // Search box and search function will be actived
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "processing": true,  // Show processing 
        "pageLength": 7,    // 5 rows per page
    });
    $('#metodosvw').DataTable(
    {
        "searching": true, // Search box and search function will be actived
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "processing": true,  // Show processing 
        "pageLength": 7,    // 5 rows per page
    });
    $('#relacionvw').DataTable(
    {
        "searching": true, // Search box and search function will be actived
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "processing": true,  // Show processing 
        "pageLength": 7,    // 5 rows per page
    });
    $('#serviciovw').DataTable(
    {
        "searching": true, // Search box and search function will be actived
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "processing": true,  // Show processing 
        "pageLength": 6,    // 5 rows per page
    });
    $('#allservices').DataTable(
    {
        "searching": true, // Search box and search function will be actived
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "processing": true,  // Show processing 
        "pageLength": 6,    // 5 rows per page
    });
} );
 </script>