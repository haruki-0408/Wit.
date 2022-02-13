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

        header {
            height: 10vh;
        }

        main {
            height: 90vh;
        }

        .roomTags {
            overflow: scroll;
        }

        #right-content {
            overflow: scroll;
        }

        .carousel .carousel-indicators li {
            background-color: #333333;
        }

        #image img {
            width: auto;
            height: auto;
            max-width: 100%;
            max-height: 100%;
            vertical-align: middle;
        }

        .modal-body img{
            max-width:100vh;
            max-height:100vh;
        }

        .carousel-item {
            position: relative;
            width: 350px;
            height: 350px;
            display: table-cell;
            vertical-align: middle;
            text-align: center;
            border: 1px solid darkgray;
        }

        #chat {
            height: 40%;
        }

        .tag {
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

        .tag:before {
            content: '●';
            margin-right: .5em;

        }

        .tag:hover {
            color: #0d6efd;
            background-color: #fff;
        }

        ul {
            list-style: none;
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
                <div class="container-fluid">
                    <div class="col-2 d-none d-md-block ">
                        <div id="hostUser" class="d-flex justify-content-center">
                            <img src="https://github.com/mdo.png" alt="" width="50px" height="50px"
                                class="rounded-circle m-1">
                            <strong class="d-flex align-items-center">{{ Auth::user()->name }}</strong>
                        </div>
                    </div>


                    <div class="col-10 col-md-8 text-wrap fw-bold">
                        <h4 class="d-none d-md-block">テストルーム（カタカナ文字数制限）をいくつにするか？</h4>
                        <p class="d-sm-none fs-6">テストルーム（カタカナ文字数制限）をいくつにするか？</p>
                    </div>

                    <div class="col-2 d-flex justify-content-center ">
                        <a style="width:42px; height:30px;" href="/home" class="btn btn-outline-primary">
                            <i class="d-flex bi bi-arrow-bar-right align-items-center"></i>
                        </a>
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
            <div class="container-fluid h-100">
                <div class="row h-100">
                    <div id="left-content" class="bg-light col-3 p-3 d-none d-lg-block h-100 flex-column">
                        <div class="row h-100">
                            <div class="roomTags col-12 fs-5 h-50">
                                <i class="bi bi-tag-fill mx-2"></i>
                                Room tags :
                                <ul>
                                    <li><a class="tag"
                                            href="#">Foodadfafasfdsafasffffffffffffffasdfawesf<span
                                                class="badge badge-light">4</span></a></li>
                                    <li><a class="tag" href="#">Fassion<span
                                                class="badge badge-dark">5</span></a></li>
                                    <li><a class="tag" href="#">Mathmatics<span
                                                class="badge badge-dark">3</span></a></li>
                                    <li><a class="tag" href="#">Science<span
                                                class="badge badge-dark">15</span></a></li>
                                    <li><a class="tag" href="#">PHP<span
                                                class="badge badge-dark">194</span></a>
                                    </li>
                                    <li><a class="tag"
                                            href="#">Foodadfafasfdsafasffffffffffffffasdfawesf<span
                                                class="badge badge-light">4</span></a></li>
                                    <li><a class="tag" href="#">Fassion<span
                                                class="badge badge-dark">5</span></a></li>


                                </ul>
                            </div>
                            <hr>
                            <div class="settingButtons col-12 h-50">
                                ID : {{$id}}
                            </div>
                        </div>
                    </div>

                    <div id="center-content" class="col-sm-12 col-md-9 col-lg-6 h-100 m-0 p-0">
                        <div id="image" class="card col-12 h-50">
                            <div class="card-body p-0 w-100 h-100 ">
                                <div id="carouselExampleIndicators" class="carousel  slide w-100 h-100"
                                    data-bs-interval="false">
                                    <div class="carousel-indicators">
                                        <button type="button" data-bs-target="#carouselExampleIndicators"
                                            data-bs-slide-to="0" class="active" aria-current="true"
                                            aria-label="Slide 1"></button>
                                        <button type="button" data-bs-target="#carouselExampleIndicators"
                                            data-bs-slide-to="1" aria-label="Slide 2"></button>
                                        <button type="button" data-bs-target="#carouselExampleIndicators"
                                            data-bs-slide-to="2" aria-label="Slide 3"></button>
                                        <button type="button" data-bs-target="#carouselExampleIndicators"
                                            data-bs-slide-to="3" aria-label="Slide 4"></button>
                                    </div>
                                    <div class="carousel-inner justify-content-center">
                                        <div class="carousel-item active align-items-center">
                                            <img src="{{ asset('/images/sample01.jpg') }} " data-bs-toggle="modal"
                                                data-bs-target="#imageModal01">
                                            <!-- Modal -->
                                            <div class="modal fade" id="imageModal01" tabindex="-1"
                                                aria-labelledby="imageModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="{{ asset('/images/sample01.jpg') }} ">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="carousel-item">
                                            <img src="{{ asset('/images/sample02.jpg') }} " data-bs-toggle="modal"
                                                data-bs-target="#imageModal02">
                                            <!-- Modal -->
                                            <div class="modal fade" id="imageModal02" tabindex="-1"
                                                aria-labelledby="imageModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="{{ asset('/images/sample02.jpg') }} ">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="carousel-item">
                                            <img src="{{ asset('/images/sample03.jpg') }} " data-bs-toggle="modal"
                                                data-bs-target="#imageModal03">
                                            <!-- Modal -->
                                            <div class="modal fade" id="imageModal03" tabindex="-1"
                                                aria-labelledby="imageModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="{{ asset('/images/sample03.jpg') }} ">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="carousel-item ">
                                            <img src="{{ asset('/images/sample04.png') }} " data-bs-toggle="modal"
                                                data-bs-target="#imageModal04">
                                            <!-- Modal -->
                                            <div class="modal fade" id="imageModal04" tabindex="-1"
                                                aria-labelledby="imageModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="{{ asset('/images/sample04.png') }} ">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button class="carousel-control-prev" type="button"
                                        data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                        <i style="font-size:2rem; font-weight:bold; color:white;"
                                            class="bi bi-chevron-left"></i>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                        data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                        <i style="font-size:2rem; font-weight:bold; color:white;"
                                            class="bi bi-chevron-right"></i>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div id="chat" class="card col-12 h-50">
                            <div class="card-body">
                            </div>
                            <div class="card-footer">
                                <form>
                                    <div class="row">
                                        <div class="col-9">
                                            <input id="message" class="form-control" type="text">
                                        </div>
                                        <div class="col-3">
                                            <button type="button" class="btn btn-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
                                                    <path
                                                        d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z">
                                                    </path>
                                                </svg>

                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div id="right-content" class="col-3 bg-light d-none d-md-block p-1 h-100">
                        <div class="onlineUsers">
                            <i class="bi bi-person-workspace"></i>
                            <span class="fs-4">Online Users</span>
                            <ul class="flex-column">
                                <li class="p-2">
                                    <a href="#" class="d-flex align-items-center  link-dark text-decoration-none">
                                        <img src="https://github.com/haruki-0408.png" alt="" width="50" height="50"
                                            class="rounded-circle me-2">
                                        haruki
                                    </a>
                                </li>
                                <li class="p-2">
                                    <a href="#" class="d-flex align-items-center  link-dark text-decoration-none">
                                        <img src="https://github.com/mika.png" alt="" width="50" height="50"
                                            class="rounded-circle me-2">
                                        asdfghjkloiuytrewqas
                                    </a>
                                </li>
                                <li class="p-2">
                                    <a href="#" class="d-flex align-items-center  link-dark text-decoration-none">
                                        <img src="https://github.com/ham.png" alt="" width="50" height="50"
                                            class="rounded-circle me-2">
                                        roy
                                    </a>
                                </li>
                                <li class="p-2">
                                    <a href="#" class="d-flex align-items-center  link-dark text-decoration-none">
                                        <img src="https://github.com/erika.png" alt="" width="50" height="50"
                                            class="rounded-circle me-2">
                                        erika
                                    </a>
                                </li>
                                <li class="p-2">
                                    <a href="#" class="d-flex align-items-center  link-dark text-decoration-none">
                                        <img src="https://github.com/doggy.png" alt="" width="50" height="50"
                                            class="rounded-circle me-2">
                                        doggy
                                    </a>
                                </li>
                                <li class="p-2">
                                    <a href="#" class="d-flex align-items-center  link-dark text-decoration-none">
                                        <img src="https://github.com/tenten.png" alt="" width="50" height="50"
                                            class="rounded-circle me-2">
                                        tenten
                                    </a>
                                </li>
                                <li class="p-2">
                                    <a href="#" class="d-flex align-items-center  link-dark text-decoration-none">
                                        <img src="https://github.com/kaori.png" alt="" width="50" height="50"
                                            class="rounded-circle me-2">
                                        香織
                                    </a>
                                </li>
                                <li class="p-2">
                                    <a href="#" class="d-flex align-items-center  link-dark text-decoration-none">
                                        <img src="https://github.com/Hong.png" alt="" width="50" height="50"
                                            class="rounded-circle me-2">
                                        Hong
                                    </a>
                                </li>
                                <li class="p-2">
                                    <a href="#" class="d-flex align-items-center  link-dark text-decoration-none">
                                        <img src="https://github.com/dod.png" alt="" width="50" height="50"
                                            class="rounded-circle me-2">
                                        rice-cooker
                                    </a>
                                </li>
                                <li class="p-2">
                                    <a href="#" class="d-flex align-items-center  link-dark text-decoration-none">
                                        <img src="https://github.com/d2.png" alt="" width="50" height="50"
                                            class="rounded-circle me-2">
                                        anchan1223
                                    </a>
                                </li>
                                <li class="p-2">
                                    <a href="#" class="d-flex align-items-center  link-dark text-decoration-none">
                                        <img src="https://github.com/jang.png" alt="" width="50" height="50"
                                            class="rounded-circle me-2">
                                        まさや
                                    </a>
                                </li>


                            </ul>
                        </div>
                    </div>

                </div>
            </div>


            <div style="width:200px;" class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasLeft"
                aria-labelledby="offcanvasLeftLabel">
                <div class="offcanvas-header">
                    <h5 id="offcanvasLeftLabel">Left</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    ...
                </div>
            </div>

            <div style="width:100px;" class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight"
                aria-labelledby="offcanvasRightLabel">
                <div class="offcanvas-header">
                    <h5 id="offcanvasRightLabel">Right</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    ...
                </div>
            </div>

        </main>

    </div>
</body>

</html>
