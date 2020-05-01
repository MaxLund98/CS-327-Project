<!DOCTYPE html>
<html>
	<head>
		<title>Welcome to the City Library System</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
	</head>
	<body>
		<h1>Welcome to the Marburg Public Library</h1>
		<form method="post" action="welcome.php" autocomplete="off">
			<table>
				<tr> <td>User ID:</td> <td colspan="2"><input type="text" name="userid"/></td> </tr>
				<tr> <td>Password:</td> <td colspan="2"><input type="text" name="password"/></td> </tr>
				<tr> <td></td> <td><input type="submit" value="Login" name="login"/></td> <td><input type="reset" value="Clear"/></td> </tr>
			<table>
			Don't have an account? Sign up <a href="signup.php">here</a>
		</form>
	</body>
</html>
