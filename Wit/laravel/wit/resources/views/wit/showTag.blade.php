@extends('layouts.app');

@section('content')
    <div class="container">
        <div class="row">
            <table>
                <h1>Tag</h1>
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>number</th>
                    <th>created_at</th>
                </tr>
                <hr>
                @foreach ($tags as $tag)
                    <tr>
                        <td>{{ $tag->id }}</td>
                        <td>{{ $tag->name}}</td>
                        <td>{{ $tag->number}}</td>
                        <td>{{ $tag->created_at}}</td>
                    </tr>
                @endforeach
            </table>
            <hr>
        </div>
    </div>
@endsection
