<!DOCTYPE html>
<html>
	<head>
		<title>Welcome to the City Library System</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
	</head>
	<body>
		<form method="post" action="welcome.php">
			User ID:  <input type="text" name="userid"/>
			<br><br>
			Password: <input type="password" name="password"/>
			<br><br>
			<input type="submit" value="Login"/>&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="reset" value="Clear"/>
			<br><br>
			Don't have an account? Sign up <a href="signup.php">here</a>.
		</form>
	</body>
</html>
