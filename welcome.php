<!DOCTYPE html>
<html>
	<head>
		<title>City Library Home</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
	</head>
	<body>
		<?php
			include 'utility.php';
			$conn = getSQLConnection();
			$userid = getFromPOST("userid");
			$password = getFromPOST("password");
			#Check if user is Librarian
			$result = $conn->query(
				"select first_name, last_name, librarian_pk from librarian "
			.	"where librarian_pk = '$userid' "
			.	"and password = '$password'");
			if($result->num_rows > 0){
				$conn->close();
				$row = $result->fetch_assoc();
				session_start();
				$_SESSION["uname"] = $userid;
				$_SESSION["fullname"] = $row["first_name"] . " " . $row["last_name"];
				$_SESSION["usertype"] = "librarian";
				
				header("Location: librarianmenu.php");
				exit();
			}
			#Check if user is reader
			$result = $conn->query(
				"select first_name, last_name, reader_pk, usertype from reader"
			.	" where reader_pk = '$userid'"
			.	" and password = '$password'");
			if($result->num_rows > 0){
				$conn->close();
				$row = $result->fetch_assoc();
				
				session_start();
				$_SESSION["uname"] = $userid;
				$_SESSION["fullname"] = $row["first_name"] . " " . $row["last_name"];
				$_SESSION["usertype"] = "reader";
				
				header("Location: readermenu.php");
				exit();
			}
			echo "<h2>Sorry! Wrong username / password!</h2>";
			echo "<br><a href='index.php'>Try again</a>";
			exit();
		?>
		<br>
		<a href="logout.php">Sign Out</a>
	</body>
</html>