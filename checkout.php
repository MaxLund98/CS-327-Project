<!DOCTYPE html>
<html>
	<head>
		<title>Welcome to the City Library System</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
	</head>
	<body>
		<?php
			include 'utility.php';
			session_start();
			$docid = $_GET["document_pk"];
			$title = $_GET["title"];
			echo "Checking out ", $title, "...";
			
			$conn = getSQLConnection();
			//Create the SQL query
			$uname = $_SESSION["uname"];
			$sql = 
				"update document "
			.	"set borrower='$uname' "
			.	"where document_pk = '$docid'";
			echo $sql;
			
			if($conn->query($sql)){
				header("Location: search.php?docid=" . $docid);
			}else{
				echo "Failed to checkout.";
			}
		?>
	</body>
</html>