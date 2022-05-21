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
                    removeMoreGetButton();
                } else {
                    let noresult = document.createElement('h3');
                    noresult.id = 'noResult'
                    noresult.classList = "d-flex justify-content-center align-items-center text-black-50 h-100"
                    noresult.textContent = 'No result';
                    document.getElementById('Rooms').appendChild(noresult);
                    removeMoreGetButton();
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
    flexCheckImage.disabled = false;
    flexCheckTag.disabled = false;
    flexCheckPassword.disabled = false;
    flexCheckAnswer.disabled = false;
    newRow.disabled = false;
    oldRow.disabled = false;
    chatRow.disabled = false;
})

$(document).on('click', "[id^='moreGetButton']", function (event) {
    let select = document.getElementById('searchType').value;
    let keyword = document.getElementById('search-keyword').value;
    let last = document.getElementById('Rooms');
    let lastli = last.lastElementChild.getAttribute('id');
    let flexCheckImage = document.getElementById('flexCheckImage').checked;
    let flexCheckTag = document.getElementById('flexCheckTag').checked;
    let flexCheckPassword = document.getElementById('flexCheckPassword').checked;
    let flexCheckAnswer = document.getElementById('flexCheckAnswer').checked;
    if (event.currentTarget.id === 'moreGetButtonSearch') {
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
                    removeMoreGetButton();
                } else {
                    let noresult = document.createElement('h3');
                    noresult.id = 'noResult'
                    noresult.classList = "d-flex justify-content-center align-items-center text-black-50 h-100"
                    noresult.textContent = 'No result';
                    document.getElementById('Rooms').appendChild(noresult);
                    removeMoreGetButton();
                }
            })
            //通信が失敗したとき
            .fail((error) => {
                console.log(error.statusText)
            })

    } else if (event.currentTarget.id === 'moreGetButton') {

        $.ajax({
            type: "get", //HTTP通信の種類
            url: '/getRoomInfo' + lastli, //通信したいURL
            dataType: 'json',
        })
            //通信が成功したとき
            .done((res) => {
                //resStringfy = JSON.stringify(res);
                addRoomPage(res);
                removeMoreGetButton();
            })
            //通信が失敗したとき
            .fail((error) => {
                console.log(error.statusText)
            })
    }
});

$(document).on('click', '#search-button', function () {
    if (document.getElementById('flexRadioUser').checked && document.getElementById('flexRadioRoom').checked != true) {
        $(document.getElementById("Rooms")).empty();
        $("[id^='moreGetButton']").remove();
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
                        removeMoreGetButton();
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
        $(document.getElementById("Rooms")).empty();
        $("[id^='moreGetButton']").remove();

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
                    removeMoreGetButton();
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


function addUserPage(res) {
    if ('content' in document.createElement('template')) {
        let template = document.getElementById('User-template');

        for (let i = 0; i < Object.keys(res).length; i++) {
            let clone = template.content.cloneNode(true);  // template要素の内容を複製
            clone.querySelector('.user-link').href = '/home/profile/' + res[i].id;
            clone.querySelector('.profile-image').src = res[i].profile_image;
            clone.querySelector('.user-name').textContent = res[i].name;

            document.getElementById('Rooms').appendChild(clone);

        }

    }

}



function addRoomPage(res) {
    //res = JSON.parse(res);
    if ('content' in document.createElement('template')) {
        let template = document.getElementById('Room-template');
        for (let i = 0; i < Object.keys(res).length; i++) {
            let clone = template.content.cloneNode(true);  // template要素の内容を複製

            clone.querySelector('li').setAttribute('id', res[i].id);
            if (res[i].password === 'yes') {
                clone.querySelector('.card-title').innerHTML = res[i].title + '' + "<i class='bi bi-lock-fill '></i>";
            } else {
                clone.querySelector('.card-title').textContent = res[i].title;
                clone.querySelector('.enter-room').remove();
                let a = document.createElement('a');
                a.href = '/home/Room:' + res[i].id;
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

        }
        if (!(document.getElementById('moreGetButton')) && !(document.getElementById('moreGetButtonSearch'))) {
            moreGetButton();
        }

    }

}

function removeMoreGetButton() {
    let last = document.getElementById('Rooms');
    let lastli = last.lastElementChild.getAttribute('id');
    let count_child = last.childElementCount;
    console.log(count_child);

    if (lastli === '01g2f34545seelfe54dhr6fi3f7' || count_child < 10) {
        $("[id^='moreGetButton']").remove();
        $("[id^='moreGetButtonSearch']").remove();
    }
}

function moreGetButton() {
    if (!(document.getElementById('noResult'))) {
        let keyword = Boolean(document.getElementById('search-keyword').value);
        let moreget = document.createElement('div');
        let flexCheckImage = document.getElementById('flexCheckImage').checked;
        let flexCheckTag = document.getElementById('flexCheckTag').checked;
        let flexCheckPassword = document.getElementById('flexCheckPassword').checked;
        let flexCheckAnswer = document.getElementById('flexCheckAnswer').checked;
        let check = [keyword, flexCheckImage, flexCheckTag, flexCheckPassword, flexCheckAnswer];
        if (check.some((element) => element === true)) {
            moreget.id = 'moreGetButtonSearch';
        } else {
            moreget.id = 'moreGetButton';
        }
        moreget.className = "btn d-flex justify-content-center m-3"
        moreget.innerHTML = "<i class='bi bi-caret-down'></i>";
        document.getElementById('Room-content').appendChild(moreget);
        removeMoreGetButton();
    }
}



if (document.getElementById('roomPasswordForm')) {
    let passwordForm = document.getElementById("roomPasswordForm"); //ルームパスワードを認証するとき
    passwordForm.addEventListener('shown.bs.modal', function (event) {
        let button = (event.relatedTarget);
        let room_id = button.parentNode.parentNode.parentNode.parentNode.getAttribute('id');
        let input = document.roomPass.room_id;
        input.value = room_id;
        document.getElementById('Room-password').appendChild(input);


    });

}

