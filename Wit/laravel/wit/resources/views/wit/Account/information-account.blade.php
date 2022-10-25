@extends('layouts.app')

@section('content')
    @component('wit.home-modals')
    @endcomponent

    <div class="card border-0 overflow-auto w-100" style="height:83%;">
        <div id="Profile-Contents" class="row justify-content-center w-100">
            <form id="Change-Profile-Form" class="m-0 p-0" action="/home/profile/settings/changeProfile" method="post" name='change_profile'
                enctype='multipart/form-data'>
                @csrf
                <div class="card-body p-1">
                    <div id="Parent-Image" class="text-center">
                        <img id="Child-Image" src="{{ asset(Auth::user()->profile_image) }}"
                            style="width:100;height:100; position:relative;" class="rounded-circle " alt="">
                        <span class="d-block m-0"><small class="text-muted">Profile Image</small></span>
                        @error('image')
                            <div class="text-danger">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <div id="Parent-Name" class="row justify-content-center align-items-center">
                        <strong class="card-title  col-10 col-md-4 text-center p-1 m-0 m-lg-2">Name</strong>
                        <p id="Child-Name" class="card-text col-10 col-md-4 text-center p-1 m-0">{{ Auth::user()->name }}
                        </p>
                        @error('name')
                            <div class="col-0 col-md-4">
                            </div>
                            <div class="col-8 col-md-4 text-center text-danger">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <div id="Parent-Email" class="row justify-content-center align-items-center">
                        <strong class="card-title  col-10 col-md-4 text-center p-1 m-0 m-lg-2">Email</strong>
                        <p id="Child-Email" class="card-text col-10 col-md-4  text-center p-1 m-0">{{ Auth::user()->email }}</p>
                    </div>

                    <div id="Parent-Message" class="row justify-content-center align-items-center">
                        <strong class="card-title  col-10 col-md-4 text-center p-1 m-0 m-lg-2">Profile Message</strong>
                        <p id="Child-Message" class="card-text col-10 text-center col-md-4 p-1 m-0"
                            style="font-size: 0.9em;">
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
                        <strong class="card-title  col-10 col-md-4 text-center p-0 m-0 m-lg-2">Created Time</strong>
                        <h6 class="card-text col-10 col-md-4 text-center p-0">{{ Auth::user()->created_at }}</h6>
                    </div>

                    <div class="row justify-content-center">
                        <strong class="card-title  col-10 col-md-4 text-center p-0 m-0 m-lg-2"></strong>
                        <div id="Parent-Button" class="col-10 col-md-4 text-end mt-2">
                            <button type="button" id="Profile-Edit-Button" class="btn btn-outline-primary">Edit</button>
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
        document.getElementById("Profile-Edit-Button").onclick = function() {

            const parent_button = document.getElementById("Parent-Button");
            const button_edit = document.getElementById("Profile-Edit-Button");
            const button_save = document.createElement("button");
            button_save.className = "btn btn-outline-primary"
            button_save.setAttribute("id", "Profile-Save-Button");
            button_save.setAttribute("type", "submit");
            button_save.setAttribute("for", "#Change-Profile-Form");
            button_save.textContent = "Save";
            button_save.setAttribute("onclick", "window.onbeforeunload = null;")

            const button_cancel = document.createElement("button");
            button_cancel.className = "btn btn-secondary mx-2";
            button_cancel.setAttribute("type", "button");
            button_cancel.setAttribute("id", "Profile-Cancel-Button");
            button_cancel.textContent = "Cancel"

            parent_button.appendChild(button_cancel);
            parent_button.replaceChild(button_save, button_edit);


            const image = document.getElementById('Child-Image');
            image.classList.add('opacity-25');
            const icon = document.createElement("label");

            //変更後の画像プレビュー
            icon.innerHTML =
                "<i style='width:50; height:50; font-size:2.5rem; position:absolute; top:10%;left:55%; cursor:pointer;' class='bi bi-camera-fill '><input id='Image-Input' name='image' type='file' accept='image/*' class='invisible'></i>";
            document.getElementById("Parent-Image").appendChild(icon);


            const child_name = document.getElementById('Child-Name');
            const child_message = document.getElementById('Child-Message');
            let old_node = [child_name, child_message];

            let input_name = document.createElement('input');
            input_name.setAttribute('name', 'name');
            input_name.className = "card-text col-10 col-md-4 p-1";
            input_name.value = child_name.innerText;

            let email_message = document.createElement('span');
            email_message.className = "text-danger badge d-block";
            email_message.textContent = '※メールアドレスは専用ページから変更して下さい';

            let input_message = document.createElement('textarea');
            input_message.setAttribute('name', 'message');
            input_message.className = "card-text col-10 col-md-4 p-1";
            input_message.value = child_message.innerText;

            document.getElementById('Child-Email').appendChild(email_message);
            let new_node = [input_name, input_message];

            for (var i = 0; i < 2; i++) {
                switch (i) {
                    case 0:
                        var parent_node = document.getElementById('Parent-Name');
                        break;
                    case 1:
                        var parent_node = document.getElementById('Parent-Message');
                        break;
                    default:
                        break;
                }
                parent_node.replaceChild(new_node[i], old_node[i]);
            }

        }

        //画像の変更プレビュー表示
        document.addEventListener('click', function(e) { //VanillaJSで動的要素にイベント登録するための書き方
            if (event.target.id === 'Image-Input') {
                document.getElementById("Image-Input").addEventListener("change", function(e) {
                    const file = e.target.files[0];

                    // Only process image files.
                    if (!file.type.match('image.*')) {
                        return false;
                    }

                    const reader = new FileReader();
                    reader.onload = (function(theFile) {
                        return function(e) {
                            const img_element = document.getElementById("Child-Image");
                            img_element.src = e.target.result;
                            img_element.classList.remove('opacity-25');
                        }
                    })(file);

                    // Read in the image file as a data URL.
                    reader.readAsDataURL(file);

                }, false);
            }
        })

        document.addEventListener('click', function(e) {
            // id属性の値で判定
            if (event.target.id === 'Profile-Cancel-Button') {
                window.location.reload(true);
            }
        });
    }

    window.onbeforeunload = function(e) {
        e.returnValue = "ページを離れようとしています。よろしいですか？";
    }
</script>
