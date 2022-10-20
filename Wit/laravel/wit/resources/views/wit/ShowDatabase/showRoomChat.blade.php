@extends('layouts.app');

@section('content')
    <div class="container">
        <div class="row">
            <table>
                <h1>RoomChat</h1>
                <tr>
                    <th>id</th>
                    <th>room_id</th>
                    <th>room_titke</th>
                    <th>user_id</th>
                    <th>user_name</th>
                    <th>message</th>
                    <th>postFILE</th>
                    <th>created_at</th>
                    <th>updated_at</th>
                </tr>
                <hr>
                @foreach ($room_chat as $chat)
                    <tr>
                        <td>{{ $chat->id }}</td>
                        <td>{{ $chat->room_id}}</td>
                        <td>{{ $chat->room->title}}</td>
                        <td>{{ $chat->user_id}}</td>
                        <td>{{ $chat->user->name}}</td>
                        <td>{{ $chat->message}}</td>
                        <td>{{ $chat->postfile}}</td>
                        <td>{{ $chat->created_at}}</td>
                        <td>{{ $chat->updated_at}}</td>
                    </tr>
                @endforeach
            </table>
            <hr>
        </div>
    </div>
@endsection
