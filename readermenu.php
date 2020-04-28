<!DOCTYPE html>
<html>
	<head>
			<title>City Library Home</title>
			<link rel="stylesheet" type="text/css" href="styles.css">
	</head>
	<body>
		<?php
			session_start();
			include 'utility.php';
			if(validateFromSession("uname")){
				echo
					$_SESSION["fullname"],
					"<h2>Welcome ", $_SESSION["uname"],"<br>",
					"<a href='search.php'>Search for Documents</a>";
			}else{
				echo
					"<h2>Sorry! Wrong username / password!</h2><br>",
					"<a href='index.php'>Try again</a>";
			}
		?>
		<br>
		<a href="logout.php">Sign Out</a>
	</body>
</html>