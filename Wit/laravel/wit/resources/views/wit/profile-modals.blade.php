<!-- Modals -->
<div class="modal fade" id="otherPostModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="posts" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Posts</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-1">
                <ul id="otherPost" class="p-0 m-0">
                    @foreach ($other_post_rooms as $post_room)
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
                                        <button type="button" class="add-list-room btn btn-outline-primary p-2"><i
                                            class="bi bi-plus"></i><i class="bi bi-card-list"></i></button>
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
                                @if (isset($post_room->password))
                                    <strong class="card-title">{{ $post_room->title }}<i
                                            class='bi bi-lock-fill '></i></strong>
                                @else
                                    <strong class="card-title">{{ $post_room->title }}</strong>
                                @endif
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

<div class="modal fade" id="otherAnswerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="answer" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Answers</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-1">
                <ul id="otherAnswer" class="p-0 m-0 ">
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
                <h5 class="modal-title"><i class="bi bi-people-fill mx-2 "></i>Users</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-1">
                <ul id="otherListUser" class="flex-column  mb-auto fs-5">
                    ここに要素をループする
                </ul>
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
                <h5 class="modal-title"><i class="bi bi-house-fill mx-2 "></i>Rooms</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-1">
                <ul id="otherListRoom" class="p-0 m-0 ">
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
