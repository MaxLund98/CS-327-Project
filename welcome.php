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
			$password = getFromPOST("password"]);
			//Create the SQL query
			$sql =
				"select first_name, last_name, reader_pk, usertype from reader" .
				" where reader_pk = '$userid'" .
				" and password = '$password'";
			//Run the query
			$result = $conn->query($sql);
			if($result->num_rows == 0){
				echo "<h2>Sorry! Wrong username / password!</h2>";
				echo "<br><a href='index.php'>Try again</a>";
				return;
			}
			$row = $result->fetch_assoc();
			//Set Session Variables
			session_start();
			$_SESSION["uname"] = $row["reader_pk"];
			$_SESSION["fullname"] = $row["first_name"] . " " . $row["last_name"];
			$usertype = $row["usertype"];
			echo "<h2>Welcome ", $_SESSION["fullname"];
			if($usertype == "reader"){
				header("Location: readermenu.php");
				// write menu with links here
			}else if($usertype == "librarian"){
				echo "<br>Librarian Menu</br>";
				// write menu with links here
			}
			$conn->close();
		?>
		<br>
		<a href="logout.php">Sign Out</a>
	</body>
</html>