<?php
	if(!isset($_SESSION))
	{
		session_start();
	}
	
	if (!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on") 
	{
        header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        exit;
    }
	
	function addPost($post) 
	{
		require "config.php";
		$conn = new mysqli($hostname, $u, $pwd, $dbname);

		if(mysqli_connect_errno())
		{
			echo "Error when posting";
			return;
		}
		
        $sql = "INSERT INTO `posts` (`userId`, `post`) VALUES (?, ?);";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $_SESSION['nick'], $post);
        $stmt->execute();
    }

    function getPosts() 
	{
		require "config.php";
		$conn = new mysqli($hostname, $u, $pwd, $dbname);

		if(mysqli_connect_errno())
		{
			echo "No comments";
			return;
		}
		
        $sql = "SELECT * from posts";
        $res = mysqli_query($conn, $sql);

        if ($res != false) 
		{
			if (mysqli_num_rows($res) >= 1) 
			{
                echo "<table cellpadding='0' cellspacing='0' id='allPosts'>";
                while ($posts = mysqli_fetch_object($res)) {
                    echo "</br>". htmlentities($posts->userId) . " wrote:</br><i style=font-weight:italic;>" . htmlentities($posts->post). "</i><br/>";
                }
                echo "</table>";
            } else 
			{
                echo "No comments";
            }
        } 
		else 
		{
            echo "No comments";
        }
    }
	
	// setup google client
	require_once __DIR__.'/google-api-php-client/vendor/autoload.php';
	$g_client = new Google_Client();
	$g_client->setAuthConfigFile('../das_permitted/client_secret.json');
	
	if(isset($_SESSION['user']))
	{
		if(isset($_SESSION['nick']))
		{
			echo '<form action="Guestbook.php" method="POST">';
			
			echo "Logged in as ";
			echo $_SESSION['nick'];
			echo '<br/>';
			echo '
				<button type="submit" name="out"> Logout </button>
				<br/>
			';
					
			if (isset($_POST['out'])) 
			{
				echo 'logged out';
				setcookie("name", null, time() - 1);
				setcookie("pass", null, time() - 1);
				session_destroy();

				if(isset($_SESSION['google']))
				{
					if ($_SESSION['google'])
					{
						$g_client->revokeToken(); // google logout
					}
				}
				
				header("Refresh:0");
			}
			if(isset($_POST['komm']))
			{
				addPost($_POST['kommentar']);
			}
			echo '<br/>';
			echo '<p style="font-size:110%;font-weight:bold;"><u>Guestbook</u></p>';
			echo 
				'Post your comment:
				<input type="text" name="kommentar"> </br>
				<button type="submit" name="komm"> Post </button>
				</form>
			';
			
			getPosts();
		}
		else
		{
			header('Location: '.'index.php');
		}
	}
	else
	{
		header('Location: '.'index.php');
	}
?>