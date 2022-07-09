@extends('layouts.app')

@section('content')
    @component('wit.home-modals')
    @endcomponent

    <div class="card border-0 overflow-auto" style="width:100%; height:83%;">
        <div id="profileContents" class="row justify-content-center w-100">
            <form action="/home/profile/settings/changeProfile" method="post" name='changeProfile'
                enctype='multipart/form-data'>
                @csrf
                <div class="card-body p-1">
                    <div id="parentImage" class="text-center">
                        <img id="childImage" src="{{ asset(Auth::user()->profile_image) }}"
                            style="width:100;height:100; position:relative;" class="rounded-circle " alt="">
                        <span class="d-block m-0"><small class="text-muted">Profile Image</small></span>
                        @error('image')
                            <div class="text-danger">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <div id="parentName" class="row justify-content-center align-items-center">
                        <strong class="card-title  col-10 col-md-4 text-center p-1 m-0 m-lg-2">Name</strong>
                        <p id="childName" class="card-text col-10 col-md-4 text-center p-1 m-0">{{ Auth::user()->name }}</p>
                        @error('name')
                            <div class="col-0 col-md-4">
                            </div>
                            <div class="col-8 col-md-4 text-center text-danger">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <div id="parentEmail" class="row justify-content-center align-items-center">
                        <strong class="card-title  col-10 col-md-4 text-center p-1 m-0 m-lg-2">Email</strong>
                        <p id="childEmail" class="card-text col-10 col-md-4  text-center p-1 m-0">{{ Auth::user()->email }}
                        </p>
                        @error('email')
                            <div class="col-0 col-md-4">
                            </div>
                            <div class="col-8 col-md-4 text-center text-danger">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <div id="parentMessage" class="row justify-content-center align-items-center">
                        <strong class="card-title  col-10 col-md-4 text-center p-1 m-0 m-lg-2">Profile Message</strong>
                        <p id="childMessage" class="card-text col-10 text-center col-md-4 p-1 m-0" style="font-size: 0.9em;">
                            {{ Auth::user()->profile_message }}</p>
                        @error('message')
                            <div class="col-0 col-md-4">
                            </div>
                            <div class="col-8 col-md-4 text-center text-danger">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <div class="row justify-content-center align-items-center">
                        <strong class="card-title  col-10 col-md-4 text-center p-0 m-0 m-lg-2">Created Date</strong>
                        <h6 class="card-text col-10 col-md-4 text-center p-0">{{ Auth::user()->created_at }}</h6>
                    </div>

                    <div class="row justify-content-center">
                        <strong class="card-title  col-10 col-md-4 text-center p-0 m-0 m-lg-2"></strong>
                        <div id="parentButton" class="col-10 col-md-4 text-end">
                            <button type="button" id="profileEdit" class="btn btn-outline-primary">Edit</button>
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
        document.getElementById("profileEdit").onclick = function() {

            var parent_button = document.getElementById("parentButton");
            var button_edit = document.getElementById("profileEdit");
            var button_save = document.createElement("button");
            button_save.className = "btn btn-outline-primary"
            button_save.setAttribute("id", "saveButton");
            button_save.setAttribute("type", "submit");
            button_save.textContent = "Save";

            var button_cancel = document.createElement("button");
            button_cancel.className = "btn btn-secondary mx-2";
            button_cancel.setAttribute("type", "button");
            button_cancel.setAttribute("id", "cancelButton");
            button_cancel.textContent = "Cancel"

            parent_button.appendChild(button_cancel);
            parent_button.replaceChild(button_save, button_edit);


            var image = document.getElementById('childImage');
            image.classList.add('opacity-25');
            var icon = document.createElement("label");

            //変更後の画像プレビュー
            icon.innerHTML =
                "<i style='width:50; height:50; font-size:2.5rem; position:absolute; top:10%;left:55%; cursor:pointer;' class='bi bi-camera-fill '><input id='imageInput' name='image' type='file' accept='image/*' class='invisible'></i>";
            document.getElementById("parentImage").appendChild(icon);


            var childName = document.getElementById('childName');
            var childEmail = document.getElementById('childEmail');
            var childMessage = document.getElementById('childMessage');
            var oldNode = [childName, childEmail, childMessage];

            var name = document.getElementById('childName').innerText;
            var email = document.getElementById('childEmail').innerText;
            var message = document.getElementById('childMessage').innerText;

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
                    var parentNode = document.getElementById('parentName');
                } else if (i === 1) {
                    var parentNode = document.getElementById('parentEmail');
                } else if (i === 2) {
                    var parentNode = document.getElementById('parentMessage');
                }

                parentNode.replaceChild(newNode[i], oldNode[i]);
            }

        }

        //画像の変更プレビュー表示
        document.addEventListener('click', function(e) { //VanillaJSで動的要素にイベント登録するための書き方
            if (event.target.id === 'imageInput') {
                document.getElementById("imageInput").addEventListener("change", function(e) {
                    const file = e.target.files[0];

                    // Only process image files.
                    if (!file.type.match('image.*')) {
                        return false;
                    }

                    const reader = new FileReader();
                    reader.onload = (function(theFile) {
                        return function(e) {
                            const imgElm = document.getElementById("childImage");
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
            if (event.target.id === 'cancelButton') {
                window.location.reload(false);
            }
        });
    }
</script>
