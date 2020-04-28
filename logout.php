<!DOCTYPE html>
<html>
	<head>
		<title>Logout</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
	</head>
	<body>
		<?php
			session_start();
			include 'utility.php';
			if(validateFromSession("uname")){
				echo $_SESSION["fullname"], " logged out successfully.";
				session_destroy();
			}
		?>
	</body>
</html>