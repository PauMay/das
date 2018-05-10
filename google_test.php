<?php
if(!isset($_SESSION))
{
	session_start();
}

if (isset($_SESSION['g_username']))
{
	echo "Willkommen beim Google-Login-Test, ".$_SESSION['g_username']."!";
}
else
{
	echo "Willkommen :-(";
}
?>