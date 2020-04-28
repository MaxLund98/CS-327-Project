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
			if(!validateFromSession("uname")){
				echo
					"You are not supposed to be here!",
					"<br><a href='index.php'>Login</a> to continue.";
				return;
			}
			echo
				$_SESSION["fullname"],"<br>",
				"<a href='readermenu.php'>Return Home🏠</a>";
		?>
			<form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
				Document ID: <input type="text" name="docid" autocomplete="off"/><br><br>
				Title: <input type="text" name="title" /><br><br>
				Publisher: <input type="text" name="publisher" /><br><br>
				<input type="submit" value="Search" />&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="reset" value="Clear" /><br><br>
			</form>
		<?php
			$conn = getSQLConnection();
			if($conn->connect_error){
				die("Connection failed: " . $conn->connect_error);
			}
			//echo "Connected successfully<br>";
			
			$docid = getFromGET("docid");
			$title = getFromGET("title");
			$publisher = getFromGET("publisher");

			$sql = 
				"select document_pk, publisher, borrower, title "
			.	"from document "
			.	"where document_pk = '$docid' "
			.	"or title = '$title' "
			.	"or publisher = '$publisher'";
			
			$result = $conn->query($sql);
			if($result->num_rows == 0){
				echo "<h2>Sorry! No results found</h2>";
				return;
			}
			while ($row = $result->fetch_assoc()) {
				$title = $row["title"];
				$docid = $row["document_pk"];
				$publisher = $row["publisher"];
				$borrower = $row["borrower"];
				echo
					"<b>$title</b><br>",
					"Document ID: $docid<br>",
					"Publisher: $publisher<br>";	 				
				if($borrower == NULL){
					echo "This document is available.<br>";
		?>
					<form method="post" action="checkout.php?document_pk=<?php echo "$docid"; ?>&title=<?php echo "$title"; ?>">
						<input type="submit" value="Checkout" />&nbsp;&nbsp;&nbsp;&nbsp;
						<!-- <input type='hidden' name='var' value='<?php echo "$var"; ?>' /> -->
					</form>
		<?php
				}else if($borrower == $_SESSION["uname"]){
		?>
						<form method="post" action="return.php?document_pk=<?php echo "$docid"; ?>&title=<?php echo "$title"; ?>">
							<input type="submit" value="Return" />&nbsp;&nbsp;&nbsp;&nbsp;
							<!-- <input type='hidden' name='var' value='<?php echo "$var"; ?>' /> -->
						</form>
		<?php
				}else{
					echo "This document is currently checked out.<br>";
				}
			}
		?>
	</body>
</html>
