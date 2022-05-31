//ページ読み込み時
$(function () {
    if (document.getElementById('Room-content')) {
        //DOMツリーの構築だけでなく、画像などの関連データの読み込みが完了しないと処理を実行しない。
        // ページ読み込み時に実行したい処理
        $.ajax({
            type: "get", //HTTP通信の種類
            url: '/getRoomInfo', //通信したいURL
            dataType: 'json'
        })
            //通信が成功したとき
            .done((res) => {
                if (res.length !== 0) {
                    addRoomPage(res);
                    removeGetMoreButton();
                } else {
                    let noresult = document.createElement('h3');
                    noresult.id = 'noResult'
                    noresult.classList = "d-flex justify-content-center align-items-center text-black-50 h-100"
                    noresult.textContent = 'No result';
                    document.getElementById('Rooms').appendChild(noresult);
                    removeGetMoreButton();
                }
            })
            //通信が失敗したとき
            .fail((error) => {
                console.log(error.statusText)
            })
    }
});

//getMore押したとき
$(document).on('click', "[id^='getMore']", function (event) {
    let select = document.getElementById('searchType').value;
    let keyword = document.getElementById('search-keyword').value;
    let last = document.getElementById('Rooms');
    let lastli = last.lastElementChild.dataset.roomId;
    let flexCheckImage = document.getElementById('flexCheckImage').checked;
    let flexCheckTag = document.getElementById('flexCheckTag').checked;
    let flexCheckPassword = document.getElementById('flexCheckPassword').checked;
    let flexCheckAnswer = document.getElementById('flexCheckAnswer').checked;
    if (event.currentTarget.id === 'getMoreSearchButton') {
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
                "checkAnswer": flexCheckAnswer,
            },
            dataType: 'json',
        })
            //通信が成功したとき
            .done((res) => {
                if (res.length !== 0) {
                    addRoomPage(res);
                    removeGetMoreButton();
                } else {
                    let noresult = document.createElement('h3');
                    noresult.id = 'noResult'
                    noresult.classList = "d-flex justify-content-center align-items-center text-black-50 h-100"
                    noresult.textContent = 'No result';
                    document.getElementById('Rooms').appendChild(noresult);
                    removeGetMoreButton();
                }
            })
            //通信が失敗したとき
            .fail((error) => {
                console.log(error.statusText)
            })

    } else if (event.currentTarget.id === 'getMoreButton') {
        $.ajax({
            type: "get", //HTTP通信の種類
            url: '/getRoomInfo' + lastli, //通信したいURL
            dataType: 'json',
        })
            //通信が成功したとき
            .done((res) => {
                //resStringfy = JSON.stringify(res);
                addRoomPage(res);
                removeGetMoreButton();
            })
            //通信が失敗したとき
            .fail((error) => {
                console.log(error.statusText)
            })
    } else {
        console.log("それ以外が押されました");
    }
});

//検索ボタンを押したとき
$(document).on('click', '#search-button', function () {
    document.getElementById('getMoreButton').disabled =true;
    //$("[id^='getMoreButton']").remove();
    $(this).prop('disabled',true);
    $(document.getElementById("Rooms")).empty();

    if (document.getElementById('flexRadioUser').checked && document.getElementById('flexRadioRoom').checked != true) {
        
        if (document.getElementById("search-keyword").value) {
            let keyword = document.getElementById("search-keyword").value;
            $.ajax({
                type: "get", //HTTP通信の種類
                url: '/home/searchUser' + '?' + 'keyword=' + keyword, //通信したいURL
                dataType: 'json',
            })
                //通信が成功したとき
                .done((res) => {
                    if (res.length !== 0) {
                        addUserPage(res);
                    } else {
                        let noresult = document.createElement('h3');
                        noresult.classList = "d-flex justify-content-center align-items-center text-black-50 h-100"
                        noresult.textContent = 'No result';
                        document.getElementById('Rooms').appendChild(noresult);
                    }
                })
                //通信が失敗したとき
                .fail((error) => {
                    console.log(error.statusText)
                })
        } else {
            location.reload();
        }
    } else if (document.getElementById('flexRadioRoom').checked && document.getElementById('flexRadioUser').checked != true) {

        let keyword = document.getElementById("search-keyword").value;
        let select = document.getElementById('searchType').value;
        let flexCheckImage = document.getElementById('flexCheckImage').checked;
        let flexCheckTag = document.getElementById('flexCheckTag').checked;
        let flexCheckPassword = document.getElementById('flexCheckPassword').checked;
        let flexCheckAnswer = document.getElementById('flexCheckAnswer').checked;

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
                "checkAnswer": flexCheckAnswer,
            },
            dataType: 'json',
        })
            //通信が成功したとき
            .done((res) => {
                if (res.length !== 0) {
                    addRoomPage(res);
                    removeGetMoreButton();
                } else {
                    let noresult = document.createElement('h3');
                    noresult.classList = "d-flex justify-content-center align-items-center text-black-50 h-100"
                    noresult.textContent = 'No result';
                    document.getElementById('Rooms').appendChild(noresult);
                }
            })
            //通信が失敗したとき
            .fail((error) => {
                console.log(error.statusText)
            })
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

$(document).on('click', '.add-list-room', function () {
    let button = $(this); 
    let room_id = button.parent().parent().attr('data-room-id');
   

    $.ajax({
        type: "get", //HTTP通信の種類
        url: '/home/addListRoom' + room_id, //通信したいURL
        dataType: 'json',
    })
        //通信が成功したとき
        .done((res) => {
            alert(res);
        })
        //通信が失敗したとき
        .fail((error) => {
            console.log(error.statusText)
        })

});

$(document).on('click', '.add-list-user', function () {
    let button = $(this); 
    console.log(button);
    let user_id = button.parent().parent().attr('data-user-id');
   

    $.ajax({
        type: "get", //HTTP通信の種類
        url: '/home/addListUser' + user_id, //通信したいURL
        dataType: 'json',
    })
        //通信が成功したとき
        .done((res) => {
            alert(res);
        })
        //通信が失敗したとき
        .fail((error) => {
            console.log(error.statusText)
        })

});


$(document).on('click', '#flexRadioUser', function () {
    let select = document.getElementById('searchType');
    let flexCheckImage = document.getElementById('flexCheckImage');
    let flexCheckTag = document.getElementById('flexCheckTag');
    let flexCheckPassword = document.getElementById('flexCheckPassword');
    let flexCheckAnswer = document.getElementById('flexCheckAnswer');
    let newRow = document.getElementById('new-row');
    let oldRow = document.getElementById('old-row');
    let chatRow = document.getElementById('chat-row');
    select.disabled = true;
    flexCheckImage.disabled = true;
    flexCheckTag.disabled = true;
    flexCheckPassword.disabled = true;
    flexCheckAnswer.disabled = true;
    newRow.disabled = true;
    oldRow.disabled = true;
    chatRow.disabled = true;
})

$(document).on('click', '#flexRadioRoom', function () {
    let select = document.getElementById('searchType');
    let flexCheckImage = document.getElementById('flexCheckImage');
    let flexCheckTag = document.getElementById('flexCheckTag');
    let flexCheckPassword = document.getElementById('flexCheckPassword');
    let flexCheckAnswer = document.getElementById('flexCheckAnswer');
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
            flexCheckAnswer.disabled = false;
            newRow.disabled = false;
            oldRow.disabled = false;
            chatRow.disabled = false;

            break;
        case 'id':
            flexCheckImage.disabled = true;
            flexCheckTag.disabled = true;
            flexCheckPassword.disabled = true;
            flexCheckAnswer.disabled = true;
            newRow.disabled = true;
            oldRow.disabled = true;
            chatRow.disabled = true;
            break;
        case 'tag':
            flexCheckImage.disabled = false;
            flexCheckTag.disabled = true;
            flexCheckPassword.disabled = false;
            flexCheckAnswer.disabled = false;
            newRow.disabled = false;
            oldRow.disabled = false;
            chatRow.disabled = false;
            break;
        default:
            location.reload();
            break;
    }
})


$(document).on('change', '#searchType', function () {
    let select = document.getElementById('searchType').value;
    let flexCheckImage = document.getElementById('flexCheckImage');
    let flexCheckTag = document.getElementById('flexCheckTag');
    let flexCheckPassword = document.getElementById('flexCheckPassword');
    let flexCheckAnswer = document.getElementById('flexCheckAnswer');
    let newRow = document.getElementById('new-row');
    let oldRow = document.getElementById('old-row');
    let chatRow = document.getElementById('chat-row');

    switch (select) {
        case 'keyword':
            flexCheckImage.disabled = false;
            flexCheckTag.disabled = false;
            flexCheckPassword.disabled = false;
            flexCheckAnswer.disabled = false;
            newRow.disabled = false;
            oldRow.disabled = false;
            chatRow.disabled = false;

            break;
        case 'id':
            flexCheckImage.disabled = true;
            flexCheckTag.disabled = true;
            flexCheckPassword.disabled = true;
            flexCheckAnswer.disabled = true;
            newRow.disabled = true;
            oldRow.disabled = true;
            chatRow.disabled = true;
            break;
        case 'tag':
            flexCheckImage.disabled = false;
            flexCheckTag.disabled = true;
            flexCheckPassword.disabled = false;
            flexCheckAnswer.disabled = false;
            newRow.disabled = false;
            oldRow.disabled = false;
            chatRow.disabled = false;
            break;
        default:
            location.reload();
            break;
    }
})





function addUserPage(res) {
    if ('content' in document.createElement('template')) {
        let template = document.getElementById('User-template');

        for (let i = 0; i < Object.keys(res).length; i++) {
            let clone = template.content.cloneNode(true);  // template要素の内容を複製
            clone.querySelector('li').setAttribute('data-user-id', res[i].id);
            clone.querySelector('.user-link').href = '/home/profile/' + res[i].id;
            clone.querySelector('.profile-image').src = res[i].profile_image;
            clone.querySelector('.user-name').textContent = res[i].name;

            document.getElementById('Rooms').appendChild(clone);
            let search_button = document.getElementById("search-button");
            if(search_button.disabled){
                search_button.disabled = false;
            }

            if($("[id^='getMoreButton']").prop('disabled',true)){
                $("[id^='getMoreButton']").prop('disabled',false);
            }
        }

    }

}



function addRoomPage(res) {
    //res = JSON.parse(res);
    if ('content' in document.createElement('template')) {
        let template = document.getElementById('Room-template');
        for (let i = 0; i < Object.keys(res).length; i++) {
            let clone = template.content.cloneNode(true);  // template要素の内容を複製

            clone.querySelector('li').setAttribute('data-room-id',res[i].id);
            if (res[i].password === 'yes') {
                clone.querySelector('.card-title').innerHTML = res[i].title + '' + "<i class='bi bi-lock-fill '></i>";
            } else {
                clone.querySelector('.card-title').textContent = res[i].title;
                clone.querySelector('.enter-room').remove();
                let a = document.createElement('a');
                if (res[i].id.length > 26) {
                    a.href = '/home/Room:' + res[i].id.slice(0, -1);
                } else {
                    a.href = '/home/Room:' + res[i].id;
                }

                a.className = "enter-room btn btn-outline-primary p-2";
                a.innerHTML = "<i class='bi bi-door-open'></i>";
                clone.querySelector('.btn-group').appendChild(a);
            }
            clone.querySelector('.user-link').href = '/home/profile/' + res[i].user_id;
            clone.querySelector('.profile-image').src = res[i].user.profile_image;
            clone.querySelector('.user-name').textContent = res[i].user.name;
            clone.querySelector('.room-description').innerHTML = res[i].description.replace(/\r?\n/g, '<br>');



            for (let j = 0; j < Object.keys(res[i].room_tags).length; j++) { //ここの実装見直したい、、
                let room_tag_li = document.createElement("li");
                room_tag_li.setAttribute("class", "d-inline-block");
                let room_tag_a = document.createElement("a");
                room_tag_a.setAttribute("class", "tag");
                room_tag_a.href = "#";
                room_tag_a.textContent = res[i].room_tags[j].tag.name;
                let room_tag_span = document.createElement("span");
                room_tag_span.className = "number badge badge-light";
                room_tag_span.textContent = res[i].room_tags[j].tag.number;
                room_tag_a.appendChild(room_tag_span);
                room_tag_li.appendChild(room_tag_a);

                clone.querySelector('.room_tags').appendChild(room_tag_li);
            }

            document.getElementById('Rooms').appendChild(clone);

            let search_button = document.getElementById("search-button");
            if(search_button.disabled){
                search_button.disabled = false;
            }

            if($("[id^='getMoreButton']").prop('disabled',true)){
                $("[id^='getMoreButton']").prop('disabled',false);
            }
            /*switch (type) {
                case 'room':
                    document.getElementById('Rooms').appendChild(clone);
                    break;
                case 'post':
                    document.getElementById('myPost').appendChild(clone);
                    break;
 
                case 'answer':
                    document.getElementById('myAnswer').appendChild(clone);
                    break;
 
                case 'list-room':
                    document.getElementById('myListRoom').appendChild(clone);
                    break;
            }*/
        }

        if (!(document.getElementById('getMoreButton')) && !(document.getElementById('getMoreSearchButton'))) {
            getMoreButton();
        }

    }

}


function removeGetMoreButton() {
    let rooms = document.getElementById('Rooms');
    let lastli = rooms.lastElementChild.dataset.roomId;
    let count_child = rooms.childElementCount;

    if (lastli.length === 27 || count_child < 10) {
        $("[id^='getMoreButton']").remove();
        $("[id^='getMoreSearchButton']").remove();
    }
}

function getMoreButton() {
    if (!(document.getElementById('noResult'))) {
        let keyword = Boolean(document.getElementById('search-keyword').value);
        let getmore = document.createElement('div');
        let flexCheckImage = document.getElementById('flexCheckImage').checked;
        let flexCheckTag = document.getElementById('flexCheckTag').checked;
        let flexCheckPassword = document.getElementById('flexCheckPassword').checked;
        let flexCheckAnswer = document.getElementById('flexCheckAnswer').checked;
        let check = [keyword, flexCheckImage, flexCheckTag, flexCheckPassword, flexCheckAnswer];
        if (check.some((element) => element === true)) {
            getmore.id = 'getMoreSearchButton';
        } else {
            getmore.id = 'getMoreButton';
        }
        getmore.className = "btn d-flex justify-content-center m-3"
        getmore.innerHTML = "<i class='bi bi-caret-down'></i>";
        document.getElementById('Room-content').appendChild(getmore);
        removeGetMoreButton();
    }
}

function getMorePostButton() {
    if (!(document.getElementById('noResult'))) {
        let getmore = document.createElement('div');
        getmore.id = "getMorePostButton";
        getmore.className = "btn d-flex justify-content-center m-3"
        getmore.innerHTML = "<i class='bi bi-caret-down'></i>";
        document.getElementById('Post-rooms').appendChild(getmore);
    }
}



if (document.getElementById('roomPasswordFormModal')) {
    let passwordForm = document.getElementById("roomPasswordFormModal"); //ルームパスワードを認証するとき
    passwordForm.addEventListener('shown.bs.modal', function (event) {
        let button = (event.relatedTarget);
        let room_id = button.parentNode.parentNode.parentNode.parentNode.getAttribute('id');
        let input = document.roomPass.room_id;
        input.value = room_id;
        document.getElementById('roomPassword').appendChild(input);


    });

}

