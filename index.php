<?php
if (!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on") 
	{
        header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        exit;
    }


require_once __DIR__.'/google-api-php-client/vendor/autoload.php';

// setup google client
$g_client = new Google_Client();
$g_client->setAuthConfigFile('../das_permitted/client_secret.json');
$g_client->setRedirectUri("https://localhost/das/google_oauth2_callback.php");
$g_client->setScopes("https://www.googleapis.com/auth/userinfo.profile");
$auth_url = $g_client->createAuthUrl();

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
		<br/><a href="HttpDigest.php">Login via http digest</a>
		<br/>
		<?php echo "</br><a href='$auth_url'>Login via Google</a>"; ?>
	</body>
</html>