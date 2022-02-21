<!-- Create Room Form -->
<div class="modal fade" id="CreateRoomForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="CreateRoomForm" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRoom">NEW ROOM</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="InputTitle" class="form-label">Title</label>
                        <input type="title" class="form-control" id="InputTitle" aria-describedby="titleHelp">
                        <div id="titleHelp" class="form-text">シンプルかつ簡潔に書きましょう</div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="InputImages" class="form-label">Images</label>
                        <input class="form-control" type="file" id="InputImages" multiple>
                        <div id="InputImages" class="form-text">画像は最大5MBまで追加できます。JPEG,PNGファイル形式のみ</div>
                    </div>


                    <div class="mb-3">
                        <label for="InputTags" class="form-label">Tags</label>
                        <input type="tags" class="form-control" id="InputTags" aria-describedby="tagsHelp">
                        <div id="tagsHelp" class="form-text">1タグにつき最大20文字、複数記入は' ; 'で区切ってください</div>
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="RoomSwitch">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Private Mode</label>
                    </div>

                    <div class="mb-3">
                        <label for="disabledTextInput" class="form-label"></label>
                        <div id="test1">
                        
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-outline-primary" data-bs-dismiss="modal">Create</button>
            </div>
        </div>
    </div>
</div>

<script>
    function valueChange(event) {
        if (RoomSwitch.checked) {
            test1.innerHTML = '<input type="text" id="disabledTextInput" class="form-control" placeholder="password">';
        } else {
            test1.innerHTML = '<input type="text" id="disabledTextInput" class="form-control" placeholder="password" disabled>';
        }
    }

    let RoomSwitch = document.getElementById('RoomSwitch');
    RoomSwitch.addEventListener('change', valueChange);
    let test1 = document.getElementById('test1');
</script>
