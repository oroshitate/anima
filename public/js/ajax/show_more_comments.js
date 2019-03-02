$(function(){
    var end_flag = 0;
    if(end_flag == 0){
        $(document).on("click", "button#show-more-comments-button", function () {
            $("div#show-more-comments").empty();
            var review_id = $(this).data('review_id');
            var comments_li =  $("#comments").find("li");
            var comments_count = comments_li.length;
            var base_url = "http://localhost:8080";
            //ajaxで読み出し
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type : 'POST',
                url : base_url + '/ajax/comments/show',
                dataType: 'json',
                data : {
                    'review_id' : review_id,
                    'count' : comments_count,
                },
            })
            // Ajaxリクエストが成功した時発動
            .done(function(response){
                $(response).appendTo("ul#comments");
                var comments_li_after =  $('ul#comments').find('li');
                var comments_count_after = comments_li_after.length;
                if(comments_count_after < 20 + comments_count){
                    $("<div class='text-center mb-md-5'>\
                        <p class='h4 text-danger'>Show "+ comments_count_after + " comments</p>\
                    </div>").appendTo("div#show-more-comments");
                    end_flag=1;
                }else {
                    $("<div class='text-center mb-md-5'>\
                        <p class='h4 text-danger'>Show "+ comments_count_after + " comments</p>\
                    </div>\
                    <div class='text-center mb-md-5'>\
                        <button type='button' id='show-more-comments-button' class='btn btn-outline-secondary w-100' data-review_id='" + review_id + "'>さらに読み込む</button>\
                    </div>").appendTo("div#show-more-comments");
                }
                setTimeout(function(){
                    var created_list = $("p.created-date");
                    for (var i = comments_count; i < comments_count_after; i++) {
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
