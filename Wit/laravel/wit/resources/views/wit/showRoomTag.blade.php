@extends('layouts.app');

@section('content')
    <div class="container">
        <div class="row">
            <table>
                <h1>RoomTag</h1>
                <tr>
                    <th>id</th>
                    <th>room_id</th>
                    <th>tag_id</th>
                    <th>tag_name</th>
                    <th>created_at</th>
                    <th>updated_at</th>
                </tr>
                <hr>
                @foreach ($room_tags as $room_tag)
                    <tr>
                        <td>{{ $room_tag->id }}</td>
                        <td>{{ $room_tag->room_id}}</td>
                        <td>{{ $room_tag->tag_id}}</td>
                        <td>{{ $room_tag->tag->name}}</td>
                        <td>{{ $room_tag->created_at}}</td>
                        <td>{{ $room_tag->updated_at}}</td>
                    </tr>
                @endforeach
            </table>
            <hr>
        </div>
    </div>
@endsection
