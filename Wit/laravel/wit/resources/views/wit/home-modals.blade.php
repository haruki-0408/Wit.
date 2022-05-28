<!-- Modals -->
<div class="modal fade" id="myPostModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="posts" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Posts</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-1">
                <ul id="myPost" class="p-0 m-0">
                    @foreach ($post_rooms as $post_room)
                        <li>
                            <div class="card border-0">
                                <div class="card-header border-0 d-flex bg-white p-1 justify-content-between">
                                    <div class="user">
                                        <a href="#"
                                            class="user-link link-dark p-1 text-decoration-none d-flex align-items-center">
                                            <img src="{{ asset($post_room->user->profile_image) }}" alt="user_image"
                                                width="50" height="50" class="profile-image rounded-circle me-2">
                                            <strong class="user-name">{{ $post_room->user->name }}</strong>
                                        </a>
                                    </div>

                                    <div class="btn-group d-flex align-items-center p-2">
                                        <button type="button" class="remove-list-room btn btn-outline-danger p-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                            <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                                          </svg></button>
                                        @if (isset($post_room->password))
                                            <button type="button" class="enter-room btn btn-outline-primary p-2"
                                                data-bs-toggle="modal" data-bs-target="#roomPasswordFormModal"><i
                                                    class="bi bi-door-open"></i></button>
                                        @else
                                            <a href='/home/Room:{{ $post_room->id }}'
                                                class="enter-room btn btn-outline-primary p-2"><i
                                                    class="bi bi-door-open"></i></a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="card-body p-1 row align-items-center m-0">
                                <strong class="card-title">{{ $post_room->title }}</strong>
                                <p class="card-text room-description text-break">{{ $post_room->description }}</p>
                            </div>

                            <div class="card-footer border-0 bg-white p-0">
                                <ul class="room_tags p-1">
                                    @foreach ($post_room->roomTags as $room_tag)
                                        <li class="d-inline-block tag">{{ $room_tag->tag->name }} <span
                                                class="number badge badge-light">{{ $room_tag->tag->number }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myAnswerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="answer" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Answers</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-1">
                <ul id="myAnswer" class="p-0 m-0 ">
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myListUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="users" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-people-fill mx-2 "></i>Users</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-1">
                <ul id="myListUser" class="flex-column  mb-auto fs-5 ">
                    ここに要素をループする
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myListRoomModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="list-rooms" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-house-fill mx-2 "></i>Rooms</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-1">
                <ul id="myListRoom" class="p-0 m-0 ">
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Room Password Modal -->
<div class="modal fade" id="roomPasswordFormModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="roomPasswordForm" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-lock-fill mx-2"></i>Room Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-column p-3">

                    <form id="roomPassword" name='roomPass' method="post" action="/home/authRoomPassword">
                        @csrf
                        <input type="password" name="enterPass" class="form-control mb-3" autocomplete=off>
                        <input type="hidden" name="room_id">
                        <button type="submit" form="roomPassword" class="btn btn-primary text-end">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="tagsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="tags" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tags</h5>
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

<!-- Profile Settings Modal -->
<div class="modal fade" id="settingsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="settings" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-gear-fill mx-2"></i>Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-1">
                <ul id="setting-links" class="p-0 m-0 fs-5 rounded">
                    <li><a class="dropdown-item link-dark fw-bold" data-bs-target="#userPasswordForm1"
                            data-bs-toggle="modal" data-bs-dismiss="modal"><i
                                class="bi bi-info-circle-fill mx-2 "></i>Account Information</a></li>
                    <li><a class="dropdown-item link-dark fw-bold" data-bs-target="#userPasswordForm2"
                            data-bs-toggle="modal" data-bs-dismiss="modal"><i class="bi bi-key-fill mx-2"></i>Change
                            Password</a></li>
                    <li><a class="dropdown-item link-dark  fw-bold text-danger" data-bs-target="#userPasswordForm3"
                            data-bs-toggle="modal" data-bs-dismiss="modal"><i
                                class="bi bi-exclamation-triangle-fill mx-2"></i>Delete Account</a></li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- User Password Form From Account Information-->
<div class="modal fade" id="userPasswordForm1" aria-hidden="true" aria-labelledby="userPasswordForm1"
    tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">User Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="userPassword1" name='userPass' method="post"
                    action="/home/profile/settings/authUserPassword?ref=info">
                    @csrf
                    <input type="password" name="settingPass" class="form-control mb-3" autocomplete=off>
                    <div class="text-end">
                        <button type="submit" form="userPassword1" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- User Password Form Change Password-->
<div class="modal fade" id="userPasswordForm2" aria-hidden="true" aria-labelledby="userPasswordForm2"
    tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="userPassword2" name='userPass' method="post" action="/home/profile/settings/changePassword">
                    @csrf
                    Current Password
                    <input type="password" name="currentPass" class="form-control mb-3" autocomplete=off>
                    New Password
                    <input type="password" name="newPass" class="form-control mb-3" autocomplete=off>
                    Confirm Password
                    <input type="password" name="confirmPass" class="form-control mb-3" autocomplete=off>
                    <div class="text-end">
                        <button type="submit" form="userPassword2" class="btn btn-outline-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- User Password Form Delete Account-->
<div class="modal fade" id="userPasswordForm3" aria-hidden="true" aria-labelledby="userPasswordForm3"
    tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">User Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="userPassword3" name='userPass' method="post"
                    action="/home/profile/settings/authUserPassword?ref=delete">
                    @csrf
                    <input type="password" name="settingPass" class="form-control mb-3" autocomplete=off>
                    <div class="text-end">
                        <button type="submit" form="userPassword3" class="btn btn-primary text-end">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--Delete Account Confirm-->
<div class="modal fade" id="deleteAccountModal" aria-hidden="true" aria-labelledby="deleteAccount" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content text-end">
            <div class="modal-header">
                <h5 class="modal-title">削除しますか</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <a href="/home/profile/settings/deleteAccount" class="btn btn-primary text-end">YES</a>
            </div>
        </div>
    </div>
</div>
