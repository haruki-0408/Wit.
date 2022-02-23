@extends('layouts.app');

@section('content')
    <div class="container-fluid">
        <div class="row">

            <table>
                <p>ID:{{$show_id}}
                <h1>作ったルームに表示してほしい情報</h1>
                <tr>
                    <th>id</th>
                    <th>作成者:NAME</th>
                    <th>TITLE</th>
                    <th>DESCRIPTION</th>
                    <th>ルームタグ</th>
                    <th>ルームイメージ</th>
                    <th>チャットメッセージ</th>


                </tr>
                <hr>

                <tr>
                    @foreach ($room_informations as $room_information)
                        <td>{{ $room_information->id }}</td>
                        <td>{{ $room_information->user->name }}</td>
                        <td>{{ $room_information->title }}</td>
                        <td>{{ $room_information->description }}</td>
                        <td>
                        @foreach ($room_information->roomTags as $roomTag)
                            <li>{{ $roomTag->tag_id }}</li>
                        @endforeach
                        </td>

                        <td>
                        @foreach ($room_information->roomImages as $roomImage)
                            <li>{{ $roomImage->image}} </li>
                            <li><img src="{{$roomImage->image}}" alt="" style="width:100; height:100;"></li>
                        @endforeach
                        </td>

                        <td>
                            @foreach ($room_information->roomChat as $chat)
                                <li>{{ $chat->message}} </li>
                            @endforeach
                        </td>



                    @endforeach
                </tr>


            </table>
            <hr>
        </div>
    </div>
@endsection
