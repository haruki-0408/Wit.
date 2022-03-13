$("#Room-content").on('scroll', function () {
    var docHeight = document.getElementById('Room-content').scrollHeight, //要素の全体の高さ
        docSCR = $('#Room-content').scrollTop(); //一番上からスクロールされた量
        windowHeight = document.getElementById('Room-content').clientHeight //スクロールウィンドウ部分の高さ
        docBottom = docHeight - windowHeight + 0.5; //要素全体の高さ - スクロールウィンドウに収まっている部分の高さ　= ページの底の高さ(スクロールによらず一定)
    
        if (docBottom < docSCR) { //スクロール量がページの底の高さを越えると = ページの下部までスクロールすると
            console.log('docHeight:'+docHeight);
            console.log('windowHeight:'+windowHeight);
            console.log('scrollTop:'+docSCR);
            console.log('docBottom:'+docBottom);
            console.log('------------');
            alert('一番下までスクロールしました');
            }
        
});
