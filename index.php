<?php
if (!session_id()) {
    session_start();
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Brandex Dashboard Login</title>
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href='http://fonts.googleapis.com/css?family=Rokkitt' rel='stylesheet' type='text/css'>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
</head>
<body>
<div class="wrap vertical-center">
<!-- strat-contact-form -->	
<div class="contact-form">
<!-- start-account -->
<div class="account">
	<h1 class="text-center">Join Us @ Brandex!</h1>
	<div class="span">
	<?php
	require_once 'facebook-php-sdk/autoload.php';
		$fb = new Facebook\Facebook([
		  'app_id' => '1886782914918529',
		  'app_secret' => '0fc3bb372cef7da2564d6f965e1c949a',
		  'default_graph_version' => 'v2.10',
		]);
		 	
		$helper = $fb->getRedirectLoginHelper();	 
		$loginUrl = $helper->getLoginUrl('http://localhost/ravina_3minds/'); 
		echo '<a href="' . htmlspecialchars($loginUrl) . '"><img src="images/facebook.png" alt=""/><i>Sign In with Facebook</i><div class="clear"></div></a>';
	?>
    </div>	
    <div class="span1">
    <?php
	require_once 'src/twitteroauth.php';
	$consumerKey    = 'F2HYf87kTJPyaBLjkYuZhxwjq';
	$consumerSecret = 'bxWllOKzDC3s4TqQyzNg5rmiuMaivsNm7FqjnlF0cYeF4atvek';
	$redirectURL    = 'http://localhost/ravina_3minds/dashboard_login.php';
	//If OAuth token not matched
	if(isset($_REQUEST['oauth_token']) && $_SESSION['token'] !== $_REQUEST['oauth_token']){
	    //Remove token from session
	    unset($_SESSION['token']);
	    unset($_SESSION['token_secret']);
	} 
	//If user not verified 
	if(isset($_REQUEST['oauth_token']) && $_SESSION['token'] == $_REQUEST['oauth_token']){
		//Call Twitter API
	    $twClient = new TwitterOAuth($consumerKey, $consumerSecret, $_SESSION['token'] , $_SESSION['token_secret']);
	    
	    //Get OAuth token
	    $access_token = $twClient->getAccessToken($_REQUEST['oauth_verifier']);
	    
	    //If returns success
	    if($twClient->http_code == '200'){
	        //Storing access token data into session
	        $_SESSION['status'] = 'verified';
	        $_SESSION['request_vars'] = $access_token;
	        
	        //Get user profile data from twitter
	        $user_profile = $twClient->get('account/verify_credentials');
	         $userData = array(
      			'oauth_provider'=> 'Twitter',
      			'oauth_uid' => $user_profile->id,
      			'name'    	  => $user_profile->name,
  				'link'          => 'https://twitter.com/'.$user_profile->screen_name
  			);
	    //Storing user id into session
        $_SESSION['USER'] = $user_profile;
        
        //Remove oauth token and secret from session
        unset($_SESSION['token']);
        unset($_SESSION['token_secret']);
        //insert user profile in database
        require 'dbconfig.php';
	  	if (!mysqli_connect_errno()){
	    	require 'dboperations.php';
	  	}
        header('Location: dashboard_login.php');
	    }
	    else{
        	echo 'Some problem occurred, please try again.';
    	}
	}
	else{
		//Fresh authentication
    $twClient = new TwitterOAuth($consumerKey, $consumerSecret);
    $request_token = $twClient->getRequestToken($redirectURL);
    
    //Received token info from twitter
    $_SESSION['token'] = $request_token['oauth_token'];
    $_SESSION['token_secret'] = $request_token['oauth_token_secret'];
    
    //If authentication returns success
    if($twClient->http_code == '200'){
        //Get twitter oauth url
        $authUrl = $twClient->getAuthorizeURL($request_token['oauth_token']);
        echo '<a href="' . filter_var($authUrl, FILTER_SANITIZE_URL) . '"><img src="images/twitter.png" alt=""/><i>Sign In with Twitter</i><div class="clear"></div></a>';
	}
	}
	?>
    </div>
    <div class="span2">
    <?php
    require_once 'src/Instagram.php';
    use MetzWeb\Instagram\Instagram;
    $instagram = new Instagram(array(
	'apiKey' => '1888be13f18644039c15195b63990f49',
	'apiSecret' => '73c5fa1fdd7242f88bddd6c3bb9f2aad',
	'apiCallback' => 'http://localhost/ravina_3minds/instagram.php' // Callback URL
	));
	// create login URL
	$loginUrl = $instagram->getLoginUrl();
    ?>
    <a href="<?php echo $loginUrl ?>"><img src="images/instagram.png" alt=""/><i>Sign In with Instagram</i><div class="clear"></div></a></div>
</div>	
<?php
try {
	if(isset($_GET['state'])){
		$_SESSION['FBRLH_state']=$_GET['state'];
  		$accessToken = $helper->getAccessToken();
	}
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
 
if (! isset($accessToken)) {
  if ($helper->getError()) {
    header('HTTP/1.0 401 Unauthorized');
    echo "Error: " . $helper->getError() . "\n";
    echo "Error Code: " . $helper->getErrorCode() . "\n";
    echo "Error Reason: " . $helper->getErrorReason() . "\n";
    echo "Error Description: " . $helper->getErrorDescription() . "\n";
  } else {
    header('HTTP/1.0 400 Bad Request');
  }
  exit;
}
// Logged in
// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();
 
// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
if (isset($tokenMetadata)) {
 try {
 	$response = $fb->get('/me?fields=name,email,gender,link', $accessToken);
 } catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
$user_profile = $response->getGraphUser();
 $userData = array(
      'oauth_provider'=> 'Facebook',
      'oauth_uid' => $tokenMetadata->getField('user_id'),
      'name'    	  => $user_profile['name'],
      'link'          => $user_profile['link']
  );
  $_SESSION['USER'] = $user_profile; 
  require 'dbconfig.php';
  if (!mysqli_connect_errno()){
    	require 'dboperations.php';
  }
  header('Location: dashboard_login.php');
 }
?>
<!-- end-account -->
<div class="clear"></div>	
</div>>
</div>
</body>
</html>