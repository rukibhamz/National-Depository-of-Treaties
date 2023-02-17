<?php
function check_login()
{
if(strlen($_SESSION['sudo_id'])==0)
	{
		$host = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$extra="pages_sudo_index.php";
		$_SESSION["sudo_id"]="";
		header("Location: http://$host$uri/$extra");
	}
}
?>
