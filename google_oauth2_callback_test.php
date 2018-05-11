<?php
require_once __DIR__.'/google-api-php-client/vendor/autoload.php';

if(!isset($_SESSION))
{
	session_start();
}

$g_client = new Google_Client();
$g_client->setAuthConfigFile('../das_permitted/client_secret.json');
$g_client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/das/google_oauth2_callback_test.php');
$g_client->setScopes("https://www.googleapis.com/auth/userinfo.profile");

$code = isset($_GET['code']) ? $_GET['code'] : NULL;

if(isset($code)) {
	try {
		$g_client->authenticate($code);
	} catch (Exception $e) {
		echo "authenticate error: ".$e->getMessage()."\r\n";    
	}
	
	try {
		$token = $g_client->getAccessToken();
	} catch (Exception $e) {
		echo "token error: ".$e->getMessage()."\r\n";     
	}
    
	try {
        $g_client->setAccessToken($token);
    } catch (Exception $e){
		echo "get access error: ".$e->getMessage()."\r\n";   
    }

    try {
        $pay_load = $g_client->verifyIdToken();	
    } catch (Exception $e) {
		echo "payload error: ".$e->getMessage()."\r\n";    
    }

} else{
    $pay_load = null;
}

if(isset($pay_load)){

	$service = new Google_Service_Oauth2($g_client);
	$user = $service->userinfo->get();
	$_SESSION['g_username'] = $user->name;

  $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/das/google_test.php';
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));

}
?>