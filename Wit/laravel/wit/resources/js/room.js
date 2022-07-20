require('./bootstrap');
// bootstrap.js import 

Echo.channel('room-user-notifications')
            .listen('UserSessionChanged', (e) => {
                console.log('received a message');
                console.log(e);
            });

