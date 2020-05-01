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
				"SELECT first_name, last_name, checkout_count"
			.	"FROM reader, "
			.		"(SELECT borrower, count(*) checkout_count"
			.		"FROM loans"
			.		"GROUP BY borrower"
			.		"ORDER BY count(*) DESC"
			.		"LIMIT 10)"
			.	"WHERE reader.reader_pk = borrower");
			if($result == False){
				echo "No results!";
				exit();
			}
			echo "<table> <tr> <th>Reader Name</th> <th>Number of checkouts</th> </tr>";
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