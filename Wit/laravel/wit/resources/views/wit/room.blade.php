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

        .roomTagsList {
            overflow: scroll;
        }

        #onlineUsersList {
            height: 90%;
            overflow: scroll;
        }


        :-webkit-full-screen {
            background-color: #f8f9fa;
        }

        :-webkit-full-screen img {
            display: block;
            margin: auto;
            cursor: pointer;
        }

        .carousel-item img {
            max-width: 100%;
            max-height: 100%;
        }

        #chat {
            height: 50%;
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

 <!-- Offcanvas -->
 <div style="width:90px;" class="offcanvas d-flex align-items-start justify-content-center offcanvas-end"
 tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
 <div class="offcanvas-header">
     <div id="offcanvasRightLabel">
         <img src="https://github.com/haruki-0408.png" alt="" width="30" height="30"
             class="rounded-circle me-2">
     </div>
     <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
         aria-label="Close"></button>
 </div>

 <div class="offcanvas-body d-flex flex-column ">
     <div data-bs-toggle="modal" data-bs-target="#users" class="onlineUsers pb-3">
         <i style="width:30px; height:30px" class="bi bi-person-check-fill mx-2"></i>
     </div>

     <div data-bs-toggle="modal" data-bs-target="#tags" class="roomTags pb-3">
         <i style="width:30px; height:30px" class="bi bi-tag-fill mx-2"></i>
     </div>

     <div class="information pb-3">
         <i style="width:30px; height:30px" class="bi bi-info-circle-fill mx-2"></i>
     </div>

     <div class="exitRoomButton pt-3">
         <a style="width:42px; height:30px;" href="/home" class="btn btn-outline-primary">
             <i class="d-flex bi bi-arrow-bar-right align-items-center"></i>
         </a>
     </div>
 </div>
</div>

<!-- Mordals -->
<div class="modal fade" id="users" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
 aria-labelledby="users" aria-hidden="true">
 <div class="modal-dialog modal-dialog-scrollable">
     <div class="modal-content">
         <div class="modal-header">
             <h5 class="modal-title" id="users"><i class="bi bi-person-check-fill mx-2"></i>Online</h5>
             <button type="button" class="btn-close" data-bs-dismiss="modal"
                 aria-label="Close"></button>
         </div>
         <div class="modal-body">
             @component('wit.room-users')
             @endcomponent
         </div>
         <div class="modal-footer">
             <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
         </div>
     </div>
 </div>
</div>

<div class="modal fade" id="tags" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
 aria-labelledby="tags" aria-hidden="true">
 <div class="modal-dialog modal-dialog-scrollable">
     <div class="modal-content">
         <div class="modal-header">
             
             <h5 class="modal-title" id="tags"><i class="bi bi-tag-fill mx-2"></i>Room Tags</h5>
             <div class="col-1"></div>
             <a href="#" class="btn btn-outline-primary">+<i class="bi bi-tags-fill"></i></a>
             <button type="button" class="btn-close" data-bs-dismiss="modal"
                 aria-label="Close"></button>
         </div>
         <div class="modal-body">
             <div class="d-flex flex-column p-3  ">
                 @component('wit.room-tags')

                 @endcomponent
             </div>
         </div>
         <div class="modal-footer">
             <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
         </div>
     </div>
 </div>
</div>

<body>
    <div id="app">
        <header>
            <nav style="" class="navbar navbar-light bg-light shadow-sm h-100">
                <div class="container-fluid">
                    <div class="col-2 d-none d-md-block ">
                        <div id="hostUser" class="d-flex justify-content-center">
                            <img src="{{ Auth::user()->profile_image }}" alt="" width="50px" height="50px"
                                class="rounded-circle m-1">
                            <strong class="d-flex align-items-center">{{ Auth::user()->name }}</strong>
                        </div>
                    </div>

                    <div class="col-10 col-md-8 text-wrap fw-bold">
                        <h4 class="d-none d-md-block">テストルーム（カタカナ文字数制限）をいくつにするか？ここまでで３３文字</h4>
                        <p class="d-sm-none">テストルーム（カタカナ文字数制限）をいくつにするか？ここまでで３３文字
                        </p>
                    </div>

                    <div class="exitRoomButton col-2 d-none d-md-block d-flex justify-content-center ">
                        <a style="width:42px; height:30px;" href="/home"
                            class="d-flex justify-content-center btn btn-outline-primary">
                            <i class="d-flex bi bi-arrow-bar-right align-items-center"></i>
                        </a>

                    </div>

                    <div class="col-2 d-sm-none d-flex justify-content-center ">
                        <a data-bs-toggle="offcanvas" href="#offcanvasRight" role="button"
                            aria-controls="offcanvasRight">
                            <button class="navbar-toggler" type="button">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                        </a>
                    </div>

                </div>
            </nav>
        </header>

        <main>
            <div class="container-fluid h-100">
                <div class="row h-100">
                    <div id="left-content" class="bg-light col-3 p-3 d-none d-lg-block h-100 flex-column">
                        <div class="row h-100">
                            <div class="row roomTags">
                                <div class="col-6 p-0 text-start">
                                    <i class="bi bi-tag-fill mx-2"></i>
                                    <strong>Room tags</strong>
                                </div>
                                <div class="col-6 p-0 text-end">
                                    <a href="#" class="btn btn-outline-primary">+<i class="bi bi-tags-fill"></i></a>
                                </div>
                            </div>
                            <div class="roomTagsList col-12 fs-5 h-25">
                                @component('wit.room-tags')
                                @endcomponent
                            </div>
                            <hr>
                            <div class="settingButtons col-12 h-50">
                                ID : {{ $id }}
                            </div>
                        </div>
                    </div>

                    <div id="center-content" class="col-sm-12 col-md-9 col-lg-6 h-100 m-0 p-0">
                        <div id="image" class="h-50">
                            <div id="carouselIndicators"
                                class="carousel slide w-100 h-100 p-0 m-0 d-flex align-items-center "
                                data-bs-interval="false">
                                <div class="carousel-indicators">
                                    <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="0"
                                        class="active" aria-current="true" aria-label="Slide 1"></button>
                                    <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                    <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                </div>

                                <div class="carousel-inner d-flex align-items-center h-100 w-100">
                                    <div id='img01' onclick="this.webkitRequestFullScreen();"
                                        class="carousel-item active">
                                        <img src="{{ asset('/images/sample01.png') }} ">
                                    </div>

                                    <div id='img02' onclick="this.webkitRequestFullScreen();" class="carousel-item">
                                        <img src="{{ asset('/images/sample02.png') }} ">
                                    </div>

                                    <div id='img05' onclick="this.webkitRequestFullScreen();" class="carousel-item">
                                        <img src="{{ asset('/images/sample05.png') }} ">
                                    </div>

                                </div>

                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselIndicators"
                                    data-bs-slide="prev">
                                    <i style="font-size:2.5rem; font-weight:bolder; color:#6b7075;"
                                        class="bi bi-chevron-left"></i>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselIndicators"
                                    data-bs-slide="next">
                                    <i style="font-size:2.5rem; font-weight:bolder; color:#6b7075;"
                                        class="bi bi-chevron-right"></i>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>

                        <div id="chat" class="card col-12 ">
                            <div class="card-body">

                            </div>
                            <div class="card-footer">
                                <form>
                                    <div class="row">
                                        <div class="col-9">
                                            <input id="message" class="form-control" type="text">
                                        </div>
                                        <div class="col-3 d-flex justify-content-center">
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

                    <div id="right-content" class="col-3 bg-light d-none d-md-block p-3 h-100">
                        <div class="row h-100">
                            <div class="onlineUsers col-12">
                                <i class="bi bi-person-check-fill mx-2"></i>
                                <strong>Online</strong>
                            </div>

                            <div id="onlineUsersList" class="col-12">
                                @component('wit.room-users')
                                @endcomponent
                            </div>
                        </div>

                    </div>
                </div>

        </main>
    </div>
</body>

</html>
