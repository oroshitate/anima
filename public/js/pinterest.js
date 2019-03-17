$(function(){
    var cnt = 0;
    var waiting = setInterval(function(){
        if(cnt == 1) {
            $('.grid-index').masonry({
                itemSelector: '.grid-item',
                columnWidth: '.grid-sizer',
                percentPosition: true
            });

            clearInterval(waiting);
        }
        cnt++;
      }, 500);
});
