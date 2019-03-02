$(function(){
    var end_flag = 0;
    if(end_flag == 0){
        $(document).on("click", "button#show-more-reviews-button", function () {
            $("div#show-more-reviews").empty();
            var item_id = $(this).data('item_id');
            var reviews_li =  $("ul#reviews").find("li");
            var reviews_count = reviews_li.length;
            var base_url = "http://localhost:8080";
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
                    $("<div class='text-center mb-md-5'>\
                        <p class='h4 text-danger'>Show "+ reviews_count_after + " Reviews</p>\
                    </div>").appendTo("div#show-more-reviews");
                    end_flag=1;
                }else {
                    $("<div class='text-center mb-md-5'>\
                        <p class='h4 text-danger'>Show "+ reviews_count_after + " Reviews</p>\
                    </div>\
                    <div class='text-center mb-md-5'>\
                        <button type='button' id='show-more-reviews-button' class='btn btn-outline-secondary w-100' data-item_id='"+ item_id + "'>さらに読み込む</button>\
                    </div>").appendTo("div#show-more-reviews");
                }
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
