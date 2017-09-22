$(document).ready(function(){
    $('.event a').click(function() {
        var content_show = $(this).attr("id"); 
        $('#wrapper').after("<div id='ajax'></div><div id='loading'>Loading...</div><div id='ajaxBox'><div id='ajaxBoxTitle'><div id='ajaxBoxClose'><a><img src='/images/close.png' title='Close' alt='Close' /></a></div></div><div id='ajaxBoxContents'></div></div>"),
        $.ajax({
            method: "get",url: "/unitinfo/details.php",data: "id="+content_show,
            beforeSend: function(){$("#loading").show("fast");},
            complete: function(){ $("#loading").hide("fast");},
            success: function(html){
                showPopup();
                $("#ajaxBoxContents").html(html);
            }
        });

        $('#ajax').click(function() {
            hidePopup();
        });

        $('#ajaxBoxClose').click(function() {
            hidePopup();
        });
    });
    
    
    
});  



function hidePopup(){
    //disables popup only if it is enabled
    $("#ajax").fadeOut("slow").remove();
    $("#ajaxBox").fadeOut("slow").remove();
    $("#loading").fadeOut("slow").remove();
}



function centrePopup(){
    var windowWidth = document.documentElement.clientWidth;
    var windowHeight = document.documentElement.clientHeight;
    var popupWidth = $("#ajaxBox").width();

    $("#ajaxBox").css({
        "top": windowHeight/4,
        "left": windowWidth/2-popupWidth/2
    });


    $("#ajax").css({
        "height": windowHeight
    });

}


function showPopup() {
    centrePopup();
    $("#ajax").css({"opacity": "0.75"}).fadeIn("slow");
    $("#ajaxBox").show("slow");
}


