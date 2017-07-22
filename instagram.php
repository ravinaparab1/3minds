<?php
require 'src/Instagram.php';
use MetzWeb\Instagram\Instagram;
// initialize class
$instagram = new Instagram(array(
	'apiKey' => '1888be13f18644039c15195b63990f49',
	'apiSecret' => '73c5fa1fdd7242f88bddd6c3bb9f2aad',
	'apiCallback' => 'http://localhost/ravina_3minds/instagram.php'// must point to success.php
));
// receive OAuth code parameter
$code = $_GET['code'];
// check whether the user has granted access
if (isset($code)) {
    // receive OAuth token object
    $user_profile = $instagram->getOAuthToken($code,false);
	if(empty($user_profile))
	{
		header('Location: index.php');
	}
	else
	{
		session_start();
        $_SESSION['USER'] = $user_profile;
       	$userData = array(
      		'oauth_provider'=> 'Instagram',
      		'oauth_uid' => $user_profile->user->id,
      		'name'    	  => $user_profile->user->full_name,
  			'link'          => "https://www.instagram.com/ravup93/".$user_profile->user->username
  		);
        //insert user profile in database
        require 'dbconfig.php';
  		if (!mysqli_connect_errno()){
    		require 'dboperations.php';
  		}
        header('Location: dashboard_login.php');
	}
} else {
    // check whether an error occurred
    if (isset($_GET['error'])) {
        echo 'An error occurred: ' . $_GET['error_description'];
    }
}
?>