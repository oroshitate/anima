$(function() {
    $('button#search').on('click', function(){
        $keyword = $("input[name='keyword']").val();
        $route = $("form[name='search']").attr('action');
        $url = $route + "/" + $keyword;
        $("form[name='search']").attr({'action' : $url});
    });
});
