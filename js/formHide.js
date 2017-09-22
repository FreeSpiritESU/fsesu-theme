function showForm(id) 
{
   document.getElementById(id).style.display = 'block';
   document.getElementById('show').style.display = 'none';
   document.getElementById('hide').style.display = 'block';
}
function hideForm(id) 
{
   document.getElementById(id).style.display = 'none';
   document.getElementById('show').style.display = 'block';
   document.getElementById('hide').style.display = 'none';
}