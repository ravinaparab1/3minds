<?php    
    $prevQuery = "SELECT * FROM `users` WHERE oauth_provider = '".$userData['oauth_provider']."' AND oauth_uid = '".$userData['oauth_uid']."'";
      $prevResult = $db->query($prevQuery);
      if($prevResult->num_rows > 0){
          // Update user data if already exists
          $query = "UPDATE `users` SET name = '".$userData['name']."', link = '".$userData['link']."' WHERE oauth_provider = '".$userData['oauth_provider']."' AND oauth_uid = '".$userData['oauth_uid']."'";
          $update = $db->query($query);
      }else{
          // Insert user data
          $query = "INSERT INTO `users` SET oauth_provider =  '".$userData['oauth_provider']."' , oauth_uid = '".$userData['oauth_uid']."', name = '".$userData['name']."', link = '".$userData['link']."'";
          $insert = $db->query($query);
      }
?>