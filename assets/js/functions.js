jQuery(document).ready(function($) {
    var stickyNavTop = $('#primary-navigation').offset().top;
    
    var stickyNav = function(){
        var scrollTop = $(window).scrollTop();
           
        if (scrollTop >= stickyNavTop) { 
            $('#primary-navigation').addClass('primary-navigation-fixed');
        } else {
            $('#primary-navigation').removeClass('primary-navigation-fixed'); 
        }
    };
    
    stickyNav();
    
    $(window).scroll(function() {
      stickyNav();
    });
    
    
    $('table tr:nth-child(even)').addClass('even');
    
    $('a:has(img)').addClass('image-link');
});