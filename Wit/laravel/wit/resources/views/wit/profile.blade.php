@extends('layouts.app')

@section('content')

    @component('wit.home-modals')
    @endcomponent


    <div id="profile">
        <div class="container-sm p-4">
            <div class="row">
                <div class="header">
                    <div class="row align-items-center">
                        <div class="col-6 text-start">
                            <a href="#" class="d-flex align-items-center link-dark text-decoration-none text-start">
                                <img src="https://github.com/mdo.png" alt="" width="80" height="80"
                                    class="rounded-circle me-2">
                                <strong>{{ Auth::user()->name }}</strong>
                            </a>

                        </div>
                        <div class="col-6 text-end">
                            <a href="home/setting" class="link-dark"><i style="font-size:1.5rem;"
                                    class="bi bi-gear-fill"></i></a>
                        </div>
                    </div>

                    <div class="links pt-2">
                        <ul>
                            <li>
                                <a href="#" class="d-flex align-items-center link-dark ">
                                    <i style="font-size:2rem;" class="bi bi-link-45deg texrt-wrap"></i>
                                    https://wit.com
                                </a>
                            </li>
                            <li>
                                <a href="#" class="d-flex align-items-center link-dark ">
                                    <i style="font-size:2rem;" class="bi bi-link-45deg"></i>
                                    https://google.com
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <hr>
                <div class="discription">
                    <p class="text-wrap fs-6">
                        <!--文字数制限を入れる-->
                        Greetings everyone! My name is Timmy Ang and a new addition to the iTop family school of
                        instructors. My
                        goal is to get you guys started in speaking english. I believe that learning another language
                        improves
                        ones view of the world as well as opens many opportunities both professional and otherwise. If you
                        have
                        the passion, interest, and love for of a language, it should be quite easy and exciting.

                    </p>
                </div>
                <hr>

                <div class="lists p-2">
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
