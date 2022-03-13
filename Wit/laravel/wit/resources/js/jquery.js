$("#Room-content").on('scroll', function () {
    var docHeight = document.getElementById('Room-content').scrollHeight, //要素の全体の高さ
        docSCR = $('#Room-content').scrollTop(); //一番上からスクロールされた量
    windowHeight = document.getElementById('Room-content').clientHeight //スクロールウィンドウ部分の高さ
    docBottom = docHeight - windowHeight + 0.5; //要素全体の高さ - スクロールウィンドウに収まっている部分の高さ　= ページの底の高さ(スクロールによらず一定)

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
    const template = document.getElementById('Room-template');

    if ('content' in document.createElement('Room-template')) {
        for (var i = 0; i < Object.keys(res).length; i++) {
            // template要素の内容を複製
            var clone = template.content.cloneNode(true);

            // 複製したtemplate要素にデータを挿入
            clone.querySelector('.card-title').textContent = res[i].title;
            clone.querySelector('.profile-image').textContent = res[i].user.profile_image;
            clone.querySelector('.user-name').textContent = res[i].user.name;
            clone.querySelector('.room-description').textContent = res[i].description;

            for (var j = 0; j < Object.keys(room_tags).length; i++) {
                var clone = clone.querySelector('d-inline-block').cloneNode(true);
                clone.querySelector('.tag').textContent = res[j].room_tags.tag_id;
                clone.querySelector('.badge').textContent = res[j].room_tags.tag_id;
            }

            // div#containerの中に追加
            document.getElementById('Rooms').appendChild(clone);
        }
    }else{
        console.log('templateがおかしい');
    }
}