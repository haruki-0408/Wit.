<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>RoomID:{{ $room_info->id }}</title>

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

        .card-body {
            overflow: scroll;
        }

        #image {
            height: 45%;
        }

        #chat {
            height: 55%;
        }

        #messageList p {
            font-size: 13px;
            padding: 10px;
            margin: 5px;
            border-radius: 20px;
        }

        .message-wrapper {
            text-align: right;
        }

        .myself p {
            max-width: 70%;
            background-color: #0d6efd;
            color: #fff;
            display: inline-block;
            text-align: left;
        }

        .opponent p {
            display: table;
            max-width: 70%;
            background-color: #f8f9fa;
        }

        .roomTagsList {
            overflow: scroll;
        }

        #onlineUsersList {
            height: 90%;
            overflow: scroll;
        }


        :-webkit-full-screen {
            background-color: white;
        }

        :-webkit-full-screen img {
            cursor: pointer;
        }

        .carousel-item img {
            width: auto;
            max-width: 100%;
            max-height: 100%;
            display: block;
            margin: auto;
        }


        .tag {
            display: inline-block;
            border: none;
            margin: 0 .1em .6em .2em;
            padding: .6em;
            line-height: 1;
            color: #fff;
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
<div style="width:90px;" class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight"
    aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <div id="offcanvasRightLabel">
            <img src="https://github.com/haruki-0408.png" alt="" width="30" height="30"
                class="rounded-circle me-2">
        </div>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body d-flex flex-column align-items-center">
        <div data-bs-toggle="modal" data-bs-target="#users" class="onlineUsers pb-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                class="bi bi-person-check-fill" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M15.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
            </svg>
        </div>

        <div data-bs-toggle="modal" data-bs-target="#tags" class="roomTags pb-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                class="bi bi-tags-fill" viewBox="0 0 16 16">
                <path
                    d="M2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586V2zm3.5 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z" />
                <path
                    d="M1.293 7.793A1 1 0 0 1 1 7.086V2a1 1 0 0 0-1 1v4.586a1 1 0 0 0 .293.707l7 7a1 1 0 0 0 1.414 0l.043-.043-7.457-7.457z" />
            </svg>
        </div>

        <div class="information pb-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                <path
                    d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
            </svg>
        </div>

        <div class="exitRoomButton ">
            <a href="/home" class="btn btn-outline-primary d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z" />
                    <path fill-rule="evenodd"
                        d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z" />
                </svg>
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
                <h5 class="modal-title" id="users"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                        height="16" fill="currentColor" class="bi bi-person-check-fill mx-2" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M15.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                        <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                    </svg>Online</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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

                <h5 class="modal-title" id="tags">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="bi bi-tags-fill mx-2" viewBox="0 0 16 16">
                        <path
                            d="M2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586V2zm3.5 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z" />
                        <path
                            d="M1.293 7.793A1 1 0 0 1 1 7.086V2a1 1 0 0 0-1 1v4.586a1 1 0 0 0 .293.707l7 7a1 1 0 0 0 1.414 0l.043-.043-7.457-7.457z" />
                    </svg>Room Tags
                </h5>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-column p-3  ">
                    <ul>
                        @foreach ($room_info->roomTags as $roomTag)
                            <li>
                                <div class="tag"><span class="tag-name">{{ $roomTag->tag->name }}</span><span
                                        class="tag-number badge badge-light">{{ $roomTag->tag->number }}</span></div>
                            </li>
                        @endforeach
                    </ul>
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
                            <img src="{{ asset($room_info->user->profile_image) }}" alt="" width="50px"
                                height="50px" class="rounded-circle m-1">
                            <strong class="d-flex align-items-center">{{ $room_info->user->name }}</strong>
                        </div>
                    </div>

                    <div class="col-10 col-md-8 text-wrap fw-bold">
                        <h4 class="d-none d-md-block">{{ $room_info->title }}</h4>
                        <p class="d-sm-none">{{ $room_info->title }}</p>
                    </div>

                    <div class="exitRoomButton col-2 d-none d-md-block d-flex justify-content-center ">
                        <a style="width:42px; height:30px;" href="/home"
                            class="d-flex justify-content-center btn btn-outline-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z" />
                                <path fill-rule="evenodd"
                                    d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z" />
                            </svg>
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
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-tags-fill mx-2" viewBox="0 0 16 16">
                                        <path
                                            d="M2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586V2zm3.5 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z" />
                                        <path
                                            d="M1.293 7.793A1 1 0 0 1 1 7.086V2a1 1 0 0 0-1 1v4.586a1 1 0 0 0 .293.707l7 7a1 1 0 0 0 1.414 0l.043-.043-7.457-7.457z" />
                                    </svg>
                                    <strong>Room Tags</strong>
                                </div>

                            </div>

                            <div class="roomTagsList col-12 fs-5 h-25">
                                <div class="Room-tag fs-5">
                                    <ul>
                                        @foreach ($room_info->roomTags as $roomTag)
                                            <li>
                                                <div class="tag">
                                                    <span class="tag-name">{{ $roomTag->tag->name }}</span>
                                                    <span class="tag-number badge badge-light">{{ $roomTag->tag->number }}</span>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <hr>
                            <div class="settingButtons col-12 h-50">
                                ID : {{ $room_info->id }}
                            </div>
                        </div>
                    </div>

                    <div id="center-content" class="col-sm-12 col-md-9 col-lg-6 h-100 m-0 p-0">
                        <div id="image">
                            <div id="carouselIndicators"
                                class="carousel slide w-100 h-100 p-0 m-0 d-flex align-items-center "
                                data-bs-interval="false">
                                <div class="carousel-indicators">
                                    @if ($count_image_data > 1)
                                        @for ($i = 0; $i < $count_image_data; $i++)
                                            @if ($i == 0)
                                                <button type="button" data-bs-target="#carouselIndicators"
                                                    data-bs-slide-to="{{ $i }}" class="active"
                                                    aria-current="true"
                                                    aria-label="image {{ $i }}"></button>
                                            @else
                                                <button type="button" data-bs-target="#carouselIndicators"
                                                    data-bs-slide-to="{{ $i }}"
                                                    aria-label="image {{ $i }}"></button>
                                            @endif
                                        @endfor
                                    @endif
                                </div>

                                <div class="carousel-inner  h-100 w-100">
                                    @for ($i = 0; $i < $count_image_data; $i++)
                                        @if ($i == 0)
                                            <div onclick="this.webkitRequestFullScreen();"
                                                class="carousel-item active">
                                                <img src=" {{ route('showRoomImage', [
                                                    'room_id' => $room_info->id,
                                                    'number' => $i,
                                                ]) }}"
                                                    alt="" style="" class="image-fluid">
                                            </div>
                                        @else
                                            <div onclick="this.webkitRequestFullScreen();" class="carousel-item">
                                                <img src=" {{ route('showRoomImage', [
                                                    'room_id' => $room_info->id,
                                                    'number' => $i,
                                                ]) }}"
                                                    alt="" style="" class=" image-fluid">
                                            </div>
                                        @endif
                                    @endfor

                                </div>

                                @if ($count_image_data > 1)
                                    <button class="carousel-control-prev" type="button"
                                        data-bs-target="#carouselIndicators" data-bs-slide="prev">
                                        <i style="font-size:2.5rem; font-weight:bolder; color:#6b7075;"
                                            class="bi bi-chevron-left"></i>

                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                        data-bs-target="#carouselIndicators" data-bs-slide="next">
                                        <i style="font-size:2.5rem; font-weight:bolder; color:#6b7075;"
                                            class="bi bi-chevron-right"></i>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                @endif
                            </div>
                        </div>

                        <div id="chat" class="card col-12">
                            <div class="card-body">
                                <!-- MESSAGE -->
                                <ul id="messageList" class="p-0 m-0 w-100 ">
                                    <li class="myself">
                                        <div class="message-wrapper">
                                            <p>
                                                @foreach ($room_info->roomChat as $chat)
                                                    {!! nl2br(e($chat->message)) !!}
                                                @endforeach
                                            </p><br>
                                        </div>
                                    </li>

                                    <li class="opponent">
                                        <img class="" src="{{ asset($room_info->user->profile_image) }}"
                                            alt="" width="20" height="20" class="rounded-circle">
                                        <strong>haruki</strong>
                                        <p>test message!</p>
                                        <p>はじめまして、こんばんはチャットメッセージの長い要素を打てばどうなるのかのメッセージテストです。</p>
                                        <p>こちらのチャットスペースではすべての背景を灰色にし、メッセージだけでなく画像やPDFファイルの投稿も可能です。</p>
                                    </li>

                                    <li class="myself">
                                        <div class="message-wrapper">
                                            <p>harukiさん</p><br>
                                            <p>こちらこそはじめまして、自分側のメッセージは右側に表示され青色の背景で白文字になります</p><br>
                                            <p>相手のページからは左側に見えるのでフレキシブルです</p><br>
                                        </div>
                                    </li>

                                    <li class="opponent">
                                        <img class="" src="{{ asset('images/sample02.PNG') }}"
                                            alt="" width="20" height="20" class="rounded-circle">
                                        <strong>test2</strong>
                                        <p>test message!</p>
                                        <p>はじめまして、こんばんはチャットメッセージの長い要素を打てばどうなるのかのメッセージテストです。</p>
                                        <p>こちらのチャットスペースではすべての背景を灰色にし、メッセージだけでなく画像やPDFファイルの投稿も可能です。</p>
                                    </li>

                                    <li class="myself">
                                        <div class="message-wrapper">
                                            <p>harukiさん</p><br>
                                            <p>こちらこそはじめまして、自分側のメッセージは</p><br>
                                            <p>相手のページからは左側</p><br>
                                            <p>I have got the bus</p><br>
                                        </div>
                                    </li>


                                </ul>
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
                            <div class="onlineUsers col-12 d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-person-check-fill mx-2" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M15.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                                    <path
                                        d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                </svg>
                                <strong>Online</strong>
                            </div>

                            <div id="onlineUsersList" class="col-12">
                                @component('wit.room-users')
                                @endcomponent
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>

</body>

</html>
