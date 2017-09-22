function showFiles(id) 
{
   document.getElementById('1'.id).style.display = 'block';
   document.getElementById('2'.id).innerHTML = "<a href='' onclick='hideFiles(\"".id."\"); return false;'>[-]</a>';
}

function hideFiles(id, folder) 
{
   document.getElementById('1'.id).style.display = 'none';
   document.getElementById('2'.id).innerHTML = "<a href='' onclick='showFiles(\"".id."\"); return false;'>[+]</a>';
}