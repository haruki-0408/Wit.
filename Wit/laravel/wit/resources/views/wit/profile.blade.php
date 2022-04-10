@extends('layouts.app')

@section('content')
    @component('wit.home-modals')
    @endcomponent


    <div id="profile" class="overflow-auto" style="width:100%; height:85%;">
        <div class="container-sm p-3">
            <div class="row">
                <div class="header">
                    <div class="row align-items-center">
                        <div class="col-10 text-start">
                            <a href="#" class="d-flex align-items-center link-dark text-decoration-none text-start">
                                <div class="profile">
                                    <img src="{{ asset($profile_image) }}" alt="" width="70" height="70"
                                        class="rounded-circle me-2">
                                    <strong>{{ $user_name }}</strong>
                                </div>
                            </a>

                        </div>
                        <div class="col-2 text-end">
                            @if ($user_id == Auth::id())
                                <button type="button" class="btn" data-bs-toggle="modal"
                                    data-bs-target="#settings"><i style="font-size:1.5rem;"
                                        class="bi bi-gear-fill"></i></button>
                            @else
                                <button type="button" class="add-list-user btn btn-outline-primary"><i
                                        class="bi bi-plus"></i><i class="bi bi-person-square"></i></button>
                            @endif
                        </div>
                    </div>

                    <div class="links pt-2">
                        <ul>
                            <li>
                                <a href="/" class="d-flex align-items-center link-dark ">
                                    <i style="font-size:2rem;" class="bi bi-link-45deg texrt-wrap"></i>
                                    https://wit.com
                                </a>
                            </li>
                            <li>
                                <a href="https://google.com" class="d-flex align-items-center link-dark ">
                                    <i style="font-size:2rem;" class="bi bi-link-45deg"></i>
                                    https://google.com
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <hr class="m-1">
                <div class="discription">
                    <p class="text-break m-1" style="font-size:1.1em;">
                        {{ $profile_message }}
                    </p>
                </div>
                <hr class="m-1">

                <div class="lists p-0">
                    <!-- Button trigger modal -->
                    <ul style="list-style-type:disc ">
                        <li class="border-bottom">
                            <a href="#" class="link-dark text-decoration-none" data-bs-toggle="modal"
                                data-bs-target="#posts">
                                <strong>Posts</strong>
                            </a>
                        </li>
                        <li class="border-bottom">
                            <a href="#" class="link-dark text-decoration-none" data-bs-toggle="modal"
                                data-bs-target="#answers">
                                <strong>Answers</strong>
                            </a>
                        </li>
                        <li class="border-bottom">
                            <a href="#" class="link-dark text-decoration-none" data-bs-toggle="modal"
                                data-bs-target="#users">
                                <strong>Users</strong>
                            </a>
                        </li>
                        <li class="border-bottom">
                            <a href="#" class="link-dark text-decoration-none" data-bs-toggle="modal"
                                data-bs-target="#list-rooms">
                                <strong>Rooms</strong>
                            </a>
                        </li>
                        <li class="border-bottom">
                            <a href="#" class="link-dark text-decoration-none" data-bs-toggle="modal"
                                data-bs-target="#tags">
                                <strong>Tags</strong>
                            </a>
                        </li>
                    </ul>

                </div>

            </div>
        </div>
    </div>
@endsection

@component('wit.footer')
@endcomponent
