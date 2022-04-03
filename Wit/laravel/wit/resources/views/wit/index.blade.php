<!doctype html>
<html lang="ja">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- normal CSS -->
    
    
    <style>
      
    </style>


    <title>Wit.</title>


  </head>

  <body>
    
  <div class="container-fluid content">
    <header>
      <nav class="navbar navbar-expand-md navbar-light bg-transparent">
        <a class="navbar-brand"  href="#">Wit.</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample03">
          <ul class="navbar-nav mx-auto">
            <li class="nav-item active">
              <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Link</a>
            </li>
        
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
              <div class="dropdown-menu" aria-labelledby="dropdown03">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
              </div>
            </li>
          </ul>
        
          <form class="form-inline my-2 my-md-0">
            <input class="form-control" type="text" placeholder="Search">
          </form>
        </div>
      </nav>
  </header>

  <main>
        <div class="top-message mx-auto"> 
          <div class="row justify-content-center" >
            <div class="col-8">
              <img width=200px height=200px src="{{ asset('/images/wit/wit.png') }} "" >
              Welcome to Wit.
            </div>
          </div>
        </div>     

        <div class="top-button  mb-5">
          <div class="row justify-content-center">
            <div class="col-2"><!-- space --> </div>
            <div class="col-sm-12 align-self-center col-md-3">  <a href="{{ route('login') }}" class="btn btn-primary px-5 m-2  " >ログイン</a>   </div> 
            <div class="col-sm-12 align-self-center col-md-3">  <a href="{{ route('register') }}" class="btn btn-success px-5 m-2  " >新規登録</a>   </div>      
          </div>
        </div>

        <div class="message-wrapper mx-auto"></div>
          <div class="row text-center"> 
            <div class="col-auto-12 m-3"><h1>Wit</h1></div>
            <div class="col-auto-12 m-3"><h2>こんにちは</h2></div>
            <div class="col-auto-12 m-3"><h2>あなたの技術的に知りたい聞きたい</h2></div>
            <div class="col-auto-12 m-3"><h2>そんな願望を叶えてくれます</h2></div>
            <div class="col-auto-12 m-3"><h2>一人では分からない思いつかない</h2></div>
            <div class="col-auto-12 m-3"><h2>そんなときこそ</h2></div>
            <div class="col-auto-12 m-3"><h2>知識や技術を相互に共有しましょう</h2></div>
            <div class="col-auto-12 m-3"><h2>リアルタイム通信を用いた</h2></div>
            <div class="col-auto-12 m-3"><h2>データベース機能であなただけの技術展開を</h2></div>
            <div class="col-auto-12 m-3"><h2>さあ今すぐ登録しましょう！</h2></div>
          </div>
        </div>
    </main>

      <!-- FOOTER -->
    <footer class="container m-5 bg-transparent">
      <p class="float-end"><a href="#">Back to top</a></p>
      <p>&copy; 2017–2021 Company, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
    </footer>

  </div>









    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>