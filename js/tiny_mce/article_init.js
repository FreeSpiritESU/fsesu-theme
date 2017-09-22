tinyMCE.init(
{
   // General options
   mode : 'exact',
   elements : 'article',
   theme : 'advanced',
   plugins : 'safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template',

   // Theme options
   theme_advanced_buttons1 : 'bold,italic,underline,strikethrough,|,undo,redo,|,cleanup,|,bullist,numlist,blockquote,|,justifyleft,justifycenter,justifyright,justifyfull',
   theme_advanced_buttons2 : 'formatselect,fontselect,fontsizeselect,iespell,help,code,|,outdent,indent',
   theme_advanced_buttons3 : 'link,unlink,anchor,image,media,advhr,visualchars,|,insertdate,inserttime,preview,|,forecolor,backcolor',
   theme_advanced_toolbar_align : 'left',
   width : 390,
   height : 300,

   // Content CSS
   content_css : "./../css/stylesheet3.css",
});

tinyMCE.init(
{
   // General options
   mode : 'exact',
   elements : 'summary',
   theme : 'simple',
   
   width : 390,
   height : 50,
   
   // Content CSS
   content_css : "./../css/stylesheet3.css",
});