$(function(){
    var end_flag = 0;
    if(end_flag == 0){
        $(document).on("click", "button#show-more-watchlists-button", function () {
            $("div#show-more-watchlists").empty();
            var user_id = $(this).data('user_id');
            var watchlists_li =  $("div#watchlists").find("div.watchlist");
            var watchlists_count = watchlists_li.length;

            //ajaxで読み出し
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type : 'POST',
                url : base_url + '/ajax/watchlists/show',
                dataType: 'json',
                data : {
                    'user_id' : user_id,
                    'count' : watchlists_count,
                },
            })
            // Ajaxリクエストが成功した時発動
            .done(function(response){
                $(response).appendTo("div#watchlists");
                var cnt = 0;
                var waiting = setInterval(function(){
                    if(cnt == 1) {
                        $('.grid-index').masonry({
                            itemSelector: '.grid-item',
                            columnWidth: '.grid-sizer',
                            percentPosition: true
                        });

                        clearInterval(waiting);
                    }
                    cnt++;
                }, 400);

                var $setElm_name = $('.name-length'); // 省略する文字のあるセレクタを取得
                var cutFigure_name = '14'; // 表示する文字数
                var afterTxt_name = ' …'; // 文字カット後に表示するテキスト

                $setElm_name.each(function(){
                    var textLength = $(this).text().length;  // 文字数を取得
                    var textTrim = $(this).text().substr(0,cutFigure_name) // 表示する数以上の文字をトリムする

                    if(cutFigure_name < textLength) { // 文字数が表示数より多い場合
                        $(this).html(textTrim + afterTxt_name).css({visibility:'visible'}); // カット後の文字数に…を追加
                    } else if(cutFigure_name >= textLength) { // 文字数が表示数以下の場合
                        $(this).css({visibility:'visible'}); // そのまま表示
                    }
                });

                var watchlists_li_after = $('div#watchlists').find('div.watchlist');
                var watchlists_count_after = watchlists_li_after.length;
                if(watchlists_count_after < 20 + watchlists_count){
                    end_flag=1;
                }else {
                    $("<div class='text-center mb-5'>\
                        <button type='button' id='show-more-watchlists-button' class='btn btn-outline-secondary w-100' data-review_id='" + review_id + "'>"+ show_more +"</button>\
                    </div>").appendTo("div#show-more-watchlists");
                }
            });
        })
    }
});
