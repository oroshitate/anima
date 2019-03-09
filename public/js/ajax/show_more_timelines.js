$(function(){
    var end_flag = 0;
    if(end_flag == 0){
        $(document).on("click", "button#show-more-timelines-button", function () {
            $("div#show-more-timelines").empty();
            var timelines_li =  $('ul#timelines').find('li');
            var timelines_count = timelines_li.length;
            var base_url = 'http://localhost:8080';
            //ajaxで読み出し
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                }
            });
            $.ajax({
                type : 'POST',
                url : base_url + '/ajax/timelines/show',
                dataType: 'json',
                data : {
                    'count' : timelines_count,
                },
            })
            // Ajaxリクエストが成功した時発動
            .done(function(response){
                $(response).appendTo("#timelines");
                var timelines_li_after =  $('ul#timelines').find('li');
                var timelines_count_after = timelines_li_after.length;
                if(timelines_count_after < 20 + timelines_count){
                    end_flag=1;
                }else {
                    $("<div class='text-center mb-5'>\
                        <button type='button' id='show-more-timelines-button' class='btn btn-outline-secondary w-100'>さらに読み込む</button>\
                    </div>").appendTo("div#show-more-timelines");
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
                    for (var i = timelines_count; i < timelines_count_after; i++) {
                        var created = created_list[i].innerHTML;
                        var now = new Date();
                        var past = new Date(created);
                        var diff_time = now.getTime() - past.getTime();
                        var diff_day = Math.floor(diff_time / (1000 * 60 * 60 * 24));
                        if(diff_day == 0){
                            var diff_hour = Math.floor(diff_time / (1000 * 60 * 60));
                            if(diff_hour == 0){
                                var diff_minute = Math.floor(diff_time / (1000 * 60));
                                created_list[i].innerHTML = String(diff_minute) + "分前";
                                continue;
                            }else {
                                created_list[i].innerHTML = String(diff_hour) + "時間前";
                                continue;
                            }
                        }else if (0 < diff_day < 8) {
                            created_list[i].innerHTML = String(diff_day) + "日前";
                        }else {
                            continue;
                        }
                    }
                },100);
            });
        })
    }
});
