@extends('layouts.app');

@section('content')
    <div class="container">
        <div class="row">
            <table>
                <h1>RoomUser</h1>
                <tr>
                    <th>id</th>
                    <th>room_id</th>
                    <th>user_id</th>
                    <th>user_name</th>
                    <th>entered_at</th>
                    <th>exited_at</th>
                </tr>
                <hr>
                @foreach ($room_users as $room_user)
                    <tr>
                        <td>{{ $room_user->id }}</td>
                        <td>{{ $room_user->room_id}}</td>
                        <td>{{ $room_user->user_id}}</td>
                        <td>{{ $room_user->user->name}}</td>
                        <td>{{ $room_user->entered_at}}</td>
                        <td>{{ $room_user->exited_at}}</td>
                    </tr>
                @endforeach
            </table>
            <hr>
        </div>
    </div>
@endsection
