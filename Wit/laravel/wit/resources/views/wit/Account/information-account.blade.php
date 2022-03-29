@extends('layouts.app')

@section('content')
    @component('wit.home-modals')
    @endcomponent

    <div class="card container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-6 text-center">
                <img src="{{ Auth::user()->profile_image }}" style="width:100;height:100;" alt="...">
                <p><small class="text-muted">profile image</small></p>
            </div>

            <div class="card-body">
                <div class="row justify-content-center">
                    <h5 class="card-title col-5 text-center">Name</h5>
                    <p class="card-text col-5 text-center">{{ Auth::user()->name }}</p>
                </div>
                <div class="row justify-content-center">
                    <h5 class="card-title col-5 text-center">Email</h5>
                    <p class="card-text col-5 text-center">{{ Auth::user()->email }}</p>
                </div>
                <div class="row justify-content-center">
                    <h5 class="card-title col-5 text-center">Profile Message</h5>
                    <p class="card-text col-5 text-center">{{ Auth::user()->profile_message }}</p>
                </div>

                <div class="row justify-content-center">
                    <h5 class="card-title col-5 text-center">Created Date</h5>
                    <p class="card-text col-5 text-center">{{ Auth::user()->created_at }}</p>
                </div>
                

                    
                </div>
            </div>
        </div>
    </div>
@endsection



@component('wit.footer')
@endcomponent
