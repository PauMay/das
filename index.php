<?php
require_once __DIR__.'/google-api-php-client/vendor/autoload.php';

session_start();

// setup google client
$g_client = new Google_Client();
$g_client->setClientId("127519901009-d6di364446faheeq2aaaqvpnm1dh891u.apps.googleusercontent.com");
$g_client->setClientSecret("DzERhutnLzrSa8SoHq_2p08D");
$g_client->setRedirectUri("https://localhost/das/google_oauth2_callback.php");
//$g_client->setRedirectUri("http://localhost/das/google_oauth2_callback_test.php");
$g_client->setScopes("https://www.googleapis.com/auth/userinfo.profile");
$auth_url = $g_client->createAuthUrl();

// check for access token, otherwise redirect
if (isset($_SESSION['access_token']) && $_SESSION['access_token'])
{
  $g_client->setAccessToken($_SESSION['access_token']);
}


?>

<!DOCTYPE html>

<html>
	<header>
		<title>
			Logins
		</title>
	</header>
	<body>
		<a href="Login.php"> Login Formular </a>
		<br/>		
	<?php echo "<a href='$auth_url'> Login with Google </a>"; ?>
		<br/>
		<a href=""> Login http </a>
	</body>
</html>