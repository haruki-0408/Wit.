<!-- Modals -->
<div class="modal fade" id="posts" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="posts" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Posts</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-1">
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
                <h5 class="modal-title">Answers</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-1">
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
                <h5 class="modal-title"><i class="bi bi-people-fill mx-2 "></i>Users</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-1">
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
                <h5 class="modal-title"><i class="bi bi-house-fill mx-2 "></i>Rooms</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-1">
                @component('wit.list-rooms')
                @endcomponent
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Room Password Modal -->
<div class="modal fade" id="roomPasswordForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="roomPasswordForm" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-lock-fill mx-2"></i>Room Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-column p-3">

                    <form name='roomPass' method="post" action="/home/authRoomPassword" id="Room-password">
                        @csrf
                        <input type="password" name="enterPass" class="form-control mb-3" autocomplete=off>
                        <input type="hidden" name="room_id">
                        <button type="submit" form="Room-password" class="btn btn-primary text-end">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="tags" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
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
<div class="modal fade" id="settings" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="settings" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-gear-fill mx-2"></i>Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-1">
                <ul id="setting-links" class="p-0 m-0 fs-5 rounded">
                    <li><a class="dropdown-item link-dark  text-primary" data-bs-target="#userPasswordForm1"
                            data-bs-toggle="modal" data-bs-dismiss="modal"><i
                                class="bi bi-info-circle-fill mx-2"></i>Account Information</a></li>
                    <li><a class="dropdown-item link-dark  text-primary" data-bs-target="#userPasswordForm2"
                            data-bs-toggle="modal" data-bs-dismiss="modal"><i class="bi bi-key-fill mx-2"></i>Change
                            Password</a></li>
                    <li><a class="dropdown-item link-dark  text-danger" data-bs-target="#userPasswordForm3"
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
<div class="modal fade" id="userPasswordForm1" aria-hidden="true" aria-labelledby="userPasswordForm1" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">User Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="User-password1" name='userPass' method="post" action="/home/profile/settings/authUserPassword?ref=info">
                    @csrf
                    <input type="password" name="settingPass" class="form-control mb-3" autocomplete=off>
                    <button type="submit" form="User-password1" class="btn btn-primary text-end">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- User Password Form Change Password-->
<div class="modal fade" id="userPasswordForm2" aria-hidden="true" aria-labelledby="userPasswordForm2" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">User Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="User-password2" name='userPass' method="post" action="/home/profile/settings/authUserPassword?ref=change">
                    @csrf
                    <input type="password" name="settingPass" class="form-control mb-3" autocomplete=off>
                    <button type="submit" form="User-password2" class="btn btn-primary text-end">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- User Password Form Delete Account-->
<div class="modal fade" id="userPasswordForm3" aria-hidden="true" aria-labelledby="userPasswordForm3" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">User Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="User-password3" name='userPass' method="post" action="/home/profile/settings/authUserPassword?ref=delete">
                    @csrf
                    <input type="password" name="settingPass" class="form-control mb-3" autocomplete=off>
                    <button type="submit" form="User-password3" class="btn btn-primary text-end">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
