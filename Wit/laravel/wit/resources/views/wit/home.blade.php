@extends('layouts.app')

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
    <div id="RoomCreateButton">
        <button type="button" class="d-lg-none align-items-center btn-room-create gaming"style="position:fixed; right:40px; bottom:40px; z-index:5;"><span>+</span></button>
        <button type="button" class="d-none d-lg-block align-items-center btn-room-create gaming"style="position:fixed; right:400px; bottom:40px; z-index:5;"><span>+</span></button>
    </div>
@endsection

@component('wit.footer')
@endcomponent
