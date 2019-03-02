$(function() {
    $("button#share-twitter-button").on("click", function(){
        var share_twitter_class = $(this).attr("class");
        if(share_twitter_class.indexOf("active") !== -1){
            $(this).addClass("btn-secondary");
            $(this).removeClass("btn-primary text-white active");
            $("input[name='share']").val("");
        }else {
            $(this).addClass("btn-primary text-white active");
            $(this).removeClass("btn-secondary");
            $("input[name='share']").val("on");
        }
    });

    $("input#slider").on("change",function(){
        var score = $(this).val();
        $("span#slider-count").text(score);
    });

    $("input#edit-review-slider").on("change",function(){
        var score = $(this).val();
        $("span#edit-slider-count").text(score);
    });

    $("button#create-review-modal-button").on("click", function(){
        var item_id = $(this).data("item_id");
        $("input[name='item_id']").val(item_id);
    });

    $("button#create-review-button").on("click", function(){
        $(this).prop("disabled", true);
        $("form[name='create-review']").submit();
    });

    $("button#edit-review-button").on("click", function(){
        $(this).prop("disabled", true);
        $("form[name='edit-review']").submit();
    });

    $("button#delete-review-button").on("click", function(){
        $(this).prop("disabled", true);
        $("form[name='delete-review']").submit();
    });

    $(document).on("click", "button.review-modal-button", function () {
        var review_id = $(this).data("review_id");
        var score= $(this).data("score");
        var content = $(this).data("content");
        $("input#edit-review-slider").val(score);
        $("span#edit-slider-count").text(score);
        $("input#edit-review-id").val(review_id);
        $("textarea#edit-review-content").val(content);
        $("input#delete-review-id").val(review_id);
    });
});
