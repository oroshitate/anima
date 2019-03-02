$(function() {
    $("input#link-twitter").on("click",function(){
        $(this).prop("disabled", true);
        $("form[name='link-twitter']").submit();
    });
    $("input#link-facebook").on("click", function(){
        $(this).prop("disabled", true);
        $("form[name='link-facebook']").submit();
    });
    $("input#link-goole").on("click", function(){
        $(this).prop("disabled", true);
        $("form[name='link-google']").submit();
    });
});
