const room_id = document.querySelector('body').id;
console.log(room_id);

Echo.private('room-user-notifications.'+room_id)
    .listen('UserSessionChanged', (e) => {
        console.log('received a message');
        console.log(e);
    });

/*Echo.join('room-user-notifications.'+room_id)
    .here((users) => {
        console.log(users);
    })
    .joining((user) => {
        console.log('入室しました');
    })
    .leaving((user) => {
        console.log(user);
    })
    .error((error) => {
        console.error(error);
    });*/