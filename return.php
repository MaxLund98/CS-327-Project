<!DOCTYPE html>
<html>
	<head>
		<title>Welcome to the City Library System</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
	</head>
	<body>
		<?php
			session_start();
			include 'utility.php';
			waitForSubmission("return","post");
			$uname = validateReader();
			$conn = GetSQLConnection();
			
			$docid = $_POST["docid"];
			$docnum = $_POST["docnum"];
			$title = $_POST["title"];
			echo "Returning $title...";
			
			$result = $conn->query(
				"update loan "
			.	"set return_date = CURDATE() "
			.	"where borrower = '$uname' "
			.	"and docid = $docid "
			.	"and docnum = $docnum "
			.	"and return_date is NULL");
			//Run the query
			if($result != false){
					header("Location: search.php?docid=$docid");
			}else{
					echo "Failed to return.";
			}
		?>
	</body>
</html>