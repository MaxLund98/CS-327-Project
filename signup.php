<!DOCTYPE html>
<html>
	<head>
		<title>Create New User</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
	</head>
	<body>
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off">
			<table>
				<tr> <td>First Name</td>	<td colspan="2"><input type="text" name="firstname"/></td> </tr>
				<tr> <td>Last Name</td>	<td colspan="2"><input type="text" name="lastname"/></td> </tr>
				<tr> <td>User ID</td>	<td colspan="2"><input type="text" name="userid"/></td> </tr>
				<tr> <td>Password</td>	<td colspan="2"><input type="text" name="password1"/></td> </tr>
				<tr> <td>Retype Password</td>	<td colspan="2"><input type="text" name="password2"/></td> </tr>
				<tr> <td></td> <td><input type="submit" value="Create User" id="create user"></td>
					<td><input type="reset" value="Clear"/></td></tr>
				<tr> <td colspan = "3">Already have an account? Sign in <a href="index.php">here</a>.</td> </tr>
			</table>
		</form>

		<?php
			include "utility.php";
			session_start();
			
			$fname = getFromPOST("firstname");
			$lname = getFromPOST("lastname");
			$userid = getFromPOST("userid");
			$password = getFromPOST("password1");
			$password_retype = getFromPOST("password2");
			if($userid==""){
				exit();
			}
			if("$password" != "$password_retype"){
				echo "Passwords do not match! $password $password_retype";
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
			$result = $conn->query(
				"insert into reader(first_name,last_name,reader_pk,password)" .
				"values('$fname','$lname','$userid','$password')");
			echo "<a href='index.php'>Login</a>";
			$conn->close();
		?>
	</body>
</html>
