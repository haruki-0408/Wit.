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
            <nav class="navbar navbar-light bg-light shadow-sm ">
                <div class="container">
                    <div class="col-2 d-none d-md-block d-flex justify-content-center align-items-center">
                        <div class="row">
                            <strong>
                                ID:{{ $id }}329343854753438439436556456
                            </strong>
                        </div>
                        <div class="row">
                            <div class="hostUser">
                                <img src="https://github.com/mdo.png" alt="" width="80px" height="80px"
                                    class="rounded-circle me-2">
                                <strong>{{ Auth::user()->name }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-11 col-md-9 text-truncate fw-bold">
                        Let's Create Room Starting I'm glad to meeting you and that222fdfer
                    </div>
                    <div class="col-1 m-0 d-flex justify-content-center">
                        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas"data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><i class="bi bi-arrow-bar-left"></i></button>
                        
                        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight"
                            aria-labelledby="offcanvasRightLabel">
                            <div class="offcanvas-header">
                                <h5 id="offcanvasRightLabel">Offcanvas right</h5>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                ...
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
