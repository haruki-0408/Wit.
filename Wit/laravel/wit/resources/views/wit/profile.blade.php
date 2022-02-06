@extends('layouts.app')

@section('content')
    <div id="profile" class="container-fluid m-5">
        <div class="row">
            <div class="">
                <a href="#" class="d-flex align-items-center link-dark text-decoration-none">
                    <img src="https://github.com/mdo.png" alt="" width="70" height="70" class="rounded-circle me-2">
                    <strong>{{ Auth::user()->name }}</strong>
                </a>
            </div>
        </div>
    </div>
@endsection

@component('wit.footer')
@endcomponent
