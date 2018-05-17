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
		<a href="Login.php"> Login Formular </a>
		<br/>		
	<?php echo "<a href='$auth_url'> Login with Google </a>"; ?>
		<br/>
		<a href="HttpDigest.php"> Login http </a>
	</body>
</html>