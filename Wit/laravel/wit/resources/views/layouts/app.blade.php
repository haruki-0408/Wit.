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
            border: none;
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
            background-color: #fff;
            /* transition: .3s;*/
            color: #0d6efd;
            box-shadow: 0 3px 10ex #fff;
        }

        .btn-room-create:hover {
            background-color: #0d6efd;
            /* transition: .3s;*/
            color: #fff;
        }
    </style>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">


</head>

<template id="User-template">
    <li class="d-flex bg-white p-1 justify-content-between">
        <div class="user">
            <a class="user-link link-dark text-decoration-none d-flex align-items-center p-1" href="#"
                alt="">
                <img src="" alt="" width="50" height="50"
                    class="profile-image rounded-circle me-2">
                <strong class="user-name text-break"></strong>
            </a>
        </div>
        <div class="btn-group d-flex align-items-center p-2">

        </div>
    </li>
</template>

<template id="Room-template">
    <li>
        <div class="card border-0">
            <div class="card-header border-0 d-flex bg-white p-1 justify-content-between">
                <div class="user">
                    <a href="#" class="user-link link-dark p-1 text-decoration-none d-flex align-items-center">
                        <img src="" alt="" width="50" height="50"
                            class="profile-image rounded-circle me-2">
                        <strong class="user-name text-break"></strong>
                    </a>
                </div>

                <div class="btn-group d-flex align-items-center p-2">

                </div>
            </div>
        </div>

        <div class="card-body p-1 row d-flex align-items-center m-0">
            <strong class="card-title m-0 pb-1"></strong>
            <p class="card-text room-description text-break m-0"></p>
            <small class="text-muted d-flex justify-content-end text-end">
                <div class="mx-2 countOnlineUsers">
                </div>
                <div class="countChatMessages">
                </div>
            </small>
            <small class="d-block text-end text-muted created_at"></small>
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
                                        <strong style="font-size:10px;">{{ Auth::user()->name }}</strong>
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


            <div id="error-message" class="alert alert-primary d-flex align-items-center fixed-top invisible"
                role="alert" style="z-index: 1060;">
                <svg width="24" height="24" fill="currentColor"
                    class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16">
                    <path
                        d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                </svg>
                <div>
                    {{ session('error_message') }}
                </div>
            </div>

            <div id="action-message" class="alert alert-success d-flex align-items-center fixed-top invisible"
                role="alert" style="z-index: 1050;">
                <svg width="16" height="16" fill="currentColor" class="bi bi-hand-thumbs-up-fill me-2"
                    viewBox="0 0 16 16">
                    <path
                        d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z" />
                </svg>
                <div>
                    {{ session('action_message') }}
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
        @if (session('action_message'))
            action = document.getElementById("action-message")
            action.classList.remove('invisible');
            setTimeout(() => {
                action.classList.add('invisible')
            }, 3000);
        @endif

        @if (session('error_message'))
            error = document.getElementById("error-message")
            error.classList.remove('invisible');
            setTimeout(() => {
                error.classList.add('invisible')
            }, 3000);
        @endif

        @if ($errors->hasAny([
            'title',
            'description',
            'sumImageSize',
            'sumImageCount',
            'roomImages.*',
            'matches.*',
            'createPass',
        ]))
            if (document.getElementById('createRoomModalButton')) {
                const myModal = document.getElementById('createRoomModalButton');
                myModal.click();
            }
        @elseif($errors->hasAny(['currentPass', 'newPass']))
            if (document.getElementById('changePasswordModalButton')) {
                const change_password_button = document.getElementById('changePasswordModalButton');
                change_password_button.click();
            }
        @elseif($errors->has('infoPass'))
            if (document.getElementById('informationPasswordModalButton')) {
                const info_password_button = document.getElementById('informationPasswordModalButton');
                info_password_button.click();
            } else if (document.getElementById('informationPasswordModalButtonFooter')) {
                const info_password_button2 = document.getElementById('informationPasswordModalButtonFooter');
                info_password_button2.click();
            }
        @elseif($errors->has('deletePass'))
            if (document.getElementById('deleteAccountPasswordModalButton')) {
                const delete_password_button = document.getElementById('deleteAccountPasswordModalButton');
                delete_password_button.click();
            } else if (document.getElementById('deleteAccountPasswordModalButtonFooter')) {
                const delete_password_button2 = document.getElementById(
                    'deleteAccountPasswordModalButtonFooter');
                delete_password_button2.click();
            }
        @elseif($errors->has('enterPass'))
            const room_id = '{{ old('room_id') }}';
            const room = document.querySelector('[data-room-id="' + room_id + '"]');
            const enter_password_button = room.querySelector('[data-bs-target = "#roomPasswordFormModal"]');
            enter_password_button.click();
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
