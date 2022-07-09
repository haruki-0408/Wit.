<!-- Modals -->
<div class="modal fade" id="otherPostModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="posts" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><svg width="16" height="16" fill="currentColor"
                        class="bi bi-house-fill mx-2" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
                        <path fill-rule="evenodd"
                            d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z" />
                    </svg>Posts</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul id="otherPost" class="p-1 m-0">
                    @component('wit.room-content')
                        @slot('rooms', $o_post_rooms)
                    @endcomponent

                </ul>
                @if (!isset($o_post_rooms->last()->no_get_more) && $o_post_rooms->isNotEmpty())
                    <div id="otherMorePostRoomButton" class="btn d-flex justify-content-center m-3"><svg width="16"
                            height="16" fill="currentColor" class="bi bi-caret-down" viewBox="0 0 16 16">
                            <path
                                d="M3.204 5h9.592L8 10.481 3.204 5zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659z">
                            </path>
                        </svg>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="otherAnswerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="answer" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><svg width="16" height="16" fill="currentColor"
                        class="bi bi-house-fill mx-2" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
                        <path fill-rule="evenodd"
                            d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z" />
                    </svg>Answers</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-1">
                <ul id="otherAnswer" class="p-1 m-0 ">

                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="otherListUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="users" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><svg width="16" height="16" fill="currentColor"
                        class="bi bi-people-fill mx-2" viewBox="0 0 16 16">
                        <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                        <path fill-rule="evenodd"
                            d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z" />
                        <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z" />
                    </svg>Users</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-1">
                <ul id="otherListUser" class="fs-6 p-2">
                    @foreach ($o_list_users as $o_list_user)
                        <li data-user-id='{{ $o_list_user->id }}'
                            class="border-0 d-flex bg-white p-1 align-items-center justify-content-between">
                            <div class="user">
                                <a class="user-link link-dark text-decoration-none"
                                    href='/home/profile:{{ $o_list_user->id }}' alt="">
                                    <img src="{{ asset($o_list_user->profile_image) }}" alt=""
                                        width="50" height="50" class="profile-image rounded-circle me-2">
                                    <strong class="user-name">{{ $o_list_user->name }}</strong>
                                </a>
                            </div>

                            <div class="btn-group d-flex align-items-center p-2">
                                @switch($o_list_user->type)
                                    @case(0)
                                    @break

                                    @case(1)
                                        <button class="add-list-user btn btn-outline-primary"><svg width="16"
                                                height="16" fill="currentColor" class="bi bi-person-plus-fill"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z">
                                                </path>
                                                <path fill-rule="evenodd"
                                                    d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z">
                                                </path>
                                            </svg></button>
                                    @break;
                                    @case(10)
                                        <button type="button" class="remove-list-user btn btn-outline-danger"><svg
                                                width="16" height="16" fill="currentColor"
                                                class="bi bi-person-dash-fill" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M11 7.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5z" />
                                                <path
                                                    d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                            </svg></button>
                                    @break
                                @endswitch
                            </div>
                        </li>
                    @endforeach
                </ul>

                @if (!isset($o_list_users->last()->no_get_more) && $o_list_users->isNotEmpty())
                    <div id="otherMoreListUserButton" class="btn d-flex justify-content-center m-3"><svg
                            width="16" height="16" fill="currentColor" class="bi bi-caret-down"
                            viewBox="0 0 16 16">
                            <path
                                d="M3.204 5h9.592L8 10.481 3.204 5zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659z">
                            </path>
                        </svg>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="otherListRoomModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="list-rooms" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><svg width="16" height="16" fill="currentColor"
                        class="bi bi-house-fill mx-2" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
                        <path fill-rule="evenodd"
                            d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z" />
                    </svg>Rooms</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul id="otherListRoom" class="p-1 m-0 ">
                    @component('wit.room-content')
                        @slot('rooms', $o_list_rooms);
                    @endcomponent
                </ul>
                @if (!isset($o_list_rooms->last()->no_get_more) && $o_list_rooms->isNotEmpty())
                    <div id="otherMoreListRoomButton" class="btn d-flex justify-content-center m-3"><svg
                            width="16" height="16" fill="currentColor" class="bi bi-caret-down"
                            viewBox="0 0 16 16">
                            <path
                                d="M3.204 5h9.592L8 10.481 3.204 5zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659z">
                            </path>
                        </svg>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
