@extends('layouts.app')

@section('content')

<div id="profile">   
    <div class="d-flex flex-column p-3 bg-light d-none d-md-block">      
        <div class="profile-box  ">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                        <i class="bi bi-person-fill mx-2"></i>
                        <span class="fs-4">Profile</span>
                    </a>

                    <hr>

                    <div class="dropdown mb-3">
                        <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://github.com/mdo.png" alt="" width="70" height="70" class="rounded-circle me-2">
                            <strong>{{ Auth::user()->name }}</strong>
                        </a>
@endsection