<!DOCTYPE html>
<html>
	<head>
		<title>Logout</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
	</head>
	<body>
		<?php
			session_start();
			if(isset($_SESSION["uname"]) && $_SESSION["uname"]!=""){
				echo $_SESSION["fullname"] . " logged out successfully.";
				session_destroy();
			}        
		?>
	</body>
</html>
