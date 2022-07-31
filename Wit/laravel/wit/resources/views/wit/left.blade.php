<div id="left-sidebar" class="col-lg-3 col-md-4 d-flex flex-column p-3 bg-light d-none d-md-block">
    <div class="profile-box  ">
        <a href="/home/profile:{{ Crypt::encrypt(Auth::user()->id) }}"
            class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-person-fill mx-2" viewBox="0 0 16 16">
                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
            </svg>
            <span class="fs-4">Profile</span>
        </a>

        <hr>

        <div class="dropdown mb-3">
            <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle"
                id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="profile">
                    <img src="{{ asset(Auth::user()->profile_image) }}" alt="" width="70" height="70"
                        class="rounded-circle m-2">
                    <strong>{{ Auth::user()->name }}</strong>
                </div>
            </a>


            <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                <li><button class="btn dropdown-item" data-bs-toggle="modal" data-bs-target="#CreateRoomForm">New
                        Room</button></li>
                <li><button class="btn dropdown-item" data-bs-toggle="modal"
                        data-bs-target="#settingsModal">Settings</button></li>
                <li><a class="dropdown-item" href="/home/profile:{{ Crypt::encrypt(Auth::user()->id) }}">Profile</a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form2').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form2" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>

                </li>
            </ul>
        </div>

        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li>
                <a href="#" class="dropdown-item link-dark" data-bs-toggle="modal" data-bs-target="#myPostModal">
                    Post
                </a>
            </li>
            <li>
                <a href="#" class="dropdown-item link-dark" data-bs-toggle="modal" data-bs-target="#myAnswerModal">
                    Answer
                </a>
            </li>
        </ul>
        <hr>
    </div>


    <div class="mylist-box ">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-list mx-2"
            viewBox="0 0 16 16">
            <path
                d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
            <path
                d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zM4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z" />
        </svg>
        <span class="fs-4">My list</span>

        <hr>

        <div class="user-list fs-5">
            <a href="#" class="link-dark text-decoration-none" data-bs-toggle="modal" data-bs-target="#myListUserModal">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-people-fill mx-2" viewBox="0 0 16 16">
                    <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                    <path fill-rule="evenodd"
                        d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z" />
                    <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z" />
                </svg>
                User
            </a>
        </div>


        <div class="room-list fs-5 mt-3 ">
            <a href="#" class="link-dark text-decoration-none" data-bs-toggle="modal" data-bs-target="#myListRoomModal">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-house-fill mx-2" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
                    <path fill-rule="evenodd"
                        d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z" />
                </svg>
                Room
            </a>
        </div>
        <hr>
    </div>
</div>
