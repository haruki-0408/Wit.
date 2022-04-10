@extends('layouts.app')

@section('content')
    @component('wit.home-modals')
    @endcomponent

    <div class="card border-0 m-2 overflow-auto" style="width:100%; height:83%;">
        <div id="profile-contents" class="row justify-content-center w-100">
            <form action="/home/profile/settings/changeProfile" method="post" name='profile' enctype='multipart/form-data'>
                @csrf
                <div class="card-body p-1">
                    <div id="parent-image" class="text-center">
                        <img id="image" src="{{ asset(Auth::user()->profile_image) }}"
                            style="width:100;height:100; position:relative;" class="rounded-circle " alt="">
                        <span class="d-block m-0"><small class="text-muted">Profile Image</small></span>
                    </div>

                    <div id="parent-name" class="row justify-content-center">
                        <strong class="card-title  col-10 col-md-4 text-center p-1 m-0 m-lg-2">Name</strong>
                        <p id="name" class="card-text col-10 col-md-4 text-center p-1">{{ Auth::user()->name }}</p>
                    </div>

                    <div id="parent-email" class="row justify-content-center">
                        <strong class="card-title  col-10 col-md-4 text-center p-1 m-0 m-lg-2">Email</strong>
                        <p id="email" class="card-text col-10 col-md-4  text-center p-1">{{ Auth::user()->email }}</p>
                    </div>

                    <div id="parent-message" class="row justify-content-center">
                        <strong class="card-title  col-10 col-md-4 text-center p-1 m-0 m-lg-2">Profile Message</strong>
                        <p id="message" class="card-text col-10 col-md-4 p-1" style="font-size: 0.9em;">
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


            var image = document.getElementById('image');
            image.classList.add('opacity-25');
            var icon = document.createElement("label");

            icon.innerHTML =
                "<i style='width:50; height:50; font-size:2.5rem; position:absolute; top:10%;left:55%; cursor:pointer;' class='bi bi-camera-fill '><input id='image-input' name='edit_image' type='file' accept='image/*' class='invisible'></i>";
            document.getElementById("parent-image").appendChild(icon);


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
                    var parentNode = document.getElementById('parent-name');
                } else if (i === 1) {
                    var parentNode = document.getElementById('parent-email');
                } else if (i === 2) {
                    var parentNode = document.getElementById('parent-message');
                }

                parentNode.replaceChild(newNode[i], oldNode[i]);
            }

        }

        //画像の変更プレビュー表示
        document.addEventListener('click', function(e) { //VanillaJSで動的要素にイベント登録するための書き方
            if (event.target.id === 'image-input') {
                document.getElementById("image-input").addEventListener("change", function(e) {
                    const file = e.target.files[0];

                    // Only process image files.
                    if (!file.type.match('image.*')) {
                        return false;
                    }

                    const reader = new FileReader();
                    reader.onload = (function(theFile) {
                        return function(e) {
                            const imgElm = document.getElementById("image");
                            imgElm.src = e.target.result;
                            imgElm.classList.remove('opacity-25');
                        }
                    })(file);

                    // Read in the image file as a data URL.
                    reader.readAsDataURL(file);

                }, false);
            }
        })

        document.addEventListener('click', function(e) {
            // id属性の値で判定
            if (event.target.id === 'cancel-button') {
                window.location.reload(false);
            }
        });
    }
</script>
