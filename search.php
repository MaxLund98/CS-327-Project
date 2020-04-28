<!DOCTYPE html>
<html>
	<head>
		<title>Search for Documents</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
	</head>
	<body>
		<?php
			session_start();
			if(isset($_SESSION["uname"]) && $_SESSION["uname"]!=""){
				echo $_SESSION["fullname"];
				echo "<br>";
		?>
				<form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					Document ID:  <input type="text" name="docid"/>
					<br><br>
					Title: <input type="text" name="title"/>
					<br><br>
					Author: <input type="text" name="author"/>
					<br><br>
					<input type="submit" value="Search"/>&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="reset" value="Clear"/>
					<br><br>
				</form>
		<?php
			}else{
				echo "You are not supposed to be here!<br>";
				echo "<a href='index.php'>Login</a> to continue.";
			}
		?>
	</body>
</html>
