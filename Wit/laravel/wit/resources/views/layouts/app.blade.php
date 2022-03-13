<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        body {
            overflow: hidden;
        }

        .tag {
            display: inline-block;
            margin: 0 .1em .6em .2em;
            padding: .5em;
            color: #fff;
            text-align: center;
            text-decoration: none;
            background-color: #0d6efd;
            border-radius: 2em 0 0 2em;
            font-size: 10px;
        }

        .tag:before {
            content: '●';
            margin-right: .5em;
        }

        .tag:hover {
            color: #0d6efd;
            background-color: #fff;
        }

        #Room-content {
            height: 85%;
            overflow: scroll;
        }

        ul {
            list-style-type: none;
        }

        .btn-room-create {
            display: inline-block;
            text-decoration: none;
            width: 50px;
            height: 50px;
            border-width: thin;
            border-color: #0d6efd;
            border-radius: 50%;
            text-align: center;
            font-size: 20px;
            background-color: white;
            /* transition: .3s;*/
            color: #0d6efd;
            box-shadow: 0 3px 10ex white;
        }

        .btn-room-create:hover {
            background-color: #0d6efd;
            /* transition: .3s;*/
            color: white;
        }

    </style>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">


</head>

<body>
    <div id="app" class="h-100">
        <header>
            <nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/home') }}">
                        <img style="width:40px;height:40px;" src="{{ asset('/images/wit/wit.png') }} ">
                        {{ config('app.name') }}

                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->

                        <!-- Right Side Of Navbar -->
                        <div class="navbar-nav ms-auto">
                            <!-- Authentication Links -->
                            @yield('home-only')


                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link text-nowrap text-black" href="{{ route('login') }}">ログイン</a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link text-nowrap text-black"
                                            href="{{ route('register') }}">新規登録</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item text-center dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle " href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                                                         document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>

                            @endguest
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <main>
            @yield('content')
        </main>

    </div>

    @stack('scripts')
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery.js') }}"></script>
   
    
</body>


</html>
