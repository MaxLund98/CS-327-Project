<!DOCTYPE html>
<html>
	<head>
		<title>Add Document</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
	</head>
	<body>
		<?php
			include 'utility.php';
			session_start();
			$uname = validateLibrarian();
			if(isset($_POST["clear"]) || isset($_POST["add_document"])){
				unset($_SESSION["credits"]);
				unset($_POST["title"]);
				unset($_POST["publisher"]);
				unset($_POST["docid"]);
			}
			if(!isset($_SESSION["credits"])){
				$_SESSION["credits"] = array();
			}
			
			$newcredit = getFromPOST("newcredit");
			if($newcredit != ""){
				array_push($_SESSION["credits"], $newcredit);
			}
			$credits = $_SESSION["credits"];
		?>
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off">
			<table>
				<tr> <td>Document Type</td>
					<td colspan="2"><select name="doctype">
						<option value="book">Book</option>
						<option value="journal">Journal</option>
						<option value="dvd">DVD</option>
					</select></td>
				</tr>
				<tr> <td>Title</td> <td colspan="2"><input type="text" name="title" value=<?php echo getFromPOST("title")?>> </td> </tr>
				<tr> <td>Publisher</td> <td colspan="2"><input type="text" name="publisher" value=<?php echo getFromPOST("publisher")?>></td> </tr>
				<tr> <td>ISBN/ID</td> <td colspan="2"><input type="text" name="docid" value=<?php echo getFromPOST("docid")?>></td> </tr>
				<?php
					echo "<tr> <td>Credits:</td>";
					foreach($credits as $credit_entry){
						echo '<td colspan="2">', "$credit_entry</td> </tr> <tr> <td></td>";
					}
					unset($credit_entry);
					echo "<td><input type=\"text\" name=\"newcredit\"/></td> </tr>";
				?>
				<tr> <td></td> <td><input type="submit" value="Add Credit" name="add_credit"/></td> <td></td> </tr>
				<tr> <td></td> <td><input type="submit" value="Add Document" name="add_document"/></td> <td><input type="submit" value="Clear" name="clear"/></td> </tr>
			</table>
		</form>
		<?php
			waitForSubmission("add_document", "post");
			$conn = getSQLConnection();
			print("adding");
			$doctype = getFromPOST("doctype");
			$title = getFromPOST("title");
			$publisher = getFromPOST("publisher");
			$docid = getFromPOST("docid");
			
			$conn->query(
				"insert into document(docid, publisher, title)"
			.	"values($docid, $publisher, $title)");
			
			$credits = getFromPOST("credits");
			
			$credit_table = getCreditTable($doctype);
			
			$conn->close();
		?>
	</body>
</html>
