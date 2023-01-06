<!-- Create Room Form -->
<div class="modal fade " id="Create-Room-Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="Create-Room-Modal" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <form id="Create-Room-Form" action="/home/createRoom" enctype="multipart/form-data" method="post">
                @csrf
                <div class="modal-header">
                    <svg width="16" height="16" fill="currentColor"
                        class="bi bi-house-fill mx-2" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
                        <path fill-rule="evenodd"
                            d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z" />
                    </svg>
                    <h5 class="modal-title">NEW ROOM</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="Input-Title" class="form-label">Title</label>
                        <input id="Input-Title" type="text" name="title" value="{{ old('title') }}"class="form-control">
                        <div class="form-text">Titleは全角半角問わず30文字まで記載できます</div>
                        @error('title')
                            <div class="text-danger">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="Input-Description" class="form-label">Description</label>
                        <textarea id="Input-Description" class="form-control" type="text" name="description" rows="3">{{ old('description') }}</textarea>
                        <div class="form-text">Descriptionは500文字まで記載できます</div>
                        @error('description')
                            <div class="text-danger">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="Input-Images" class="form-label">Images</label>
                        <input id="Input-Images" class="form-control" name="room_images[]" type="file" accept="image/*" multiple>
                        <div class="form-text">画像は合計5MB,30枚まで追加できます</div>
                        @error('sum_image_size')
                            <div class="text-danger">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                        @error('sum_image_count')
                            <div class="text-danger">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                        @error('room_images.*')
                            <div class="text-danger">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="Input-Tags" class="form-label">Tags</label>
                        <input id="Input-Tags" class="form-control" type="text" name="tag" value="{{ old('tag') }}" multiple>
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
                        <div id="Show-Tags">


                        </div>
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="Switch-Room-Password">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Private Mode</label>
                    </div>

                    <div class="mb-3">
                        <label for="disabledTextInput" class="form-label"></label>
                        <div id="Password" class="mb-2">

                        </div>
                        <div id="Confirm-Password" class="mb-0">
                        

                        </div>
                        <div id="Password-Help" class="form-text"></div>

                        @error('create_password')
                            <div class="text-danger">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                </div>
                <div class="modal-footer">
                    <button id="Submit-Button" type="submit" class="btn btn-outline-primary" data-bs-dismiss="modal">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const submit_form = document.getElementById('Create-Room-Form');
    const submit_button = document.getElementById('Submit-Button');
    submit_form.addEventListener('submit',function(){
        submit_button.disabled = true;
    })

    let switch_room_password = document.getElementById('Switch-Room-Password');
    switch_room_password.addEventListener('change', switchCheck);
    let password = document.getElementById('Password');
    let confirm_password = document.getElementById('Confirm-Password');
    let password_help = document.getElementById('Password-Help');

    let input_tags = document.getElementById('Input-Tags');
    input_tags.addEventListener('change', valueChange)
    let show_tags = document.getElementById('Show-Tags');

    function switchCheck(event) {
        if (switch_room_password.checked) {
            password.innerHTML =
                '<input type="password" name="create_password" id="Disabled-Text-Input" class="form-control" placeholder="password" autocomplete="off">';
            confirm_password.innerHTML = 
                '<input type="password" name="create_password_confirmation" class="form-control" placeholder="confirm password" autocomplete="off">';
            password_help.innerHTML = '<p>passwordは8文字以上100文字以下で半角英数字&記号が使用できます</p><p>※パスワード付きのルームはPost Roomとして保存できません</p>';
        } else {
            password.innerHTML =
                '<input type="password" name="create_password" id="Disabled-Text-Input" class="form-control" placeholder="password" autocomplete="off" disabled>';
            confirm_password.innerHTML = 
                '<input type="password" name="create_password_confirmation" class="form-control" placeholder="confirm password" autocomplete="off" disabled>';
        }
    }


    function valueChange(event) {
        show_tags.innerHTML = '';
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
                show_tags.appendChild(element);
                startpoint = endpoint + 1;
            }
        }
    }
</script>
