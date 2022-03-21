<!-- Create Room Form -->
<div class="modal fade " id="CreateRoomForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="CreateRoomForm" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <form action="/home/create" enctype="multipart/form-data" method="post">
                @csrf

                <div class="modal-header">
                    <i class="bi bi-house-fill mx-2"></i>
                    <h5 class="modal-title" id="newRoom">NEW ROOM</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="InputTitle" class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" id="InputTitle">
                        <div id="titleHelp" class="form-text">シンプルかつ簡潔に書きましょう</div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                        <textarea class="form-control" type="text" name="description" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="InputImages" class="form-label">Images</label>
                        <input class="form-control" name="roomImages[]" type="file" multiple accept="image/*">
                        <div id="InputImages" class="form-text">画像は合計5MBまで複数追加できます。画像形式のみ</div>
                    </div>


                    <div class="mb-3">
                        <label for="InputTags" class="form-label">Tags</label>
                        <input id="InputTags" class="form-control" type="text" name="tag" multiple>
                        <div class="form-text">1タグ20文字まで、複数記入時と最後は' ; 'をつけてください</div>
                        <hr>
                        <p class="form-text">登録されるタグ</p>
                        <div id="showTags">
                            

                        </div>
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="RoomSwitch">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Private Mode</label>
                    </div>

                    <div class="mb-3">
                        <label for="disabledTextInput" class="form-label"></label>
                        <div id="password">

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary" data-bs-dismiss="modal">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let RoomSwitch = document.getElementById('RoomSwitch');
    RoomSwitch.addEventListener('change', switchCheck);
    let password = document.getElementById('password');

    let InputTags = document.getElementById('InputTags');
    InputTags.addEventListener('change', valueChange)
    let showTag = document.getElementById('showTags');
    

    function switchCheck(event) {
        if (RoomSwitch.checked) {
            password.innerHTML =
                '<input type="text" name="createPass" id="disabledTextInput" class="form-control" placeholder="password" autocomplete="off">';
        } else {
            password.innerHTML =
                '<input type="text" name="createPass" id="disabledTextInput" class="form-control" placeholder="password" autocomplete="off" disabled>';
        }
    }


    function valueChange(event) {
        showTag.innerHTML = '';
        let startpoint = 0;
        let endpoint = 0;
        if (InputTags.value.indexOf(';') != -1) {
            while(endpoint != InputTags.value.lastIndexOf(';')) {
                endpoint = InputTags.value.indexOf(';',startpoint);
                let element = document.createElement("span");
                element.setAttribute("class", "tag");
                element.innerText = InputTags.value.slice(startpoint, endpoint);
                showTag.appendChild(element);
                startpoint = endpoint + 1;
            }
        }


    }

    
</script>
