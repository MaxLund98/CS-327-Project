<!DOCTYPE html>
<html>
	<head>
		<title>Welcome to the City Library System</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
	</head>
	<body>
		<?php
			session_start();
			$docid = $_GET["document_pk"];
			$title = $_GET["title"];
			echo "Returning $title...";
			include 'utility.php';
			$conn = GetSQLConnection();
			//Create the SQL query
			$uname = $_SESSION["uname"];
			$sql = 
				"update document "
			. "set borrower = NULL "
			. "where document_pk = '$docid'";
			echo $sql;

			//Run the query
			if($conn->query($sql)){
					header("Location: search.php?docid=$docid");
			}else{
					echo "Failed to checkout.";
			}
		?>
	</body>
</html>