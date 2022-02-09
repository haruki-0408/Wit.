<!-- Modals -->
<div class="modal fade" id="users" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="users" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="users">Users</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
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
                <h5 class="modal-title" id="list-rooms">Rooms</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @component('wit.list-rooms')
                @endcomponent
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tags" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="tags" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tags">Tags</h5>
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

<div class="footer d-md-none fixed-bottom bg-light mt-2">
    <nav class="navbar navbar-light bg-light justify-content-around">
        <a class="home link-dark footer-buttons" href="/home"><i class="rounded bi bi-house-door-fill"></i></a>
        <a class="profile link-dark footer-buttons" href="/home/profile"><i class="bi bi-person-fill"></i></a>
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
                    <a href="#" class="link-dark text-decoration-none" data-bs-toggle="modal" data-bs-target="#list-rooms">
                    <strong>Rooms</strong>
                    </a>
                </li>
            </ul>
        </div>
        <a class="tags link-dark footer-buttons" data-bs-toggle="modal" data-bs-target="#tags" href="#"><i
                class="bi bi-tag-fill"></i></a>
        <a class="settings link-dark footer-buttons" href="#"><i class="bi bi-gear-fill"></i></a>
    </nav>
</div>
