<!doctype html>
<html lang="ja">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    

    <title>Wit.</title>


</head>

<body>
    <!-- Terms of Service -->
    <div class="modal fade" id="Terms-Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="Terms-Modal" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <svg width="16" height="16" fill="currentColor" class="bi bi-pencil-fill mx-2"
                            viewBox="0 0 16 16">
                            <path
                                d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                        </svg>Terms
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-column p-3" style="font-size:0.6em">
                        @component('wit.terms')
                        @endcomponent
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid content">
        <header>
            <nav class="navbar navbar-expand-md navbar-light bg-transparent">
                <p class="navbar-brand" href="#">Wit.</p>
            </nav>
        </header>

        <main>
            <div class="Top mx-auto">
                <div class="row justify-content-center">
                    <div class="col-8">
                        <img width=100px height=100px src="{{ asset('/images/wit/wit.png') }} "">
                        <span class="text-center">Welcome to Wit.</span>
                    </div>
                </div>
            </div>

            <div class="row text-center m-2">
                <p class="text-dark fw-bold" style="font-style:initial">質問　議論　コミュニティ</p>
            </div>

            <div class="Auth-Button row justify-content-center mb-2">
                <div class="col-sm-12 text-center col-md-3"> <a href="{{ route('login') }}"
                        class="btn btn-primary px-4 m-2  ">ログイン</a> </div>
                <div class="col-sm-12 text-center col-md-3"> <a href="{{ route('register') }}"
                        class="btn btn-success px-4 m-2  ">新規登録</a> </div>
            </div>


            <div class="Icon row d-flex justify-content-center">
                <div id="PC" class="col-lg-3 col-md-12 col-12 text-center">
                    <div class="rounded-circle border-1 bg-white m-2">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-display"
                            viewBox="0 0 16 16">
                            <path
                                d="M0 4s0-2 2-2h12s2 0 2 2v6s0 2-2 2h-4c0 .667.083 1.167.25 1.5H11a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1h.75c.167-.333.25-.833.25-1.5H2s-2 0-2-2V4zm1.398-.855a.758.758 0 0 0-.254.302A1.46 1.46 0 0 0 1 4.01V10c0 .325.078.502.145.602.07.105.17.188.302.254a1.464 1.464 0 0 0 .538.143L2.01 11H14c.325 0 .502-.078.602-.145a.758.758 0 0 0 .254-.302 1.464 1.464 0 0 0 .143-.538L15 9.99V4c0-.325-.078-.502-.145-.602a.757.757 0 0 0-.302-.254A1.46 1.46 0 0 0 13.99 3H2c-.325 0-.502.078-.602.145z" />
                        </svg> PC
                    </div>
                    <video width="100%" src="movie/pc.mp4" autoplay muted loop></video>
                </div>
                <div id="Tablet" class="col-lg-3 col-md-6 col-12 text-center">
                    <div class="rounded-circle border-1 bg-white m-2">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-tablet" viewBox="0 0 16 16">
                            <path
                                d="M12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h8zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z" />
                            <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                        </svg> Tablet
                    </div>
                    <video width="80%" src="movie/tb.mp4" autoplay muted loop></video>
                </div>
                <div id="Smartphone" class="col-lg-2 col-md-6 col-12 text-center">
                    <div class="rounded-circle border-1 bg-white m-2">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-phone" viewBox="0 0 16 16">
                            <path
                                d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h6zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z" />
                            <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                        </svg> Phone
                    </div>
                    <video width="80%" src="movie/sm.mp4" autoplay muted loop></video>
                </div>
            </div>
    </div>
    </main>

    <!-- FOOTER -->
    <footer class="row m-1 bg-transparent fixed-bottom">
        <p class="d-inline-block">Copyright © 2022 Wit. All Rights Reserved. <a data-bs-toggle="modal"
                data-bs-target="#Terms-Modal" href="#">Terms of Service</a></p>
    </footer>








    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    -->
</body>

</html>
