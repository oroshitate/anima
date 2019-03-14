$(function(){
    // var base_url = "https://www.anima.fan";
    var base_url = "http://localhost:8080";

    $(document).on("click", "a.follow-link", function () {
        var nickname = $("div#user-detail").data("nickname");
        var id = $(this).attr("id");
        if(id == "followings-link"){
            $(this).attr("href", base_url + "/user/" + nickname + "/followings");
        }else{
            $(this).attr("href", base_url + "/user/" + nickname + "/followers");
        }
    })

    $(document).on("click", "button.follow-button", function () {
        var user_id = $(this).data('user_id');
        var follow_button = $(this).attr('class');
        if(follow_button.indexOf('active') == -1){
            $(this).addClass("active btn-success");
            $(this).removeClass("btn-outline-success");
            if($("#followers-link")){
                var before_follows_count = $("#followers-link").text();
                var after_follows_count = $("#followers-link").text(Number(before_follows_count)+1);
            }

            var after_follow = $(this).text(following);

            //ajaxで読み出し
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type : 'POST',
                url : base_url + '/follow/store',
                dataType: 'json',
                data : {
                    'user_id' : user_id,
                },
            })
            // Ajaxリクエストが成功した時発動
            .done(function(response){
                $("button#follow-button-"+user_id).attr("data-follow_id", response);
            });
        }else{
            $(this).removeClass("active").removeClass("btn-success");
            $(this).addClass("btn-outline-success");
            if($("#followers-link")){
                var before_follows_count = $("#followers-link").text();
                var after_follows_count = $("#followers-link").text(Number(before_follows_count)-1);
            }

            var after_unfollow = $(this).text(follow);

            var follow_id = $(this).attr('data-follow_id');

            $("button#follow-button-"+user_id).attr("data-follow_id", "");
            //ajaxで読み出し
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type : 'POST',
                url : base_url + '/follow/delete',
                dataType: 'json',
                data : {
                    'follow_id' : follow_id,
                },
            })
            // Ajaxリクエストが成功した時発動
            .done(function(){
            });
        }
    });
});
