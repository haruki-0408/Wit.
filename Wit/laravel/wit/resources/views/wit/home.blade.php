@extends('layouts.app')

@section('content')
<div class="container-fluid"> 
        <div class="row ">  
            @component('wit.left')
                
            @endcomponent
            @component('wit.content')
                
            @endcomponent
            @component('wit.right')
                
            @endcomponent

        </div><!--row-->
</div><!--container-fluid-->
@endsection

@section("footer")
        <div class="footer d-md-none d-lg-none fixed-bottom bg-light">
            <nav class="navbar navbar-light bg-light">
                <div class="container-fluid justify-content-center">
                    <div class="btn-group  gap-5" role="group" aria-label="footer">
                        <a class="home link-dark footer-buttons" href="#" ><i class="rounded bi bi-house-door-fill"></i></a>
                        <a class="profile link-dark footer-buttons" href="#"><i class="bi bi-person-fill"></i></a>
                        <a class="mylist link-dark footer-buttons" href="#"><i class="bi bi-card-list"></i></a>
                        <a class="tag link-dark footer-buttons" href="#"><i class="bi bi-tag-fill"></i></a>
                        <a class="settings link-dark footer-buttons" href="#"><i class="bi bi-gear-fill"></i></a>
                        
                    </div>
                </div>
            </nav>
        </div>
@endsection

