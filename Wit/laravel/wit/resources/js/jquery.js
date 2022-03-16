$("#Room-content").on('scroll', function () {
    var docHeight = document.getElementById('Room-content').scrollHeight, //要素の全体の高さ
        docSCR = $('#Room-content').scrollTop(); //一番上からスクロールされた量
    windowHeight = document.getElementById('Room-content').clientHeight //スクロールウィンドウ部分の高さ
    docBottom = docHeight - windowHeight; //要素全体の高さ - スクロールウィンドウに収まっている部分の高さ　= ページの底の高さ(スクロールによらず一定)

    if (docBottom < docSCR) { //スクロール量がページの底の高さを越えると = ページの下部までスクロールすると
        console.log('docHeight:' + docHeight);
        console.log('windowHeight:' + windowHeight);
        console.log('scrollTop:' + docSCR);
        console.log('docBottom:' + docBottom);
        console.log('------------');
        alert('一番下までスクロールしました');
    }

});

$(window).on('load', function () {
    //DOMツリーの構築だけでなく、画像などの関連データの読み込みが完了しないと処理を実行しない。
    // ページ読み込み時に実行したい処理
    $.ajax({
        type: "get", //HTTP通信の種類
        url: '/getRoomInfo', //通信したいURL
        dataType: 'json'
    })
        //通信が成功したとき
        .done((res) => {
            resStringfy = JSON.stringify(res);
            addRoomPage(resStringfy);
        })
        //通信が失敗したとき
        .fail((error) => {
            console.log(error.statusText)
        })
});

function addRoomPage(res) {
    console.log(res);
    res = JSON.parse(res);
    const template = document.getElementById('Room-template');
    for (var i = 0; i < Object.keys(res).length; i++) {
        // template要素の内容を複製
        var clone = template.content.cloneNode(true);

        clone.querySelector('.card-title').textContent = res[i].title;
        clone.querySelector('.profile-image').src = res[i].user.profile_image ;
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
            room_tag_span.className ="number badge badge-light";
            room_tag_span.textContent = res[i].room_tags[j].tag.number;
            room_tag_a.appendChild(room_tag_span);
            room_tag_li.appendChild(room_tag_a);

            clone.querySelector('.room_tags').appendChild(room_tag_li);
            
        }
        document.getElementById('Rooms').appendChild(clone);
        
    }
}
