@extends('layouts.app')

@component("wit.createRoom")
@endcomponent

@section('content')
    <div class="container-fluid">
        <div class="row ">
            @component('wit.left')

            @endcomponent
            @component('wit.room-content')

            @endcomponent
            @component('wit.right')

            @endcomponent

        </div>
    </div>
    <div id="CreateRoomButton">
        <button type="button" class="d-lg-none align-items-center btn-room-create"style="position:fixed; right:40px; bottom:40px; z-index:5;" data-bs-toggle="modal" data-bs-target="#CreateRoomForm"><span>+</span></button>
        <button type="button" class="d-none d-lg-block align-items-center btn-room-create" style="position:fixed; right:400px; bottom:40px; z-index:5;" data-bs-toggle="modal" data-bs-target="#CreateRoomForm"><span>+</span></button>
    </div>
@endsection

@component('wit.footer')
@endcomponent
