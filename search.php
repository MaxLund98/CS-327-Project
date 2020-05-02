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
			$uname = validateReader();
			
		?>
			<form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" autocomplete="off">
				<table>
					<tr> <td>Document ID:</td> <td colspan="2"><input type="text" name="docid" /></td> </tr>
					<tr> <td>Title:</td> <td colspan="2"><input type="text" name="title" /></td> </tr>
					<tr> <td>Publisher:</td> <td colspan="2"><input type="text" name="publisher" /></td> </tr>
					<tr> <td></td> <td><input type="submit" value="Search" id="search"/></td> <td><input type="reset" value="Clear" /></td> </tr>
				</table>
			</form>
		<?php
			#waitForSubmission("search","get");
			$docid = intval(getFromGET("docid"));
			$title = getFromGET("title");
			$publisher = getFromGET("publisher");
			if("$docid"."$title"."$publisher" == ""){
				exit();
			}
			
			$conn = getSQLConnection();
			#$result = $conn->query(
			$sql =	"select document_pk, publisher, title "
			. "from document "
			.	"where document_pk = $docid "
			.	"or title = '$title' "
			.	"or publisher = '$publisher'";
			$result = $conn->query($sql);
			if($result == False || $result == NULL || $result->num_rows == 0){
				$conn->close();
				echo "<h2>Sorry! No results found</h2>";
				exit();
			}
			echo "<table><tr> <th>Title</th> <th>Document ID</th> <th>Publisher</th> <th>Status</th> <th></th> </tr>";
			while ($row = $result->fetch_assoc()) {
				$title = $row["title"];
				$docid = $row["document_pk"];
				$publisher = $row["publisher"];
				echo
					"<tr>",
					"<td><b>$title</b></td>",
					"<td>$docid</td>",
					"<td>$publisher</td>";
					
					#$result = $conn->query(
					$sql =
						"select copy_number "
					.	"from document_copy "
					.	"where base_document = $docid "
					.	"and copy_number in ("
					.		"select doc_copy "
					.		"from loan "
					.		"where borrower = '$uname' "
					.		"and return_date is null)";
					$result = $conn->query($sql);
					if($result != False && $result != NULL && $result->num_rows != 0){
						$copy_number = $result->fetch_assoc()["copy_number"];
		?>
					<td>Holding</td>
					<td><form method="get" action="return.php">
						<input type="submit" value="Return"/>
						<input type="hidden" name="copy_number" value=<?php echo "$copy_number"; ?>>
					</form></td>
		<?php
				}else{
					$result = $conn->query(
						"select count(*) copies_free "
					.	"from document_copy "
					.	"where base_document = $docid "
					.	"and copy_number not in ("
					.		"select doc_copy "
					.		"from loan "
					.		"where return_date is null)");
					$copies_free = intval($result->fetch_assoc()["copies_free"]);
					echo "<td>$copies_free Available</td>";
					if($copies_free > 0){
		?>
						<td><form method="get" action="checkout.php">
							<input type="submit" value="Checkout"/>
							<input type="hidden" name="document_pk" value=<?php echo "$docid"; ?>>
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