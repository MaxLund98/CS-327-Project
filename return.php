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
			$uname = validateReader();
			
			$copy_number = getFromGET("copy_number");
			$conn = GetSQLConnection();
			$sql = 
				"update loan "
			.	"set return_date = CURDATE() "
			.	"where borrower = '$uname' "
			.	"and doc_copy = $copy_number "
			.	"and return_date is NULL";
			$result = $conn->query($sql);
			if($result == False){
					echo "Failed to return.";
			}else{
					echo
						"Return successful!<br>",
						"<a href = \"search.php\">Return to search</a>";
			}
		?>
	</body>
</html>