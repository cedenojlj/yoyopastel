<!doctype html>
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
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}"> Yoyopastel </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                        @auth

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('empresas.index') }}">Empresas</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('empleados.index') }}">Empleados</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('proveedors.index') }}">Proveedores</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('clientes.index') }}">Clientes</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#">Compras</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#">Ventas</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">Productos</a>
                            <div class="dropdown-menu">

                              <a class="dropdown-item" href="{{ route('productos.index') }}">Productos</a>
                              <a class="dropdown-item" href="{{ route('materials.index') }}">Materiales</a>
                              <a class="dropdown-item" href="#">Costos</a>
                              <a class="dropdown-item" href="{{ route('categorias.index') }}">Categorias</a>
                              <a class="dropdown-item" href="{{ route('invmaterials.index') }}">Inventario Materiales</a>
                              <a class="dropdown-item" href="{{ route('invproductos.index') }}">Inventario Productos</a>
                              <a class="dropdown-item" href="{{ route('paridads.index') }}">Paridad</a>
                              
                            </div>
                          </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pagos.index') }}">Pagos</a>
                        </li>
                                               

                          <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">Reportes</a>
                            <div class="dropdown-menu">

                              <a class="dropdown-item" href="#">Reporte A</a>
                              <a class="dropdown-item" href="#">Reporte B</a>
                              
                            </div>
                          </li>

                        @endauth

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>