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
				echo 
					$_SESSION["fullname"], " logged out successfully.<br>",
					"<a href=\"index.php\">Return</a>";
				session_destroy();
			}else{
				echo "<a href=\"index.php\">Return</a>";
			}
		?>
	</body>
</html>