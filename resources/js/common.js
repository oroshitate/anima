$(function() {
    var created_list = $("p.created-date");
    for (var i = 0; i < created_list.length; i++) {
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

    var $setElm_name = $('.name-length'); // 省略する文字のあるセレクタを取得
    var cutFigure_name = '14'; // 表示する文字数
    var afterTxt_name = ' …'; // 文字カット後に表示するテキスト

    $setElm_name.each(function(){
        var textLength = $(this).text().length;  // 文字数を取得
        var textTrim = $(this).text().substr(0,cutFigure_name) // 表示する数以上の文字をトリムする

        if(cutFigure_name < textLength) { // 文字数が表示数より多い場合
            $(this).html(textTrim + afterTxt_name).css({visibility:'visible'}); // カット後の文字数に…を追加
        } else if(cutFigure_name >= textLength) { // 文字数が表示数以下の場合
            $(this).css({visibility:'visible'}); // そのまま表示
        }
    });

    var $setElm_content = $('pre.content-length'); // 省略する文字のあるセレクタを取得
    var cutFigure_content = '140'; // 表示する文字数
    var afterTxt_content = ' …'; // 文字カット後に表示するテキスト

    $setElm_content.each(function(){
        var textLength = $(this).text().length;  // 文字数を取得
        var textTrim = $(this).text().substr(0,cutFigure_content) // 表示する数以上の文字をトリムする

        if(cutFigure_content < textLength) { // 文字数が表示数より多い場合
            $(this).html(textTrim + afterTxt_content).css({visibility:'visible'}); // カット後の文字数に…を追加
        } else if(cutFigure_content >= textLength) { // 文字数が表示数以下の場合
            $(this).css({visibility:'visible'}); // そのまま表示
        }
    });

    var url = location.href;
    if(url.indexOf("/search") != -1){
        $("li#switch-search-button").addClass("active");
        $("div#search-box").css({"display":"block"});
        $("li#switch-search-button").empty();
        $("li#switch-search-button").prepend("<i class='fas fa-times text-white fa-2x'></i>");
    }

    var url = location.href;
    if(url.indexOf("/review") != -1){
        var footer_height = $("div#create-comment-footer").height();
        var body_height = $("div#app").height();
        $("div#app").css("height", body_height + footer_height);
    }

    $("li#switch-search-button").on("click", function(){
        var switch_search_button = $(this).attr("class");
        if(switch_search_button.indexOf('active') == -1){
            $(this).addClass("active");
            $("div#search-box").css({"display":"block"});
            $(this).empty();
            $(this).prepend("<i class='fas fa-times text-white fa-2x'></i>");
        }else{
            $(this).removeClass("active");
            $("div#search-box").css({"display":"none"});
            $(this).empty();
            $(this).prepend("<i class='fas fa-search text-white fa-2x'></i>");
        }
    })

    $("button#search-button").on('click', function(){
        $(this).prop("disabled", true);
        var keyword = $("input[name='keyword']").val();
        if(keyword == "" || keyword == undefined){
            location.reload();
            return;
        }
        var route = $("form[name='search']").attr('action');
        var url = route + "/" + keyword;
        $("form[name='search']").attr({'action' : url});
        $("form[name='search']").submit();
    });

    // $('.grid-index').masonry({
    //     itemSelector: '.grid-item',
    //     columnWidth: '.grid-sizer',
    //     percentPosition: true
    // });
});
