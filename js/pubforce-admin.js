jQuery(function($) {	
    $( "#fs_events_startdate" ).datepicker({ dateFormat: 'D, j M Y' });
    $(".fsdate").datepicker({
    dateFormat: 'D, j M, Y',
    showOn: 'button',
    buttonImage: '../images/icon-datepicker.png',
    buttonImageOnly: true,
    numberOfMonths: 3

    });
});