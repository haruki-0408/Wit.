<div id="left-sidebar" class="col-lg-3 col-md-4 d-flex flex-column p-3 bg-light d-none d-md-block">
    <div class="profile-box  ">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
            <i class="bi bi-person-fill mx-2"></i>
            <span class="fs-4">Profile</span>
        </a>

        <hr>

        <div class="dropdown mb-3">
            <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle"
                id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://github.com/mdo.png" alt="" width="70" height="70" class="rounded-circle me-2">
                <strong>{{ Auth::user()->name }}</strong>
            </a>


            <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                <li><a class="dropdown-item" href="#">New project...</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Sign out</a></li>
            </ul>
        </div>

        <div class="Profile-message text-break fs-6">
            Hi I'm Test account I'll work hard to make this project a success. Thank you.
            dafdasdfsadfsfefasfeafeafeafsafeafasfeasfafasfaseefasfweafaefesafeasfasefasfeasfaefeasfaefef</div>

        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="#" class="nav-link active" aria-current="page">
                    Home
                </a>
            </li>

            <li>
                <a href="#" class="nav-link link-dark">
                    Post
                </a>
            </li>
            <li>
                <a href="#" class="nav-link link-dark">
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
            <i class="bi bi-people-fill mx-2"></i>

            Users

            <ul class="nav nav-pills flex-column m-2 mb-auto fs-6 ">
                <li class="nav-item" id="user">
                    <a href="#" class="d-flex align-items-center  link-dark text-decoration-none">
                        <img src="https://github.com/haruki-0408.png" alt="" width="30" height="30"
                            class="rounded-circle me-2">
                        haruki
                    </a>
                </li>
                <li>
                    <a href="#" class="d-flex align-items-center  link-dark text-decoration-none">
                        <img src="https://github.com/mika.png" alt="" width="30" height="30"
                            class="rounded-circle me-2">
                        asdfghjkloiuytrewqas
                    </a>
                </li>
                <li>
                    <a href="#" class="d-flex align-items-center  link-dark text-decoration-none">
                        <img src="https://github.com/ham.png" alt="" width="30" height="30" class="rounded-circle me-2">
                        roy
                    </a>
                </li>
                <li>
                    <a href="#" class="d-flex align-items-center  link-dark text-decoration-none">
                        <img src="https://github.com/erika.png" alt="" width="30" height="30"
                            class="rounded-circle me-2">
                        erika
                    </a>
                </li>
                <li>
                    <a href="#" class="d-flex align-items-center  link-dark text-decoration-none">
                        <img src="https://github.com/doggy.png" alt="" width="30" height="30"
                            class="rounded-circle me-2">
                        doggy
                    </a>
                </li>

            </ul>

        </div>


        <div class="room-list fs-5 mt-3 ">
            <i class="bi bi-house-fill mx-2 "></i>

            Rooms :

            <ul class="text-truncate list-group  m-2 fs-6 ">
                <li class="list-group-item  text-truncate">An
                    itemdafasdfsadfasfdsafasfdsfasfdsafasfafdsafsafdsfasfdsafasdfa</li>
                <li class="list-group-item">A second item</li>
                <li class="list-group-item">A third item</li>
                <li class="list-group-item">A fourth item</li>
                <li class="list-group-item">And a fifth one</li>
            </ul>
        </div>
        <hr>
    </div>
</div>
