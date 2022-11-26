//bootstrapのモーダルを操作するために読み込む
window.bootstrap = require('bootstrap');

//ページ離脱防止禁止
window.onbeforeunload = function (e) {
    e.returnValue = "ページを離れようとしています。よろしいですか？";
}

const room_id = document.querySelector('body').id;
const host_id = document.getElementById('Host-User').dataset.hostId;
const me_id = document.getElementById('Me').dataset.authId;
const message = document.getElementById('Message');
const send_button = document.getElementById('Send-Message-Button');
const upload_file_button = document.getElementById('Upload-File-Button');
const input_file = document.getElementById('Upload-File-Input');
const confirm_upload_modal = new bootstrap.Modal(document.getElementById('Confirm-Upload-Modal'));

//ファイルアップロード確認メッセージの入力
input_file.addEventListener('change', () => {
    let file = input_file.files[0];
    const confirm_upload_message = document.getElementById('Confirm-Upload-Message');
    const file_name = document.createElement('p');
    const file_size = document.createElement('p');
    const file_help1 = document.createElement('p');
    const file_help2 = document.createElement('p');
    file_help1.style.fontSize = "12px";
    file_help2.style.fontSize = "12px";
    file_name.classList = "text-wrap text-break m-0";
    file_size.classList = "text-wrap text-break";
    file_help1.classList = "fw-bold fs-7 text-danger m-0";
    file_help2.classList = "fw-bold fs-7 text-danger m-0";
    file_name.innerText = 'ファイル名：' + file.name;
    file_size.innerText = 'ファイルサイズ：' + fileSizeUnit(file.size);
    file_help1.innerText = "※アップロード後は削除できません。最大10MBまで送信可能です";
    file_help2.innerText = ".txt .csv .json .xml .htm .html .pdf .png .jpeg .gif .webp がアップロード可能です";
    confirm_upload_message.appendChild(file_name);
    confirm_upload_message.appendChild(file_size);
    confirm_upload_message.appendChild(file_help1);
    confirm_upload_message.appendChild(file_help2);
    confirm_upload_modal.show();
});

document.getElementById('Confirm-Upload-Modal').addEventListener('hidden.bs.modal', () => {
    $('#Confirm-Upload-Message').empty();
    $('#Upload-File-Input').empty();
});

send_button.addEventListener('click', (e) => {
    if (message && message.value != "") {
        e.preventDefault();
        $.ajax({
            type: "post", //HTTP通信の種類
            url: '/home/room/chat/message',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data: {
                "room_id": room_id,
                "message": message.value,
            },
            dataType: 'json',
        }).done(() => {
            scrollDownChat();
        })
            .fail((error) => {
                if (error.responseJSON.errors.message) {
                    message.value = error.responseJSON.errors.message[0];
                } else if (error.responseJSON.errors.chat_count) {
                    message.value = error.responseJSON.errors.chat_count[0];
                } else {
                    console.log(error.responseJSON);
                }
            });
    }
    message.value = "";
});

upload_file_button.addEventListener('click', (e) => {
    let file = input_file.files[0];
    if (file) {
        e.preventDefault();
        let formData = new FormData();
        formData.append('room_id', room_id);
        formData.append('file', file);
        $.ajax({
            type: "post",
            url: '/home/room/chat/file',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data: formData,
            // Ajaxがdataを整形しない指定
            processData: false,
            //contentTypeもfalseに指定
            contentType: false,
            dataType: 'json',
        }).done(() => {
            scrollDownChat();
        })
            .fail((error) => {
                console.log(error);
                if (error.responseJSON.errors.file) {
                    message.value = error.responseJSON.errors.file[0];
                }
            });
    }

    confirm_upload_modal.hide();
    input_file.value = "";
});


Echo.join('room-user-notifications.' + room_id)
    .here((users) => {
        const except_host_users = [];
        users.forEach(user => {
            if (user.id != host_id) {
                except_host_users.push(user);
            }
        });
        if (me_id !== host_id) {
            if (except_host_users.length > 10) {
                window.location.href = '/home';
            }
        }

        users.forEach(user => {
            addOnlineUser(user);
        });
    })
    .joining((user) => {
        addOnlineUser(user);
        sendEnterMessage(user);
    })
    .leaving((user) => {
        removeOnlineUser(user);
        sendExitMessage(user);
    })
    .listen('ChoiceMessages', (e) => {
        addChoiceMessages(e);
    })
    .listen('RemoveRoom', () => {
        removeRoomNotification();
    })
    .listen('SaveRoom', () => {
        saveRoomNotification();
    })
    .listen('RoomBanned', (e) => {
        if (e.type === 'ban' && e.user.id === me_id) {
            window.onbeforeunload = null;
            window.location.href = '/home';
        } else if (e.type === 'lift') {
            console.log(e.user.name + 'さんのアクセスが許可されました');
        }
    })
    .listen('SendMessage', (e) => {
        addChatMessage(e);
    })
    .listen('UploadFile', (e) => {
        addUploadFile(e);
    })
    .error((error) => {
        console.error(error);
        window.location.href = '/home';
    });

function fileSizeUnit(size) {

    // 1 KB = 1024 Byte
    const kb = 1024
    const mb = Math.pow(kb, 2)
    const gb = Math.pow(kb, 3)
    const tb = Math.pow(kb, 4)
    const pb = Math.pow(kb, 5)
    const round = (size, unit) => {
        return Math.round(size / unit * 100.0) / 100.0
    }

    if (size >= pb) {
        return round(size, pb) + 'PB'
    } else if (size >= tb) {
        return round(size, tb) + 'TB'
    } else if (size >= gb) {
        return round(size, gb) + 'GB'
    } else if (size >= mb) {
        return round(size, mb) + 'MB'
    } else if (size >= kb) {
        return round(size, kb) + 'KB'
    }
    return size + 'バイト'
}

function addOnlineUser(user) {
    const check = $('li[data-user-id="' + user.id + '"]');
    if (check.length === 0) {
        const user_element = document.createElement('li');
        user_element.classList = "d-flex align-items-center p-2";
        user_element.dataset.userId = user.id;

        const user_image_column = document.createElement('div');
        user_image_column.classList = "col-2";
        const user_image = document.createElement('img');
        user_image.src = '/' + user.profile_image;

        if (screen.width < 991 && screen.width > 580) {
            user_image.width = '30';
            user_image.height = '30';
        } else {
            user_image.width = '50';
            user_image.height = '50';
        }
        user_image.classList = "rounded-circle";
        user_image_column.appendChild(user_image);

        const user_name_column = document.createElement('div');
        if (screen.width < 991 && screen.width > 580) {
            user_name_column.classList = "col-6 mx-2 mx-sm-1 text-break";
            user_name_column.style = 'font-size:8px;'
        } else {
            user_name_column.classList = "col-8 mx-2 mx-sm-1 text-break";
        }

        user_name_column.textContent = user.name;
        user_element.appendChild(user_image_column);
        user_element.appendChild(user_name_column);


        if (document.getElementById('Ban-Users-List') && user.id !== me_id) {
            const force_exit_column = document.createElement('div');
            if (screen.width < 991 && screen.width > 580) {
                force_exit_column.classList = "col-4 text-end";
            } else {
                force_exit_column.classList = "col-2 text-end";
            }

            const force_exit = document.createElement('button');
            force_exit.type = 'button';
            force_exit.dataset.bsToggle = "modal";
            force_exit.dataset.bsTarget = "#Confirm-Ban-Modal";
            force_exit.classList = "btn btn-outline-danger ";
            force_exit.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-person-x-fill' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6.146-2.854a.5.5 0 0 1 .708 0L14 6.293l1.146-1.147a.5.5 0 0 1 .708.708L14.707 7l1.147 1.146a.5.5 0 0 1-.708.708L14 7.707l-1.146 1.147a.5.5 0 0 1-.708-.708L13.293 7l-1.147-1.146a.5.5 0 0 1 0-.708z' /></svg>";
            force_exit_column.append(force_exit);
            user_element.appendChild(force_exit_column);
        }

        $("[id^='Online-Users-List']").append(user_element);
    }
}



function sendEnterMessage(user) {
    const enter_message = document.createElement('li');
    const change_element = $('p[data-enter-id="' + user.id + '"]');
    const create_enter_element = document.createElement('p');
    const create_exit_element = document.createElement('p');
    const user_name_element = document.createElement('strong');
    enter_message.classList = "text-primary text-center m-2";
    const now1 = getNowDate('full');
    const now2 = getNowDate('half');
    enter_message.textContent = user.name + 'さんが入室しました  ' + now1;
    if (change_element.length !== 0) {
        change_element.text('Latest Online ' + now2);
    } else {
        user_name_element.classList = 'text-break';
        user_name_element.innerText = user.name;
        create_enter_element.classList = "text-primary m-0";
        create_enter_element.dataset.enterId = user.id;
        create_exit_element.classList = "text-danger m-0";
        create_exit_element.dataset.exitId = user.id;
        create_enter_element.textContent = ('Latest Online ' + now2);
        $("[id^='Access-Logs-List']").append(user_name_element);
        $("[id^='Access-Logs-List']").append(create_exit_element);
        $("[id^='Access-Logs-List']").append(create_enter_element);

    }
    document.getElementById('Message-List').appendChild(enter_message);

}

function sendExitMessage(user) {
    const exit_message = document.createElement('li');
    const change_element = $('p[data-exit-id="' + user.id + '"]');
    exit_message.classList = "text-danger text-center m-2";
    const now1 = getNowDate('full');
    const now2 = getNowDate('half');
    exit_message.textContent = user.name + 'さんが退室しました  ' + now1;
    change_element.text('Latest Offline ' + now2);
    document.getElementById('Message-List').appendChild(exit_message);
}

function removeOnlineUser(user) {
    const user_mark = $('li[data-user-id="' + user.id + '"]');
    if (user_mark.length !== 0) {
        user_mark.remove();
    }
}

function getNowDate(type) {
    const date = new Date();
    const year = date.getFullYear();
    const month = date.getMonth() + 1;
    const day = date.getDate().toString().padStart(2, '0');
    const hour = date.getHours().toString().padStart(2, '0');
    const min = date.getMinutes().toString().padStart(2, '0');
    const sec = date.getSeconds().toString().padStart(2, '0');
    if (type === 'full') {
        const full_time = year + "/" + month.toString().padStart(2, '0') + "/" + day + " " + hour + ":" + min;
        return full_time;
    } else {
        const half_time = month.toString().padStart(2, '0') + "/" + day + " " + hour + ":" + min;
        return half_time;
    }
}

function scrollDownChat() {
    $('#Room-Chat .card-body').animate({ scrollTop: $('#Room-Chat .card-body')[0].scrollHeight, duration: 'fast' });
}

function addChatMessage(e) {
    const message_list = document.getElementById('Message-List');
    const message_element = document.createElement('li');
    const type = 'half';
    if (e.user.id === me_id) {
        message_element.id = e.chat_id;
        message_element.classList = "Myself"
        const div1 = document.createElement('div');
        const div2 = document.createElement('div');
        div2.classList = "Message";
        const span_element = document.createElement('span');
        const p_element = document.createElement('p');
        span_element.classList = "badge d-block text-dark text-end";
        span_element.textContent = getNowDate(type);
        p_element.innerText = e.message;
        div1.appendChild(span_element);
        div2.appendChild(p_element);
        message_element.appendChild(div1);
        message_element.appendChild(div2);
        message_list.appendChild(message_element);
    } else {
        const div1 = document.createElement('div');
        const div2 = document.createElement('div');
        div2.classList = "Message";
        const user_image = document.createElement('img');
        user_image.src = '/' + e.user.profile_image;
        user_image.classList = "rounded-circle";
        user_image.width = "20";
        user_image.height = "20";
        const user_name = document.createElement('strong');
        user_name.textContent = e.user.name;
        message_element.id = e.chat_id;
        message_element.classList = "Opponent";
        const span_element = document.createElement('span');
        span_element.classList = "badge text-dark";
        span_element.textContent = getNowDate(type);
        const p_element = document.createElement('p');
        p_element.innerText = e.message;
        div1.appendChild(user_image);
        div1.appendChild(user_name);
        div1.appendChild(span_element);
        div2.appendChild(p_element);
        message_element.appendChild(div1);
        message_element.appendChild(div2);
        message_list.appendChild(message_element);
    }
}

function addUploadFile(e) {
    const message_list = document.getElementById('Message-List');
    const message_element = document.createElement('li');
    const type = 'half';
    if (e.user.id === me_id) {
        message_element.id = e.chat_id;
        message_element.classList = "Myself"
        const div1 = document.createElement('div');
        const div2 = document.createElement('div');
        div2.classList = "Message";
        const span_element = document.createElement('span');
        const a_element = document.createElement('a');
        span_element.classList = "badge d-block text-dark text-end";
        span_element.textContent = getNowDate(type);
        a_element.onclick = window.onbeforeunload = null;
        a_element.href = '/home/room:' + e.room_id + '/downloadRoomFile:' + e.post_file;
        a_element.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-file-earmark mx-2' viewBox='0 0 16 16'><path d='M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z'/></svg>" + e.post_file;
        div1.appendChild(span_element);
        div2.appendChild(a_element);
        message_element.appendChild(div1);
        message_element.appendChild(div2);
        message_list.appendChild(message_element);
    } else {
        const div1 = document.createElement('div');
        const div2 = document.createElement('div');
        div2.classList = "Message";
        const user_image = document.createElement('img');
        user_image.src = '/' + e.user.profile_image;
        user_image.classList = "rounded-circle";
        user_image.width = "20";
        user_image.height = "20";
        const user_name = document.createElement('strong');
        user_name.textContent = e.user.name;
        message_element.id = e.chat_id;
        message_element.classList = "Opponent";
        const span_element = document.createElement('span');
        span_element.classList = "badge text-dark";
        span_element.textContent = getNowDate(type);
        const a_element = document.createElement('a');
        a_element.onclick = window.onbeforeunload = null;
        a_element.href = '/home/room:' + e.room_id + '/downloadRoomFile:' + e.post_file;
        a_element.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-file-earmark mx-2' viewBox='0 0 16 16'><path d='M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z'/></svg>" + e.post_file;
        div1.appendChild(user_image);
        div1.appendChild(user_name);
        div1.appendChild(span_element);
        div2.appendChild(a_element);
        message_element.appendChild(div1);
        message_element.appendChild(div2);
        message_list.appendChild(message_element);
    }
}

function addChoiceMessages(e) {
    let target_array = e.room_chat_array;
    target_array.map((element) => {
        if ($('#' + element).children('.Message').children('p').hasClass('Choice-Messages')) {
            $('#' + element).children('.Message').children('p').removeClass('Choice-Messages');
        } else {
            $('#' + element).children('.Message').children('p').addClass('Choice-Messages');
        }

        if ($('#' + element).children('.Message').children('a').hasClass('Choice-Messages')) {
            $('#' + element).children('.Message').children('a').removeClass('Choice-Messages');
        } else {
            $('#' + element).children('.Message').children('a').addClass('Choice-Messages');
        }
    });
}

function removeRoomNotification() {
    $('#Room-Image').children().remove();
    const counter = document.createElement('strong');
    const icon = document.createElement('div');
    icon.innerHTML = "<svg width='40' height='40' fill='currentColor' class='text-danger bi bi-exclamation-triangle mx-2' viewBox='0 0 16 16'><path d='M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z'/><path d='M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z'/></svg>";
    counter.classList = 'fs-6 d-inline text-danger p-2';
    let count = 10;
    counter.textContent = 'このルームは削除されました' + count + '秒後にホームに戻ります';
    $('#Room-Image').append(icon);
    $('#Room-Image').append(counter);
    const interval = setInterval(function () {
        counter.textContent = 'このルームは削除されました' + count + '秒後にホームに戻ります';
        count--;
        if (count == 0) {
            counter.textContent = 'このルームは削除されました' + count + '秒後にホームに戻ります';
            clearInterval(interval);
            window.onbeforeunload = null;
            window.location.href = '/home';
        }
    }, 1000);
}

function saveRoomNotification() {
    $('#Room-Image').children().remove();
    const counter = document.createElement('strong');
    const icon = document.createElement('div');
    icon.innerHTML = "<svg width='40' height='40' fill='currentColor' class='text-primary bi bi-exclamation-triangle mx-2' viewBox='0 0 16 16'><path d='M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z'/><path d='M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z'/></svg>";
    counter.classList = 'fs-6 d-inline text-primary p-2';
    let count = 10;
    counter.textContent = 'このルームはPost Roomとして保存されました' + count + '秒後にホームに戻ります';
    $('#Room-Image').append(icon);
    $('#Room-Image').append(counter);
    const interval = setInterval(function () {
        counter.textContent = 'このルームはPost Roomとして保存されました' + count + '秒後にホームに戻ります';
        count--;
        if (count == 0) {
            counter.textContent = 'このルームはPost Roomとして保存されました' + count + '秒後にホームに戻ります';
            clearInterval(interval);
            window.onbeforeunload = null;
            window.location.href = '/home';
        }
    }, 1000);
}

if (document.getElementById('Confirm-Ban-Modal')) {
    const confirm_ban_modal = document.getElementById("Confirm-Ban-Modal");
    confirm_ban_modal.addEventListener('shown.bs.modal', function (event) {
        let modal_body = $(confirm_ban_modal).find('.modal-body')
        modal_body.children().remove();
        let button = (event.relatedTarget);
        const ban_uesr_id = document.getElementById('Ban-User');
        const ban_room_id = document.getElementById('Ban-Room');
        const user_id = button.parentNode.parentNode.getAttribute('data-user-id');
        ban_uesr_id.value = user_id;
        ban_room_id.value = room_id;

        let attention_message = document.createElement('strong');
        let attention_message2 = document.createElement('p');
        attention_message.classList = "d-block mb-2 text-center text-break text-wrap";
        attention_message.textContent = 'このユーザをアクセス禁止にしますか?';
        attention_message2.classList = 'text-danger fs-6 p-1 m-0 text-center';
        attention_message2.textContent = '※ルームが終了するか解除するまで再入場不可能になります';

        let user_element = document.createElement('div');
        user_element.classList = 'text-center p-1 m-0';
        let user_image = document.createElement('img');
        user_image.src = button.parentNode.previousSibling.previousSibling.firstChild.src;
        user_image.classList = 'rounded-circle m-1';
        user_image.width = '50';
        user_image.height = '50';

        let user_name = document.createElement('strong');
        user_name.classList = 'text-break';
        user_name.textContent = button.parentNode.previousSibling.textContent;
        user_element.append(user_image);
        user_element.append(user_name);

        modal_body.append(attention_message);
        modal_body.append(user_element);
        modal_body.append(attention_message2);
    });
}

if (document.getElementById('Lift-Ban-User-Modal')) {
    const lift_ban_user_modal = document.getElementById("Lift-Ban-User-Modal");
    lift_ban_user_modal.addEventListener('shown.bs.modal', function (event) {
        let modal_body = $(lift_ban_user_modal).find('.modal-body')
        modal_body.children().remove();

        let button = event.relatedTarget;
        const lift_user_id = document.getElementById('Lift-Ban-User');
        const lift_room_id = document.getElementById('Lift-Ban-Room');
        const user_id = button.parentNode.parentNode.getAttribute('data-lift-id');
        lift_user_id.value = user_id;
        lift_room_id.value = room_id;

        let message = document.createElement('strong');
        message.classList = "d-block mb-2 text-center text-break text-wrap";
        message.textContent = 'このユーザのアクセスを許可しますか？';

        let user_element = document.createElement('div');
        user_element.classList = 'text-center p-1 m-0';
        let user_image = document.createElement('img');
        user_image.src = button.parentNode.parentNode.children[0].firstChild.src;
        user_image.classList = 'rounded-circle m-1';
        user_image.width = '50';
        user_image.height = '50';

        let user_name = document.createElement('strong');
        user_name.textContent = button.parentNode.parentNode.children[1].textContent;
        user_element.append(user_image);
        user_element.append(user_name);

        modal_body.append(message);
        modal_body.append(user_element);
    });
}

//Choice-Messages機能
if ($("[id^='Choice-Messages-Button']") && $("[id^='Choice-Messages-Cancel']")) {
    const offcanvas_close = document.getElementById("Offcanvas-Close");
    const send_message_content = document.getElementById("Send-Message-Content");
    const choice_remarks_content = document.getElementById("Choice-Messages-Content");
    let target_array = new Array;

    //Choice-Messagesボタンを押した時
    $(document).on('click', "[id^='Choice-Messages-Button']", function () {
        document.getElementById('Choice-Messages-Button').disabled = true;
        offcanvas_close.click();
        send_message_content.hidden = true;
        choice_remarks_content.hidden = false;
        $('.Message p').css('cursor', 'pointer');

        $(document).on('click', ".Message p, .Message a", (event) => {
            event.preventDefault();
            if (document.getElementById('Choice-Messages-Button').disabled) {
                const choice_check = document.createElement('span');
                choice_check.classList = "Choice-Check text-success";
                choice_check.innerHTML = "<svg width='30' height='16' fill='currentColor' class='bi bi-check-lg' viewBox='0 0 16 16'><path d='M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z'/></svg>";

                if (event.currentTarget.parentNode.getElementsByClassName('Choice-Check').length !== 0) {
                    event.currentTarget.parentNode.removeChild(event.currentTarget.parentNode.getElementsByClassName('Choice-Check')[0]);
                    target_array = target_array.filter(function (item) {
                        return item !== event.currentTarget.parentNode.parentNode.id;
                    });
                } else {
                    if (event.currentTarget.parentNode.parentNode.classList.contains('Myself')) {
                        event.currentTarget.parentNode.prepend(choice_check);
                    } else {
                        event.currentTarget.parentNode.append(choice_check);
                    }
                    target_array.push(event.currentTarget.parentNode.parentNode.id);
                }
            }
        });


        //Enterボタンを押した時
        $(document).on('click', "[id='Choice-Messages-Enter']", function () {
            if (target_array.length == 0) {
                return false;
            }
            if (document.getElementById('Choice-Messages-Button').disabled) {
                const enter_button = document.getElementById("Choice-Messages-Enter");
                enter_button.disabled = true;
                const message_list = document.getElementById("Message-List");
                message_list.classList.add("opacity-25");
                enter_button.innerHTML = "<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span> Enter";
                $.ajax({
                    type: "post",
                    url: '/home/room/chat/choice',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    data: {
                        "room_id": room_id,
                        "target_array": target_array,
                    },
                    dataType: 'json',
                })
                    .done(() => {
                        message_list.classList.remove("opacity-25");
                        enter_button.innerText = 'Enter';
                        afterPushButton(target_array);
                        target_array = [];
                        enter_button.disabled = false;
                    })
                    .fail((error) => {
                        console.log(error);
                        if (error.responseJSON.errors.target_array) {
                            message.value = error.responseJSON.errors.target_array[0];
                        }
                    });
            }
        });


        //Cancelボタンを押した時
        $(document).on('click', "[id='Choice-Messages-Cancel']", function () {
            if (document.getElementById('Choice-Messages-Button').disabled) {
                afterPushButton(target_array);
                target_array = [];
            }
        });
    });
};

function afterPushButton(target_array) {
    target_array.map((element) => {
        $('#' + element).find('.Choice-Check').remove();
    });
    $(document).off('click', "[id='Choice-Messages-Enter']");
    $(document).off('click', "[id='Choice-Messages-Cancel']");
    $(document).off('click', ".Message p, .Message a");
    document.getElementById("Send-Message-Content").hidden = false;
    document.getElementById("Choice-Messages-Content").hidden = true;
    document.getElementById("Choice-Messages-Button").disabled = false;
    $('.Message p').css('cursor', '');
}