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
			waitForSubmission("checkout","post");
			$uname = validateReader();
			$conn = getSQLConnection();
			$docid = getFromPOST("docid");
			$docnum = getFromPOST("docnum");
			$title = getFromPOST("title");
			echo "Checking out ", $title, "...";
			$sql = 
				"insert into loan(borrower,borrowed_doc,borrow_date) "
			.	"values('$uname','$docid',CURDATE())";
			echo $sql;
			
			if($conn->query($sql)){
				header("Location: search.php?docid=" . $docid);
			}else{
				echo "Failed to checkout.";
			}
		?>
	</body>
</html>
