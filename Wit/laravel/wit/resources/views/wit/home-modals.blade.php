<!-- Modals -->
<div class="modal fade" id="My-OpenRoom-Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="My-OpenRoom-Modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><svg width="16" height="16" fill="currentColor"
                        class="bi bi-house-fill mx-2" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
                        <path fill-rule="evenodd"
                            d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z" />
                    </svg>Open Room</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul id="My-OpenRoom-List" class="p-1 m-0 ">
                    @component('wit.room-content')
                        @slot('rooms', $open_rooms)
                    @endcomponent
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="My-PostRoom-Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="My-PostRoom-Modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><svg width="16" height="16" fill="currentColor"
                        class="bi bi-house-fill mx-2" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
                        <path fill-rule="evenodd"
                            d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z" />
                    </svg>Post Room</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul id="My-PostRoom-List" class="p-1 m-0">
                    @component('wit.room-content')
                        @slot('rooms', $post_rooms)
                    @endcomponent
                </ul>
                @if (!isset($post_rooms->last()->no_get_more) && $post_rooms->isNotEmpty())
                    <div id="Get-More-PostRoom-Button" class="btn d-flex justify-content-center m-3"><svg width="16"
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

<div class="modal fade" id="My-ListUser-Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="My-ListUser-Modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><svg width="16" height="16" fill="currentColor"
                        class="bi bi-people-fill mx-2" viewBox="0 0 16 16">
                        <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                        <path fill-rule="evenodd"
                            d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z" />
                        <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z" />
                    </svg>List User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-1">
                <ul id="My-ListUser-List" class="fs-6 p-2">
                    @foreach ($list_users as $list_user)
                        <li data-user-id="{{ $list_user->id }}" class="d-flex bg-white p-1 justify-content-between">
                            <div class="User">
                                <a class="User-Link link-dark text-decoration-none d-flex align-items-center p-1"
                                    href="/home/profile:{{ $list_user->id }}" alt="">
                                    <img src="{{ asset($list_user->profile_image) }}" alt="" width="50"
                                        height="50" class="Profile-Image rounded-circle me-2">
                                    <strong class="User-Name text-break">{{ $list_user->name }}</strong>
                                </a>
                            </div>
                            <div class="btn-group d-flex align-items-center p-2">
                                <button type="button" class="Remove-ListUser btn btn-outline-danger"><svg
                                        width="16" height="16" fill="currentColor"
                                        class="bi bi-person-dash-fill" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M11 7.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5z" />
                                        <path
                                            d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                    </svg></button>
                            </div>
                        </li>
                    @endforeach
                </ul>

                @if (!isset($list_users->last()->no_get_more) && $list_users->isNotEmpty())
                    <div id="Get-More-ListUser-Button" class="btn d-flex justify-content-center m-3"><svg
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

<div class="modal fade" id="My-ListRoom-Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="My-ListRoom-Modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><svg width="16" height="16" fill="currentColor"
                        class="bi bi-house-fill mx-2" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
                        <path fill-rule="evenodd"
                            d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z" />
                    </svg>List Room</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul id="My-ListRoom-List" class="p-1 m-0 ">
                    @component('wit.room-content')
                        @slot('rooms', $list_rooms);
                    @endcomponent
                </ul>
                @if (!isset($list_rooms->last()->no_get_more) && $list_rooms->isNotEmpty())
                    <div id="Get-More-ListRoom-Button" class="btn d-flex justify-content-center m-3"><svg
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

<!-- Room Password Modal -->
<div class="modal fade" id="Room-Password-Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="Room-Password-Modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><svg width="16" height="16" fill="currentColor"
                        class="bi bi-lock-fill mx-2" viewBox="0 0 16 16">
                        <path
                            d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z" />
                    </svg>Room Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-column p-3">

                    <form id="Room-Password-Form" name='room_password' method="post"
                        action="/home/authRoomPassword">
                        @csrf
                        <input type="password" name="enter_password" class="form-control mb-3" autocomplete=off>
                        <input type="hidden" name="room_id">
                        @error('enter_password')
                            <div class="text-danger">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                        <div class="text-end">
                            <button type="submit" form="Room-Password-Form"
                                class="btn btn-outline-primary ">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="Tags-Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="Tags-Modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><svg width="16" height="16" fill="currentColor"
                        class="bi bi-tags-fill mx-2" viewBox="0 0 16 16">
                        <path
                            d="M2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586V2zm3.5 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z" />
                        <path
                            d="M1.293 7.793A1 1 0 0 1 1 7.086V2a1 1 0 0 0-1 1v4.586a1 1 0 0 0 .293.707l7 7a1 1 0 0 0 1.414 0l.043-.043-7.457-7.457z" />
                    </svg>Tag</h5>
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
<div class="modal fade" id="Settings-Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="Settings-Modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><svg width="16" height="16" fill="currentColor"
                        class="bi bi-gear-fill mx-2" viewBox="0 0 16 16">
                        <path
                            d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z" />
                    </svg>Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-1">
                <ul id="Setting-Links" class="p-0 m-0 fs-5 rounded">
                    <li><button id="Information-Password-Modal-Button" class="dropdown-item fw-bold"
                            data-bs-target="#User-Password-Modal1" data-bs-toggle="modal"
                            data-bs-dismiss="modal"><svg width="16" height="16" fill="currentColor"
                                class="bi bi-info-circle-fill mx-2" viewBox="0 0 16 16">
                                <path
                                    d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                            </svg>Account Information</button></li>

                    <li><button id="Change-Email-Modal-Button" type="button" class="dropdown-item fw-bold"
                            data-bs-target="#User-Password-Modal2" data-bs-toggle="modal"
                            data-bs-dismiss="modal"><svg width="16" height="16" fill="currentColor"
                                class="bi bi-envelope-exclamation-fill mx-2" viewBox="0 0 16 16">
                                <path
                                    d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.026A2 2 0 0 0 2 14h6.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.606-3.446l-.367-.225L8 9.586l-1.239-.757ZM16 4.697v4.974A4.491 4.491 0 0 0 12.5 8a4.49 4.49 0 0 0-1.965.45l-.338-.207L16 4.697Z" />
                                <path
                                    d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1.5a.5.5 0 0 1-1 0V11a.5.5 0 0 1 1 0Zm0 3a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0Z" />
                            </svg>Change
                            Email Address</button></li>

                    <li><button id="Change-Password-Modal-Button" type="button" class="dropdown-item fw-bold"
                            data-bs-target="#User-Password-Modal3" data-bs-toggle="modal"
                            data-bs-dismiss="modal"><svg width="16" height="16" fill="currentColor"
                                class="bi bi-key-fill mx-2" viewBox="0 0 16 16">
                                <path
                                    d="M3.5 11.5a3.5 3.5 0 1 1 3.163-5H14L15.5 8 14 9.5l-1-1-1 1-1-1-1 1-1-1-1 1H6.663a3.5 3.5 0 0 1-3.163 2zM2.5 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                            </svg>Change
                            Password</button></li>

                    <li><button id="Delete-Account-Password-Modal-Button" class="dropdown-item fw-bold text-danger"
                            data-bs-target="#User-Password-Modal4" data-bs-toggle="modal"
                            data-bs-dismiss="modal"><svg width="16" height="16" fill="currentColor"
                                class="bi bi-exclamation-triangle-fill mx-2" viewBox="0 0 16 16">
                                <path
                                    d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                            </svg>Delete Account</button></li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- User Password Form From Account Information-->
<div class="modal fade" id="User-Password-Modal1" data-bs-backdrop="static" aria-hidden="true"
    aria-labelledby="User-Password-Modal1" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">User Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="User-Password-Form1" name='user_password' method="post"
                    action="/home/profile/settings/authUserPassword">
                    @csrf
                    <input type="password" name="information_password" class="form-control mb-1" autocomplete=off>
                    <input type="hidden" name="ref" value="info">
                    @error('information_password')
                        <div class="text-danger mb-1">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                    <div class="text-end">
                        <button type="submit" form="User-Password-Form1"
                            class="btn btn-outline-primary">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- User Password Form Change Email-->
<div class="modal fade" id="User-Password-Modal2" data-bs-backdrop="static" aria-hidden="true"
    aria-labelledby="User-Password-Modal2" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">User Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="User-Password-Form2" name='user-password' method="post"
                    action="/home/profile/settings/authUserPassword">
                    @csrf
                    <input type="password" name="change_email_password" class="form-control mb-1" autocomplete=off>
                    <input type="hidden" name="ref" value="email">
                    @error('change_email_password')
                        <div class="text-danger mb-1">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                    <div class="text-end">
                        <button type="submit" form="User-Password-Form2"
                            class="btn btn-outline-primary text-end">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- User Password Form Change Password-->
<div class="modal fade" id="User-Password-Modal3" data-bs-backdrop="static" aria-hidden="true"
    aria-labelledby="User-Password-Modal3" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="User-Password-Form3" name='user_password' method="post"
                    action="/home/profile/settings/changePassword">
                    @csrf
                    Current Password
                    <input type="password" name="current_password" class="form-control " autocomplete=off>
                    @error('current_password')
                        <div class="text-danger">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                    New Password
                    <input type="password" name="new_password" class="form-control " autocomplete=off>
                    @error('new_password')
                        <div class="text-danger">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                    Confirm Password
                    <input type="password" name="new_password_confirmation" class="form-control " autocomplete=off>
                    <div class="text-end mt-3">
                        <button type="submit" form="User-Password-Form3"
                            class="btn btn-outline-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- User Password Form Delete Account-->
<div class="modal fade" id="User-Password-Modal4" data-bs-backdrop="static" aria-hidden="true"
    aria-labelledby="User-Password-Modal4" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">User Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="User-Password-Form4" name='user-password' method="post"
                    action="/home/profile/settings/authUserPassword">
                    @csrf
                    <input type="password" name="delete_password" class="form-control mb-1" autocomplete=off>
                    <input type="hidden" name="ref" value="delete">
                    @error('delete_password')
                        <div class="text-danger mb-1">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                    <div class="text-end">
                        <button type="submit" form="User-Password-Form4"
                            class="btn btn-outline-primary text-end">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--Enter Room Confirm-->
<div class="modal fade" id="Enter-Room-Modal" data-bs-backdrop="static" aria-hidden="true"
    aria-labelledby="Enter-Room-Modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content text-end">
            <div class="modal-header border">
                <h5 class="modal-title">ルームへ入室しますか?
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <a id="Enter-Room-Link" href="" class="btn btn-outline-primary text-end">Yes</a>
            </div>
        </div>
    </div>
</div>


<!--Delete Room Confirm-->
<div class="modal fade" id="Remove-Room-Modal" data-bs-backdrop="static" aria-hidden="true"
    aria-labelledby="Remove-Room-Modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content text-end">
            <div class="modal-header border">
                <h5 class="modal-title">ルームを削除しますか?
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!--<a id="Remove-Room-Link" href="" class="btn btn-outline-primary text-end">Yes</a>-->
                <form method='post' action='/home/removeRoom'>
                    @csrf
                    <button type="submit" class="btn btn-outline-primary text-end"
                        onclick="window.onbeforeunload = null;" data-bs-dismiss="modal">Yes</button>
                    <input id="Remove-Room-Input" type="hidden" name="room_id">
                </form>
            </div>
        </div>
    </div>
</div>


<!--Delete Account Confirm-->
<div class="modal fade" id="Delete-Account-Modal" data-bs-backdrop="static" aria-hidden="true"
    aria-labelledby="Delete-Account-Modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content text-end">
            <div class="modal-header">
                <h5 class="modal-title">アカウントを削除しますか</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method='post' action="/home/profile/settings/deleteAccount">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary text-end">Yes</button>
                    <input type="hidden" name="auth" value="auth">
                </form>
            </div>
        </div>
    </div>
</div>
