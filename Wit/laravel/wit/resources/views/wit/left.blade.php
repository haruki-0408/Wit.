<div id="Left-Sidebar" class="col-lg-3 col-md-4 d-flex flex-column p-3 bg-light d-none d-md-block">
    <div id="Profile-Box">
        <a href="/home/profile:{{ Crypt::encrypt(Auth::user()->id) }}"
            class="d-flex align-items-center mx-2 mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
            <svg width="16" height="16" fill="currentColor" class="bi bi-person-fill mx-2" viewBox="0 0 16 16">
                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
            </svg>
            <span class="fs-4">Profile</span>
        </a>

        <hr>

        <div class="dropdown mb-3">
            <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle"
                id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                <div id="profile" class="row">
                    <div class="col-3 inline"><img src="{{ asset(Auth::user()->profile_image) }}" alt=""
                            width="70" height="70" class="rounded-circle m-2"></div>
                    <div class="col-9 d-flex align-items-center justify-content-center text-wrap text-break"><strong
                            class="p-1 m-1">{{ Auth::user()->name }}</strong></div>
                </div>
            </a>


            <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                <li><button class="btn dropdown-item" data-bs-toggle="modal" data-bs-target="#Create-Room-Modal">New
                        Room</button></li>
                <li><button class="btn dropdown-item" data-bs-toggle="modal"
                        data-bs-target="#Settings-Modal">Settings</button></li>
                <li><a class="dropdown-item" href="/home/profile:{{ Crypt::encrypt(Auth::user()->id) }}">Profile</a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                    document.getElementById('logout-form2').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form2" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>

                </li>
            </ul>
        </div>

        <hr class="m-2">
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="m-1">
                <a href="#" class="dropdown-item link-dark" data-bs-toggle="modal"
                    data-bs-target="#My-OpenRoom-Modal">
                    <strong>・Open</strong>
                </a>
            </li>
            <li class="m-1">
                <a href="#" class="dropdown-item link-dark" data-bs-toggle="modal"
                    data-bs-target="#My-PostRoom-Modal">
                    <strong>・Post</strong>
                </a>
            </li>

        </ul>
        <hr class="m-2">
    </div>


    <div id="Mylist-Box">
        <div class="d-flex align-items-center pt-1 pb-2 m-2">
            <svg width="16" height="16" fill="currentColor" class="bi bi-card-list mx-2" viewBox="0 0 16 16">
                <path
                    d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
                <path
                    d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zM4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z" />
            </svg>
            <span class="fs-4">My list</span>
        </div>

        <div class="fs-5 dropdown-item d-flex align-items-center">
            <a href="#" class="link-dark text-decoration-none d-flex align-items-center" data-bs-toggle="modal"
                data-bs-target="#My-ListUser-Modal">
                <svg width="16" height="16" fill="currentColor" class="bi bi-people-fill mx-2"
                    viewBox="0 0 16 16">
                    <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                    <path fill-rule="evenodd"
                        d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z" />
                    <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z" />
                </svg>
                User
            </a>
        </div>

        <div class="fs-5 dropdown-item mt-2 d-flex align-items-center">
            <a href="#" class="link-dark text-decoration-none d-flex align-items-center" data-bs-toggle="modal"
                data-bs-target="#My-ListRoom-Modal">
                <svg width="16" height="16" fill="currentColor" class="bi bi-house-fill mx-2"
                    viewBox="0 0 16 16">
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

    <div id="Inquiry-Box">
        <a class="d-flex m-2 align-items-center link-dark text-decoration-none" href="/home/profile/inquiry">
            <svg width="16" height="16" fill="currentColor" class="bi bi-envelope-fill mx-2"
                viewBox="0 0 16 16">
                <path
                    d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z" />
            </svg>
            <span class="fs-4">Inquiry</span>
        </a>
        <hr>
    </div>

    <div id="Terms-Box">
        <a href="#" class="m-0 px-2 dropdown-item d-flex align-items-center link-dark text-decoration-none" data-bs-toggle="modal"
            data-bs-target="#Terms-Modal">
            <svg width="16" height="16" fill="currentColor" class="bi bi-pencil-fill mx-2"
                viewBox="0 0 16 16">
                <path
                    d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
            </svg>
            <span class="fs-4">Terms</span>
        </a>
        <hr>
    </div>
</div>
