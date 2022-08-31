<!-- Create Room Form -->
<div class="modal fade " id="createRoomForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="CreateRoomForm" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <form id="createRoomForm" action="/home/createRoom" enctype="multipart/form-data" method="post">
                @csrf

                <div class="modal-header">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-house-fill mx-2" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
                        <path fill-rule="evenodd"
                            d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z" />
                    </svg>
                    <h5 class="modal-title" id="newRoom">NEW ROOM</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="InputTitle" class="form-label">Title</label>
                        <input type="text" name="title" value="{{ old('title') }}"class="form-control" id="inputTitle">
                        <div id="titleHelp" class="form-text">Titleは全角半角問わず30文字まで記載できます</div>
                        @error('title')
                            <div class="text-danger">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                        <textarea class="form-control" type="text" name="description" rows="3">{{ old('description') }}</textarea>
                        <div id="descriptionHelp" class="form-text">Descriptionは400文字まで記載できます</div>
                        @error('description')
                            <div class="text-danger">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="InputImages" class="form-label">Images</label>
                        <input class="form-control" name="roomImages[]" type="file" accept="image/*" multiple>
                        <div id="inputImages" class="form-text">画像は合計5MBまで複数追加できます</div>
                        @error('sumImageSize')
                            <div class="text-danger">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                        @error('sumImageCount')
                            <div class="text-danger">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                        @error('roomImages.*')
                            <div class="text-danger">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="InputTags" class="form-label">Tags</label>
                        <input id="inputTags" class="form-control" type="text" name="tag" value="{{ old('tag') }}" multiple>
                        <div class="form-text">1タグ20文字まで、複数記入時と最後は半角セミコロン' ; 'をつけてください</div>
                        <div class="form-text">重複しているタグは一つに統合されます</div>
                        <div class="form-text">全角数字&記号,全角スペース,中括弧'[]'は登録されず無視されます</div>
                        <div class="form-text">※タグがないとPost Roomとして保存できません</div>

                        @error('matches.*')
                            <div class="text-danger">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                        <hr>
                        <p class="form-text">Tag Preview</p>
                        <div id="showTags">


                        </div>
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="roomSwitch">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Private Mode</label>
                    </div>

                    <div class="mb-3">
                        <label for="disabledTextInput" class="form-label"></label>
                        <div id="password" class="mb-2">

                        </div>
                        <div id="confirm-password" class="mb-0">
                        

                        </div>
                        <div id="passwordHelp" class="form-text"></div>

                        @error('createPass')
                            <div class="text-danger">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                </div>
                <div class="modal-footer">
                    <button id="submitButton" type="submit" class="btn btn-outline-primary" data-bs-dismiss="modal">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const submit_form = document.getElementById('createRoomForm');
    const submit_button = document.getElementById('submitButton');
    submit_form.addEventListener('submit',function(){
        submit_button.disabled = true;
    })

    let RoomSwitch = document.getElementById('roomSwitch');
    RoomSwitch.addEventListener('change', switchCheck);
    let password = document.getElementById('password');
    let confirm_password = document.getElementById('confirm-password');
    let password_help = document.getElementById('passwordHelp');

    let InputTags = document.getElementById('inputTags');
    InputTags.addEventListener('change', valueChange)
    let showTag = document.getElementById('showTags');

    function switchCheck(event) {
        if (RoomSwitch.checked) {
            password.innerHTML =
                '<input type="password" name="createPass" id="disabledTextInput" class="form-control" placeholder="password" autocomplete="off">';
            confirm_password.innerHTML = 
                '<input type="password" name="createPass_confirmation" class="form-control" placeholder="confirm password" autocomplete="off">';
            password_help.innerHTML = '<p>passwordは8文字以上255文字以下で半角英数字&記号が使用できます</p><p>※パスワード付きのルームはPost Roomとして保存できません</p>';
        } else {
            password.innerHTML =
                '<input type="password" name="createPass" id="disabledTextInput" class="form-control" placeholder="password" autocomplete="off" disabled>';
            confirm_password.innerHTML = 
                '<input type="password" name="createPass_confirmation" class="form-control" placeholder="confirm password" autocomplete="off" disabled>';
        }
    }


    function valueChange(event) {
        showTag.innerHTML = '';
        let startpoint = 0;
        let endpoint = 0;
        if (event.target.value.indexOf(';') != -1) {
            while (endpoint != event.target.value.lastIndexOf(';')) {
                endpoint = event.target.value.indexOf(';', startpoint);
                let element = document.createElement("span");
                element.setAttribute("class", "tag");
                element.classList.add("preview");
                element.innerText = event.target.value.slice(startpoint, endpoint);
                element.innerText = element.innerText.trim();
                showTag.appendChild(element);
                startpoint = endpoint + 1;
            }
        }
    }
</script>
