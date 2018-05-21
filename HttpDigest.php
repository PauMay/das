<?php

/* begin (pseudo) check certificate */
/*
	$our_cert_file = file_get_contents('../das_permitted/server.crt');
	$our_cert = openssl_x509_parse($our_cert_file);

	$sent_cert = $_SERVER['SSL_CLIENT_VERIFY'];
	
	// check certificate and compare it with our certificate
	if (($sent_cert == 'SUCCESS')
		&& ($_SERVER['SSL_CLIENT_M_SERIAL'] == $our_cert['serialNumber'])
		&& ($_SERVER['SSL_CLIENT_V_END'] >= strtotime('today'))
	{
		// only then do all the rest...
	}
*/	
/* end (pseudo) check certificate  */

function hmac_http_auth($realm = "Realm")
{
	if( ! empty($_SERVER['PHP_AUTH_DIGEST']))
	{
		// Decode the data the client gave us
		$default = array('nounce', 'nc', 'cnounce', 'qop', 'username', 'uri', 'response');
		preg_match_all('~(\w+)="?([^",]+)"?~', $_SERVER['PHP_AUTH_DIGEST'], $matches);
		$data = array_combine($matches[1] + $default, $matches[2]);
		
		
		require_once "config.php";
		$conn = new mysqli($hostname, $u, $pwd, $dbname);

		if(mysqli_connect_errno())
		{
			echo "Login fehlgeschlagen";
			return;
		}
        $sql = "SELECT Benutzername, nickname, Passwort, realm FROM login WHERE Benutzername = ?;";
			
        $stmt = $conn->prepare($sql);
		$stmt->bind_param('s', $data['username']);
		$stmt->execute();
		
		$res = $stmt->get_result();
		$pw = "";
		$nickname = "";
		$username = "";
		$rlm = "";
		if ($res != false) 
		{
			if (mysqli_num_rows($res) == 1) 
			{
				
				while ($u = mysqli_fetch_object($res)) 
				{
					$pw = $u ->Passwort;
					$nickname = $u -> nickname;
					$username = $u -> Benutzername;
					$rlm = $u -> realm;
					echo "User found";
				}
			}
		}
		
		
		//$pwHash = md5($users[$data['username']]);
		//$A1 = md5($data['username'] . ':' . $realm . ':' . $pw);
		$A2 = md5(getenv('REQUEST_METHOD').':'.$data['uri']);
		$valid_response = md5($rlm.':'.$data['nonce'].':'.$data['nc'].':'.$data['cnonce'].':'.$data['qop'].':'.$A2);
		// Compare with what was sent
		if($data['response'] === $valid_response)
		{ 
			$_SESSION['user'] = $username;
			$_SESSION['nick'] = $nickname;
			$_SESSION['csrf_token'] = uniqid('', true);
			return TRUE;
		}
	}
	// Failed, or haven't been prompted yet
	header('HTTP/1.1 401 Unauthorized');
	header('WWW-Authenticate: Digest realm="' . $realm.
		'",qop="auth",nonce="' . uniqid() . '",opaque="' . md5($realm) . '"');
	exit();
}


		
// Fetch some users from the database or a config file

session_set_cookie_params(0);
session_start();

hmac_http_auth();
header('Location: '.'Guestbook.php');