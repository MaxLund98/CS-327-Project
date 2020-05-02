<!DOCTYPE html>
<html>
	<head>
		<title>Top 10 Documents</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
	</head>
	<body>
		<?php
			session_start();
			include 'utility.php';
			validateLibrarian();
			$conn = getSQLConnection();
			
			$result = $conn->query(
				"select title, count(*) checkout_count "
			.	"from document, document_copy, loan "
			.	"where document_pk = base_document "
			.	"and doc_copy = copy_number "
			.	"group by document_pk "
			.	"order by count(*) DESC "
			.	"limit 10");
			if($result == False || $result == NULL || $result->num_rows == 0){
				echo "No results!";
				exit();
			}
			echo "<table> <tr> <th>Document Title</th> <th>Number of checkouts</th> </tr>";
			while ($row = $result->fetch_assoc()) {
				$title = $row["title"];
				$checkouts = $row["checkout_count"];
				echo "<tr> <td><b>$title</b></td> <td>$checkouts</td> </tr>";
			}
			echo "</table>";
			
		?>
	</body>
</html>