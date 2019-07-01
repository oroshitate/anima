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
        $("<div id='reply-group' class='col-11 col-md-9 row align-items-center mb-2'>\
              <p class='mb-0 text-white border'>To " + reply_to + "</p>\
              <div id='cancel-reply-box'>\
                  <button type='button' id='cancel-reply-button' style='background:none; border:none;'>\
                      <img src='"+ base_url + "/xbutton.png' class='header-icon'>\
                  </button>\
              </div>\
          <div>").prependTo("div#footer-comment-group");

        $("textarea#comment-content").focus();
        $("input[name='reply_id']").val(comment_id);
    });

    $(document).on("click", "button#cancel-reply-button", function () {
        $("div#reply-group").remove();
        $("input[name='reply_id']").val("");
    });

    $("li#edit-comment-footer-button").on("click", function(){
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
