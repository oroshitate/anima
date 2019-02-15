$(function(){
    var end_flag = 0;
    if(end_flag == 0){
        $('button#show-more').on('click', function(){
            var items_li =  $("#items").find("li");
            var items_count = items_li.length;
            var base_url = "http://localhost:8080"
            //ajaxで読み出し
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type : 'POST',
                url : base_url + '/ajax',
                dataType: 'json',
                data : {
                    'count' : items_count,
                },
            })
            // Ajaxリクエストが成功した時発動
            .done(function(response){
                for(var i=0; i < response.length; i++){
                    $("<li><a href=" + base_url + "/items/" + response[i].item_id + "><img src=/storage/images/items/" + response[i].image + ".jpg><br></a></li>").appendTo("#items");
                }
                if(response.length < 20){
                    end_flag=1;
                }
            });
        })
    }
});
