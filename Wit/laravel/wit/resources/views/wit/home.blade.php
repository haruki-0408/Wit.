@extends('layouts.app')

@section('content')

<div class="container-fluid h-100">
    <div class="row h-100">    
        <div id="left-sidebar" class="col-3 p-0">
            <div class="d-flex flex-column p-3 m-1 bg-light">
                <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                    <i class="bi bi-person-fill mx-2 w-3 h-3"></i>
                    <span class="fs-4">Profile</span>
                </a>

                <hr>

                <div class="dropdown mb-3">
                    <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://github.com/mdo.png" alt="" width="100" height="100" class="rounded-circle me-2">
                        <strong>Test1</strong>
                    </a>
  
                    
                    <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                        <li><a class="dropdown-item" href="#">New project...</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Sign out</a></li>
                    </ul>
                </div>

                <div class="follow&follower">
                    <i class="bi bi-people-fill "></i>
                    <a href="#">follow:</a>482
                    <a href="#">follower:</a>482 
                </div>    
        
                <hr>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="#" class="nav-link active" aria-current="page">
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link link-dark">
                                Dashboard
                            </a>
                        </li>       
                        <li>
                            <a href="#" class="nav-link link-dark">
                                Orders
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link link-dark">
                                Products
                            </a>
                        </li>     
                        <li>
                            <a href="#" class="nav-link link-dark">
                                Customers
                            </a>
                        </li>
                    </ul>
                <hr>

                <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                    <i class="bi bi-list mx-2 "></i>
                    <span class="fs-4">My list</span>
                </a>
        
                <hr>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="#" class="nav-link active" aria-current="page">
                                PHP Study
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link link-dark">
                                nginx
                            </a>
                        </li>       
                    </ul>
                <hr>

                <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                    <i class="bi bi-clock-history mx-2"></i>
                    <span class="fs-4">Previous</span>
                </a>
                <hr>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="#" class="nav-link active" aria-current="page">
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
        </div> 
        <!-- Room content -->
        <div id="center-content" class="col-6 align-items-center p-1 m-0">
            <ul id="Rooms" class="align-items-center p-1 m-0">
                <li class="Room my-2 border" id="">
                    <div class="Room-contents container-fluid">
                        <div class="row">
                            <div class="title col-12">
                                <h3 class="font-weight-bold rounded-3 ">First Learning Community</h3>
                            </div>
                        </div>

                        <div class="row">
                            <div class="user col-3">
                                <a href="#" class="d-flex align-items-center  link-dark text-decoration-none">
                                    <img src="https://github.com/haruki-0408.png" alt="" width="50" height="50" class="rounded-circle me-2">
                                    <strong>haruki</strong>
                                </a>
                            </div>

                            <div class="description col-9">
                                <h4>Description:</h4>
                                <p>test message</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="room_tags col-10 ">
                                <ul>
                                    <li><a class="tags"href="#">Food</a></li>
                                    <li><a class="tags"href="#">Movie</a></li>
                                </ul>
                            </div>
                            <div class="button col-2 ">
                                <button type="button" class="btn btn-danger">Entry</button>
                            </div>
                        </div>          
                    </div>    
                </li>

                <li class="Room my-2 border" id="">
                    <div class="Room-contents container-fluid">
                        <div class="row">
                            <div class="title col-12">
                                <h3 class="font-weight-bold rounded-3 ">Where is Hot places</h3>
                            </div>
                        </div>

                        <div class="row">
                            <div class="user col-3">
                                <a href="#" class="d-flex align-items-center  link-dark text-decoration-none">
                                    <img src="https://github.com/row.png" alt="" width="50" height="50" class="rounded-circle me-2">
                                    <strong>tenten</strong>
                                </a>
                            </div>

                            <div class="description col-9">
                                <h4>Description:</h4>
                                <p>Hot Hotter Hottest Let's</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="room_tags col-10 ">
                                <ul>
                                    <li><a class="tags"href="#">Food</a></li>
                                    <li><a class="tags"href="#">Movie</a></li>
                                </ul>
                            </div>
                            <div class="button col-2 ">
                                <button type="button" class="btn btn-danger">Entry</button>
                            </div>
                        </div>          
                    </div>    
                </li>

                <li class="Room my-2 border" id="">
                    <div class="Room-contents container-fluid">
                        <div class="row">
                            <div class="title col-12">
                                <h3 class="font-weight-bold rounded-3 ">Why do you need morning News ? </h3>
                            </div>
                        </div>

                        <div class="row">
                            <div class="user col-3">
                                <a href="#" class="d-flex align-items-center  link-dark text-decoration-none">
                                    <img src="https://github.com/super.png" alt="" width="50" height="50" class="rounded-circle me-2">
                                    <strong>shtein</strong>
                                </a>
                            </div>

                            <div class="description col-9">
                                <h4>Description:</h4>
                                <p>News is the fact?</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="room_tags col-10 ">
                                <ul>
                                    <li><a class="tags"href="#">Food</a></li>
                                    <li><a class="tags"href="#">Movie</a></li>
                                </ul>
                            </div>
                            <div class="button col-2 ">
                                <button type="button" class="btn btn-danger">Entry</button>
                            </div>
                        </div>          
                    </div>    
                </li>

                <li class="Room my-2 border" id="">
                    <div class="Room-contents container-fluid">
                        <div class="row">
                            <div class="title col-12">
                                <h3 class="font-weight-bold rounded-3 ">My favorite movie</h3>
                            </div>
                        </div>

                        <div class="row">
                            <div class="user col-3">
                                <a href="#" class="d-flex align-items-center  link-dark text-decoration-none">
                                    <img src="https://github.com/tenten.png" alt="" width="50" height="50" class="rounded-circle me-2">
                                    <strong>haruki</strong>
                                </a>
                            </div>

                            <div class="description col-9">
                                <h4>Description:</h4>
                                <p>please tell me your favorite movies</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="room_tags col-10 ">
                                <ul>
                                    <li><a class="tags"href="#">Food</a></li>
                                    <li><a class="tags"href="#">Movie</a></li>
                                </ul>
                            </div>
                            <div class="button col-2 ">
                                <button type="button" class="btn btn-danger">Entry</button>
                            </div>
                        </div>          
                    </div>    
                </li>

                <li class="Room my-2 border" id="">
                    <div class="Room-contents container-fluid">
                        <div class="row">
                            <div class="title col-12">
                                <h3 class="font-weight-bold rounded-3">What is Interactive?</h3>
                            </div>
                        </div>

                        <div class="row">
                            <div class="user col-3">
                                <a href="#" class="d-flex align-items-center  link-dark text-decoration-none">
                                    <img src="https://github.com/haru.png" alt="" width="50" height="50" class="rounded-circle me-2">
                                    <strong>satoshi</strong>
                                </a>
                            </div>

                            <div class="description col-9 ">
                                <h4>Description:</h4>
                                <p>This is Super Interactive SNS </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="room_tags col-10 ">
                                <ul>
                                    <li><a class="tags"href="#">Food</a></li>
                                    <li><a class="tags"href="#">Movie</a></li>
                                </ul>
                            </div>
                            <div class="button col-2 ">
                                <button type="button" class="btn btn-danger">Entry</button>
                            </div>
                        </div>            
                    </div>    
                </li>

                <li class="Room my-2 border" id="">
                    <div class="Room-contents container-fluid">
                        <div class="row">
                            <div class="title col-12">
                                <h3 class="font-weight-bold rounded-3">PHP is Super Laungage</h3>
                            </div>
                        </div>

                        <div class="row">
                            <div class="user col-3">
                                <a href="#" class="d-flex align-items-center  link-dark text-decoration-none">
                                    <img src="https://github.com/satoshi.png" alt="" width="50" height="50" class="rounded-circle me-2">
                                    <strong>satoshi</strong>
                                </a>
                            </div>

                            <div class="description col-9 ">
                                <h4>Description:</h4>
                                <p>This is Super Interactive SNS </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="room_tags col-10 ">
                                <ul>
                                    <li><a class="tags"href="#">Food</a></li>
                                    <li><a class="tags"href="#">Movie</a></li>
                                </ul>
                            </div>
                            <div class="button col-2 ">
                                <button type="button" class="btn btn-danger">Entry</button>
                            </div>
                        </div>            
                    </div>    
                </li>


            </ul>
        </div>    

        <div id="right-sidebar" class="col-3 p-0">
            <div class="d-flex flex-column p-3 m-1  bg-light">
                    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                        <i class="bi bi-tag-fill mx-2 w-3 h-3"></i>
                        <span class="fs-4">Tags</span>
                    </a>
    
                    <hr>
                        <div class="Trend-tags fs-5">
                            <i class="bi bi-droplet mx-2 w-3 h-3"></i>
                            World Trend :
                            <ul>
                                <li><a class="tags"href="#">Food</a></li>
                                <li><a class="tags"href="#">Fassion</a></li>
                                <li><a class="tags"href="#">Mathmatics</a></li>
                                <li><a class="tags"href="#">Science</a></li>
                                <li><a class="tags"href="#">PHP</a></li>
                                <li><a class="tags"href="#">Twitter</a></li>
                                <li><a class="tags"href="#">Programming</a></li>
                                <li><a class="tags"href="#">Movie</a></li>
                            </ul>

                        </div>

                    
                        <div class="Favorite-tags fs-5">
                            <i class="bi bi-heart-fill mx-2 w-3 h-3"></i>
                            Favorites :
                            <ul>
                                <li><a class="tags"href="#">Food</a></li>
                                <li><a class="tags"href="#">Fassion</a></li>
                                <li><a class="tags"href="#">Mathmatics</a></li>
                                <li><a class="tags"href="#">Science</a></li>
                                <li><a class="tags"href="#">PHP</a></li>
                                <li><a class="tags"href="#">Twitter</a></li>
                                <li><a class="tags"href="#">Programming</a></li>
                                <li><a class="tags"href="#">Movie</a></li>    
                            </ul>
                        </div>
                    <hr>
            </div>
        </div>    

    </div><!--row-->
</div><!--container-fluid-->
@endsection