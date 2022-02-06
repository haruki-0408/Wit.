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
@endsection

@component('wit.footer')
@endcomponent
