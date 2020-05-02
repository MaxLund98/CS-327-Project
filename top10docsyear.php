<!DOCTYPE html>
<html>
	<head>
		<title>Search for Documents</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
	</head>
	<body>
		<?php
			session_start();
			include 'utility.php';
			validateLibrarian();
			$conn = getSQLConnection();
			$result = $conn->query(
				"SELECT title, checkout_count "
			.	"FROM document, "
			.		"(SELECT borrowed_doc, count(*) checkout_count "
			.		"FROM loans "
			.		"WHERE YEAR(borrow_date) = YEAR(CURDATE()) "
			.		"GROUP BY borrowed_doc "
			.		"ORDER BY count(*) DESC "
			.		"LIMIT 10) "
			.	"WHERE document_pk = borrowed_doc ");
			if($result == False){
				echo "No results!";
				exit();
			}
			echo "<table> <tr> <th>Title</th> <th>Number of checkouts</th> </tr>";
			while ($row = $result->fetch_assoc()) {
				$fname = $row["first_name"];
				$lname = $row["last_name"];
				$checkouts = $row["checkout_count"];
				echo "<tr> <td><b>$fname $lname</b></td> <td>$checkout_count</td> </tr>";
			}
			echo "</table>";
			
		?>
	</body>
</html>