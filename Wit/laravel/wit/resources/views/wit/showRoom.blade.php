@extends('layouts.app');

@section('content')
    <div class="container">
        <div class="row">
            <table>
                <h1>Room</h1>
                <tr>
                    <th>id</th>
                    <th>user_id</th>
                    <th>title</th>
                    <th>description</th>
                    <th>password</th>
                    <th>created_at</th>
                    <th>updated_at</th>
                    <th>deleted_at</th>
                </tr>
                <hr>
                @foreach ($rooms as $room)
                    <tr>
                        <td>{{ $room->id }}</td>
                        <td>{{ $room->user_id}}</td>
                        <td>{{ $room->title}}</td>
                        <td>{{ $room->description}}</td>
                        <td>{{ $room->password}}</td>
                        <td>{{ $room->created_at}}</td>
                        <td>{{ $room->updated_at}}</td>
                        <td>{{ $room->deleted_at}}</td>
                    </tr>
                @endforeach
            </table>
            <hr>
        </div>
    </div>
@endsection
