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
        body {
            height: 100vh;
        }

        #app {
            height: 100%;
        }

        header {
            height: 10vh;
        }

        main {
            height: 90vh;
        }

        #image {
            height: 50%;
        }

        #chat {
            height: 50%;
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
    <div id="app">
        <header>
            <nav style="" class="navbar navbar-light bg-light shadow-sm h-100">
                <div class="container">
                    <div class="col-2 d-none d-md-block d-flex justify-content-center align-items-center">
                        <div class="row">
                            <div class="hostUser">
                                <img src="https://github.com/mdo.png" alt="" width="50px" height="50px"
                                    class="rounded-circle ">
                                <strong>{{ Auth::user()->name }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-10 text-wrap fw-bold">
                        <h2>Greet</h2>
                    </div>
                </div>
            </nav>
        </header>

        <main>
            <!--<div class="row">
            <div class="col-6">
                <a class="d-md-none d-flex justify-content-start align-middle" data-bs-toggle="offcanvas"
                    href="#offcanvasLeft" role="button" aria-controls="offcanvasLeft">
                    <i class="bi bi-chevron-right"></i>
                </a>
            </div>
            <div class="col-6">
                <a class="d-md-none d-flex justify-content-end align-middle" data-bs-toggle="offcanvas"
                    href="#offcanvasRight" role="button" aria-controls="offcanvasRight">
                    <i class="bi bi-chevron-left"></i>
                </a>
            </div>
        </div> -->
            

            <div id="image" class="card col-12">
                <div class="card-body w-100 h-100">
                    <div id="carouselExampleIndicators" class="bg-dark carousel slide w-100 h-100" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                                class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                                aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                                aria-label="Slide 3"></button>
                        </div>
                        <div class="carousel-inner w-100 h-100">
                            <div class="carousel-item active w-100 h-100">
                                <img class="w-100 h-100" src="{{ asset('/images/sample01.jpg') }} " >
                            </div>
                            <div class="carousel-item w-100 h-100">
                                <img class="w-100 h-100" src="{{ asset('/images/sample02.jpg') }} " >
                            </div>
                            <div class="carousel-item w-100 h-100">
                                <img class="w-100 h-100" src="{{ asset('/images/sample03.jpg') }} ">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>

            <div id="chat" class="card col-12 d-flex">
                <div class="card-header bg-dark text-light">Chat</div>
                <div class="card-body">
                </div>
            </div>
            <div class="card-footer">
                <form>
                    <div class="row">
                        <div class="col-9">
                            <input id="message" class="form-control" type="text">
                        </div>
                        <div class="col-3">
                            <button type="button" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-send" viewBox="0 0 16 16">
                                    <path
                                        d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z">
                                    </path>
                                </svg>
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">
                                    </font>
                                </font>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
    </div>



    </div>

    <div style="width:200px;" class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasLeft"
        aria-labelledby="offcanvasLeftLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasRightLabel">Left</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            ...
        </div>
    </div>

    <div style="width:100px;" class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight"
        aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasRightLabel">Right</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            ...
        </div>
    </div>

    </main>

    </div>
</body>

</html>
