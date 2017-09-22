$(document).ready( function() {
    $('#fileTree').fileTree({ root: '/', loadMessage: 'Loading...' }, function(file) {
        alert(file);
    });
});