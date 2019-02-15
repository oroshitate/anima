$(function() {
    $("#slider").slider({
          value:0,
          min:0,
          max:5,
          step:0.1,
          range:"min",
          change : function( event, ui ){
              $("#slider-count").text(ui.value);
          }
    });

    $("#review").on("click", function(){
        var score = $("#slider").slider("option", "value");
        $("input[name='score']").val(score);
    })
});
