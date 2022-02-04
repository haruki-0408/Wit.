@extends('layouts.app')

@section('content')

<div class="container-fluid"> 
    <div class="row ">    
        <div id="left-sidebar" class="col-lg-3 col-md-4 d-flex flex-column p-3 bg-light d-none d-md-block">      
                <div class="profile-box  ">
                    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                        <i class="bi bi-person-fill mx-2"></i>
                        <span class="fs-4">Profile</span>
                    </a>

                    <hr>

                    <div class="dropdown mb-3">
                        <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://github.com/mdo.png" alt="" width="70" height="70" class="rounded-circle me-2">
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

                    <div class="Profile-message text-break fs-6">
                        Hi I'm Test account I'll work hard to make this project a success. Thank you. dafdasdfsadfsfefasfeafeafeafsafeafasfeasfafasfaseefasfweafaefesafeasfasefasfeasfaefeasfaefef</div>    
            
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
                    <i class="bi bi-clipboard mx-2"></i>
                    <span class="fs-4">My list</span>
                    
                    <hr>
                   
                    <div class="user-list fs-5">
                        <i class="bi bi-people-fill mx-2"></i>
                       
                        Users  
                    
                        <ul class="nav nav-pills flex-column m-2 mb-auto fs-6 ">
                            <li class="nav-item" id="user">
                                <a href="#" class="d-flex align-items-center  link-dark text-decoration-none">
                                    <img src="https://github.com/haruki-0408.png" alt="" width="30" height="30" class="rounded-circle me-2">
                                    haruki
                                </a>
                            </li>
                            <li>
                                <a href="#" class="d-flex align-items-center  link-dark text-decoration-none">
                                    <img src="https://github.com/mika.png" alt="" width="30" height="30" class="rounded-circle me-2">
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
                                    <img src="https://github.com/erika.png" alt="" width="30" height="30" class="rounded-circle me-2">
                                    erika
                                </a>
                            </li>    
                            <li>
                                <a href="#" class="d-flex align-items-center  link-dark text-decoration-none">
                                    <img src="https://github.com/doggy.png" alt="" width="30" height="30" class="rounded-circle me-2">
                                    doggy
                                </a>
                            </li>    
                            
                        </ul>
                        
                    </div>    
                    
    
                    <div class="room-list fs-5 mt-3 ">
                        <i class="bi bi-house-fill mx-2 "></i>
                       
                        Rooms :
                    
                        <ul class="text-truncate list-group  m-2 fs-6 ">
                            <li class="list-group-item  text-truncate">An itemdafasdfsadfasfdsafasfdsfasfdsafasfafdsafsafdsfasfdsafasdfa</li>
                            <li class="list-group-item">A second item</li>
                            <li class="list-group-item">A third item</li>
                            <li class="list-group-item">A fourth item</li>
                            <li class="list-group-item">And a fifth one</li>   
                         </ul>      
                    </div>
                    <hr>
                </div>
        </div>
        
        
        <!-- Room content -->
        <div id="Room-content" class="d-flex flex-column col-lg-6 col-md-8 col-sm-12">
            <ul id="Rooms" class="align-items-center p-3 m-0 ">
                <li>
                    <div class="card border-0 mt-4 w-100">
                        <div class="container-card-body">
                            <h4 class="card-title p-1">WORLD FOOLER</h4> 
                            <div class="row">
                                <div class="col-6 text-start">
                                    <a href="#" class="link-dark text-decoration-none">
                                        <img src="https://github.com/carbon.png" alt="" width="50" height="50" class="rounded-circle me-2">
                                        <strong>Mr.X</strong>
                                    </a>
                                </div>
                                <div class="col-6 text-end"><a href="#" class="btn btn-outline-primary">Enter</a></div>
                                <p class="card-text m-2">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            </div>
                                
                            <div class="room_tags">
                                <ul class="p-0">
                                    <li class="d-inline-block"><a class="tags"href="#">Food</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Fassion</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">anime</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">programming</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">suits</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">sports</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">fdfe fefe fsefefes </a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>                                        
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="card border-0 mt-4 w-100">
                        <div class="container-card-body">
                            <h4 class="card-title p-1">Apple is the Strongest Paas?</h4> 
                            <div class="row">
                                <div class="col-6 text-start">
                                    <a href="#" class="link-dark text-decoration-none">
                                        <img src="https://github.com/haruki.png" alt="" width="50" height="50" class="rounded-circle me-2">
                                        <strong>haruki</strong>
                                    </a>
                                </div>
                                <div class="col-6 text-end"><a href="#" class="btn btn-outline-primary">Enter</a></div>
                                <p class="card-text m-2">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            </div>
                                
                            <div class="room_tags">
                                <ul class="p-0">
                                    <li class="d-inline-block"><a class="tags"href="#">Food</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Fassion</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">anime</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">programming</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">suits</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">sports</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">fdfe fefe fsefefes </a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>                                        
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="card border-0 mt-4 w-100">
                        <div class="container-card-body">
                            <h4 class="card-title p-1">SUPER TEXT EDITOR</h4> 
                            <div class="row">
                                <div class="col-6 text-start">
                                    <a href="#" class="link-dark text-decoration-none">
                                        <img src="https://github.com/ram.png" alt="" width="50" height="50" class="rounded-circle me-2">
                                        <strong>Ram</strong>
                                    </a>
                                </div>
                                <div class="col-6 text-end"><a href="#" class="btn btn-outline-primary">Enter</a></div>
                                <p class="card-text m-2">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            </div>
                                
                            <div class="room_tags">
                                <ul class="p-0">
                                    <li class="d-inline-block"><a class="tags"href="#">Food</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Fassion</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">anime</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">programming</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">suits</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">sports</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">fdfe fefe fsefefes </a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>                                        
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="card border-0 mt-4 w-100">
                        <div class="container-card-body">
                            <h4 class="card-title p-1">GLIDE</h4> 
                            <div class="row">
                                <div class="col-6 text-start">
                                    <a href="#" class="link-dark text-decoration-none">
                                        <img src="https://github.com/betty.png" alt="" width="50" height="50" class="rounded-circle me-2">
                                        <strong>betty</strong>
                                    </a>
                                </div>
                                <div class="col-6 text-end"><a href="#" class="btn btn-outline-primary">Enter</a></div>
                                <p class="card-text m-2">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            </div>
                                
                            <div class="room_tags">
                                <ul class="p-0">
                                    <li class="d-inline-block"><a class="tags"href="#">Food</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Fassion</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">anime</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">programming</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">suits</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">sports</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">fdfe fefe fsefefes </a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>                                        
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="card border-0 mt-4w-100">
                        <div class="container-card-body">
                            <h4 class="card-title p-1">IS NEW CHANCE</h4> 
                            <div class="row">
                                <div class="col-6 text-start">
                                    <a href="#" class="link-dark text-decoration-none">
                                        <img src="https://github.com/car.png" alt="" width="50" height="50" class="rounded-circle me-2">
                                        <strong>CHan</strong>
                                    </a>
                                </div>
                                <div class="col-6 text-end"><a href="#" class="btn btn-outline-primary">Enter</a></div>
                                <p class="card-text m-2">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            </div>
                                
                            <div class="room_tags">
                                <ul class="p-0">
                                    <li class="d-inline-block"><a class="tags"href="#">Food</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Fassion</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">anime</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">programming</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">suits</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">sports</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">fdfe fefe fsefefes </a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>                                        
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="card border-0 mt-4 w-100">
                        <div class="container-card-body">
                            <h4 class="card-title p-1">WORLD FOOLER</h4> 
                            <div class="row">
                                <div class="col-6 text-start">
                                    <a href="#" class="link-dark text-decoration-none">
                                        <img src="https://github.com/carbon.png" alt="" width="50" height="50" class="rounded-circle me-2">
                                        <strong>Mr.X</strong>
                                    </a>
                                </div>
                                <div class="col-6 text-end"><a href="#" class="btn btn-outline-primary">Enter</a></div>
                                <p class="card-text m-2">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            </div>
                                
                            <div class="room_tags">
                                <ul class="p-0">
                                    <li class="d-inline-block"><a class="tags"href="#">Food</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Fassion</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">anime</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">programming</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">suits</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">sports</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">fdfe fefe fsefefes </a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>                                        
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
                
                <li>
                    <div class="card border-0 mt-4 w-100">
                        <div class="container-card-body">
                            <h4 class="card-title p-1">INHIVITE</h4> 
                            <div class="row">
                                <div class="col-6 text-start">
                                    <a href="#" class="link-dark text-decoration-none">
                                        <img src="https://github.com/bon.png" alt="" width="50" height="50" class="rounded-circle me-2">
                                        <strong>Irruus</strong>
                                    </a>
                                </div>
                                <div class="col-6 text-end"><a href="#" class="btn btn-outline-primary">Enter</a></div>
                                <p class="card-text m-2">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            </div>
                                
                            <div class="room_tags">
                                <ul class="p-0">
                                    <li class="d-inline-block"><a class="tags"href="#">Food</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Fassion</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">anime</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">programming</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">suits</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">sports</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">fdfe fefe fsefefes </a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>                                        
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="card border-0 mt-4 w-100">
                        <div class="container-card-body">
                            <h4 class="card-title p-1">WORLD FOOLER</h4> 
                            <div class="row">
                                <div class="col-6 text-start">
                                    <a href="#" class="link-dark text-decoration-none">
                                        <img src="https://github.com/carbon.png" alt="" width="50" height="50" class="rounded-circle me-2">
                                        <strong>Mr.X</strong>
                                    </a>
                                </div>
                                <div class="col-6 text-end"><a href="#" class="btn btn-outline-primary">Enter</a></div>
                                <p class="card-text m-2">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            </div>
                                
                            <div class="room_tags">
                                <ul class="p-0">
                                    <li class="d-inline-block"><a class="tags"href="#">Food</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Fassion</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">anime</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">programming</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">suits</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">sports</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">fdfe fefe fsefefes </a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>                                        
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="card border-0 mt-4 w-100">
                        <div class="container-card-body">
                            <h4 class="card-title p-1">Tensow flow</h4> 
                            <div class="row">
                                <div class="col-6 text-start">
                                    <a href="#" class="link-dark text-decoration-none">
                                        <img src="https://github.com/jai.png" alt="" width="50" height="50" class="rounded-circle me-2">
                                        <strong>Mr.X</strong>
                                    </a>
                                </div>
                                <div class="col-6 text-end"><a href="#" class="btn btn-outline-primary">Enter</a></div>
                                <p class="card-text m-2">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            </div>
                                
                            <div class="room_tags">
                                <ul class="p-0">
                                    <li class="d-inline-block"><a class="tags"href="#">Food</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Fassion</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">anime</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">programming</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">suits</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">sports</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">fdfe fefe fsefefes </a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>                                        
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="card border-0 mt-4 w-100">
                        <div class="container-card-body">
                            <h4 class="card-title p-1">りんごはなぜ赤い？</h4> 
                            <div class="row">
                                <div class="col-6 text-start">
                                    <a href="#" class="link-dark text-decoration-none">
                                        <img src="https://github.com/kazuki.png" alt="" width="50" height="50" class="rounded-circle me-2">
                                        <strong>はるき</strong>
                                    </a>
                                </div>
                                <div class="col-6 text-end"><a href="#" class="btn btn-outline-primary">Enter</a></div>
                                <p class="card-text m-2">日本語バージョンのルームのテストです。どんな感じになるかな。</p>
                            </div>
                                
                            <div class="room_tags">
                                <ul class="p-0">
                                    <li class="d-inline-block"><a class="tags"href="#">果物</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">日本語</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">りんご</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">傘</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">programming</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">suits</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">sports</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">fdfe fefe fsefefes </a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>                                        
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="card border-0 mt-4 w-100">
                        <div class="container-card-body">
                            <h4 class="card-title p-1">WORLD FOOLER</h4> 
                            <div class="row">
                                <div class="col-6 text-start">
                                    <a href="#" class="link-dark text-decoration-none">
                                        <img src="https://github.com/carbon.png" alt="" width="50" height="50" class="rounded-circle me-2">
                                        <strong>Mr.X</strong>
                                    </a>
                                </div>
                                <div class="col-6 text-end"><a href="#" class="btn btn-outline-primary">Enter</a></div>
                                <p class="card-text m-2">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            </div>
                                
                            <div class="room_tags">
                                <ul class="p-0">
                                    <li class="d-inline-block"><a class="tags"href="#">Food</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Fassion</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">anime</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">programming</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">suits</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">sports</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">fdfe fefe fsefefes </a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>                                        
                                    <li class="d-inline-block"><a class="tags"href="#">Movie</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>

                
            </ul>
        </div>    

        <div id="right-sidebar" class="col-3 d-none d-lg-block d-flex flex-column p-3   bg-light">    
                <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                    <i class="bi bi-tag-fill mx-2 "></i>
                    <span class="fs-4">Tags</span> <!-- Tagには文字数制限をつける　--> 
                </a> 
            
                <hr>

                <div class="Trend-tags fs-5">
                    <i class="bi bi-droplet mx-2"></i>
                        World Trend :
                        <ul>
                            <li><a class="tags"href="#">Foodadfafasfdsafasffffffffffffffasdfawesf</a></li>
                            <li><a class="tags"href="#">Fassion</a></li>
                            <li><a class="tags"href="#">Mathmatics</a></li>
                            <li><a class="tags"href="#">Science</a></li>
                            <li><a class="tags"href="#">PHP</a></li>
                            <li><a class="tags"href="#">Twitter</a></li>
                            <li><a class="tags"href="#">Programming</a></li>
                            <li><a class="tags"href="#">Movie</a></li>
                            <li><a class="tags"href="#">Unique</a></li>
                            <li><a class="tags"href="#">Star Wars</a></li>  
                        </ul>

                </div>

                    
                <div class="Favorite-tags fs-5">
                    <i class="bi bi-heart-fill mx-2"></i>
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
                        <li><a class="tags"href="#">Unique</a></li>
                        <li><a class="tags"href="#">Star Wars</a></li>        
                    </ul>
                </div>
                <hr>
        </div>    
    </div><!--row-->

    <footer class="footer d-md-none d-lg-none fixed-bottom bg-light">
        <nav class="navbar navbar-light bg-light">
            <div class="container-fluid justify-content-center">
                <div class="btn-group  gap-5" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-primary rounded-circle p-0" style="width:3rem;height:3rem;">＋</button>
                    <button type="button" class="btn btn-primary rounded-circle p-0" style="width:3rem;height:3rem;">＋</button>
                    <button type="button" class="btn btn-primary rounded-circle p-0" style="width:3rem;height:3rem;">＋</button>
                    <button type="button" class="btn btn-primary rounded-circle p-0" style="width:3rem;height:3rem;">＋</button>
            
                </div>
            </div>
          </nav>
    </footer>
</div><!--container-fluid-->

@endsection