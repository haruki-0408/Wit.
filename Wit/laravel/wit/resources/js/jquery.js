//グローバル変数としてclick flag を宣言
let clickFlag = true;

//getMore押したとき
$(document).on('click', "[id^='getMore']", function (event) {
    event.currentTarget.disabled = true;
    clickFlag = false;
    let last;
    let lastli;
    let searchButton = document.getElementById('search-button');
    searchButton.disabled = true;

    switch (event.currentTarget.id) {
        case 'getMoreButtonSearch':
            last = document.getElementById('Rooms');
            lastli = last.lastElementChild.dataset.roomId;
            let select = searchButton.dataset.select;
            let keyword = searchButton.dataset.keyword;
            let flexCheckImage = searchButton.dataset.flexCheckImage;
            let flexCheckTag = searchButton.dataset.flexCheckTag;
            let flexCheckPassword = searchButton.dataset.flexCheckPassword;
            let flexCheckPost = searchButton.dataset.flexCheckPost;

            $.ajax({
                type: "post", //HTTP通信の種類
                url: '/home/searchRoom',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                data: {
                    "searchType": select,
                    "keyword": keyword,
                    "room_id": lastli,
                    "checkImage": flexCheckImage,
                    "checkTag": flexCheckTag,
                    "checkPassword": flexCheckPassword,
                    "checkPost": flexCheckPost,
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
                    clickFlag = true;
                    searchButton.disabled = false;
                })
                //通信が失敗したとき
                .fail((error) => {
                    console.log(error.statusText)
                });
            break;

        case 'getMoreButton':
            last = document.getElementById('Rooms');
            lastli = last.lastElementChild.dataset.roomId;
            $.ajax({
                type: "get", //HTTP通信の種類
                url: '/getRoomInfo:' + lastli, //通信したいURL
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
                    clickFlag = true;
                    searchButton.disabled = false;

                })
                //通信が失敗したとき
                .fail((error) => {
                    console.log(error.statusText)
                });
            break;
        case 'getMorePostRoomButton':
            last = document.getElementById('myPost');
            lastli = last.lastElementChild.dataset.roomId;
            $.ajax({
                type: "get", //HTTP通信の種類
                url: '/getPostRoom:' + lastli, //通信したいURL
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
                    clickFlag = true;
                    searchButton.disabled = false;
                })
                //通信が失敗したとき
                .fail((error) => {
                    console.log(error.statusText)
                });
            break;
        case 'getMoreAnswerRoomButton':
            console.log("getMoreAnswerRoomButtonが押されました");
            break;
        case 'getMoreListUserButton':
            last = document.getElementById('myListUser');
            lastli = last.lastElementChild.dataset.userId;

            $.ajax({
                type: "get", //HTTP通信の種類
                url: '/getListUser:' + lastli, //通信したいURL
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
                    clickFlag = true;
                    searchButton.disabled = false;
                })
                //通信が失敗したとき
                .fail((error) => {
                    console.log(error.statusText)
                });
            break;
        case 'getMoreListRoomButton':
            last = document.getElementById('myListRoom');
            lastli = last.lastElementChild.dataset.roomId;

            $.ajax({
                type: "get", //HTTP通信の種類
                url: '/getListRoom:' + lastli, //通信したいURL
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
                    clickFlag = true;
                    searchButton.disabled = false;
                })
                //通信が失敗したとき
                .fail((error) => {
                    console.log(error.statusText)
                });
            break;

        case 'getMoreUserButton':
            last = document.getElementById('Rooms');
            last_user_id = last.lastElementChild.dataset.userId;
            keyword = searchButton.dataset.keyword;
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
                    clickFlag = true;
                    searchButton.disabled = false;
                })
                //通信が失敗したとき
                .fail((error) => {
                    console.log(error.statusText)
                });
            break;

        default:
            console.log("それ以外が押されました");
            break;

    }
});

//otherMoreを押したとき
$(document).on('click', "[id^='otherMore']", function (event) {
    event.currentTarget.disabled = true;
    let last;
    let lastli;
    let user_id = document.getElementById('targetUser').dataset.userId;
    switch (event.currentTarget.id) {
        case 'otherMorePostRoomButton':
            last = document.getElementById('otherPost');
            lastli = last.lastElementChild.dataset.roomId;
            $.ajax({
                type: "get", //HTTP通信の種類
                url: '/getPostRoom:' + lastli + '/' + user_id,
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
        case 'otherMoreAnswerRoomButton':
            console.log('otherMoreAnswerRoomButtonが押されました');
            break;
        case 'otherMoreListUserButton':
            last = document.getElementById('otherListUser');
            lastli = last.lastElementChild.dataset.userId;
            $.ajax({
                type: "get", //HTTP通信の種類
                url: '/getListUser:' + lastli + '/' + user_id,
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
        case 'otherMoreListRoomButton':
            last = document.getElementById('otherListRoom');
            lastli = last.lastElementChild.dataset.roomId;
            $.ajax({
                type: "get", //HTTP通信の種類
                url: '/getListRoom:' + lastli + '/' + user_id,
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
            console.log("それ以外が押されました");
            break;

    }
});


//検索ボタンを押したとき
$(document).on('click', '#search-button', function () {
    //document.getElementById('getMoreButton').disabled =true;
    $("[id^='getMoreButton']").remove();
    $("[id^='getMoreUserButton']").remove();
    $(this).prop('disabled', true);
    clickFlag = false;
    $(document.getElementById("Rooms")).empty();

    if (document.getElementById('flexRadioUser').checked && document.getElementById('flexRadioRoom').checked != true) {

        if (document.getElementById("search-keyword").value) {
            let keyword = document.getElementById("search-keyword").value;
            let searchButton = document.getElementById("search-button");
            searchButton.dataset.keyword = keyword;

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
                        let noresult = document.createElement('h3');
                        noresult.setAttribute('data-room-id', 'noResult');
                        noresult.classList = "d-flex justify-content-center align-items-center text-black-50 h-100"
                        noresult.textContent = 'No result';
                        document.getElementById('Rooms').appendChild(noresult);
                        searchButton.disabled = false;
                        clickFlag = true;
                    }
                })
                //通信が失敗したとき
                .fail((error) => {
                    console.log(error.statusText)
                })
        } else {
            let searchButton = document.getElementById("search-button");
            let noresult = document.createElement('h3');
            noresult.setAttribute('data-room-id', 'noResult');
            noresult.classList = "d-flex justify-content-center align-items-center text-black-50 h-100"
            noresult.textContent = 'No result';
            document.getElementById('Rooms').appendChild(noresult);
            searchButton.disabled = false;
            clickFlag = true;
        }
    } else if (document.getElementById('flexRadioRoom').checked && document.getElementById('flexRadioUser').checked != true) {

        let searchButton = document.getElementById("search-button");
        let keyword = document.getElementById("search-keyword").value;
        let select = document.getElementById('searchType').value;
        let flexCheckImage = document.getElementById('flexCheckImage').checked;
        let flexCheckTag = document.getElementById('flexCheckTag').checked;
        let flexCheckPassword = document.getElementById('flexCheckPassword').checked;
        let flexCheckPost = document.getElementById('flexCheckPost').checked;
        searchButton.dataset.select = select;
        searchButton.dataset.keyword = keyword;
        searchButton.dataset.flexCheckImage = flexCheckImage;
        searchButton.dataset.flexCheckTag = flexCheckTag;
        searchButton.dataset.flexCheckPassword = flexCheckPassword;
        searchButton.dataset.flexCheckPost = flexCheckPost;

        $.ajax({
            type: "post", //HTTP通信の種類
            url: '/home/searchRoom',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data: {
                "searchType": select,
                "keyword": keyword,
                "checkImage": flexCheckImage,
                "checkTag": flexCheckTag,
                "checkPassword": flexCheckPassword,
                "checkPost": flexCheckPost,
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
                    clickFlag = true;
                } else {
                    let noresult = document.createElement('h3');
                    last_get_more = 'none_res';
                    noresult.setAttribute('data-room-id', 'noResult');
                    noresult.classList = "d-flex justify-content-center align-items-center text-black-50 h-100"
                    noresult.textContent = 'No result';
                    document.getElementById('Rooms').appendChild(noresult);

                    searchButton.disabled = false;
                    clickFlag = true;
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
    if (clickFlag) {
        let searchButton = document.getElementById("search-button");
        searchButton.disabled = true;
        
        clickFlag = false;
        if (!(preview) && document.getElementById('Rooms')) {
            let searchTagName = event.currentTarget.children[0].textContent;
            searchButton.dataset.select = 'tag';
            searchButton.dataset.keyword = searchTagName;
            searchButton.dataset.flexCheckImage = 'false';
            searchButton.dataset.flexCheckTag = 'false';
            searchButton.dataset.flexCheckPassword = 'false';
            searchButton.dataset.flexCheckPost = 'false';
            $("[id^='getMoreButton']").remove();
            $("[id^='getMoreUserButton']").remove();
            $(document.getElementById("Rooms")).empty();
            $.ajax({
                type: "post", //HTTP通信の種類
                url: '/home/searchRoom',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                data: {
                    "searchType": 'tag',
                    "keyword": searchTagName,
                    "checkImage": 'false',
                    "checkTag": 'false',
                    "checkPassword": 'false',
                    "checkPost": 'false',
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
                        let noresult = document.createElement('h3');
                        last_get_more = 'none_res';
                        noresult.setAttribute('data-room-id', 'noResult');
                        noresult.classList = "d-flex justify-content-center align-items-center text-black-50 h-100"
                        noresult.textContent = 'No result';
                        document.getElementById('Rooms').appendChild(noresult);

                        let last_get_more = 'none_res';
                        removeGetMoreButton(show, last_get_more);
                    }
                    clickFlag = true;
                    searchButton.disabled = false;    
                })
                //通信が失敗したとき
                .fail((error) => {
                    console.log(error.statusText)
                })
        }
    }
});



//当初はルームの追加をスクロール判定で行うとしていたがデバイス間の差異やご判定が多かったので中止
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

//add-list-room ボタンを押したとき
$(document).on('click', '.add-list-room', function () {
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
            button.removeClass('add-list-room');
            button.removeClass('btn-outline-primary');
            button.addClass('remove-list-room');
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

//remove-list-roomボタンを押したとき
$(document).on('click', '.remove-list-room', function () {
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
            button.removeClass('remove-list-room');
            button.removeClass('btn-outline-danger');
            button.addClass('add-list-room');
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

//add-list-userボタンを押したとき
$(document).on('click', '.add-list-user', function () {
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
            button.removeClass('add-list-user');
            button.removeClass('btn-outline-primary');
            button.addClass('remove-list-user');
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

//remove-list-userボタンを押したとき
$(document).on('click', '.remove-list-user', function () {
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
            button.removeClass('remove-list-user');
            button.removeClass('btn-outline-danger');
            button.addClass('add-list-user');
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

//removeRoom Modalを開いたとき
$(document).on('click', '.remove-room', function (event) {
    let button = $(this);
    let remove_room_id = button.parent().parent().parent().parent().attr('data-room-id');
    let remove_room_link = document.getElementById('removeRoomLink');
    remove_room_link.href = '/home/removeRoom:' + remove_room_id;
});

//検索タイプをユーザ検索に切り替えたとき
$(document).on('click', '#flexRadioUser', function () {
    let select = document.getElementById('searchType');
    let flexCheckImage = document.getElementById('flexCheckImage');
    let flexCheckTag = document.getElementById('flexCheckTag');
    let flexCheckPassword = document.getElementById('flexCheckPassword');
    let flexCheckPost = document.getElementById('flexCheckPost');
    let newRow = document.getElementById('new-row');
    let oldRow = document.getElementById('old-row');
    let chatRow = document.getElementById('chat-row');
    select.disabled = true;
    flexCheckImage.disabled = true;
    flexCheckTag.disabled = true;
    flexCheckPassword.disabled = true;
    flexCheckPost.disabled = true;
    newRow.disabled = true;
    oldRow.disabled = true;
    chatRow.disabled = true;
});

//検索タイプをルーム検索に切り替えたとき
$(document).on('click', '#flexRadioRoom', function () {
    let select = document.getElementById('searchType');
    let flexCheckImage = document.getElementById('flexCheckImage');
    let flexCheckTag = document.getElementById('flexCheckTag');
    let flexCheckPassword = document.getElementById('flexCheckPassword');
    let flexCheckPost = document.getElementById('flexCheckPost');
    let newRow = document.getElementById('new-row');
    let oldRow = document.getElementById('old-row');
    let chatRow = document.getElementById('chat-row');

    select.disabled = false;
    select = select.value;
    switch (select) {
        case 'keyword':
            flexCheckImage.disabled = false;
            flexCheckTag.disabled = false;
            flexCheckPassword.disabled = false;
            flexCheckPost.disabled = false;
            newRow.disabled = false;
            oldRow.disabled = false;
            chatRow.disabled = false;

            break;
        case 'id':
            flexCheckImage.disabled = true;
            flexCheckTag.disabled = true;
            flexCheckPassword.disabled = true;
            flexCheckPost.disabled = true;
            newRow.disabled = true;
            oldRow.disabled = true;
            chatRow.disabled = true;
            break;
        case 'tag':
            flexCheckImage.disabled = false;
            flexCheckTag.disabled = true;
            flexCheckPassword.disabled = false;
            flexCheckPost.disabled = false;
            newRow.disabled = false;
            oldRow.disabled = false;
            chatRow.disabled = false;
            break;
        default:
            location.reload();
            break;
    }
});

//キーワード、ルームID、タグ　検索タイプを切り替えたとき
$(document).on('change', '#searchType', function () {
    let select = document.getElementById('searchType').value;
    let flexCheckImage = document.getElementById('flexCheckImage');
    let flexCheckTag = document.getElementById('flexCheckTag');
    let flexCheckPassword = document.getElementById('flexCheckPassword');
    let flexCheckPost = document.getElementById('flexCheckPost');
    let newRow = document.getElementById('new-row');
    let oldRow = document.getElementById('old-row');
    let chatRow = document.getElementById('chat-row');

    switch (select) {
        case 'keyword':
            flexCheckImage.disabled = false;
            flexCheckTag.disabled = false;
            flexCheckPassword.disabled = false;
            flexCheckPost.disabled = false;
            newRow.disabled = false;
            oldRow.disabled = false;
            chatRow.disabled = false;

            break;
        case 'id':
            flexCheckImage.disabled = true;
            flexCheckTag.disabled = true;
            flexCheckPassword.disabled = true;
            flexCheckPost.disabled = true;
            newRow.disabled = true;
            oldRow.disabled = true;
            chatRow.disabled = true;
            break;
        case 'tag':
            flexCheckImage.disabled = false;
            flexCheckTag.disabled = true;
            flexCheckPassword.disabled = false;
            flexCheckPost.disabled = false;
            newRow.disabled = false;
            oldRow.disabled = false;
            chatRow.disabled = false;
            break;
        default:
            location.reload();
            break;
    }
});

//検索フィルターのPostをクリックしたとき
$(document).on('click', '#flexCheckPost', function () {
    let select = document.getElementById('searchType').value;
    let flexCheckTag = document.getElementById('flexCheckTag');
    let flexCheckPassword = document.getElementById('flexCheckPassword');
    let flexCheckPost = document.getElementById('flexCheckPost');
    if (flexCheckPost.checked) {
        flexCheckTag.disabled = true;
        flexCheckPassword.disabled = true;
    } else if (select === 'tag') {
        flexCheckTag.disabled = true;
        flexCheckPassword.disabled = false;
    } else {
        flexCheckTag.disabled = false;
        flexCheckPassword.disabled = false;
    }
});


function addUserPage(res, show) {
    if ('content' in document.createElement('template')) {
        let template = document.getElementById('User-template');

        for (let i = 0; i < Object.keys(res).length; i++) {
            let clone = template.content.cloneNode(true);  // template要素の内容を複製
            clone.querySelector('li').setAttribute('data-user-id', res[i].id);
            clone.querySelector('.user-link').href = '/home/profile:' + res[i].id;
            clone.querySelector('.profile-image').src = res[i].profile_image;
            clone.querySelector('.user-name').textContent = res[i].name;

            button = userButtonTypeJudge(res[i].type, res[i].id);
            if (button !== 0) {
                clone.querySelector('.btn-group').appendChild(button);
            }

            switch (show) {
                case 'User':
                    document.getElementById('Rooms').appendChild(clone);
                    break;
                case 'myListUser':
                    document.getElementById('myListUser').appendChild(clone);
                    break;
                case 'otherListUser':
                    document.getElementById('otherListUser').appendChild(clone);
                    break;
                default:
                    break;
            }

            if (document.getElementById("search-button")) {
                let searchButton = document.getElementById("search-button");
                searchButton.disabled = false;
            }

        }

        if (show === 'User') {
            let last_get_more = res[Object.keys(res).length - 1].no_get_more;
            if (!(document.getElementById('getMoreUserButton')) && !(last_get_more)) {
                getMoreUserButton();
            }

        }

    }

}


function addRoomPage(res, show) {
    if ('content' in document.createElement('template')) {
        let template = document.getElementById('Room-template');
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

            clone.querySelector('.user-link').href = '/home/profile:' + res[i].user_id;
            clone.querySelector('.profile-image').src = '/' + res[i].user.profile_image;
            clone.querySelector('.user-name').textContent = res[i].user.name;
            clone.querySelector('.room-description').innerHTML = res[i].description.replace(/\r?\n/g, '<br>');
            clone.querySelector('.created_at').textContent = res[i].created_at;
            if (res[i].posted_at == null) {
                clone.querySelector('.countOnlineUsers').innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-people-fill'viewBox='0 0 16 16'><path d='M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z' /><path fill-rule='evenodd'd='M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z'/><path d='M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z' /></svg>x" + res[i].count_online_users;
                clone.querySelector('.countChatMessages').innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-chat-left-dots-fill'viewBox='0 0 16 16'><path d='M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4.414a1 1 0 0 0-.707.293L.854 15.146A.5.5 0 0 1 0 14.793V2zm5 4a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z'/></svg>x" + res[i].count_chat_messages;
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

                clone.querySelector('.room_tags').appendChild(room_tag_li);
            }

            switch (show) {
                case 'Room':
                    document.getElementById('Rooms').appendChild(clone);
                    break;
                case 'User':
                    document.getElementById('Rooms').appendChild(clone);
                    break;
                case 'myPost':
                    document.getElementById('myPost').appendChild(clone);
                    break;
                case 'myListRoom':
                    document.getElementById('myListRoom').appendChild(clone);
                    break;
                case 'otherPost':
                    document.getElementById('otherPost').appendChild(clone);
                    break;
                case 'otherListRoom':
                    document.getElementById('otherListRoom').appendChild(clone);
                    break;
                default:
                    break;
            }

            if (document.getElementById("search-button")) {
                let searchButton = document.getElementById("search-button");
                searchButton.disabled = false;

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
            button.className = "add-list-user btn btn-outline-primary";
            button.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-person-plus-fill' viewBox='0 0 16 16'> <path d='M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z'/> <path fill-rule='evenodd' d='M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z'/> </svg>"
            return button;
        case '10':
            button.className = "remove-list-user btn btn-outline-danger";
            button.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-person-dash-fill' viewBox='0 0 16 16'> <path fill-rule='evenodd' d='M11 7.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5z'/> <path d='M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z'/> </svg>"
            return button;
    }
}

function roomButtonTypeJudge(type, room_id) {
    let button0 = document.createElement('button');
    let button1 = document.createElement('button');
    let button2 = document.createElement('button');
    let button3 = document.createElement('button')
    switch (type) {
        case '0':
            button1.className = "add-list-room btn btn-outline-primary p-2";
            button1.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-clipboard-plus' viewBox='0 0 16 16'> <path fill-rule='evenodd' d='M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7z' /> <path d='M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z' /> <path d='M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z' /> </svg>";
            button3.className = "enter-room btn btn-outline-primary p-2";
            button3.setAttribute("data-bs-toggle", 'modal');
            button3.setAttribute("data-bs-target", '#enterRoomModal');
            button3.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-box-arrow-in-right' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z'/><path fill-rule='evenodd' d='M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z'/></svg>";
            return [button1, button3];

        case '1':
            button1.className = "add-list-room btn btn-outline-primary p-2";
            button1.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-clipboard-plus' viewBox='0 0 16 16'> <path fill-rule='evenodd' d='M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7z' /> <path d='M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z' /> <path d='M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z' /> </svg>";
            button2.className = "enter-room btn btn-outline-primary p-2";
            button2.setAttribute("data-bs-toggle", 'modal');
            button2.setAttribute("data-bs-target", "#roomPasswordFormModal")
            button2.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-box-arrow-in-right' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z'/><path fill-rule='evenodd' d='M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z'/></svg>";
            return [button1, button2];

        case '10':
            button1.className = "remove-list-room btn btn-outline-danger p-2";
            button1.innerHTML = "<svg width = '16' height = '16' fill = 'currentColor' class='bi bi-clipboard-minus' viewBox = '0 0 16 16'> <path fill-rule='evenodd' d='M5.5 9.5A.5.5 0 0 1 6 9h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z' /> <path d='M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z' /> <path d='M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z' /> </svg>"
            button3.className = "enter-room btn btn-outline-primary p-2";
            button3.setAttribute("data-bs-toggle", 'modal');
            button3.setAttribute("data-bs-target", "#enterRoomModal")
            button3.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-box-arrow-in-right' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z'/><path fill-rule='evenodd' d='M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z'/></svg>";

            return [button1, button3];


        case '11':
            button1.className = "remove-list-room btn btn-outline-danger p-2";
            button1.innerHTML = "<svg width = '16' height = '16' fill = 'currentColor' class='bi bi-clipboard-minus' viewBox = '0 0 16 16'> <path fill-rule='evenodd' d='M5.5 9.5A.5.5 0 0 1 6 9h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z' /> <path d='M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z' /> <path d='M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z' /> </svg>"
            button2.className = "enter-room btn btn-outline-primary p-2";
            button2.setAttribute("data-bs-toggle", 'modal');
            button2.setAttribute("data-bs-target", "#roomPasswordFormModal")
            button2.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-box-arrow-in-right' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z'/><path fill-rule='evenodd' d='M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z'/></svg>";
            return [button1, button2];

        case '100':
            button0.dataset.bsToggle = 'modal';
            button0.dataset.bsTarget = '#removeRoomModal';
            button0.className = "remove-room btn btn-outline-danger p-2";
            button0.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-trash3' viewBox='0 0 16 16'> <path d='M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z' /> </svg>"
            button1.className = "add-list-room btn btn-outline-primary p-2";
            button1.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-clipboard-plus' viewBox='0 0 16 16'> <path fill-rule='evenodd' d='M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7z' /> <path d='M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z' /> <path d='M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z' /> </svg>";
            button3.className = "enter-room btn btn-outline-primary p-2";
            button3.setAttribute("data-bs-toggle", 'modal');
            button3.setAttribute("data-bs-target", "#enterRoomModal")
            button3.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-box-arrow-in-right' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z'/><path fill-rule='evenodd' d='M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z'/></svg>";
            return [button0, button1, button3];

        case '101':
            button0.dataset.bsToggle = 'modal';
            button0.dataset.bsTarget = '#removeRoomModal';
            button0.className = "remove-room btn btn-outline-danger p-2";
            button0.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-trash3' viewBox='0 0 16 16'> <path d='M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z' /> </svg>"
            button1.className = "add-list-room btn btn-outline-primary p-2";
            button1.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-clipboard-plus' viewBox='0 0 16 16'> <path fill-rule='evenodd' d='M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7z' /> <path d='M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z' /> <path d='M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z' /> </svg>";
            button2.className = "enter-room btn btn-outline-primary p-2";
            button2.setAttribute("data-bs-toggle", 'modal');
            button2.setAttribute("data-bs-target", "#roomPasswordFormModal")
            button2.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-box-arrow-in-right' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z'/><path fill-rule='evenodd' d='M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z'/></svg>";
            return [button0, button1, button2];

        case '110':
            button0.dataset.bsToggle = 'modal';
            button0.dataset.bsTarget = 'removeRoomModal';
            button0.className = "remove-room btn btn-outline-danger p-2";
            button0.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-trash3' viewBox='0 0 16 16'> <path d='M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z' /> </svg>"
            button1.className = "remove-list-room btn btn-outline-danger p-2";
            button1.innerHTML = "<svg width = '16' height = '16' fill = 'currentColor' class='bi bi-clipboard-minus' viewBox = '0 0 16 16'> <path fill-rule='evenodd' d='M5.5 9.5A.5.5 0 0 1 6 9h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z' /> <path d='M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z' /> <path d='M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z' /> </svg>"
            button3.className = "enter-room btn btn-outline-primary p-2";
            button3.setAttribute("data-bs-toggle", 'modal');
            button3.setAttribute("data-bs-target", "#enterRoomModal")
            button3.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-box-arrow-in-right' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z'/><path fill-rule='evenodd' d='M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z'/></svg>";
            return [button0, button1, button3];

        case '111':
            button0.dataset.bsToggle = 'modal';
            button0.dataset.bsTarget = '#removeRoomModal';
            button0.className = "remove-room btn btn-outline-danger p-2";
            button0.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-trash3' viewBox='0 0 16 16'> <path d='M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z' /> </svg>"
            button1.className = "remove-list-room btn btn-outline-danger p-2";
            button1.innerHTML = "<svg width = '16' height = '16' fill = 'currentColor' class='bi bi-clipboard-minus' viewBox = '0 0 16 16'> <path fill-rule='evenodd' d='M5.5 9.5A.5.5 0 0 1 6 9h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z' /> <path d='M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z' /> <path d='M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z' /> </svg>"
            button2.className = "enter-room btn btn-outline-primary p-2";
            button2.setAttribute("data-bs-toggle", 'modal');
            button2.setAttribute("data-bs-target", "#roomPasswordFormModal")
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
            rooms = document.getElementById('Rooms');
            button = $("[id^='getMoreButton']");
            break;
        case 'User':
            rooms = document.getElementById('Rooms');
            button = document.getElementById('getMoreUserButton');
            break;
        case 'myPost':
            rooms = document.getElementById('myPost');
            button = document.getElementById('getMorePostRoomButton');
            break;
        case 'myListRoom':
            rooms = document.getElementById('myListRoom');
            button = document.getElementById('getMoreListRoomButton');
            break;
        case 'myListUser':
            rooms = document.getElementById('myListUser');
            button = document.getElementById('getMoreListUserButton');
            break;
        case 'otherPost':
            rooms = document.getElementById('otherPost');
            button = document.getElementById('otherMorePostRoomButton');
            break;
        case 'otherListUser':
            rooms = document.getElementById('otherListUser');
            button = document.getElementById('otherMoreListUserButton');
            break;
        case 'otherListRoom':
            rooms = document.getElementById('otherListRoom');
            button = document.getElementById('otherMoreListRoomButton');
            break;
        default:
            break;
    }

    if (last_get_more === 'none_res' || last_get_more === true || rooms.lastElementChild.tagName === 'H3') {
        $(button).remove();
    }
}

function getMoreRoomButton(tag) {
    if (!(document.getElementById('getMoreButton')) && !(document.getElementById('getMoreButtonSearch')) && !(document.getElementById('noResult'))) {
        let keyword = Boolean(document.getElementById('search-keyword').value);
        let getmore = document.createElement('div');
        let flexCheckImage = document.getElementById('flexCheckImage').checked;
        let flexCheckTag = document.getElementById('flexCheckTag').checked;
        let flexCheckPassword = document.getElementById('flexCheckPassword').checked;
        let flexCheckPost = document.getElementById('flexCheckPost').checked;
        let check = [keyword, flexCheckImage, flexCheckTag, flexCheckPassword, flexCheckPost];
        if (check.some((element) => element === true) || tag === 1) {
            getmore.id = 'getMoreButtonSearch';
        } else {
            getmore.id = 'getMoreButton';
        }
        getmore.className = "btn d-flex justify-content-center m-3";
        getmore.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-caret-down' viewBox='0 0 16 16'><path d='M3.204 5h9.592L8 10.481 3.204 5zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659z'/></svg>";
        document.getElementById('Room-content').appendChild(getmore);
    }
}

function getMoreUserButton() {
    if (!(document.getElementById('noResult'))) {
        let getmore = document.createElement('div');
        getmore.id = "getMoreUserButton";
        getmore.className = "btn d-flex justify-content-center m-3";
        getmore.innerHTML = "<svg width='16' height='16' fill='currentColor' class='bi bi-caret-down' viewBox='0 0 16 16'><path d='M3.204 5h9.592L8 10.481 3.204 5zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659z'/></svg>";
        document.getElementById('Room-content').appendChild(getmore);
    }
}

function actionSuccess(res) {
    let action;
    let message;
    if ('message' in res) {
        action = document.getElementById('action-message');
        message = res['message'];
    } else if ('error_message' in res) {
        action = document.getElementById('error-message');
        message = res['error_message'];
    }

    action.classList.remove("invisible");
    $(action).children('div').text(message);
    setTimeout(() => { action.classList.add('invisible') }, 3000);

}



//ルームに入場する時
if (document.getElementById('enterRoomModal')) {
    let enterRoomModal = document.getElementById("enterRoomModal");
    enterRoomModal.addEventListener('shown.bs.modal', function (event) {
        let button = (event.relatedTarget);
        let room_id = button.parentNode.parentNode.parentNode.parentNode.getAttribute('data-room-id');
        let enterRoomLink = document.getElementById('enterRoomLink');
        enterRoomLink.href = '/home/room:' + room_id;
    });
}


//ルームパスワードを認証するとき
if (document.getElementById('roomPasswordFormModal')) {
    let passwordForm = document.getElementById("roomPasswordFormModal");
    passwordForm.addEventListener('shown.bs.modal', function (event) {
        let button = (event.relatedTarget);
        let room_id = button.parentNode.parentNode.parentNode.parentNode.getAttribute('data-room-id');
        let input = document.roomPass.room_id;
        input.value = room_id;
        document.getElementById('roomPassword').appendChild(input);
    });
}



