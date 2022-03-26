$(function () {
    if (document.getElementById('Room-content')) {
        //DOMツリーの構築だけでなく、画像などの関連データの読み込みが完了しないと処理を実行しない。
        // ページ読み込み時に実行したい処理
        $.ajax({
            type: "get", //HTTP通信の種類
            url: '/getFirstRoomInfo', //通信したいURL
            dataType: 'json'
        })
            //通信が成功したとき
            .done((res) => {
                //resStringfy = JSON.stringify(res);
                addRoomPage(res);
            })
            //通信が失敗したとき
            .fail((error) => {
                console.log(error.statusText)
            })
            
    }
});



$("#Room-content").on('scroll', function () {
    var docHeight = document.getElementById('Room-content').scrollHeight, //要素の全体の高さ
        docSCR = $('#Room-content').scrollTop(); //一番上からスクロールされた量
    windowHeight = document.getElementById('Room-content').clientHeight //スクロールウィンドウ部分の高さ
    docBottom = docHeight - windowHeight + 0.5; //要素全体の高さ - スクロールウィンドウに収まっている部分の高さ　= ページの底の高さ(スクロールによらず一定)

    if (docBottom < docSCR) { //スクロール量がページの底の高さを越えると = ページの下部までスクロールすると
        var last = document.getElementById('Rooms');
        var lastli = last.lastElementChild.getAttribute('id');
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

function addRoomPage(res) {
    //res = JSON.parse(res);
    if ('content' in document.createElement('template')) {
        const template = document.getElementById('Room-template');
        for (var i = 0; i < Object.keys(res).length; i++) {
            var clone = template.content.cloneNode(true);  // template要素の内容を複製
            clone.querySelector('li').setAttribute('id', res[i].id);
            if (res[i].password === null) {
                clone.querySelector('.card-title').textContent = res[i].title;
                clone.querySelector('.enter-room').remove();
                var a = document.createElement('a');
                a.href = '/home/Room' + res[i].id;
                a.className = "enter-room btn btn-outline-primary p-2";
                a.innerHTML = "<i class='bi bi-door-open'></i>";
                clone.querySelector('.btn-group').appendChild(a);
            } else {
                clone.querySelector('.card-title').innerHTML = res[i].title + '' + "<i class='bi bi-lock-fill '></i>";
            }
            clone.querySelector('.profile-image').src = res[i].user.profile_image;
            clone.querySelector('.user-name').textContent = res[i].user.name;
            clone.querySelector('.room-description').textContent = res[i].description;



            for (var j = 0; j < Object.keys(res[i].room_tags).length; j++) { //ここの実装見直したい、、
                var room_tag_li = document.createElement("li");
                room_tag_li.setAttribute("class", "d-inline-block");
                var room_tag_a = document.createElement("a");
                room_tag_a.setAttribute("class", "tag");
                room_tag_a.href = "#";
                room_tag_a.textContent = res[i].room_tags[j].tag.name;
                var room_tag_span = document.createElement("span");
                room_tag_span.className = "number badge badge-light";
                room_tag_span.textContent = res[i].room_tags[j].tag.number;
                room_tag_a.appendChild(room_tag_span);
                room_tag_li.appendChild(room_tag_a);

                clone.querySelector('.room_tags').appendChild(room_tag_li);
            }
            document.getElementById('Rooms').appendChild(clone);
        }

    }
}

if (document.getElementById('passwordForm')) {
    var passwordForm = document.getElementById("passwordForm"); //ルームパスワードを認証するとき
    passwordForm.addEventListener('shown.bs.modal', function (event) {
        var button = (event.relatedTarget);
        var room_id = button.parentNode.parentNode.parentNode.parentNode.getAttribute('id');
        var input = document.roomPass.room_id;
        input.value = room_id;
        console.log(input.value);
        document.getElementById('Room-password').appendChild(input);


    });
}

