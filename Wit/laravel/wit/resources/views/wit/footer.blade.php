<div class="footer d-md-none fixed-bottom bg-light mt-2">
    <nav class="navbar navbar-light bg-light justify-content-around">
        <a class="home link-dark footer-buttons" href="/home"><i class="rounded bi bi-house-door-fill"></i></a>
        <a class="profile link-dark footer-buttons" href="/home/profile/{{ Auth::user()->id }}"><i class="bi bi-person-fill"></i></a>
        <div class="dropup">
            <a class="mylist dropup link-dark footer-buttons dropdown-toggle" data-bs-toggle="dropdown"
                aria-expanded="false"" href=" #"><i class="bi bi-card-list"></i></a>
            <ul class="dropdown-menu justify-content-center p-2">
                <li class="p-2">
                    <a href="#" class="link-dark text-decoration-none" data-bs-toggle="modal" data-bs-target="#users">
                        <strong>Users</strong>
                    </a>
                </li>
                <hr>
                <li class="p-2">
                    <a href="#" class="link-dark text-decoration-none" data-bs-toggle="modal"
                        data-bs-target="#list-rooms">
                        <strong>Rooms</strong>
                    </a>
                </li>
            </ul>
        </div>
        <a class="tags link-dark footer-buttons" data-bs-toggle="modal" data-bs-target="#tags" href="#"><i
                class="bi bi-tag-fill"></i></a>
        <a class="settings link-dark footer-buttons" data-bs-toggle="modal" data-bs-target="#settings"><i
                class="bi bi-gear-fill"></i></a>
    </nav>
</div>
