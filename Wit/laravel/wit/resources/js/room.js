const room_id = document.querySelector('body').id;
const me_id = document.getElementById('me').dataset.authId;
const message = document.getElementById('message');
const send_button = document.getElementById('send');

send_button.addEventListener('click', (e) => {
    if (message.value != "") {
        e.preventDefault();
        $.ajax({
            type: "post", //HTTP通信の種類
            url: '/room/chat/message',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data: {
                "room_id": room_id,
                "message": message.value,
            },
            dataType: 'json',
        })
            .fail((error) => {
                message.value = error.responseJSON.errors.message[0];
            });
        message.value = "";
    }
});

//ページ離脱防止禁止
window.onbeforeunload = function (e) {
    e.returnValue = "ページを離れようとしています。よろしいですか？";
}

//ルーム退出時
if (document.getElementById('exitRoomModal')) {
    let exitRoomModal = document.getElementById("exitRoomModal");
    exitRoomModal.addEventListener('shown.bs.modal', function (event) {
        let button = (event.relatedTarget);
        let enterRoomLink = document.getElementById('exitRoomLink');
        exitRoomLink.href = '/home';
    });
}



Echo.join('room-user-notifications.' + room_id)
    .here((users) => {
        users.forEach(user => {
            addOnlineUser(user);
        });
    })
    .joining((user) => {
        addOnlineUser(user);
        sendEnterMessage(user);
    })
    .leaving((user) => {
        $.ajax({
            type: "post", //HTTP通信の種類
            url: '/home/exitRoom',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data: {
                "room_id": room_id,
                "user_id": user.id,
                "user_name": user.name,
            },
            dataType: 'json',
        })
            .fail((error) => {
                console.log(error);
            });
        removeOnlineUser(user);
        sendExitMessage(user);
    })
    .listen('RemoveRoom', (e) => {
        console.log(e.room_id);
        console.log('このルームは作成者によって削除されました10秒後にホームに戻ります');
        removeRoomNotification();
    })
    .listen('SendMessage', (e) => {
        addChatMessage(e);
    })
    .error((error) => {
        console.error(error);
    });

function addOnlineUser(user) {
    const check = $('li[data-user-id="' + user.id + '"]');
    if (check.length == 0) {
        const user_element = document.createElement('li');
        user_element.classList = "d-flex align-items-center p-2";
        user_element.dataset.userId = user.id;
        const user_image = document.createElement('img');
        user_image.src = '/' + user.profile_image;
        user_image.width = '50';
        user_image.height = '50';
        user_image.classList = "rounded-circle me-2";
        const user_name = document.createElement('p');
        user_name.classList = "m-0";
        user_name.textContent = user.name;
        user_element.appendChild(user_image);
        user_element.appendChild(user_name);
        $("[id^='onlineUsersList']").append(user_element);

        if (document.getElementById('accessDeniedList')) {
            const force_user_element = $('li[data-user-id="' + user.id + '"]');
            const div = document.createElement('div');
            div.classList = "text-end";
            const force_exit_button = document.createElement('button');
            force_exit_button.type = 'button';
            force_exit_button.dataset.bsToggle = "modal";
            force_exit_button.dataset.bsTarget = "#forceConfirm";
            force_exit_button.classList = "btn btn-outline-danger ";
            force_exit_button.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-person-x-fill' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6.146-2.854a.5.5 0 0 1 .708 0L14 6.293l1.146-1.147a.5.5 0 0 1 .708.708L14.707 7l1.147 1.146a.5.5 0 0 1-.708.708L14 7.707l-1.146 1.147a.5.5 0 0 1-.708-.708L13.293 7l-1.147-1.146a.5.5 0 0 1 0-.708z' /></svg>";
            div.append(force_exit_button)
            force_user_element.append(div);
        }
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
        user_name_element.innerText = user.name;
        create_enter_element.classList = "text-primary m-0";
        create_enter_element.dataset.enterId = user.id;
        create_exit_element.classList = "text-danger m-0";
        create_exit_element.dataset.exitId = user.id;
        create_enter_element.textContent = ('Latest Online ' + now2);
        $("[id^='accessLogList']").append(user_name_element);
        $("[id^='accessLogList']").append(create_exit_element);
        $("[id^='accessLogList']").append(create_enter_element);

    }
    document.getElementById('messageList').appendChild(enter_message);

}

function sendExitMessage(user) {
    const exit_message = document.createElement('li');
    const change_element = $('p[data-exit-id="' + user.id + '"]');
    exit_message.classList = "text-danger text-center m-2";
    const now1 = getNowDate('full');
    const now2 = getNowDate('half');
    exit_message.textContent = user.name + 'さんが退室しました  ' + now1;
    change_element.text('Latest Offline ' + now2);
    document.getElementById('messageList').appendChild(exit_message);
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

function addChatMessage(e) {
    const message_list = document.getElementById('messageList');
    const message_element = document.createElement('li');
    const type = 'half';
    if (e.user.id === me_id) {
        message_element.classList = "myself message-wrapper"
        const span_element = document.createElement('span');
        const p_element = document.createElement('p');
        span_element.classList = "badge d-block text-dark text-end";
        span_element.textContent = getNowDate(type);
        p_element.innerHTML = e.message.replace(/\r?\n/g, '<br>');
        message_element.appendChild(span_element);
        message_element.appendChild(p_element);
        message_list.appendChild(message_element);
    } else {
        const user_image = document.createElement('img');
        user_image.src = '/' + e.user.profile_image;
        user_image.classList = "rounded-circle";
        user_image.width = "20";
        user_image.height = "20";
        const user_name = document.createElement('strong');
        user_name.textContent = e.user.name;
        message_element.classList = "opponent";
        const span_element = document.createElement('span');
        span_element.classList = "badge text-dark";
        span_element.textContent = getNowDate(type);
        const p_element = document.createElement('p');
        p_element.innerHTML = e.message.replace(/\r?\n/g, '<br>');
        message_element.appendChild(user_image);
        message_element.appendChild(user_name);
        message_element.appendChild(span_element);
        message_element.appendChild(p_element);
        message_list.appendChild(message_element);
    }
}

function removeRoomNotification() {
    $('#image').children().remove();
    const counter = document.createElement('strong');
    const icon = document.createElement('div');
    icon.innerHTML = "<svg width='40' height='40' fill='currentColor' class='text-danger bi bi-exclamation-triangle mx-2' viewBox='0 0 16 16'><path d='M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z'/><path d='M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z'/></svg>";
    counter.classList = 'fs-6 d-inline text-danger p-2';
    let count = 10;
    counter.textContent = 'このルームは作成者によって削除されました' + count + '秒後にホームに戻ります';
    $('#image').append(icon);
    $('#image').append(counter);
    const interval = setInterval(function () {
        counter.textContent = 'このルームは作成者によって削除されました' + count + '秒後にホームに戻ります';
        count--;
        if (count == 0) {
            counter.textContent = 'このルームは作成者によって削除されました' + count + '秒後にホームに戻ります';
            clearInterval(interval);
            window.onbeforeunload = null;
            window.location.href = '/home';
        }
    }, 1000);
}
