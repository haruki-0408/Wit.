//グローバル変数としてclick flag を宣言
let click_flag = true;

//getMore押したとき
$(document).on('click', "[id^='Get-More']", function (event) {
    event.currentTarget.disabled = true;
    click_flag = false;
    let last;
    let last_room_id;
    let search_button = document.getElementById('Search-Button');
    if (document.getElementById('Search-Button')) {
        search_button.disabled = true;
    }

    switch (event.currentTarget.id) {
        case 'Get-More-Button-Search':
            last = document.getElementById('Rooms-List');
            last_room_id = last.lastElementChild.dataset.roomId;
            let select = search_button.dataset.select;
            let keyword = search_button.dataset.keyword;
            let check_image = search_button.dataset.check_image;
            let check_tag = search_button.dataset.check_tag;
            let check_password = search_button.dataset.check_password;
            let check_post = search_button.dataset.check_post;

            $.ajax({
                type: "post", //HTTP通信の種類
                url: '/home/searchRoom',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                data: {
                    "search_type": select,
                    "keyword": keyword,
                    "room_id": last_room_id,
                    "check_image": check_image,
                    "check_tag": check_tag,
                    "check_password": check_password,
                    "check_post": check_post,
                },
                dataType: 'json',
            })
                //通信が成功したとき
                .done((res) => {
                    let show = 'Room';
                    if (res.length !== 0) {
                        let last_get_more = res[Object.keys(res).length - 1].no_get_more;
                        addRoomPage(res, show);
                        getMoreRoomButton(1);
                        removeGetMoreButton(show, last_get_more);
                    } else {
                        let last_get_more = 'none_res';
                        removeGetMoreButton(show, last_get_more);
                    }
                    event.currentTarget.disabled = false;
                    click_flag = true;
                    search_button.disabled = false;
                })
                //通信が失敗したとき
                .fail((error) => {
                    console.log(error.statusText)
                });
            break;

        case 'Get-More-Button':
            last = document.getElementById('Rooms-List');
            last_room_id = last.lastElementChild.dataset.roomId;
            $.ajax({
                type: "get", //HTTP通信の種類
                url: '/getRoomInfo:' + last_room_id, //通信したいURL
                dataType: 'json',
            })
                //通信が成功したとき
                .done((res) => {
                    let show = 'Room';
                    if (res.length !== 0) {
                        let last_get_more = res[Object.keys(res).length - 1].no_get_more;
                        addRoomPage(res, show);
                        getMoreRoomButton(0);
                        removeGetMoreButton(show, last_get_more);
                    } else {
                        let last_get_more = 'none_res';
                        removeGetMoreButton(show, last_get_more);
                    }
                    event.currentTarget.disabled = false;
                    click_flag = true;
                    search_button.disabled = false;

                })
                //通信が失敗したとき
                .fail((error) => {
                    console.log(error.statusText)
                });
            break;
        case 'Get-More-PostRoom-Button':
            last = document.getElementById('My-PostRoom-List');
            last_room_id = last.lastElementChild.dataset.roomId;
            $.ajax({
                type: "get", //HTTP通信の種類
                url: '/getPostRoom:' + last_room_id, //通信したいURL
                dataType: 'json',
            })
                //通信が成功したとき
                .done((res) => {
                    if (res.length !== 0) {
                        let show = "myPost";
                        let last_get_more = res[Object.keys(res).length - 1].no_get_more;
                        addRoomPage(res, show);
                        removeGetMoreButton(show, last_get_more);
                    } else {
                        let last_get_more = 'none_res';
                        removeGetMoreButton(show, last_get_more);
                    }
                    event.currentTarget.disabled = false;
                    click_flag = true;
                    if (document.getElementById('Search-Button')) {
                        search_button.disabled = false;
                    }
                })
                //通信が失敗したとき
                .fail((error) => {
                    console.log(error.statusText)
                });
            break;

        case 'Get-More-ListUser-Button':
            last = document.getElementById('My-ListUser-List');
            last_room_id = last.lastElementChild.dataset.userId;

            $.ajax({
                type: "get", //HTTP通信の種類
                url: '/getListUser:' + last_room_id, //通信したいURL
                dataType: 'json',
            })
                //通信が成功したとき
                .done((res) => {
                    let show = "myListUser";
                    if (res.length !== 0) {
                        let last_get_more = res[Object.keys(res).length - 1].no_get_more;
                        addUserPage(res, show);
                        removeGetMoreButton(show, last_get_more);
                    } else {
                        let last_get_more = 'none_res';
                        removeGetMoreButton(show, last_get_more);
                    }
                    event.currentTarget.disabled = false;
                    click_flag = true;
                    if (document.getElementById('Search-Button')) {
                        search_button.disabled = false;
                    }
                })
                //通信が失敗したとき
                .fail((error) => {
                    console.log(error.statusText)
                });
            break;
        case 'Get-More-ListRoom-Button':
            last = document.getElementById('My-ListRoom-List');
            last_room_id = last.lastElementChild.dataset.roomId;

            $.ajax({
                type: "get", //HTTP通信の種類
                url: '/getListRoom:' + last_room_id, //通信したいURL
                dataType: 'json',
            })
                //通信が成功したとき
                .done((res) => {
                    let show = "myListRoom";
                    if (res.length !== 0) {
                        let last_get_more = res[Object.keys(res).length - 1].no_get_more;
                        addRoomPage(res, show);
                        removeGetMoreButton(show, last_get_more);
                    } else {
                        let last_get_more = 'none_res';
                        removeGetMoreButton(show, last_get_more);
                    }
                    event.currentTarget.disabled = false;
                    click_flag = true;
                    if (document.getElementById('Search-Button')) {
                        search_button.disabled = false;
                    }
                })
                //通信が失敗したとき
                .fail((error) => {
                    console.log(error.statusText)
                });
            break;

        case 'Get-More-User-Button':
            last = document.getElementById('Rooms-List');
            last_user_id = last.lastElementChild.dataset.userId;
            keyword = search_button.dataset.keyword;
            $.ajax({
                type: "get",
                url: '/home/searchUser' + '?' + 'keyword=' + keyword + '&' + 'user_id=' + last_user_id,
                dataType: 'json',
            })
                //通信が成功したとき
                .done((res) => {
                    let show = 'User';
                    if (res.length !== 0) {
                        let last_get_more = res[Object.keys(res).length - 1].no_get_more;
                        addUserPage(res, show);
                        removeGetMoreButton(show, last_get_more);
                    } else {
                        let last_get_more = 'none_res';
                        removeGetMoreButton(show, last_get_more);
                    }
                    event.currentTarget.disabled = false;
                    click_flag = true;
                    search_button.disabled = false;
                })
                //通信が失敗したとき
                .fail((error) => {
                    console.log(error.statusText)
                });
            break;

        default:
            console.log("No Button");
            break;
    }
});

//otherMoreを押したとき
$(document).on('click', "[id^='Other-More']", function (event) {
    event.currentTarget.disabled = true;
    let last;
    let last_room_id;
    let user_id = document.getElementById('Target-User').dataset.userId;
    switch (event.currentTarget.id) {
        case 'Other-More-PostRoom-Button':
            last = document.getElementById('Other-PostRoom-List');
            last_room_id = last.lastElementChild.dataset.roomId;
            $.ajax({
                type: "get", //HTTP通信の種類
                url: '/getPostRoom:' + last_room_id + '/' + user_id,
                dataType: 'json',
            })
                //通信が成功したとき
                .done((res) => {
                    let show = 'otherPost';
                    if (res.length !== 0) {
                        let last_get_more = res[Object.keys(res).length - 1].no_get_more;
                        addRoomPage(res, show);
                        removeGetMoreButton(show, last_get_more);
                    } else {
                        let last_get_more = 'none_res';
                        removeGetMoreButton(show, last_get_more);
                    }
                    event.currentTarget.disabled = false;
                })
                //通信が失敗したとき
                .fail((error) => {
                    console.log(error.statusText)
                });
            break;
        case 'Other-More-ListUser-Button':
            last = document.getElementById('Other-ListUser-List');
            last_room_id = last.lastElementChild.dataset.userId;
            $.ajax({
                type: "get", //HTTP通信の種類
                url: '/getListUser:' + last_room_id + '/' + user_id,
                dataType: 'json',
            })
                //通信が成功したとき
                .done((res) => {
                    let show = 'otherListUser';
                    if (res.length !== 0) {
                        let last_get_more = res[Object.keys(res).length - 1].no_get_more;
                        addUserPage(res, show);
                        removeGetMoreButton(show, last_get_more);
                    } else {
                        let last_get_more = 'none_res';
                        removeGetMoreButton(show, last_get_more);
                    }
                    event.currentTarget.disabled = false;
                })
                //通信が失敗したとき
                .fail((error) => {
                    console.log(error.statusText)
                });
            break;
        case 'Other-More-ListRoom-Button':
            last = document.getElementById('Other-ListRoom-List');
            last_room_id = last.lastElementChild.dataset.roomId;
            $.ajax({
                type: "get", //HTTP通信の種類
                url: '/getListRoom:' + last_room_id + '/' + user_id,
                dataType: 'json',
            })
                //通信が成功したとき
                .done((res) => {
                    let show = 'otherListRoom';
                    if (res.length !== 0) {
                        let last_get_more = res[Object.keys(res).length - 1].no_get_more;
                        addRoomPage(res, show);
                        removeGetMoreButton(show, last_get_more);
                    } else {
                        let last_get_more = 'none_res';
                        removeGetMoreButton(show, last_get_more);
                    }
                    event.currentTarget.disabled = false;
                })
                //通信が失敗したとき
                .fail((error) => {
                    console.log(error.statusText)
                });
            break;
        default:
            console.log("No Button");
            break;
    }
});


//検索ボタンを押したとき
$(document).on('click', '#Search-Button', function () {
    $("[id^='Get-More-Button']").remove();
    $("[id^='Get-More-User-Button']").remove();
    $(this).prop('disabled', true);
    click_flag = false;
    $(document.getElementById("Rooms-List")).empty();

    if (document.getElementById('Radio-User').checked && document.getElementById('Radio-Room').checked != true) {

        if (document.getElementById("Search-Keyword").value) {
            let keyword = document.getElementById("Search-Keyword").value;
            let search_button = document.getElementById("Search-Button");
            search_button.dataset.keyword = keyword;

            $.ajax({
                type: "get", //HTTP通信の種類
                url: '/home/searchUser' + '?' + 'keyword=' + keyword, //通信したいURL
                dataType: 'json',
            })
                //通信が成功したとき
                .done((res) => {
                    let show = 'User';
                    if (res.length !== 0) {
                        addUserPage(res, show);
                        //removeGetMoreButton(show,last_get_more);
                    } else {
                        let no_result = document.createElement('h3');
                        no_result.setAttribute('data-room-id', 'No-Result');
                        no_result.classList = "d-flex justify-content-center align-items-center text-black-50 h-100"
                        no_result.textContent = 'No result';
                        document.getElementById('Rooms-List').appendChild(no_result);
                        search_button.disabled = false;
                        click_flag = true;
                    }
                })
                //通信が失敗したとき
                .fail((error) => {
                    console.log(error.statusText)
                })
        } else {
            let search_button = document.getElementById("Search-Button");
            let no_result = document.createElement('h3');
            no_result.setAttribute('data-room-id', 'No-Result');
            no_result.classList = "d-flex justify-content-center align-items-center text-black-50 h-100"
            no_result.textContent = 'No result';
            document.getElementById('Rooms-List').appendChild(no_result);
            search_button.disabled = false;
            click_flag = true;
        }
    } else if (document.getElementById('Radio-Room').checked && document.getElementById('Radio-User').checked != true) {
        let search_button = document.getElementById("Search-Button");
        let keyword = document.getElementById("Search-Keyword").value;
        let select = document.getElementById('Search-Type').value;
        let check_image = document.getElementById('Check-Image').checked;
        let check_tag = document.getElementById('Check-Tag').checked;
        let check_password = document.getElementById('Check-Password').checked;
        let check_post = document.getElementById('Check-Post').checked;
        search_button.dataset.select = select;
        search_button.dataset.keyword = keyword;
        search_button.dataset.check_image = check_image;
        search_button.dataset.check_tag = check_tag;
        search_button.dataset.check_password = check_password;
        search_button.dataset.check_post = check_post;

        $.ajax({
            type: "post", //HTTP通信の種類
            url: '/home/searchRoom',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data: {
                "search_type": select,
                "keyword": keyword,
                "check_image": check_image,
                "check_tag": check_tag,
                "check_password": check_password,
                "check_post": check_post,
            },
            dataType: 'json',
        })
            //通信が成功したとき
            .done((res) => {
                let show = "Room";
                if (res.length !== 0) {
                    let last_get_more = res[Object.keys(res).length - 1].no_get_more;
                    addRoomPage(res, show);
                    getMoreRoomButton(1);
                    removeGetMoreButton(show, last_get_more);
                    click_flag = true;
                } else {
                    let no_result = document.createElement('h3');
                    last_get_more = 'none_res';
                    no_result.setAttribute('data-room-id', 'No-Result');
                    no_result.classList = "d-flex justify-content-center align-items-center text-black-50 h-100"
                    no_result.textContent = 'No result';
                    document.getElementById('Rooms-List').appendChild(no_result);
                    search_button.disabled = false;
                    click_flag = true;
                }
            })
            //通信が失敗したとき
            .fail((error) => {
                console.log(error.statusText)
            })
    }
});


//tagボタンを押したとき
$(document).on('click', '.tag', function (event) {
    let preview = event.currentTarget.classList.contains('preview');
    if (click_flag) {
        let search_button = document.getElementById("Search-Button");
        search_button.disabled = true;

        click_flag = false;
        if (!(preview) && document.getElementById('Rooms-List')) {
            let search_tag_name = event.currentTarget.children[0].textContent;
            search_button.dataset.select = 'tag';
            search_button.dataset.keyword = search_tag_name;
            search_button.dataset.check_image = 'false';
            search_button.dataset.check_tag = 'false';
            search_button.dataset.check_password = 'false';
            search_button.dataset.check_post = 'false';
            $("[id^='Get-More-Button']").remove();
            $("[id^='Get-More-User-Button']").remove();
            $(document.getElementById("Rooms-List")).empty();
            $.ajax({
                type: "post", //HTTP通信の種類
                url: '/home/searchRoom',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                data: {
                    "search_type": 'tag',
                    "keyword": search_tag_name,
                    "check_image": 'false',
                    "check_tag": 'false',
                    "check_password": 'false',
                    "check_post": 'false',
                },
                dataType: 'json',
            })
                //通信が成功したとき
                .done((res) => {
                    let show = 'Room';
                    if (res.length !== 0) {
                        event.currentTarget.disabled = false;
                        let last_get_more = res[Object.keys(res).length - 1].no_get_more;
                        addRoomPage(res, show);
                        getMoreRoomButton(1);
                        removeGetMoreButton(show, last_get_more);
                    } else {
                        let no_result = document.createElement('h3');
                        last_get_more = 'none_res';
                        no_result.setAttribute('data-room-id', 'No-Result');
                        no_result.classList = "d-flex justify-content-center align-items-center text-black-50 h-100"
                        no_result.textContent = 'No result';
                        document.getElementById('Rooms-List').appendChild(no_result);

                        let last_get_more = 'none_res';
                        removeGetMoreButton(show, last_get_more);
                    }
                    click_flag = true;
                    search_button.disabled = false;
                })
                //通信が失敗したとき
                .fail((error) => {
                    console.log(error.statusText)
                })
        }
    }
});



//当初はルームの追加をスクロール判定で行うとしていたがデバイス間の差異や誤判定が多かったので中止
/*$("#Room-content").on('scroll', function () {　　　　　
    let docHeight = document.getElementById('Room-content').scrollHeight, //要素の全体の高さ
        docSCR = $('#Room-content').scrollTop(); //一番上からスクロールされた量
    windowHeight = document.getElementById('Room-content').clientHeight //スクロールウィンドウ部分の高さ
    docBottom = docHeight - windowHeight + 0.5; //要素全体の高さ - スクロールウィンドウに収まっている部分の高さ　= ページの底の高さ(スクロールによらず一定)

    if (docBottom < docSCR) { //スクロール量がページの底の高さを越えると = ページの下部までスクロールすると
        let last = document.getElementById('Rooms');
        let lastli = last.lastElementChild.getAttribute('id');
        console.log('底の高さ:' + docBottom);
        console.log('スクロール量:' + docSCR);
        console.log('底の高さをスクロール量が超えた');
        console.log(lastli);

        $.ajax({
            type: "get", //HTTP通信の種類
            url: '/getRoomInfo' + lastli, //通信したいURL
            dataType: 'json',
        })
            //通信が成功したとき
            .done((res) => {
                //resStringfy = JSON.stringify(res);
                addRoomPage(res); //1秒時間をずらすことでデータベースの混同を防ぐ
                
            })
            //通信が失敗したとき
            .fail((error) => {
                console.log(error.statusText)
            })
    }

});
*/

//Add-List-Room ボタンを押したとき
$(document).on('click', '.Add-List-Room', function () {
    let button = $(this);
    button.addClass('disabled');
    let room_id = button.parent().parent().parent().parent().attr('data-room-id');


    $.ajax({
        type: "get", //HTTP通信の種類
        url: '/home/addListRoom:' + room_id, //通信したいURL
        dataType: 'json',
    })
        //通信が成功したとき
        .done((res) => {
            actionSuccess(res);
            button.removeClass('Add-List-Room');
            button.removeClass('btn-outline-primary');
            button.addClass('Remove-List-Room');
            button.addClass('btn-outline-danger');
            button.html("<svg width = '16' height = '16' fill = 'currentColor' class='bi bi-clipboard-minus' viewBox = '0 0 16 16'> <path fill-rule='evenodd' d='M5.5 9.5A.5.5 0 0 1 6 9h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z' /> <path d='M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z' /> <path d='M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z' /> </svg>")
            button.removeClass('disabled');
        })
        //通信が失敗したとき
        .fail((error) => {
            console.log(error.statusText);
            button.removeClass('disabled');
        })

});

//Remove-List-Roomボタンを押したとき
$(document).on('click', '.Remove-List-Room', function () {
    let button = $(this);
    button.addClass('disabled');
    let room_id = button.parent().parent().parent().parent().attr('data-room-id');


    $.ajax({
        type: "get", //HTTP通信の種類
        url: '/home/removeListRoom:' + room_id, //通信したいURL
        dataType: 'json',
    })
        //通信が成功したとき
        .done((res) => {
            actionSuccess(res);
            button.removeClass('Remove-List-Room');
            button.removeClass('btn-outline-danger');
            button.addClass('Add-List-Room');
            button.addClass('btn-outline-primary');
            button.html("<svg width='16' height='16' fill='currentColor' class='bi bi-clipboard-plus' viewBox='0 0 16 16'> <path fill-rule='evenodd' d='M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7z' /> <path d='M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z' /> <path d='M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z' /> </svg>")
            button.removeClass('disabled');
        })
        //通信が失敗したとき
        .fail((error) => {
            console.log(error.statusText);
            button.removeClass('disabled');
        })

});

//Add-List-Userボタンを押したとき
$(document).on('click', '.Add-List-User', function () {
    let button = $(this);
    button.addClass('disabled');
    let user_id = button.parent().parent().attr('data-user-id');
    $.ajax({
        type: "get", //HTTP通信の種類
        url: '/home/addListUser:' + user_id, //通信したいURL
        dataType: 'json',
    })
        //通信が成功したとき
        .done((res) => {
            actionSuccess(res);
            button.removeClass('Add-List-User');
            button.removeClass('btn-outline-primary');
            button.addClass('Remove-List-User');
            button.addClass('btn-outline-danger');
            button.html("<svg width='16' height='16' fill='currentColor' class='bi bi-person-dash-fill' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M11 7.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5z'></path><path d='M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z'></path></svg>")
            button.removeClass('disabled');
        })
        //通信が失敗したとき
        .fail((error) => {
            console.log(error.statusText)
            button.removeClass('disabled');
        })

});

//Remove-List-Userボタンを押したとき
$(document).on('click', '.Remove-List-User', function () {
    let button = $(this);
    button.addClass('disabled');
    let user_id = button.parent().parent().attr('data-user-id');
    $.ajax({
        type: "get", //HTTP通信の種類
        url: '/home/removeListUser:' + user_id, //通信したいURL
        dataType: 'json',
    })
        //通信が成功したとき
        .done((res) => {
            actionSuccess(res);
            button.removeClass('Remove-List-User');
            button.removeClass('btn-outline-danger');
            button.addClass('Add-List-User');
            button.addClass('btn-outline-primary');
            button.html("<svg width='16' height='16' fill='currentColor' class='bi bi-person-plus-fill' viewBox='0 0 16 16'> <path d='M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z'/> <path fill-rule='evenodd' d='M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z'/> </svg>")
            button.removeClass('disabled');
        })
        //通信が失敗したとき
        .fail((error) => {
            console.log(error.statusText)
            button.removeClass('disabled');
        })

});

//RemoveRoom Modalを開いたとき
$(document).on('click', '.Remove-Room', function (event) {
    let button = $(this);
    let remove_room_id = button.parent().parent().parent().parent().attr('data-room-id');
    let remove_room_link = document.getElementById('Remove-Room-Link');
    remove_room_link.href = '/home/removeRoom:' + remove_room_id;
});

//検索タイプをユーザ検索に切り替えたとき
$(document).on('click', '#Radio-User', function () {
    let select = document.getElementById('Search-Type');
    let check_image = document.getElementById('Check-Image');
    let check_tag = document.getElementById('Check-Tag');
    let check_password = document.getElementById('Check-Password');
    let check_post = document.getElementById('Check-Post');

    select.disabled = true;
    check_image.disabled = true;
    check_tag.disabled = true;
    check_password.disabled = true;
    check_post.disabled = true;
});

//検索タイプをルーム検索に切り替えたとき
$(document).on('click', '#Radio-Room', function () {
    let select = document.getElementById('Search-Type');
    let check_image = document.getElementById('Check-Image');
    let check_tag = document.getElementById('Check-Tag');
    let check_password = document.getElementById('Check-Password');
    let check_post = document.getElementById('Check-Post');

    select.disabled = false;
    select = select.value;
    switch (select) {
        case 'keyword':
            check_image.disabled = false;
            check_tag.disabled = false;
            check_password.disabled = false;
            check_post.disabled = false;
            break;
        case 'id':
            check_image.disabled = true;
            check_tag.disabled = true;
            check_password.disabled = true;
            check_post.disabled = true;
            break;
        case 'tag':
            check_image.disabled = false;
            check_tag.disabled = true;
            check_password.disabled = false;
            check_post.disabled = false;
            break;
        default:
            location.reload();
            break;
    }
});

//キーワード、ルームID、タグ　検索タイプを切り替えたとき
$(document).on('change', '#Search-Type', function () {
    let select = document.getElementById('Search-Type').value;
    let check_image = document.getElementById('Check-Image');
    let check_tag = document.getElementById('Check-Tag');
    let check_password = document.getElementById('Check-Password');
    let check_post = document.getElementById('Check-Post');

    switch (select) {
        case 'keyword':
            check_image.disabled = false;
            check_tag.disabled = false;
            check_password.disabled = false;
            check_post.disabled = false;
            break;
        case 'id':
            check_image.disabled = true;
            check_tag.disabled = true;
            check_password.disabled = true;
            check_post.disabled = true;
            break;
        case 'tag':
            check_image.disabled = false;
            check_tag.disabled = true;
            check_password.disabled = false;
            check_post.disabled = false;
            break;
        default:
            location.reload();
            break;
    }
});

//検索フィルターのPostをクリックしたとき
$(document).on('click', '#Check-Post', function () {
    let select = document.getElementById('Search-Type').value;
    let check_tag = document.getElementById('Check-Tag');
    let check_password = document.getElementById('Check-Password');
    let check_post = document.getElementById('Check-Post');
    if (check_post.checked) {
        check_tag.disabled = true;
        check_password.disabled = true;
    } else if (select === 'tag') {
        check_tag.disabled = true;
        check_password.disabled = false;
    } else {
        check_tag.disabled = false;
        check_password.disabled = false;
    }
});


function addUserPage(res, show) {
    if ('content' in document.createElement('template')) {
        let template = document.getElementById('User-Template');

        for (let i = 0; i < Object.keys(res).length; i++) {
            let clone = template.content.cloneNode(true);  // template要素の内容を複製
            clone.querySelector('li').setAttribute('data-user-id', res[i].id);
            clone.querySelector('.User-Link').href = '/home/profile:' + res[i].id;
            clone.querySelector('.Profile-Image').src = res[i].profile_image;
            clone.querySelector('.User-Name').textContent = res[i].name;

            button = userButtonTypeJudge(res[i].type, res[i].id);
            if (button !== 0) {
                clone.querySelector('.btn-group').appendChild(button);
            }

            switch (show) {
                case 'User':
                    document.getElementById('Rooms-List').appendChild(clone);
                    break;
                case 'myListUser':
                    document.getElementById('My-ListUser-List').appendChild(clone);
                    break;
                case 'otherListUser':
                    document.getElementById('Other-ListUser-List').appendChild(clone);
                    break;
                default:
                    break;
            }

            if (document.getElementById("Search-Button")) {
                let search_button = document.getElementById("Search-Button");
                search_button.disabled = false;
            }

        }

        if (show === 'User') {
            let last_get_more = res[Object.keys(res).length - 1].no_get_more;
            if (!(document.getElementById('Get-More-User-Button')) && !(last_get_more)) {
                getMoreUserButton();
            }

        }

    }

}


function addRoomPage(res, show) {
    if ('content' in document.createElement('template')) {
        let template = document.getElementById('Room-Template');
        let array = new Array;
        for (let i = 0; i < Object.keys(res).length; i++) {
            let clone = template.content.cloneNode(true);  // template要素の内容を複製

            clone.querySelector('li').setAttribute('data-room-id', res[i].id);

            //鍵マーク判定
            if (res[i].type.substr(-1, 1) === '1') {
                clone.querySelector('.card-title').innerHTML = res[i].title + '' + "<svg width='16' height='16' fill='currentColor' class='bi bi-lock-fill' viewBox='0 0 16 16'><path d='M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z' /></svg>";
            } else {
                clone.querySelector('.card-title').textContent = res[i].title;
            }

            array = roomButtonTypeJudge(res[i].type, res[i].id);
            array.forEach(function (value) {
                clone.querySelector('.btn-group').appendChild(value);
            });

            clone.querySelector('.User-Link').href = '/home/profile:' + res[i].user_id;
            clone.querySelector('.Profile-Image').src = '/' + res[i].user.profile_image;
            clone.querySelector('.User-Name').textContent = res[i].user.name;
            clone.querySelector('.Room-Description').innerHTML = res[i].description.replace(/\r?\n/g, '<br>');
            clone.querySelector('.Create-Time').textContent = res[i].created_at;
            if (res[i].posted_at == null) {
                clone.querySelector('.Count-Online-Users').innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-people-fill'viewBox='0 0 16 16'><path d='M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z' /><path fill-rule='evenodd'd='M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z'/><path d='M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z' /></svg>x" + res[i].count_online_users;
                clone.querySelector('.Count-Chat-Messages').innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-chat-left-dots-fill'viewBox='0 0 16 16'><path d='M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4.414a1 1 0 0 0-.707.293L.854 15.146A.5.5 0 0 1 0 14.793V2zm5 4a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z'/></svg>x" + res[i].count_chat_messages;
                clone.querySelector('.Expired-Time-Left').innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-clock-history mx-1' viewBox='0 0 16 16'><path d='M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.95.313a7.023 7.023 0 0 0-.179-.483zm.53 2.507a6.991 6.991 0 0 0-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1 .025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 0 1-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535zm-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 0 1-.401.432l-.707-.707z'/><path d='M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0v1z' /><path d='M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z' /></svg>" + res[i].expired_time_left + '  Hours';
            }

            for (let j = 0; j < Object.keys(res[i].tags).length; j++) { //ここの実装見直したい、、
                let room_tag_li = document.createElement("li");
                room_tag_li.setAttribute("class", "d-inline-block");
                let room_tag_button = document.createElement("button");
                room_tag_button.setAttribute("class", "tag");
                room_tag_button.type = "button";
                let room_tag_name_span = document.createElement("span");
                room_tag_name_span.className = "tag-name"
                room_tag_name_span.textContent = res[i].tags[j].name;
                let room_tag_number_span = document.createElement("span");
                room_tag_number_span.className = "tag-number badge badge-light";
                room_tag_number_span.textContent = res[i].tags[j].number;
                room_tag_button.appendChild(room_tag_name_span);
                room_tag_button.appendChild(room_tag_number_span);
                room_tag_li.appendChild(room_tag_button);

                clone.querySelector('.Room-Tags').appendChild(room_tag_li);
            }

            switch (show) {
                case 'Room':
                    document.getElementById('Rooms-List').appendChild(clone);
                    break;
                case 'User':
                    document.getElementById('Rooms-List').appendChild(clone);
                    break;
                case 'myPost':
                    document.getElementById('My-PostRoom-List').appendChild(clone);
                    break;
                case 'myListRoom':
                    document.getElementById('My-ListRoom-List').appendChild(clone);
                    break;
                case 'otherPost':
                    document.getElementById('Other-PostRoom-List').appendChild(clone);
                    break;
                case 'otherListRoom':
                    document.getElementById('Other-ListRoom-List').appendChild(clone);
                    break;
                default:
                    break;
            }

            if (document.getElementById("Search-Button")) {
                let search_button = document.getElementById("Search-Button");
                search_button.disabled = false;

            }
        }
    }

}


function userButtonTypeJudge(type) {
    let button = document.createElement('button');
    switch (type) {
        case '0':
            return 0;
        case '1':
            button.className = "Add-List-User btn btn-outline-primary";
            button.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-person-plus-fill' viewBox='0 0 16 16'> <path d='M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z'/> <path fill-rule='evenodd' d='M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z'/> </svg>"
            return button;
        case '10':
            button.className = "Remove-List-User btn btn-outline-danger";
            button.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-person-dash-fill' viewBox='0 0 16 16'> <path fill-rule='evenodd' d='M11 7.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5z'/> <path d='M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z'/> </svg>"
            return button;
    }
}

function roomButtonTypeJudge(type) {
    let button0 = document.createElement('button');
    let button1 = document.createElement('button');
    let button2 = document.createElement('button');
    let button3 = document.createElement('button')
    switch (type) {
        case '0':
            button1.className = "Add-List-Room btn btn-outline-primary p-2";
            button1.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-clipboard-plus' viewBox='0 0 16 16'> <path fill-rule='evenodd' d='M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7z' /> <path d='M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z' /> <path d='M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z' /> </svg>";
            button3.className = "Enter-Room btn btn-outline-primary p-2";
            button3.setAttribute("data-bs-toggle", 'modal');
            button3.setAttribute("data-bs-target", '#Enter-Room-Modal');
            button3.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-box-arrow-in-right' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z'/><path fill-rule='evenodd' d='M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z'/></svg>";
            return [button1, button3];

        case '1':
            button1.className = "Add-List-Room btn btn-outline-primary p-2";
            button1.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-clipboard-plus' viewBox='0 0 16 16'> <path fill-rule='evenodd' d='M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7z' /> <path d='M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z' /> <path d='M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z' /> </svg>";
            button2.className = "Enter-Room btn btn-outline-primary p-2";
            button2.setAttribute("data-bs-toggle", 'modal');
            button2.setAttribute("data-bs-target", "#Room-Password-Modal")
            button2.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-box-arrow-in-right' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z'/><path fill-rule='evenodd' d='M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z'/></svg>";
            return [button1, button2];

        case '10':
            button1.className = "Remove-List-Room btn btn-outline-danger p-2";
            button1.innerHTML = "<svg width = '16' height = '16' fill = 'currentColor' class='bi bi-clipboard-minus' viewBox = '0 0 16 16'> <path fill-rule='evenodd' d='M5.5 9.5A.5.5 0 0 1 6 9h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z' /> <path d='M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z' /> <path d='M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z' /> </svg>"
            button3.className = "Enter-Room btn btn-outline-primary p-2";
            button3.setAttribute("data-bs-toggle", 'modal');
            button3.setAttribute("data-bs-target", "#Enter-Room-Modal")
            button3.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-box-arrow-in-right' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z'/><path fill-rule='evenodd' d='M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z'/></svg>";

            return [button1, button3];


        case '11':
            button1.className = "Remove-List-Room btn btn-outline-danger p-2";
            button1.innerHTML = "<svg width = '16' height = '16' fill = 'currentColor' class='bi bi-clipboard-minus' viewBox = '0 0 16 16'> <path fill-rule='evenodd' d='M5.5 9.5A.5.5 0 0 1 6 9h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z' /> <path d='M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z' /> <path d='M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z' /> </svg>"
            button2.className = "Enter-Room btn btn-outline-primary p-2";
            button2.setAttribute("data-bs-toggle", 'modal');
            button2.setAttribute("data-bs-target", "#Room-Password-Modal")
            button2.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-box-arrow-in-right' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z'/><path fill-rule='evenodd' d='M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z'/></svg>";
            return [button1, button2];

        case '100':
            button0.dataset.bsToggle = 'modal';
            button0.dataset.bsTarget = '#Remove-Room-Modal';
            button0.className = "Remove-Room btn btn-outline-danger p-2";
            button0.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-trash3' viewBox='0 0 16 16'> <path d='M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z' /> </svg>"
            button1.className = "Add-List-Room btn btn-outline-primary p-2";
            button1.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-clipboard-plus' viewBox='0 0 16 16'> <path fill-rule='evenodd' d='M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7z' /> <path d='M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z' /> <path d='M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z' /> </svg>";
            button3.className = "Enter-Room btn btn-outline-primary p-2";
            button3.setAttribute("data-bs-toggle", 'modal');
            button3.setAttribute("data-bs-target", "#Enter-Room-Modal")
            button3.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-box-arrow-in-right' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z'/><path fill-rule='evenodd' d='M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z'/></svg>";
            return [button0, button1, button3];

        case '101':
            button0.dataset.bsToggle = 'modal';
            button0.dataset.bsTarget = '#Remove-Room-Modal';
            button0.className = "Remove-Room btn btn-outline-danger p-2";
            button0.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-trash3' viewBox='0 0 16 16'> <path d='M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z' /> </svg>"
            button1.className = "Add-List-Room btn btn-outline-primary p-2";
            button1.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-clipboard-plus' viewBox='0 0 16 16'> <path fill-rule='evenodd' d='M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7z' /> <path d='M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z' /> <path d='M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z' /> </svg>";
            button2.className = "Enter-Room btn btn-outline-primary p-2";
            button2.setAttribute("data-bs-toggle", 'modal');
            button2.setAttribute("data-bs-target", "#Room-Password-Modal")
            button2.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-box-arrow-in-right' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z'/><path fill-rule='evenodd' d='M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z'/></svg>";
            return [button0, button1, button2];

        case '110':
            button0.dataset.bsToggle = 'modal';
            button0.dataset.bsTarget = 'Remove-Room-Modal';
            button0.className = "Remove-Room btn btn-outline-danger p-2";
            button0.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-trash3' viewBox='0 0 16 16'> <path d='M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z' /> </svg>"
            button1.className = "Remove-List-Room btn btn-outline-danger p-2";
            button1.innerHTML = "<svg width = '16' height = '16' fill = 'currentColor' class='bi bi-clipboard-minus' viewBox = '0 0 16 16'> <path fill-rule='evenodd' d='M5.5 9.5A.5.5 0 0 1 6 9h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z' /> <path d='M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z' /> <path d='M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z' /> </svg>"
            button3.className = "Enter-Room btn btn-outline-primary p-2";
            button3.setAttribute("data-bs-toggle", 'modal');
            button3.setAttribute("data-bs-target", "#Enter-Room-Modal")
            button3.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-box-arrow-in-right' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z'/><path fill-rule='evenodd' d='M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z'/></svg>";
            return [button0, button1, button3];

        case '111':
            button0.dataset.bsToggle = 'modal';
            button0.dataset.bsTarget = '#Remove-Room-Modal';
            button0.className = "Remove-Room btn btn-outline-danger p-2";
            button0.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-trash3' viewBox='0 0 16 16'> <path d='M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z' /> </svg>"
            button1.className = "Remove-List-Room btn btn-outline-danger p-2";
            button1.innerHTML = "<svg width = '16' height = '16' fill = 'currentColor' class='bi bi-clipboard-minus' viewBox = '0 0 16 16'> <path fill-rule='evenodd' d='M5.5 9.5A.5.5 0 0 1 6 9h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z' /> <path d='M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z' /> <path d='M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z' /> </svg>"
            button2.className = "Enter-Room btn btn-outline-primary p-2";
            button2.setAttribute("data-bs-toggle", 'modal');
            button2.setAttribute("data-bs-target", "#Room-Password-Modal")
            button2.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-box-arrow-in-right' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z'/><path fill-rule='evenodd' d='M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z'/></svg>";
            return [button0, button1, button2];

        default:
            break;
    }
}

function removeGetMoreButton(show, last_get_more) {
    let rooms;
    let button;
    switch (show) {
        case 'Room':
            rooms = document.getElementById('Rooms-List');
            button = $("[id^='Get-More-Button']");
            break;
        case 'User':
            rooms = document.getElementById('Rooms-List');
            button = document.getElementById('Get-More-User-Button');
            break;
        case 'myPost':
            rooms = document.getElementById('My-PostRoom-List');
            button = document.getElementById('Get-More-PostRoom-Button');
            break;
        case 'myListRoom':
            rooms = document.getElementById('My-ListRoom-List');
            button = document.getElementById('Get-More-ListRoom-Button');
            break;
        case 'myListUser':
            rooms = document.getElementById('My-ListUser-List');
            button = document.getElementById('Get-More-ListUser-Button');
            break;
        case 'otherPost':
            rooms = document.getElementById('Other-PostRoom-List');
            button = document.getElementById('Other-More-PostRoom-Button');
            break;
        case 'otherListUser':
            rooms = document.getElementById('Other-ListUser-List');
            button = document.getElementById('Other-More-ListUser-Button');
            break;
        case 'otherListRoom':
            rooms = document.getElementById('Other-ListRoom-List');
            button = document.getElementById('Other-More-ListRoom-Button');
            break;
        default:
            break;
    }

    if (last_get_more === 'none_res' || last_get_more === true || rooms.lastElementChild.tagName === 'H3') {
        $(button).remove();
    }
}

function getMoreRoomButton(tag) {
    if (!(document.getElementById('Get-More-Button')) && !(document.getElementById('Get-More-Button-Search')) && !(document.getElementById('No-Result'))) {
        let keyword = Boolean(document.getElementById('Search-Keyword').value);
        let get_more = document.createElement('div');
        let check_image = document.getElementById('Check-Image').checked;
        let check_tag = document.getElementById('Check-Tag').checked;
        let check_password = document.getElementById('Check-Password').checked;
        let check_post = document.getElementById('Check-Post').checked;
        let check = [keyword, check_image, check_tag, check_password, check_post];
        console.log(check);
        if (check.some((element) => element === true) || tag === 1) {
            get_more.id = 'Get-More-Button-Search';
        } else {
            get_more.id = 'Get-More-Button';
        }
        get_more.className = "btn d-flex justify-content-center m-3";
        get_more.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-caret-down' viewBox='0 0 16 16'><path d='M3.204 5h9.592L8 10.481 3.204 5zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659z'/></svg>";
        document.getElementById('Room-Content').appendChild(get_more);
    }
}

function getMoreUserButton() {
    if (!(document.getElementById('No-Result'))) {
        let getmore = document.createElement('div');
        getmore.id = "Get-More-User-Button";
        getmore.className = "btn d-flex justify-content-center m-3";
        getmore.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-caret-down' viewBox='0 0 16 16'><path d='M3.204 5h9.592L8 10.481 3.204 5zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659z'/></svg>";
        document.getElementById('Room-Content').appendChild(getmore);
    }
}

function actionSuccess(res) {
    let action;
    let message;
    if ('message' in res) {
        action = document.getElementById('Action-Message');
        message = res['message'];
    } else if ('error_message' in res) {
        action = document.getElementById('Error-Message');
        message = res['error_message'];
    }

    action.classList.remove("invisible");
    $(action).children('div').text(message);
    setTimeout(() => { action.classList.add('invisible') }, 3000);

}



//ルームに入場する時
if (document.getElementById('Enter-Room-Modal')) {
    let enter_room_modal = document.getElementById("Enter-Room-Modal");
    enter_room_modal.addEventListener('shown.bs.modal', function (event) {
        let button = (event.relatedTarget);
        let room_id = button.parentNode.parentNode.parentNode.parentNode.getAttribute('data-room-id');
        let enter_room_link = document.getElementById('Enter-Room-Link');
        enter_room_link.href = '/home/room:' + room_id;
    });
}


//ルームパスワードを認証するとき
if (document.getElementById('Room-Password-Modal')) {
    let room_password_modal = document.getElementById("Room-Password-Modal");
    room_password_modal.addEventListener('shown.bs.modal', function (event) {
        let button = (event.relatedTarget);
        let room_id = button.parentNode.parentNode.parentNode.parentNode.getAttribute('data-room-id');
        let input = document.room_password.room_id;
        input.value = room_id;
        document.getElementById('Room-Password-Form').appendChild(input);
    });
}



