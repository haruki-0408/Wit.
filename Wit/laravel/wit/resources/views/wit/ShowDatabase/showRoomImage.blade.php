@extends('layouts.app');

@section('content')
    <div class="container">
        <div class="row">
            <table>
                <h1>RoomImage</h1>
                <tr>
                    <th>id</th>
                    <th>room_id</th>
                    <th>room_title</th>
                    <th>imagePATH</th>
                    <th>image</th>
                    <th>created_at</th>
                    <th>updated_at</th>
                </tr>
                <hr>
                @foreach ($room_images as $room_image)
                    <tr>
                        <td>{{ $room_image->id }}</td>
                        <td>{{ $room_image->room_id}}</td>
                        <td>{{ $room_image->room->title}}</td>
                        <td>{{ $room_image->image}}</td>
                        <td><img src="{{$room_image->image}}" alt="" style="width:100; height:100;"></td>
                        <td>{{ $room_image->created_at}}</td>
                        <td>{{ $room_image->updated_at}}</td>
                    </tr>
                @endforeach
            </table>
            <hr>
        </div>
    </div>
@endsection
