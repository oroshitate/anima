$(function(){
  var end_flag = 0;
  if(end_flag == 0){
      $(document).on("click", "button#show-more-keyword-users-button", function () {
          $("div#show-more-keyword-users").empty();
          var keyword = $("input[name='keyword']").val();
          var keyword_users_li =  $("#keyword-users").find("li");
          var keyword_users_count = keyword_users_li.length;
          var base_url = "http://localhost:8080";
          //ajaxで読み出し
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
              type : 'POST',
              url : base_url + '/ajax/keyword-users/show',
              dataType: 'json',
              data : {
                  'keyword' : keyword,
                  'count' : keyword_users_count,
              },
          })
          // Ajaxリクエストが成功した時発動
          .done(function(response){
            $(response).appendTo("ul#keyword-users");
            var keyword_users_li_after =  $('ul#keyword-users').find('li');
            var keyword_users_count_after = keyword_users_li_after.length;
            var follow_buttons = $("button.follow-button");
            for(var i = 0; i < follow_buttons.length; i++){
                var follow_id = follow_buttons[i].dataset.follow_id;
                var user_id = follow_buttons[i].dataset.user_id;
                if(follow_id == "" || follow_id == undefined){
                    $("button#follow-button-"+user_id).text("フォローする");
                }else{
                    $("button#follow-button-"+user_id).text("フォロー中");
                }
            }

            if(keyword_users_count_after < 20 + keyword_users_count){
                end_flag=1;
            }else {
                $("<div class='text-center mb-5'>\
                    <button type='button' id='show-more-keyword-users-button' class='btn btn-outline-secondary w-100'>さらに読み込む</button>\
                </div>").appendTo("div#show-more-keyword-users");
            }
          });
      })
  }
});
$(function(){

});
