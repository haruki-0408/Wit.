@extends('layouts.app')

@section('home-only')
<div class="input-group p-2 align-items-center">
    <input class="form-control mx-2" type="text">
    <a> <i class="btn btn-primary bi bi-search"></i> </a>
</div>

<div class="btn-group p-2">
    <button class="btn btn-primary dropdown-toggle mx-3" type="button"
        data-bs-toggle="dropdown" aria-expanded="true"><i
            class="bi bi-filter-square"></i></button>
    <ul class="dropdown-menu">
        ...
    </ul>
</div>
@endsection

@component("wit.createRoom")
@endcomponent

@component("wit.home-modals")
@endcomponent


@section('content')
    <div class="container-fluid h-100">
        <div class="row h-100">
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
