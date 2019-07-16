$(function(){
    $("footer").css({"display":"none"});

    $("#pills-watchlists-tab").one("click", function () {
        var user_id = $(this).data('user_id');
        //ajaxで読み出し
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type : 'POST',
            url : base_url + '/ajax/one-watchlists/show',
            dataType: 'json',
            data : {
                'user_id' : user_id,
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
            }, 500);

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

            var watchlists_li =  $("div#watchlists").find("div.watchlist");
            var watchlists_count = watchlists_li.length;
            if(watchlists_count == 20){
                $("<div class='text-center mb-5'>\
                    <button type='button' id='show-more-watchlists-button' class='btn btn-outline-secondary w-100' data-user_id='" + user_id + "'>"+ show_more +"</button>\
                </div>").appendTo("div#show-more-watchlists");
            }
        });
    });

    $(document).on("click", "div#watchlist-button", function () {
        var user_id = $(this).data('user_id');
        var item_id = $(this).data('item_id');
        var watchlist_button = $(this).attr('class');
        if(watchlist_button.indexOf('active') == -1){
            $(this).addClass("active");
            var img_src = base_url + "/add_to_watchlist_b.png";
            $(this).find("img").attr('src', img_src);

            //ajaxで読み出し
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type : 'POST',
                url : base_url + '/watchlist/store',
                dataType: 'json',
                data : {
                    'user_id' : user_id,
                    'item_id' : item_id
                },
            })
            // Ajaxリクエストが成功した時発動
            .done(function(response){
                $("div#watchlist-button").attr("data-watchlist_id", response);
            });
        }else{
            $(this).removeClass("active");
            var img_src = base_url + "/add_to_watchlist_a.png";
            $(this).find("img").attr('src', img_src);

            var watchlist_id = $(this).attr('data-watchlist_id');
            $("div#watchlist-button").attr("data-watchlist_id", "");
            //ajaxで読み出し
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type : 'POST',
                url : base_url + '/watchlist/delete',
                dataType: 'json',
                data : {
                    'watchlist_id' : watchlist_id,
                },
            })
            // Ajaxリクエストが成功した時発動
            .done(function(){
            });
        }
    });
});
