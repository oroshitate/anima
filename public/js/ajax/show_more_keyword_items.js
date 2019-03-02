$(function(){
  var end_flag = 0;
  if(end_flag == 0){
      $(document).on("click", "button#show-more-keyword-items-button", function () {
          $("div#show-more-keyword-items").empty();
          var keyword = $("input[name='keyword']").val();
          var filter = $("#keyword-items").data("filter");
          var keyword_items_li = $("#keyword-items").find("li");
          var keyword_items_count = keyword_items_li.length;
          var base_url = "http://localhost:8080";
          //ajaxで読み出し
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
              type : 'POST',
              url : base_url + '/ajax/keyword-items/show',
              dataType: 'json',
              data : {
                  'keyword' : keyword,
                  'count' : keyword_items_count,
              },
          })
          // Ajaxリクエストが成功した時発動
          .done(function(response){
              $(response).appendTo("ul#keyword-items");
              var keyword_items_li_after =  $('ul#keyword-items').find('li');
              var keyword_items_count_after = keyword_items_li_after.length;
              if(keyword_items_count_after < 20 + keyword_items_count){
                  $("<div class='text-center mb-md-5'>\
                      <p class='h4 text-danger'>Show "+ keyword_items_count_after + " Reviews</p>\
                  </div>").appendTo("div#show-more-keyword-items");
                  end_flag=1;
              }else {
                  $("<div class='text-center mb-md-5'>\
                      <p class='h4 text-danger'>Show "+ keyword_items_count_after + " Reviews</p>\
                  </div>\
                  <div class='text-center mb-md-5'>\
                      <button type='button' id='show-more-keyword-items-button' class='btn btn-outline-secondary w-100'>さらに読み込む</button>\
                  </div>").appendTo("div#show-more-keyword-items");
              }
          });
      })
  }
});
