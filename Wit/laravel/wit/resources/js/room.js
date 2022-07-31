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
    }
}

function sendEnterMessage(user) {
    const enter_message = document.createElement('li');
    const type = 'full';
    enter_message.classList = "text-primary text-center m-2";
    now = getNowDate(type);
    enter_message.textContent = user.name + 'さんが入室しました  ' + now;
    document.getElementById('messageList').appendChild(enter_message);
}

function sendExitMessage(user) {
    const exit_message = document.createElement('li');
    const type = 'full';
    exit_message.classList = "text-danger text-center m-2";
    now = getNowDate(type);
    exit_message.textContent = user.name + 'さんが退室しました  ' + now;
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
        const full_time = year + "/" + month.toString().padStart(2, '0') + "/" + day + " " + hour + ":" + min + ":" + sec;
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