const room_id = document.querySelector('body').id;

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

/*Echo.private('room-user-notifications.'+room_id)
    .listen('UserSessionChanged', (e) => {
        console.log('received a message');
        console.log(e);
    });*/

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
        removeOnlineUser(user);
        sendExitMessage(user);
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
    enter_message.classList = "text-primary text-center m-2";
    now = getNowDate();
    enter_message.textContent = user.name + 'さんが入室しました  '+now;
    document.getElementById('messageList').appendChild(enter_message);
}

function sendExitMessage(user) {
    const exit_message = document.createElement('li');
    exit_message.classList = "text-danger text-center m-2";
    now = getNowDate();
    exit_message.textContent = user.name + 'さんが退室しました  '+now;
    document.getElementById('messageList').appendChild(exit_message);
}

function removeOnlineUser(user) {
    const user_mark = $('li[data-user-id="' + user.id + '"]');
    if (user_mark.length !== 0) {
        user_mark.remove();
    }
}

function getNowDate() {
    const date = new Date();
    const year = date.getFullYear();
    const month = date.getMonth() + 1;
    const day = date.getDate().toString().padStart(2, '0');
    const hour = date.getHours().toString().padStart(2, '0');
    const min = date.getMinutes().toString().padStart(2, '0');
    const sec = date.getSeconds().toString().padStart(2, '0');
    const now = year + "-" + month.toString().padStart(2, '0') + "-" + day + "-" + hour + ":" + min + ":" + sec;
    return now;
}