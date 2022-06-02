<!-- Room content -->
<div id="Room-content" class="col-lg-6 col-md-8 col-sm-12 m-0 p-2">
    <ul id="Rooms" class="p-0 m-0 ">

        @foreach ($rooms as $room)
            <li data-room-id="{{ $room->id }}">
                <div class="card border-0">
                    <div class="card-header border-0 d-flex bg-white p-1 justify-content-between">
                        <div class="user">
                            <a href="'home/profile/'{{ $room->user_id }} }}"
                                class="user-link link-dark p-1 text-decoration-none d-flex align-items-center">
                                <img src="{{ asset($room->user->profile_image) }}" alt="" width="50" height="50"
                                    class="profile-image rounded-circle me-2">
                                <strong class="user-name">{{ $room->user->name }}</strong>
                            </a>
                        </div>

                        <div class="btn-group d-flex align-items-center p-2">
                            @if (isset($type))
                                <p>typeが設定されています</p>
                            @endif

                            <button type="button" class="add-list-room btn btn-outline-primary p-2"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-clipboard-plus" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7z" />
                                    <path
                                        d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z" />
                                    <path
                                        d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z" />
                                </svg></button>
                            @if (isset($room->password))
                                <button type="button" class="enter-room btn btn-outline-primary p-2"
                                    data-bs-toggle="modal" data-bs-target="#roomPasswordFormModal"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z" />
                                        <path fill-rule="evenodd"
                                            d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
                                    </svg></button>
                            @else
                                <a href='/home/Room:{{ $room->id }}'
                                    class="enter-room btn btn-outline-primary p-2"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z" />
                                        <path fill-rule="evenodd"
                                            d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
                                    </svg></a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body p-1 row align-items-center m-0">
                    @if (isset($room->password))
                        <strong class="card-title align-items-center d-flex">{{ $room->title }}
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-lock-fill" viewBox="0 0 16 16">
                                <path
                                    d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z" />
                            </svg></strong>
                    @else
                        <strong class="card-title">{{ $room->title }}</strong>
                    @endif
                    <p class="card-text room-description text-break">{!! nl2br(e($room->description)) !!}</p>
                </div>

                <div class="card-footer border-0 bg-white p-0">
                    <ul class="room_tags p-1">
                        @foreach ($room->roomTags as $roomtag)
                            <li class="d-inline-block"><a class="tag"
                                    href="#">{{ $roomtag->tag->name }}<span
                                        class="badge badge-light">{{ $roomtag->tag->number }}</span></a></li>
                        @endforeach
                    </ul>
                </div>
            </li>
        @endforeach
    </ul>

    <div id="getMoreButton" class="btn d-flex justify-content-center m-3"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down" viewBox="0 0 16 16"><path d="M3.204 5h9.592L8 10.481 3.204 5zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659z"></path></svg></div>

</div>
