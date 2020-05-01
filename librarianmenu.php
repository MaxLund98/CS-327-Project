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
			validateFromSession("uname");
			echo
				$_SESSION["fullname"],
				"<h2>Welcome ", $_SESSION["uname"],"<br>";
		?>
		<a href='top10readers.php'>Find Top 10 Readers</a><br>
		<a href='top10docsyear.php'>Find Top 10 Documents (This year)</a><br>
		<a href='top10docs.php'>Find Top 10 Documents (All time)</a><br>
		<a href="logout.php">Sign Out</a>
	</body>
</html>