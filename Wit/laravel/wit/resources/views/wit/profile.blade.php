@extends('layouts.app')

@section('content')
    @component('wit.home-modals')
    @endcomponent

    @if ($user_id != Auth::id())
        @component('wit.profile-modals', ['o_post_rooms' => $o_post_rooms, 'o_list_rooms' => $o_list_rooms, 'o_list_users' => $o_list_users])
        @endcomponent
    @endif


    <div id="profile" class="overflow-auto" style="width:100%; height:85%;">
        <div class="container-sm p-3">
            <div class="row">
                <div class="header">
                    <div id="targetUser" data-user-id={{ Crypt::encrypt($user_id) }} class="row align-items-center">
                        <div class="col-9 text-start">
                            <a href="#" class="d-flex align-items-center link-dark text-decoration-none text-start">
                                <div class="profile">
                                    <img src="{{ asset($profile_image) }}" alt="" width="70" height="70"
                                        class="rounded-circle me-2">
                                    <strong>{{ $user_name }}</strong>
                                </div>
                            </a>

                        </div>
                        <div class="col-3 text-end">
                            @switch($type)
                                @case(0)
                                    <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#settingsModal">
                                        <svg width="24" height="24" fill="currentColor" class="bi bi-gear-fill"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z" />
                                        </svg></button>
                                @break

                                @case(1)
                                    <button type="button" class="add-list-user btn btn-outline-primary">
                                        <svg width="16" height="16" fill="currentColor" class="bi bi-person-plus-fill"
                                            viewBox="0 0 16 16">
                                            <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                            <path fill-rule="evenodd"
                                                d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z" />
                                        </svg>
                                    </button>
                                @break

                                @case(10)
                                    <button type="button" class="remove-list-user btn btn-outline-danger"><svg width="16"
                                            height="16" fill="currentColor" class="bi bi-person-dash-fill" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M11 7.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5z"></path>
                                            <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z">
                                            </path>
                                        </svg></button>
                                @break
                            @endswitch
                        </div>
                    </div>

                    <div class="links pt-2">
                        <ul>
                            <li class="w-50">
                                <a href="/" class="d-flex align-items-center link-dark ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                        fill="currentColor" class="bi bi-link-45deg text-wrap" viewBox="0 0 16 16">
                                        <path
                                            d="M4.715 6.542 3.343 7.914a3 3 0 1 0 4.243 4.243l1.828-1.829A3 3 0 0 0 8.586 5.5L8 6.086a1.002 1.002 0 0 0-.154.199 2 2 0 0 1 .861 3.337L6.88 11.45a2 2 0 1 1-2.83-2.83l.793-.792a4.018 4.018 0 0 1-.128-1.287z" />
                                        <path
                                            d="M6.586 4.672A3 3 0 0 0 7.414 9.5l.775-.776a2 2 0 0 1-.896-3.346L9.12 3.55a2 2 0 1 1 2.83 2.83l-.793.792c.112.42.155.855.128 1.287l1.372-1.372a3 3 0 1 0-4.243-4.243L6.586 4.672z" />
                                    </svg>
                                    https://wit.com
                                </a>
                            </li>
                            <li class="w-50">
                                <a href="https://twitter.com" class="d-flex align-items-center link-dark ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                        fill="currentColor" class="bi bi-link-45deg text-wrap" viewBox="0 0 16 16">
                                        <path
                                            d="M4.715 6.542 3.343 7.914a3 3 0 1 0 4.243 4.243l1.828-1.829A3 3 0 0 0 8.586 5.5L8 6.086a1.002 1.002 0 0 0-.154.199 2 2 0 0 1 .861 3.337L6.88 11.45a2 2 0 1 1-2.83-2.83l.793-.792a4.018 4.018 0 0 1-.128-1.287z" />
                                        <path
                                            d="M6.586 4.672A3 3 0 0 0 7.414 9.5l.775-.776a2 2 0 0 1-.896-3.346L9.12 3.55a2 2 0 1 1 2.83 2.83l-.793.792c.112.42.155.855.128 1.287l1.372-1.372a3 3 0 1 0-4.243-4.243L6.586 4.672z" />
                                    </svg>
                                    https://twitter.com
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
                    @if ($user_id == Auth::id())
                        <ul style="list-style-type:disc ">
                            <li class="border-bottom">
                                <a href="#" class="link-dark text-decoration-none" data-bs-toggle="modal"
                                    data-bs-target="#myPostModal">
                                    <strong>Post</strong>
                                </a>
                            </li>
                            <li class="border-bottom">
                                <a href="#" class="link-dark text-decoration-none" data-bs-toggle="modal"
                                    data-bs-target="#myAnswerModal">
                                    <strong>Answer</strong>
                                </a>
                            </li>
                            <li class="border-bottom">
                                <a href="#" class="link-dark text-decoration-none" data-bs-toggle="modal"
                                    data-bs-target="#myListUserModal">
                                    <strong>List User</strong>
                                </a>
                            </li>
                            <li class="border-bottom">
                                <a href="#" class="link-dark text-decoration-none" data-bs-toggle="modal"
                                    data-bs-target="#myListRoomModal">
                                    <strong>List Room</strong>
                                </a>
                            </li>
                            <li class="border-bottom">
                                <a href="#" class="link-dark text-decoration-none" data-bs-toggle="modal"
                                    data-bs-target="#tagsModal">
                                    <strong>Trend Tag</strong>
                                </a>
                            </li>
                        </ul>
                    @else
                        <ul style="list-style-type:disc ">
                            <li class="border-bottom">
                                <a href="#" class="link-dark text-decoration-none" data-bs-toggle="modal"
                                    data-bs-target="#otherPostModal">
                                    <strong>Post</strong>
                                </a>
                            </li>
                            <li class="border-bottom">
                                <a href="#" class="link-dark text-decoration-none" data-bs-toggle="modal"
                                    data-bs-target="#otherAnswerModal">
                                    <strong>Answer</strong>
                                </a>
                            </li>
                            <li class="border-bottom">
                                <a href="#" class="link-dark text-decoration-none" data-bs-toggle="modal"
                                    data-bs-target="#otherListUserModal">
                                    <strong>List User</strong>
                                </a>
                            </li>
                            <li class="border-bottom">
                                <a href="#" class="link-dark text-decoration-none" data-bs-toggle="modal"
                                    data-bs-target="#otherListRoomModal">
                                    <strong>List Rooms</strong>
                                </a>
                            </li>
                            <li class="border-bottom">
                                <a href="#" class="link-dark text-decoration-none" data-bs-toggle="modal"
                                    data-bs-target="#tagsModal">
                                    <strong>Trend Tag</strong>
                                </a>
                            </li>
                        </ul>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection

@component('wit.footer')
@endcomponent
