<?php
   
   if ($session->logged_in)
   {
      $user_links = "
               <div class='user'>
                  <ul>
                     <li>Welcome {$session->userdata['forename']}</li>
                     <li><a href='{$fs['members']}account.php' title='My Account'>My Account</a></li>";
                    // <li><a href='{$fs['members']}prefs.php' title='Preferences'>Preferences</a></li>";
      if ($session->userdata['userlevel'] > 5)
      {
         $user_links .= "
                     <li><a href='{$fs['admin']}' title='Site Admin Panel'>Site Admin Panel</a></li>";
      }
      $user_links .= "
                     <li><a href='{$fs_root}login.php?logout' title='Logout'>Logout</a></li>
                  </ul>";
      $user_links .= "
               </div>";
   }
   else
   {
      $user_links = "
               <div class='user'>
                  <form method='post' action='{$fs_root}login.php'>
                     <table class='login' cellspacing='0'>
                        <th colspan='2'><h3>Login</h3></th>
                        <tr>
                           <td style='width: 75px'>Username : </td>
                           <td style='padding: 3px 0'><input type='text' name='username'/></td>
                        </tr>
                        <tr>
                           <td style='width: 75px'>Password : </td>
                           <td style='padding: 3px 0'><input type='password' width='10' name='password'/></td>
                        </tr>
                        <tr>
                           <td style='text-align: center; padding: 10px 0 0'>
                              <input type='checkbox' name='remember' style='margin: 0 auto'/>
                           </td>
                           <td style='padding: 10px 0 0; text-align: left'>Remember me</td>
                        </tr>
                        <tr>
                           <td colspan='2' style='text-align: center'>
                              <p><input type='submit' value='Submit' name='login' style='margin: 0 auto'/></p>
                           </td>
                        </tr>
                     </table>
                  </form> 
               </div>";
   }
   
 
 ?>