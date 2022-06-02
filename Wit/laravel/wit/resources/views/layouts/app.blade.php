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
        html {
            overflow: hidden;

        }

        body {
            overflow: hidden;
            width: 100vw;
            height: 100vh;
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

<template id="User-template">
    <li class="border-0 d-flex bg-white p-1 align-items-center justify-content-between">
        <div class="user">
            <a class="user-link link-dark text-decoration-none" href="" alt="">
                <img src="" alt="" width="50" height="50" class="profile-image rounded-circle me-2">
                <strong class="user-name"></strong>
            </a>
        </div>

        <div class="btn-group d-flex align-items-center p-2">
            <button type="button" class="add-list-user btn btn-outline-primary"><i class="bi bi-person-plus-fill"></i></button>
        </div>
    </li>
</template>

<template id="Room-template">
    <li>
        <div class="card border-0">
            <div class="card-header border-0 d-flex bg-white p-1 justify-content-between">
                <div class="user">
                    <a href="#" class="user-link link-dark p-1 text-decoration-none d-flex align-items-center">
                        <img src="" alt="" width="50" height="50" class="profile-image rounded-circle me-2">
                        <strong class="user-name"></strong>
                    </a>
                </div>

                <div class="btn-group d-flex align-items-center p-2">
                    @if(isset($type))
                        <p>typeが設定されています</p>
                    @endif

                    <button type="button" class="add-list-room btn btn-outline-primary p-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard-plus" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7z"/>
                        <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"/>
                        <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z"/>
                      </svg></button>
                    <button type="button" class="enter-room btn btn-outline-primary p-2" data-bs-toggle="modal"
                        data-bs-target="#roomPasswordFormModal"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
                            <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                          </svg></button>
                </div>
            </div>
        </div>

        <div class="card-body p-1 row align-items-center m-0">
            <strong class="card-title"></strong>
            <p class="card-text room-description text-break"></p>
        </div>

        <div class="card-footer border-0 bg-white p-0">
            <ul class="room_tags p-1">

            </ul>
        </div>
    </li>
</template>

<body>
    <div id="app">
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
                                        <a class="nav-link text-nowrap text-black" href="{{ route('register') }}">新規登録</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown d-flex align-items-center justify-content-center">
                                    <a id="navbarUserName" class="link-dark text-decoration-none dropdown-toggle "
                                        role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                        v-pre>
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


            <div id="error-message" class="alert alert-primary d-flex align-items-center fixed-top invisible"
                role="alert" style="z-index: 1060;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                    class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16">
                    <path
                        d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                </svg>
                <div>
                    {{ session('flashmessage') }}
                </div>
            </div>
        </header>

        <main>
            @yield('content')
        </main>


    </div>

    @stack('scripts')
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script>
        @if (session('flashmessage'))
            error = document.getElementById("error-message")
            error.classList.remove('invisible');
            setTimeout(() => {error.classList.add('invisible')}, 3000);
        @endif
    </script>
    
    <noscript>
        <div id="javascript-error" class="alert alert-primary d-flex align-items-center fixed-top " role="alert"
            style="z-index: 1060;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16">
                <path
                    d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
            </svg>
            <div>
                このアプリはJavascriptを使用しています。有効に設定してからお使いください
            </div>
        </div>
    </noscript>

</body>


</html>
