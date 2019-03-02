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
                    $("<div class='text-center mb-md-5'>\
                        <p class='h4 text-danger'>Show "+ timelines_count_after + " Reviews</p>\
                    </div>").appendTo("div#show-more-timelines");
                    end_flag=1;
                }else {
                    $("<div class='text-center mb-md-5'>\
                        <p class='h4 text-danger'>Show "+ timelines_count_after + " Reviews</p>\
                    </div>\
                    <div class='text-center mb-md-5'>\
                        <button type='button' id='show-more-timelines-button' class='btn btn-outline-secondary w-100'>さらに読み込む</button>\
                    </div>").appendTo("div#show-more-timelines");
                }
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
