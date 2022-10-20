@extends('layouts.app');

@section('content')
    <div class="container">
        <div class="row">
            <table>
                <h1>User</h1>
                <tr>
                    <th>ID</th>
                    <th>Proffile</th>
                    <th>Email</th>
                    <th>profile_message</th>
                    <th>profile_image_PATH</th>
                    <th>created_at</th>
                    <th>updated_at</th>
                    <th>deleted_at</th>
                </tr>
                <hr>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id}}</td>
                        <td><img src="{{ asset($user->profile_image) }}" alt="" width="50" height="50" class="rounded-circle">
                        <strong>{{ $user->name }}</strong></td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->profile_message }}</td>
                        <td>{{ $user->profile_image }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $user->updated_at }}</td>
                        <td>{{ $user->deleted_at }}</td>
                    </tr>
                @endforeach
            </table>

            <hr>
        </div>
    </div>
@endsection
