@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">    
        <div id="left-sidebar" class="col-3">
            <div class="d-flex flex-column p-3 m-1 bg-light">
                <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                    <svg class="bi me-2" width="80" height="32"><use xlink:href="#bootstrap"></use></svg>
                    <i class="bi bi-person-fill mx-2 w-3 h-3"></i>
                    <span class="fs-4">Profile
                        <svg class="bi" width="32" height="32" fill="currentColor">
                            <use xlink:href="bootstrap-icons.svg#heart-fill"/>
                        </svg>
                    </span>
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
                                <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link link-dark">
                                <svg class="bi me-2" width="16" height="16"><use xlink:href="#speedometer2"></use></svg>
                                Dashboard
                            </a>
                        </li>       
                        <li>
                            <a href="#" class="nav-link link-dark">
                                <svg class="bi me-2" width="16" height="16"><use xlink:href="#table"></use></svg>
                                Orders
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link link-dark">
                                <svg class="bi me-2" width="16" height="16"><use xlink:href="#grid"></use></svg>
                                Products
                            </a>
                        </li>     
                        <li>
                            <a href="#" class="nav-link link-dark">
                                <svg class="bi me-2" width="16" height="16"><use xlink:href="#people-circle"></use></svg>
                                Customers
                            </a>
                        </li>
                    </ul>
                <hr>

                <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                    <svg class="bi me-2" width="80" height="32"><use xlink:href="#bootstrap"></use></svg>
                    <i class="bi bi-clock-history mx-2"></i>
                    <span class="fs-4">Previous
                        <svg class="bi" width="32" height="32" fill="currentColor">
                            <use xlink:href="bootstrap-icons.svg#heart-fill"/>
                        </svg>
                    </span>
                </a>
        
                <hr>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="#" class="nav-link active" aria-current="page">
                                <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
                                Post
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link link-dark">
                                <svg class="bi me-2" width="16" height="16"><use xlink:href="#speedometer2"></use></svg>
                                Answer
                            </a>
                        </li>       
                    </ul>
                <hr>
            
            
                
            </div>
        </div> 

        <div id="center-content" class="col-6">
        </div>

        <div id="right-sidebar" class="col-3">
            <div class="d-flex flex-column p-3  bg-light">
                <div class="d-flex flex-column p-3 m-1 bg-light">
                    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                        <svg class="bi me-2" width="80" height="32"><use xlink:href="#bootstrap"></use></svg>
                        <i class="bi bi-tag-fill mx-2 w-3 h-3"></i>
                        <span class="fs-4">Tags
                            <svg class="bi" width="32" height="32" fill="currentColor">
                                <use xlink:href="bootstrap-icons.svg#heart-fill"/>
                            </svg>
                        </span>
                    </a>
    
                    <hr>
            </div>
        </div>    

    </div><!--row-->
</div><!--container-fluid-->
@endsection