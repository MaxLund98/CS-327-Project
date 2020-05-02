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
			
			$docid = getFromGET("document_pk");
			
			$conn = getSQLConnection();
			$result = $conn->query(
				"select copy_number "
			.	"from document_copy "
			.	"where base_document = $docid "
			.	"and copy_number not in ("
			.		"select doc_copy "
			.		"from loan "
			.		"where return_date is null)");
			if($result == False || $result == NULL || $result->num_rows == 0){
				echo "Failed to checkout.";
				exit();
			}
			$copy_number = $result->fetch_assoc()["copy_number"];
			$result = $conn->query(
				"insert into loan(borrower,doc_copy,borrow_date) "
			.	"values('$uname','$copy_number',CURDATE())");
			if($result == False || $result == NULL){
				echo "Failed to checkout.";
			}else{
				echo
					"Checkout successful!<br>",
					"<a href = \"search.php\">Return to search</a>";
			}
		?>
	</body>
</html>
