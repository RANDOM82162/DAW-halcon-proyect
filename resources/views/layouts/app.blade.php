<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Panel Administrativo</title>

    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/favicon/favicon-96x96.png') }}">
    <meta name="theme-color" content="#ffffff">

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    
    <div class="sidebar sidebar-dark sidebar-fixed border-end" id="sidebar">
        <!-- Sidebar content -->
        <div class="sidebar-header border-bottom">
            <div class="sidebar-brand">
                <svg class="sidebar-brand-full" width="88" height="32" alt="CoreUI Logo">
                    <use xlink:href="{{ asset('assets/brand/coreui.svg#full') }}"></use>
                </svg>
                <svg class="sidebar-brand-narrow" width="32" height="32" alt="CoreUI Logo">
                    <use xlink:href="{{ asset('assets/brand/coreui.svg#signet') }}"></use>
                </svg>
            </div>
            <button class="btn-close d-lg-none" type="button" data-coreui-theme="dark" aria-label="Close" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()"></button>
        </div>
        
        <ul class="sidebar-nav" data-coreui="navigation" data-simplebar>
            <!-- Nav content -->
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('assets/icons/sprites/free.svg#cil-speedometer') }}"></use>
                    </svg> @if(auth()->check()) Dashboard @else Inicio @endif
                </a>
            </li>
            @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('assets/icons/sprites/free.svg#cil-lock-locked') }}"></use>
                    </svg> Login
                </a>
            </li>
            @endguest
            @auth
            <li class="nav-item">
                <a class="nav-link {{ request()->is('users*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('assets/icons/sprites/free.svg#cil-group') }}"></use>
                    </svg> Usuarios
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('orders*') ? 'active' : '' }}" href="{{ route('orders.index') }}">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('assets/icons/sprites/free.svg#cil-cart') }}"></use>
                    </svg> Pedidos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('inventories*') ? 'active' : '' }}" href="{{ route('inventories.index') }}">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('assets/icons/sprites/free.svg#cil-storage') }}"></use>
                    </svg> Inventario
                </a>
            </li>
            @endauth
        </ul>
        
        <div class="sidebar-footer border-top d-none d-md-flex">     
            <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
        </div>
    </div>

    <div class="wrapper d-flex flex-column min-vh-100 bg-light">
        
        <header class="header header-sticky p-0 mb-4">
            <div class="container-fluid border-bottom px-4">
                <button class="header-toggler" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()" style="margin-inline-start: -14px;">
                    <svg class="icon icon-lg">
                        <use xlink:href="{{ asset('assets/icons/sprites/free.svg#cil-menu') }}"></use>
                    </svg>
                </button>
                
                <ul class="header-nav d-none d-lg-flex">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Inicio</a></li>
                </ul>

                <ul class="header-nav ms-auto">
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
                            <a class="nav-link py-0 pe-0 d-flex align-items-center" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                <span class="me-2">{{ Auth::user()->name }}</span>
                                <div class="avatar avatar-md">
                                    <img class="avatar-img" src="{{ asset('assets/img/avatars/8.jpg') }}" alt="{{ Auth::user()->email }}">
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end pt-0">
                                <div class="dropdown-header bg-body-tertiary text-body-secondary fw-semibold rounded-top mb-2">Cuenta</div>
                                
                                <a class="dropdown-item" href="#">
                                    <svg class="icon me-2">
                                        <use xlink:href="{{ asset('assets/icons/sprites/free.svg#cil-user') }}"></use>
                                    </svg> Perfil
                                </a>
                                
                                <div class="dropdown-divider"></div>
                                
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <svg class="icon me-2">
                                        <use xlink:href="{{ asset('assets/icons/sprites/free.svg#cil-account-logout') }}"></use>
                                    </svg> {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
            
            <div class="container-fluid px-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb my-0">
                        <li class="breadcrumb-item active"><span>Dashboard</span></li>
                    </ol>
                </nav>
            </div>
        </header>

        <div class="body flex-grow-1">
            <div class="container-lg px-4">
                @yield('content')
            </div>
        </div>

        <footer class="footer px-4">
            <div><a href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a> &copy; {{ date('Y') }}.</div>
            <div class="ms-auto">Powered by CoreUI & Laravel</div>
        </footer>
    </div>

    <script>
      document.addEventListener('DOMContentLoaded', () => {
          const header = document.querySelector('header.header');
          document.addEventListener('scroll', () => {
            if (header) {
              header.classList.toggle('shadow-sm', document.documentElement.scrollTop > 0);
            }
          });
      });
    </script>
</body>
</html>