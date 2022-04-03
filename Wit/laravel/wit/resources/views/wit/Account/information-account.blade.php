@extends('layouts.app')

@section('content')
    @component('wit.home-modals')
    @endcomponent

    <div class="card border-0 m-2 overflow-auto" style="width:100%; height:83%;">
        <div id="profile-contents" class="row justify-content-center w-100">
            <form action="/home/profile/settings/changeProfile" method="post" name='profile'>
                @csrf
                <div class="card-body p-1">
                    <div class="text-center p-1">
                        <img id="image" src="{{ Auth::user()->profile_image }}" style="width:100;height:100;"
                            class="rounded-circle me-2" alt="">
                        <span class="d-block m-0"><small class="text-muted">Profile Image</small></span>
                    </div>

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
                        <div id="parent-button" class="col-10 col-md-4 text-end">
                            <button type="button" id="profile-edit" class="btn btn-outline-primary">Edit</button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection



@component('wit.footer')
@endcomponent

<script>
    window.onload = function() {
        document.getElementById("profile-edit").onclick = function() {

            var parent_button = document.getElementById("parent-button");
            var button_edit = document.getElementById("profile-edit");
            var button_save = document.createElement("button");
            button_save.className = "btn btn-outline-primary"
            button_save.setAttribute("id", "profile-save");
            button_save.setAttribute("type", "submit");
            button_save.textContent = "Save";

            var button_cancel = document.createElement("button");
            button_cancel.className = "btn btn-secondary mx-2";
            button_cancel.setAttribute("type", "button");
            button_cancel.setAttribute("id", "cancel-button");
            button_cancel.textContent = "Cancel"

            parent_button.appendChild(button_cancel);
            parent_button.replaceChild(button_save, button_edit);



            var oldNode = document.querySelectorAll('p');

            var name = document.getElementById('name').innerText;
            var email = document.getElementById('email').innerText;
            var message = document.getElementById('message').innerText;


            var input_name = document.createElement('input');
            input_name.setAttribute('name', 'name');
            input_name.className = "card-text col-10 col-md-4 p-1";
            input_name.value = name;

            var input_email = document.createElement('input');
            input_email.setAttribute('name', 'email');
            input_email.className = "card-text col-10 col-md-4 p-1";
            input_email.value = email;

            var input_message = document.createElement('textarea');
            input_message.setAttribute('name', 'message');
            input_message.className = "card-text col-10 col-md-4 p-1";
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

        }


        document.addEventListener('click', function(e) {
            // id属性の値で判定
            if (event.target.id === 'cancel-button') {
                window.location.reload(false);
            }
        });
    }
</script>
