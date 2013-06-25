$(document).ready(function() {
var stickyNavTop = $('#access').offset().top;

var stickyNav = function(){
var scrollTop = $(window).scrollTop();
     
if (scrollTop > stickyNavTop) { 
    $('#access').addClass('sticky');
} else {
    $('#access').removeClass('sticky'); 
}
};

stickyNav();

$(window).scroll(function() {
    stickyNav();
});
});