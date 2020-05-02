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
			validateLibrarian();
			
			if(isset($_POST["clear"])){
				unset($_SESSION["credits"]);
				unset($_POST["title"]);
				unset($_POST["publisher"]);
				unset($_POST["docid"]);
				unset($_POST["copies"]);
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
					<td colspan="2"><select name="doc_table">
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
				<tr> <td>Copies</td> <td colspan="2"><input type="text" name="copies" value=<?php echo getFromPOST("copies")?>></td> </tr>
				<tr> <td></td> <td><input type="submit" value="Add Credit" name="add_credit"/></td> <td></td> </tr>
				<tr> <td></td> <td><input type="submit" value="Add Document" id="add_document" name="add_document"/></td> <td><input type="submit" value="Clear" name="clear"/></td> </tr>
			</table>
		</form>
		<?php
			waitForSubmission("add_document", "post");
			$title = getFromPOST("title");
			$pub_name = getFromPOST("publisher");
			$docid = intval(getFromPOST("docid"));
			$conn = getSQLConnection();
			$publisher_pk = intval(getOrAddPublisher($pub_name, $conn));
			$sql=	"insert into document (document_pk, publisher, title) "
			.	"values ($docid, $publisher_pk, '$title')";
			$result = $conn->query($sql);
			if($result == False){
				echo "Base document already exists.<br>";
			}
			$doc_table = getFromPOST("doc_table");
			$sql=	"insert into $doc_table ($doc_table"."_pk) "
			.	"values ($docid)";
			$result = $conn->query($sql);
			foreach($credits as $credit_entry){
				if($credit_entry == ""){
					continue;
				}
				$credit_table = getCreditTable($doc_table);
				addCredit($docid, $doc_table, $credit_entry, $credit_table, $conn);
			}
			$copies = intval(getFromPOST("copies"));
			if($copies==0){$copies=1;}
			for($i=0; $i < $copies; $i++){
				$sql = 
					"insert into document_copy (base_document) "
				.	"values ($docid)";
				$result = $conn->query($sql);
				if($result == false){
					echo "failed.";
				}
			}
			echo "$copies copies added.<br>";
			echo "<a href=\"welcome.php\">Return home</a><br>";
			$conn->close();
		?>
	</body>
</html>
