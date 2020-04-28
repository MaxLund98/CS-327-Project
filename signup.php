<!DOCTYPE html>
<html>
	<head>
		<title>Create New User</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
	</head>
	<body>
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off">
			First Name:	<input type="text" name="firstname"/><br><br>
			Last Name:	<input type="text" name="lastname"/><br><br>
			User ID:	<input type="text" name="userid"/><br><br>
			Password:	<input type="password" name="password1"/><br><br>
			Retype Password:	<input type="password" name="password2"/><br><br>
			<input type="submit" value="Create User"/>&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="reset" value="Clear"/><br><br>
			Already have an account? Sign in <a href="index.php">here</a>.
		</form>
		<?php
			include "utility.php";
			$conn = getSQLConnection();
			$fname = getFromPOST("firstname");
			$lname = getFromPOST("lastname");
			$userid = getFromPOST("userid");
			$password = getFromPOST("password1");
			if($userid==""){
				$conn->close();
				return;
			}
			//Create the SQL query
			$sql = 
				"select reader_pk from reader" .
				" where reader_pk = '$userid'";
			$result = $conn->query($sql);
			if($result->num_rows == 0){
				echo 
					"Sorry! That userid already exists!<br>",
					"<a href='signup.php'>Try again</a>";
				return;
			}
			$sql2 = 
				"insert into reader(first_name,last_name,reader_pk,password)" .
				"values('$fname','$lname','$userid','$password')";
			$result = $conn->query($sql2);
			echo 
				$sql2, "<br>",
				"<a href='index.php'>Login</a>";
			$conn->close();
		?>
</body>
</html>

