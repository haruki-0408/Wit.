<div id="right-sidebar" class="col-3 d-none d-lg-block d-flex flex-column p-3   bg-light">
    <div class="d-flex align-items-center mb-3">
        <a href="#" class="link-dark text-decoration-none" data-bs-toggle="modal" data-bs-target="#tags">
            <i class="bi bi-tag-fill mx-2"></i>
            <span class="fs-4">Trend Tag</span> <!-- Tagには文字数制限をつける　-->
        </a>
    </div>

    <hr>
    @component('wit.tags')
    @endcomponent
    <hr>
</div>
