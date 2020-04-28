<!DOCTYPE html>
<html>
<head>
    <title>Welcome to the City Library System</title>
    <style>
    
        table, th, td, tr {
            border: solid black;
            border-collapse: collapse
        }
    </style>
</head>
<body>
<h1>Welcome to the Marburg Public Library</h1>
<form method="post" action="welcome.php">
    User ID:  <input type="text" name="userid" autocomplete="off"/>
	<br><br>
    Password: <input type="password" name="password" autocomplete="off"/>
    <br><br>
    <input type="submit" value="Login"/>&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="reset" value="Clear"/>
    <br><br>
    Don't have an account? Sign up <a href="signup.php">here</a>.
</form>
    
</body>
</html>
