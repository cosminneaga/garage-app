<?php
if(!defined('user-log-in'))
{
	header('Location: ../../user-portal.php');
}
else
{
	
	define('functions',TRUE);
	require('functions.php');
	$user_err = $pass_err = $gen_err = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if (!empty($_POST['username']))
		{
			$username = clean_input($_POST['username']);
		}
		else
		{
			$user_err = "Please enter your Username";
		}
		if (!empty($_POST['password']))
		{
			if(preg_match("/^[a-zA-Z0-9@#~!`()=+-_|*\,&.<>?]*$/", $_POST['password']))
			{
				$password = clean_input($_POST['password']);
			}
		}
		else
		{
			$pass_err = "Please enter your Password";
		}
		if(empty($user_err)&&empty($pass_err)&&empty($gen_err))
		{
			$extract = new extract();
			$data = $extract->extractLGNUser($conn, $username);
			
			$usernameF = $data["username"];
			$passwordF = $data["password"];
			$statusF = $data["status"];
			$ownedBy = $data["owned_by"];
			$level = $data["auth_level"];

			if ($statusF == 'blocked')
			{
				$gen_err = "Your account has been blocked. Please contact administrator.";
			}
			elseif (!empty($usernameF))
			{
				if ($passwordF == "".md5($password)."")
					{
						session_start();
						$_SESSION['username'] = $usernameF;
						$_SESSION['own'] = $ownedBy;
						$_SESSION['level'] = $level;
						header("Location: user/cpanel.php");
					}
				else
					{
						$pass_err = "Wrong password.";
					}		
			}
			else
			{
				$gen_err = "Username does not exists in our records.";
			}
		}
    }
}

?>