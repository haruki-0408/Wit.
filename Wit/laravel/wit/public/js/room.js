/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************!*\
  !*** ./resources/js/room.js ***!
  \******************************/
var room_id = document.querySelector('body').id;
console.log(room_id);
Echo["private"]('room-user-notifications.' + room_id).listen('UserSessionChanged', function (e) {
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
/******/ })()
;