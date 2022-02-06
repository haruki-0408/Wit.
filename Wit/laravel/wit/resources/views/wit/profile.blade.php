@extends('layouts.app')

@section('content')
    <!-- Modal -->
    <div class="modal fade" id="posts" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="posts" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="posts">Posts</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @component('wit.posts')
                    @endcomponent
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="answers" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="answer" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="answers">Answers</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @component('wit.answers')
                    @endcomponent
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="users" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="users" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="users">Users</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @component('wit.list-users')
                    @endcomponent
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="list-rooms" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="list-rooms" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="list-rooms">Rooms</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @component('wit.list-rooms')
                    @endcomponent
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tags" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="tags" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tags">Tags</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-column p-3  ">
                    @component('wit.tags')
                    
                    @endcomponent
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

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

                <div class="lists">
                    <!-- Button trigger modal -->
                    <ul style="list-style-type:disc">
                        <li class="border-bottom">
                            <a href="#" class="link-dark text-decoration-none" data-bs-toggle="modal" data-bs-target="#posts">
                                Posts
                            </a>
                        </li>
                        <li class="border-bottom">
                            <a href="#" class="link-dark text-decoration-none" data-bs-toggle="modal" data-bs-target="#answers">
                                Answers
                            </a>
                        </li>
                        <li class="border-bottom">
                            <a href="#" class="link-dark text-decoration-none" data-bs-toggle="modal" data-bs-target="#users">
                                Users
                            </a>
                        </li>
                        <li class="border-bottom">
                            <a href="#" class="link-dark text-decoration-none" data-bs-toggle="modal" data-bs-target="#list-rooms">
                                Rooms
                            </a>
                        </li>
                        <li class="border-bottom">
                            <a href="#" class="link-dark text-decoration-none" data-bs-toggle="modal" data-bs-target="#tags">
                                Tags
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
