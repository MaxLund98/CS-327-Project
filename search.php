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
			$uname = validateUser();
			
		?>
			<form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" autocomplete="off">
				<table>
					<tr> <td>Document ID:</td> <td colspan="2"><input type="text" name="docid" /></td> </tr>
					<tr> <td>Title:</td> <td colspan="2"><input type="text" name="title" /></td> </tr>
					<tr> <td>Publisher:</td> <td colspan="2"><input type="text" name="publisher" /></td> </tr>
					<tr> <td></td> <td><input type="submit" value="Search" name="search"/></td> <td><input type="reset" value="Clear" /></td> </tr>
				</table>
			</form>
		<?php
			waitForSubmission("search","get");
			$docid = getFromGET("docid");
			$title = getFromGET("title");
			$publisher = getFromGET("publisher");
			
			$conn = getSQLConnection();
			$result = $conn->query(
				"select document_pk, publisher, title, copies_free, user_checked_out "
			.	"from document, "
			
			.		"(select count(*) copies_free "
			.		"from document_copy, loan"
			.		"where document_copy.base_document = $docid"
			.		"and not (loan.doc_id = $docid and loan.return_date is null)), "
			
			.		"(select count(*) user_checked_out "
			.		"from loan "
			.		"where loan.docid = $docid "
			.		"and loan.borrower = '$uname' "
			.		"and loan.return_date is null)"
			
			.	"where document_pk = '$docid' "
			.	"or title = '$title' "
			.	"or publisher = '$publisher'");
			
			if($result==False || $result->num_rows == 0){
				$conn->close();
				echo "<h2>Sorry! No results found</h2>";
				exit();
			}
			echo "<table><tr> <th>Title</th> <th>Document ID</th> <th>Publisher</th> <th>Status</th> <th></th> </tr>";
			while ($row = $checkout_result->fetch_assoc()) {
				$title = $row["title"];
				$docid = $row["document_pk"];
				$publisher = $row["publisher"];
				$copies_free = $row["copies_free"];
				echo
					"<tr>",
					"<td><b>$title</b></td>",
					"<td>$docid</td>",
					"<td>$publisher</td>";
				if($copy_checked_out > 0){
		?>
					<td>Holding</td>
					<td><form method="get" action="return.php?document_pk=<?php echo "$docid"; ?>&title=<?php echo "$title"; ?>">
						<input type="submit" value="Return" name="return"/>
					</form></td>
		<?php
				}else{
					echo "<td>$copies_free Available</td>";
					if($copies_free > 0){
		?>
						<td><form method="get" action="checkout.php?document_pk=<?php echo "$docid"; ?>&title=<?php echo "$title"; ?>">
							<input type="submit" value="Checkout" name="checkout"/>
						</form></td>
		<?php
		
					}else{
						echo "<td></td>";
					}
				}
				echo "</tr>";
			}
			echo "</table>";
		?>
	</body>
</html>