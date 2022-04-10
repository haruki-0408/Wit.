<div id="left-sidebar" class="col-lg-3 col-md-4 d-flex flex-column p-3 bg-light d-none d-md-block">
    <div class="profile-box  ">
        <a href="/home/profile/{{ Auth::user()->id }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
            <i class="bi bi-person-fill mx-2"></i>
            <span class="fs-4">Profile</span>
        </a>

        <hr>

        <div class="dropdown mb-3">
            <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle"
                id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="profile">
                    <img src="{{ Auth::user()->profile_image }}" alt="" width="70" height="70"
                        class="rounded-circle me-2">
                    <strong>{{ Auth::user()->name }}</strong>
                </div>
            </a>


            <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                <li><button class="btn dropdown-item" data-bs-toggle="modal" data-bs-target="#CreateRoomForm">New
                        Room</button></li>
                <li><button class="btn dropdown-item" data-bs-toggle="modal"
                        data-bs-target="#settings">Settings</button></li>
                <li><a class="dropdown-item" href="/home/profile/{{ Auth::user()->id }}">Profile</a></li>
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
                <a href="#" class="dropdown-item link-dark" data-bs-toggle="modal" data-bs-target="#posts">
                    Post
                </a>
            </li>
            <li>
                <a href="#" class="dropdown-item link-dark" data-bs-toggle="modal" data-bs-target="#answers">
                    Answer
                </a>
            </li>
        </ul>
        <hr>
    </div>


    <div class="mylist-box ">
        <i class="bi bi-card-list mx-2"></i>
        <span class="fs-4">My list</span>

        <hr>

        <div class="user-list fs-5">
            <a href="#" class="link-dark text-decoration-none" data-bs-toggle="modal" data-bs-target="#users">
                <i class="bi bi-people-fill mx-2 "></i>
                User
            </a>
        </div>


        <div class="room-list fs-5 mt-3 ">
            <a href="#" class="link-dark text-decoration-none" data-bs-toggle="modal" data-bs-target="#list-rooms">
                <i class="bi bi-house-fill mx-2 "></i>
                Room
            </a>
        </div>
        <hr>
    </div>
</div>
