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

        #room-description {
            margin: 10px;
            font-size: 13px;
            border-radius: 20px;
            border-color: #0d6efd;
            background-color: #f8f9fa;
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

        #roomTagsList {
            height: 90%;
            overflow: scroll;
        }

        #accessLogList {
            height: 90%;
            overflow: scroll
        }


        :-webkit-full-screen {
            background-color: #fff;
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
            <img src="{{ asset($auth_user->profile_image) }}" id="me" alt="" width="30"
                height="30" class="rounded-circle me-2" data-auth-id={{ $auth_user->id }}>
        </div>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body d-flex flex-column align-items-center p-2">
        <div data-bs-toggle="modal" data-bs-target="#tags" class="roomTags pb-3">
            <svg width="20" height="20" fill="currentColor" class="bi bi-tags-fill" viewBox="0 0 16 16">
                <path
                    d="M2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586V2zm3.5 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z" />
                <path
                    d="M1.293 7.793A1 1 0 0 1 1 7.086V2a1 1 0 0 0-1 1v4.586a1 1 0 0 0 .293.707l7 7a1 1 0 0 0 1.414 0l.043-.043-7.457-7.457z" />
            </svg>
        </div>

        <div data-bs-toggle="modal" data-bs-target="#logs" class="accessLog pb-3">
            <svg width="16" height="16" fill="currentColor" class="bi bi-file-text-fill mx-2"
                viewBox="0 0 16 16">
                <path
                    d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM5 4h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1zm0 2h3a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1z" />
            </svg>
        </div>


        <div data-bs-toggle="modal" data-bs-target="#information" class="pb-3">
            <svg width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                <path
                    d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
            </svg>
        </div>

        <div class="exitRoomButton">
            <a data-bs-toggle="modal" data-bs-target="#exitRoomModal"
                class="btn btn-outline-primary d-flex align-items-center">
                <svg width="16" height="16" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z" />
                    <path fill-rule="evenodd"
                        d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z" />
                </svg>
            </a>
        </div>
    </div>
</div>

<div class="modal fade" id="redirect" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="redirect" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><svg width="16" height="16" fill="currentColor"
                        class="bi bi-person-check-fill mx-2" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M15.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                        <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                    </svg>Notification</h5>
            </div>
            <div class="modal-body">
                ルームが作成者により削除されました　１０秒後にホーム画面に戻ります
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="logs" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby=logs" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <svg width="16" height="16" fill="currentColor" class="bi bi-file-text-fill mx-2"
                        viewBox="0 0 16 16">
                        <path
                            d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM5 4h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1zm0 2h3a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1z" />
                    </svg>Access Log
                </h5>
            </div>
            <div class="modal-body">
                <ul id="accessLogListModal">
                    @foreach ($room_info->roomUsers as $user)
                        <li>
                            <strong>{{ $user->name }}</strong>

                            <p data-exit-id="{{ $user->id }}" class="m-0 text-danger">
                                @if (isset($user->pivot->exited_at))
                                    Latest Offline {{ $user->pivot->exited_at->format('m/d H:i') }}
                                @endif
                            </p>
                            <p data-enter-id="{{ $user->id }}" class="m-0 text-primary">
                                Latest Online {{ $user->pivot->entered_at->format('m/d H:i') }}</p>
                        </li>
                    @endforeach
                </ul>
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
                <h5 class="modal-title">
                    <svg width="20" height="20" fill="currentColor" class="bi bi-tags-fill mx-2"
                        viewBox="0 0 16 16">
                        <path
                            d="M2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586V2zm3.5 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z" />
                        <path
                            d="M1.293 7.793A1 1 0 0 1 1 7.086V2a1 1 0 0 0-1 1v4.586a1 1 0 0 0 .293.707l7 7a1 1 0 0 0 1.414 0l.043-.043-7.457-7.457z" />
                    </svg>Room Tags
                </h5>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-column p-3  ">
                    <ul id="roomTagsListModal">
                        @foreach ($room_info->tags as $roomTag)
                            <li>
                                <div class="tag"><span class="tag-name">{{ $roomTag->name }}</span><span
                                        class="tag-number badge badge-light">{{ $roomTag->number }}</span></div>
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

<div class="modal fade" id="information" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="information" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <svg width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill mx-2"
                        viewBox="0 0 16 16">
                        <path
                            d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                    </svg>Information
                </h5>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-column p-3  ">
                    <ul id="informationListModal" class="p-1">
                        <li>Id : {{ $room_info->id }}</li>
                        <li>Create : {{ $room_info->created_at->format('Y/m/d H:i') }}</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="exitRoomModal" data-bs-backdrop="static" aria-hidden="true" aria-labelledby="exitRoom"
    tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content text-end">
            <div class="modal-header border">
                <h5 class="modal-title">ルームから退出しますか?
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <a id="exitRoomLink" onclick="window.onbeforeunload = null;"
                    class="btn btn-outline-primary text-end">Yes</a>
            </div>
        </div>
    </div>
</div>

<body id='{{ $room_info->id }}'>
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


                    <div class="exitRoomButton col-2 d-none d-md-block d-flex justify-content-center">
                        <a style="width:42px; height:30px;" data-bs-toggle="modal" data-bs-target="#exitRoomModal"
                            class="d-flex justify-content-center btn btn-outline-primary">
                            <svg width="16" height="16" fill="currentColor" class="bi bi-box-arrow-left"
                                viewBox="0 0 16 16">
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
                            <div class="h-50">
                                <div id="roomTags" class="col-12 d-flex align-items-center p-2">
                                    <svg width="16" height="16" fill="currentColor"
                                        class="bi bi-tags-fill mx-2" viewBox="0 0 16 16">
                                        <path
                                            d="M2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586V2zm3.5 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z" />
                                        <path
                                            d="M1.293 7.793A1 1 0 0 1 1 7.086V2a1 1 0 0 0-1 1v4.586a1 1 0 0 0 .293.707l7 7a1 1 0 0 0 1.414 0l.043-.043-7.457-7.457z" />
                                    </svg>
                                    <strong>Room Tags</strong>
                                </div>

                                <ul id="roomTagsList" class="col-12 fs-5 p-0 m-2">
                                    @foreach ($room_info->tags as $roomTag)
                                        <li>
                                            <div class="tag">
                                                <span class="tag-name">{{ $roomTag->name }}</span>
                                                <span
                                                    class="tag-number badge badge-light">{{ $roomTag->number }}</span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="h-50">
                                <ul id="informationList" class="col-12 mt-2 p-1">
                                    <li>Id : {{ $room_info->id }}</li>
                                    <li>Create : {{ $room_info->created_at->format('Y/m/d H:i') }}</li>
                                    @if (Auth::id() == $room_info->user->id)
                                        <hr>
                                        <li class="p-2">Room Administration</li>

                                        <li><button class="mx-2 btn-outline-danger btn" type="button"
                                                data-bs-target="#banUsers" data-bs-toggle="modal">Ban Users
                                                List</button></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div id="center-content" class="col-sm-12 col-md-9 col-lg-6 h-100 m-0 p-0">
                        <div id="image" class="d-flex align-items-center">
                            <div id="carouselIndicators"
                                class="carousel slide w-100 h-100 p-0 m-0 d-flex align-items-center"
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
                                    <li id="room-description">
                                        <p class="fs-6 fw-bold m-0 pb-0">Description</p>
                                        <p> {!! nl2br(e($room_info->description)) !!}</p>
                                    </li>
                                    @foreach ($room_info->roomChat as $chat)
                                        @if ($chat->pivot->user_id == $auth_user->id)
                                            <li class="myself">
                                                <div class="message-wrapper">
                                                    <span
                                                        class="badge d-block text-dark text-end">{{ $chat->pivot->created_at->format('m/d H:i') }}</span>
                                                    <p> {!! nl2br(e($chat->pivot->message)) !!}</p>

                                                </div>
                                            </li>
                                        @else
                                            <li class="opponent">
                                                <img src="{{ asset($chat->profile_image) }}" alt="user-image"
                                                    width="20" height="20" class="rounded-circle">
                                                <strong>{{ $chat->name }}</strong><span
                                                    class="badge text-dark">{{ $chat->pivot->created_at->format('m/d H:i') }}</span>
                                                <p>{{ $chat->pivot->message }}</p>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div id="right-content" class="col-3 bg-light d-none d-md-block p-3 h-100">
                        <div class="row h-100">
                            <div>
                                <div class="accessLog col-12 d-flex align-items-center mt-2 p-2">
                                    <svg width="16" height="16" fill="currentColor"
                                        class="bi bi-file-text-fill mx-2" viewBox="0 0 16 16">
                                        <path
                                            d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM5 4h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1zm0 2h3a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1z" />
                                    </svg>
                                    <strong>Access Log</strong>
                                </div>
                                <ul id="accessLogList" class="col-12 p-0 m-0">
                                    @foreach ($room_info->roomUsers as $user)
                                        <li>
                                            <strong>{{ $user->name }}</strong>

                                            <p data-exit-id="{{ $user->id }}" class="m-0 text-danger">
                                                @if (isset($user->pivot->exited_at))
                                                    Latest Offline {{ $user->pivot->exited_at->format('m/d H:i') }}
                                                @endif
                                            </p>

                                            <p data-enter-id="{{ $user->id }}" class="m-0 text-primary">
                                                Latest
                                                Online {{ $user->pivot->entered_at->format('m/d H:i') }}</p>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
        </main>
    </div>
</body>

</html>