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

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        header {
            padding-bottom: 60px;
        }

        .tags {
            display: inline-block;
            margin: 0 .1em .6em 0;
            padding: .6em;
            line-height: 1;
            color: #fff;
            text-decoration: none;
            background-color: #0d6efd;
            border-radius: 2em 0 0 2em;
            font-size: 12px;
        }

        .tags:before {
            content: '●';
            margin-right: .5em;

        }

        .tags:hover {
            color: #0d6efd;
            background-color: #fff;
        }

        #Room-content {
            max-height: 150vh;
            overflow: scroll;
        }

        ul {
            list-style-type: none;
        }


        }

    </style>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">


</head>

<body>
    <div id="wit">
        <header>
            <nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm fixed-top">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
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

                            <div class="input-group p-2">
                                <input class="form-control mx-2" type="text" placeholder="KEYWORD">
                                <a> <i class="btn btn-primary bi bi-search"></i> </a>
                            </div>

                            <div class="btn-group p-2">
                                <button class="btn btn-primary dropdown-toggle mx-3" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="true"><i
                                        class="bi bi-filter-square"></i></button>
                                <ul class="dropdown-menu">
                                    ...
                                </ul>
                            </div>

                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link text-nowrap" href="{{ route('login') }}">ログイン</a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link text-nowrap" href="{{ route('register') }}">新規登録</a>
                                    </li>
                                @endif
                            @else

                                <li class="nav-item text-center dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle " href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
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
</body>

</html>
