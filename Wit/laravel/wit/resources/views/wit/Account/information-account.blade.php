@extends('layouts.app')

@section('content')
    @component('wit.home-modals')
    @endcomponent

    <div class="card border-0 m-2 overflow-auto" style="height:84%;">
        <div id="profile-contents" class="row justify-content-center">
            <div class="col-10 text-center p-1">
                <img id="image" src="{{ Auth::user()->profile_image }}" style="width:100;height:100;"
                    class="rounded-circle me-2" alt="">
                <span class="d-block m-0"><small class="text-muted">Profile Image</small></span>
            </div>

            <div class="card-body p-1">
                <div id="parent0" class="row justify-content-center">
                    <strong class="card-title  col-10 col-md-4 text-center p-1 m-0 m-lg-2">Name</strong>
                    <p id="name" class="card-text col-10 col-md-4 text-center p-1">{{ Auth::user()->name }}</p>
                </div>

                <div id="parent1" class="row justify-content-center">
                    <strong class="card-title  col-10 col-md-4 text-center p-1 m-0 m-lg-2">Email</strong>
                    <p id="email" class="card-text col-10 col-md-4  text-center p-1">{{ Auth::user()->email }}</p>
                </div>

                <div id="parent2" class="row justify-content-center">
                    <strong class="card-title  col-10 col-md-4 text-center p-1 m-0 m-lg-2">Profile Message</strong>
                    <p id="message" class="card-text col-10 col-md-4 p-1" style="font-size: 0.8em;">
                        {{ Auth::user()->profile_message }}</p>
                </div>

                <div class="row justify-content-center">
                    <strong class="card-title  col-10 col-md-4 text-center p-0 m-0 m-lg-2">Created Date</strong>
                    <h6 class="card-text col-10 col-md-4 text-center p-0">{{ Auth::user()->created_at }}</h6>
                </div>

                <div class="row justify-content-center">
                    <strong class="card-title  col-10 col-md-4 text-center p-0 m-0 m-lg-2"></strong>
                    <div class="col-10 col-md-4 text-end">
                        <button type="button" id="profile-edit" class="btn btn-outline-primary">Edit</button>
                    </div>

                </div>


            </div>
        </div>
    </div>
@endsection



@component('wit.footer')
@endcomponent

<script>
    window.onload = function() {
        document.getElementById("profile-edit").onclick = function() {
            var oldNode = document.querySelectorAll('p');
            console.log(parentNode);
            console.log(oldNode);
            var name = document.getElementById('name').innerText;
            var email = document.getElementById('email').innerText;
            var message = document.getElementById('message').innerText;
            console.log(name);
            console.log(email);
            console.log(message);

            var input_name = document.createElement('input');
            input_name.setAttribute('name', 'edit-name');
            input_name.className = "card-text col-10 col-md-4 p-1" ;
            input_name.value = name;

            var input_email = document.createElement('input');
            input_email.setAttribute('name', 'edit-email');
            input_email.className = "card-text col-10 col-md-4 p-1" ;
            input_email.value = email;

            var input_message = document.createElement('textarea');
            input_message.setAttribute('name', 'edit-message');
            input_message.className = "card-text col-10 col-md-4 p-1" ;
            input_message.value = message;

            var newNode = [input_name, input_email, input_message];

            for (var i = 0; i < 3; i++) {
                
                if (i === 0) {
                    var parentNode = document.getElementById('parent0');
                } else if (i === 1) {
                    var parentNode = document.getElementById('parent1');
                } else if (i === 2) {
                    var parentNode = document.getElementById('parent2');
                }

                parentNode.replaceChild(newNode[i], oldNode[i]);
            }

            console.log(parentNode);
        };
    }
</script>
