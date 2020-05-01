<!DOCTYPE html>
<html>
	<head>
		<title>Create New User</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
	</head>
	<body>
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off">
			<table>
				<tr> <td>First Name</td>	<td><input type="text" name="firstname"/></td> </tr>
				<tr> <td>Last Name</td>	<td><input type="text" name="lastname"/></td> </tr>
				<tr> <td>User ID</td>	<td><input type="text" name="userid"/></td> </tr>
				<tr> <td>Password</td>	<td><input type="text" name="passsword1"/></td> </tr>
				<tr> <td>Retype Password</td>	<td><input type="text" name="password2"/></td> </tr>
				<input type="submit" value="Create User", name="create user"/>&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="reset" value="Clear"/><br><br>
				Already have an account? Sign in <a href="index.php">here</a>.
			</table>
		</form>

		<?php
			include "utility.php";
			waitForSubmission("create user", "post");
			
			
			$fname = getFromPOST("firstname");
			$lname = getFromPOST("lastname");
			$userid = getFromPOST("userid");
			$password = getFromPOST("password1");
			$password_retype = getFromPOST("password2");
			if($userid==""){
				echo "Invalid User ID!";
				exit();
			}
			if($password != $password_retype){
				echo "Passwords do not match!";
				exit();
			}
			//Create the SQL query
			$conn = getSQLConnection();
			$result = $conn->query(
				"select reader_pk from reader"
			.	" where reader_pk = '$userid'");
			if($result->num_rows > 0){
				echo "Sorry! That userid already exists!";
				exit();
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
