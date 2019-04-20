$(function(){
    var end_flag = 0;
    if(end_flag == 0){
        $(document).on("click", "button#show-more-reviews-button", function () {
            $("div#show-more-reviews").empty();
            var item_id = $(this).data('item_id');
            var reviews_li =  $("ul#reviews").find("li");
            var reviews_count = reviews_li.length;

            //ajaxで読み出し
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type : 'POST',
                url : base_url + '/ajax/reviews/show',
                dataType: 'json',
                data : {
                    'item_id' : item_id,
                    'count' : reviews_count,
                },
            })
            // Ajaxリクエストが成功した時発動
            .done(function(response){
                $(response).appendTo("ul#reviews");
                var reviews_li_after =  $('ul#reviews').find('li');
                var reviews_count_after = reviews_li_after.length;
                if(reviews_count_after < 20 + reviews_count){
                    end_flag=1;
                }else {
                    $("<div class='text-center mb-5'>\
                        <button type='button' id='show-more-reviews-button' class='btn btn-outline-secondary w-100' data-item_id='"+ item_id + "'>"+ show_more +"</button>\
                    </div>").appendTo("div#show-more-reviews");
                }

                var $setElm_content = $('pre.content-length'); // 省略する文字のあるセレクタを取得
                var cutFigure_content = '140'; // 表示する文字数
                var afterTxt_content = ' …'; // 文字カット後に表示するテキスト

                $setElm_content.each(function(){
                    var textLength = $(this).text().length;  // 文字数を取得
                    var textTrim = $(this).text().substr(0,cutFigure_content) // 表示する数以上の文字をトリムする

                    if(cutFigure_content < textLength) { // 文字数が表示数より多い場合
                        $(this).html(textTrim + afterTxt_content).css({visibility:'visible'}); // カット後の文字数に…を追加
                    } else if(cutFigure_content >= textLength) { // 文字数が表示数以下の場合
                        $(this).css({visibility:'visible'}); // そのまま表示
                    }
                });

                setTimeout(function(){
                    var created_list = $("p.created-date");
                    for (var i = reviews_count; i < reviews_count_after; i++) {
                        var created = created_list[i].innerHTML;
                        var now = new Date();
                        var past = new Date(created);
                        var diff_time = now.getTime() - past.getTime();
                        var diff_day = Math.floor(diff_time / (1000 * 60 * 60 * 24));
                        if(diff_day == 0){
                            var diff_hour = Math.floor(diff_time / (1000 * 60 * 60));
                            if(diff_hour == 0){
                                var diff_minute = Math.floor(diff_time / (1000 * 60));
                                created_list[i].innerHTML = String(diff_minute) + minutes;
                            }else {
                                created_list[i].innerHTML = String(diff_hour) + hours;
                            }
                        }else if (0 < diff_day && diff_day <= 7) {
                            created_list[i].innerHTML = String(diff_day) + days;
                        }
                    }
                },100);
            });
        })
    }
});
