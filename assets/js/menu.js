jQuery(document).ready(function($) {
    var stickyNavTop = $('#primary-navigation').offset().top;
    
    var stickyNav = function(){
    var scrollTop = $(window).scrollTop();
         
    if (scrollTop > stickyNavTop) { 
        $('#primary-navigation').addClass('sticky');
    } else {
        $('#primary-navigation').removeClass('sticky'); 
    }
    };
    
    stickyNav();
    
    $(window).scroll(function() {
        stickyNav();
    });
});