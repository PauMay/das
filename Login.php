<form action="Login.php" method="POST">

<?php	
	function print_login()
	{
		echo '
			<table>
				<tr>
					<td>
						Username: 
					</td>
					<td>
						<input type="text" name="user"> </br>
					</td>
				</tr>
				<tr>
					<td>
						Password: 
					</td>
					<td>
						<input type="password" name="pass"> </br>
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						<input type="checkbox" name="merken"> Remember me
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						<button type="submit" name="in"> Login </button>
					</td>
				</tr>
			</table>
		';
	}
	
	function check_login($user, $pass)
	{
		require_once "config.php";
		$conn = new mysqli($hostname, $u, $pwd, $dbname);

		if(mysqli_connect_errno())
		{
			echo "Login failed";
			print_login();
			return;
		}
        $sql = "SELECT Benutzername, nickname FROM login WHERE Benutzername = ? AND Passwort = ?;";
			
        $stmt = $conn->prepare($sql);
		$stmt->bind_param('ss', $user, md5($pass));
		$stmt->execute();

		$res = $stmt->get_result();
		if ($res != false) 
		{
			if (mysqli_num_rows($res) == 1) 
			{
				while ($u = mysqli_fetch_object($res)) 
				{
					$_SESSION['user'] = $u->Benutzername;
					$_SESSION['nick'] = $u->nickname;
					if(isset($_POST['merken']))
					{
						setcookie('name', $user, time()+2000, null, null, true);
						setcookie('pass', $pass, time()+2000, null, null, true);
					}
					echo "logged in";
					header('Location: '.'Guestbook.php');
				}
			}
			else
			{
				echo "Login failed";
				print_login();
			}
		}
		else
		{
			echo 'Login failed';
			print_login();
		}
	}

	session_set_cookie_params(0);
	session_start();

    if (!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on") 
	{
        header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        exit;
    }

	
    if(isset($_POST['user'])) 
	{
        if (isset($_POST['pass'])) 
		{
            check_login($_POST['user'], $_POST['pass']);
        }
    }
	else if(isset($_COOKIE['name']))
	{
		if(isset($_COOKIE['pass']))
		{
			check_login($_COOKIE['name'], $_COOKIE['pass']);
		}
	}
	else if(isset($_SESSION['user']))
	{
		if(isset($_SESSION['nick']))
		{
			echo "logged in";
			header('Location: '.'Guestbook.php');
		}
		else
		{
			print_login();
		}
	}
	else
	{
		print_login();
	}

?>

</form>