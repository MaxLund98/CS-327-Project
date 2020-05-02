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
			$uname = validateReader();
			echo
				$_SESSION["fullname"],
				"<h2>Welcome $uname<br>",
				"<a href='search.php'>Search for Documents</a>";
		?>
		<br>
		<a href="logout.php">Sign Out</a>
	</body>
</html>