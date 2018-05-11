<?php
require_once __DIR__.'/google-api-php-client/vendor/autoload.php';

if(!isset($_SESSION))
{
	session_start();
}

// setup google client
$g_client = new Google_Client();
$g_client->setAuthConfigFile('../das_permitted/client_secret.json');
$g_client->setRedirectUri('https://' . $_SERVER['HTTP_HOST'] . '/das/google_oauth2_callback.php');
$g_client->setScopes("https://www.googleapis.com/auth/userinfo.profile");

//
$code = isset($_GET['code']) ? $_GET['code'] : NULL;

if(isset($code)) // authorization code recieved
{
	// exchange authorization code for access token
	try
	{
		$g_client->authenticate($code);
		$access_token = $g_client->getAccessToken();
	} catch (Exception $e) {
		// log exception - don't display it      
	}
    
	// use access token to call google API
	try
	{
        $g_client->setAccessToken($access_token);
    } catch (Exception $e){
		// log exception - don't display it      
    }
	
	// retrieve payload (= user information - in this case)
    try
	{
        $pay_load = $g_client->verifyIdToken();	
    } catch (Exception $e) {
		// log exception - don't display it    
    }

} else
{
    $pay_load = null;
}

if(isset($pay_load)){

	// if login was successful, save username and redirect
	$service = new Google_Service_Oauth2($g_client);
	$user = $service->userinfo->get();
	//$_SESSION['g_username'] = $user->name;
	$_SESSION['user'] = $user->name;
	$_SESSION['nick'] = $user->name;
	$_SESSION['google'] = true;

	$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/das/Guestbook.php';
	header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));

}
?>