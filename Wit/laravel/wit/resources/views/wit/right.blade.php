<div id="right-sidebar" class="col-3 d-none d-lg-block d-flex flex-column p-3   bg-light">
    <div class="d-flex align-items-center mb-3 mb-md-0 me-md-auto">
        <a href="#" class="link-dark text-decoration-none" data-bs-toggle="modal" data-bs-target="#tags">
            <i class="bi bi-tag-fill mx-2"></i>
            <span class="fs-4">Tags</span> <!-- Tagには文字数制限をつける　-->
        </a>
    </div>

    <hr>
    @component('wit.tags')
    @endcomponent
    <hr>
</div>
