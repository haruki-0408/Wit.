<div id="Right-Sidebar" class="col-3 d-none d-lg-block d-flex flex-column p-3   bg-light">
    <div id="Tag-Box">
        <div class="d-flex align-items-center mb-3">
            <svg width="16" height="16" fill="currentColor" class="bi bi-tags-fill mx-2" viewBox="0 0 16 16">
                <path
                    d="M2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586V2zm3.5 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z" />
                <path
                    d="M1.293 7.793A1 1 0 0 1 1 7.086V2a1 1 0 0 0-1 1v4.586a1 1 0 0 0 .293.707l7 7a1 1 0 0 0 1.414 0l.043-.043-7.457-7.457z" />
            </svg>
            <span class="fs-4">Tag</span>
        </div>

        <hr>

        @component('wit.tags')
        @endcomponent

    </div>
    <hr>
</div>
