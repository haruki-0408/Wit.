<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Room:{{ $show_id }}</title>

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

        .tag {
            display: inline-block;
            margin: 0 .1em .6em 0;
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


<body> 
    <main>
    <h1>{{$show_id}}</h1>
    <h3>{{ $room_info }}</h3>  
    </main>
</body>

</html>
