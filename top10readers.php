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
				"select first_name, last_name, count(*) checkout_count "
			.	"from reader, loan "
			.	"where reader_pk = borrower "
			.	"group by reader_pk "
			.	"order by count(*) DESC "
			.	"limit 10");
			if($result == False || $result == NULL || $result->num_rows == 0){
				echo "No results!";
				exit();
			}
			echo "<table> <tr> <th>Reader Name</th> <th>Number of checkouts</th> </tr>";
			while ($row = $result->fetch_assoc()) {
				$fname = $row["first_name"];
				$lname = $row["last_name"];
				$checkouts = $row["checkout_count"];
				echo "<tr> <td><b>$fname $lname</b></td> <td>$checkouts</td> </tr>";
			}
			echo "</table>";
			
		?>
	</body>
</html>