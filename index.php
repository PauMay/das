<?php
require_once __DIR__.'/google-api-php-client/vendor/autoload.php';

session_start();

// setup google client
$g_client = new Google_Client();
$g_client->setAuthConfigFile('../das_permitted/client_secret.json');
$g_client->setRedirectUri("https://localhost/das/google_oauth2_callback.php");
$g_client->setScopes("https://www.googleapis.com/auth/userinfo.profile");
$auth_url = $g_client->createAuthUrl();

// check if access token already exists, otherwise redirect
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
		<br/><a href="Login.php">Login via formular</a>
		<br/>		
	<?php echo "</br><a href='$auth_url'>Login via Google</a>"; ?>
		<br/>
		<br/><a href="HttpDigest.php">Login via http digest</a>
	</body>
</html>