$(function() {
    $(document).on("click", "div.reply-box", function () {
        var comment_id = $(this).data("reply_id");
        var comment_li_id = "comment-li-" + comment_id;
        $("html,body").animate({scrollTop:$("li#"+comment_li_id).offset().top});
    });

    $(document).on("click", "div.reply-button", function () {
        var comment_id = $(this).data("comment_id");
        var user_nickname = $(this).data("user_nickname");
        var reply_to = "@" + user_nickname + "";
        $("<div id='reply-group' class='col-md-2'>\
              <div class='row align-items-center justify-content-center h-100 bg-secondary rounded'>\
                  <p class='mb-0 text-white'>To " + reply_to + "</p>\
              </div>\
          </div>\
          <div id='cancel-reply-box' class='ml-md-2 mr-md-4'>\
              <button type='button' id='cancel-reply-button' class='btn btn-secondary'><i class='fas fa-times text-white fa-1x'></i></button></   div>").prependTo("div#footer-comment-group");

        $("textarea#comment-content").focus();
        $("input[name='reply_id']").val(comment_id);
    });

    $(document).on("click", "button#cancel-reply-button", function () {
        $("div#reply-group").remove();
        $("div#cancel-reply-box").remove();
        $("input[name='reply_id']").val("");
    });

    $("span#edit-comment-footer-button").on("click", function(){
        $("div#create-comment-footer").css("display","none");
        $("div#edit-comment-footer").css("display","block");
    });

    $("button#edit-comment-cancel-button").on("click", function(){
        $("div#edit-comment-footer").css("display","none");
        $("div#create-comment-footer").css("display","block");
    });

    $("button#create-comment-button").on("click", function(){
        $(this).prop("disabled", true);
        var review_id = $(this).data("review_id");
        $("input#create-comment-review-id").val(review_id);
        $("form[name='create-comment']").submit();
    });

    $("button#edit-comment-button").on("click", function(){
        $(this).prop("disabled", true);
        $("form[name='edit-comment']").submit();
    });

    $("button#delete-comment-button").on("click", function(){
        $(this).prop("disabled", true);
        $("form[name='delete-comment']").submit();
    });

    $(document).on("click", "button.comment-modal-button", function () {
        var comment_id = $(this).data("comment_id");
        var content = $(this).data("content");
        $("input#edit-comment-id").val(comment_id);
        $("textarea#edit-comment-content").val(content);
        $("input#delete-comment-id").val(comment_id);
    });
});
