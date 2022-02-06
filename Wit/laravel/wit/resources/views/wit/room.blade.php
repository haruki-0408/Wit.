<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Room:{{ $id }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        main {
            padding-top: 60px;
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

    </style>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">

</head>

<body>
    <div id="2">
        <header>
            <nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm ">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3">
                            <strong>
                                ID:{{ $id }}
                            </strong>
                            <img src="https://github.com/mdo.png" alt="" width="80" height="80"
                                    class="rounded-circle me-2">
                                <strong>{{ Auth::user()->name }}</strong>
                        </div>
                        <div class="col-9">
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

                                    <div class="input-group p-2 align-items-center">
                                        <input class="form-control mx-2" type="text">
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

                                </div>
                            </div>
                        </div>
                    </div>
            </nav>
        </header>
        <main>
        </main>

    </div>
</body>

</html>
