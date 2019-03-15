$(function(){
    $(document).on("click", ".like-review-button", function () {
        var review_id = $(this).data("review_id");
        var like_button_id = "#like-review-button-" + review_id;
        var likes_count_id = "span#likes-review-count-" + review_id;
        var like_button = $(like_button_id).attr('class');
        if(like_button.indexOf('active') == -1){
            $(like_button_id).addClass("active text-danger");
            var before_likes_count = $(likes_count_id).text();
            var after_likes_count = $(likes_count_id).text(Number(before_likes_count)+1);

            //ajaxで読み出し
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type : 'POST',
                url : base_url + '/like/store',
                dataType: 'json',
                data : {
                    'review_id' : review_id,
                },
            })
            // Ajaxリクエストが成功した時発動
            .done(function(response){
                $(like_button_id).attr("data-like_id", response);
            });
        }else{
            $(like_button_id).removeClass("active").removeClass("text-danger");
            var before_likes_count = $(likes_count_id).text();
            var after_likes_count = $(likes_count_id).text(Number(before_likes_count)-1);
            var like_id = $(like_button_id).attr('data-like_id');

            $(like_button_id).attr("data-like_id", "");
            //ajaxで読み出し
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type : 'POST',
                url : base_url + '/like/delete',
                dataType: 'json',
                data : {
                    'like_id' : like_id,
                },
            })
            // Ajaxリクエストが成功した時発動
            .done(function(){
            });
        }
    });

    $(document).on("click", ".like-comment-button", function () {
        var comment_id = $(this).data("comment_id");
        var review_id = $(this).data("review_id");
        var like_button_id = "#like-comment-button-" + comment_id;
        var likes_count_id = "span#likes-comment-count-" + comment_id;
        var like_button = $(like_button_id).attr('class');
        if(like_button.indexOf('active') == -1){
            $(like_button_id).addClass("active text-danger");
            var before_likes_count = $(likes_count_id).text();
            var after_likes_count = $(likes_count_id).text(Number(before_likes_count)+1);

            //ajaxで読み出し
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type : 'POST',
                url : base_url + '/like/store',
                dataType: 'json',
                data : {
                    'review_id' : review_id,
                    'comment_id' : comment_id,
                },
            })
            // Ajaxリクエストが成功した時発動
            .done(function(response){
                $(like_button_id).attr("data-like_id", response);
            });
        }else{
            $(like_button_id).removeClass("active").removeClass("text-danger");
            var before_likes_count = $(likes_count_id).text();
            var after_likes_count = $(likes_count_id).text(Number(before_likes_count)-1);
            var like_id = $(like_button_id).attr('data-like_id');

            $(like_button_id).attr("data-like_id", "");
            //ajaxで読み出し
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type : 'POST',
                url : base_url + '/like/delete',
                dataType: 'json',
                data : {
                    'like_id' : like_id,
                },
            })
            // Ajaxリクエストが成功した時発動
            .done(function(){
            });
        }
    });
});
