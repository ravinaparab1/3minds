<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  require 'dbconfig.php';
  if (!mysqli_connect_errno()){
      $prevQuery = "SELECT * FROM `admin` WHERE username = '".$_POST['username']."' AND password = '".$_POST['password']."'";
      $prevResult = $db->query($prevQuery);
      if($prevResult->num_rows == 1){
        header('Location: dashboard.php');
      }
  }
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>The Facebook-Twitter-Google-Login Website Template | Home :: w3layouts</title>
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href='http://fonts.googleapis.com/css?family=Rokkitt' rel='stylesheet' type='text/css'>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
</head>
<body>
<div class="wrap vertical-center" id="dashboard_login">
<!-- strat-contact-form --> 
<div class="contact-form">
<!-- start-form -->
  <form class="contact_form" action="#" method="post" name="contact_form">
    <h1 class="text-center">Dashboard Login</h1>
      <ul>
          <li>
              <input type="text" class="textbox1" name="username" placeholder="Username" required />
               <p><img src="images/contact.png" alt=""></p>
          </li>
          <li>
              <input type="password" name="password" class="textbox2" placeholder="Password" required="">
              <p><img src="images/lock.png" alt=""></p>
          </li>
         </ul>
          <input type="submit" name="Sign In" value="Sign In"/>
    <div class="clear"></div> 
  </form>
<!-- end-form -->
<div class="clear"></div> 
</div>
</div>
</body>
</html>
