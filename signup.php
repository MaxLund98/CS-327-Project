<!DOCTYPE html>
<html>
<head>
    <title>Create New User</title>
    <style>
    
        table, th, td, tr {
            border: solid black;
            border-collapse: collapse
        }
        
    </style>
</head>
<body>
 
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    First Name:  <input type="text" name="firstname" autocomplete="off"/>
	<br><br>
    Last Name:  <input type="text" name="lastname" autocomplete="off"/>
	<br><br>
    User ID:  <input type="text" name="userid" autocomplete="off"/>
	<br><br>
    Password: <input type="password" name="password1" autocomplete="off"/>
    <br><br>
    Retype Password: <input type="password" name="password2" autocomplete="off"/>
    <br><br>
	(For Librarians) Access Passoword:: <input type="password" name="librarianpassword" autocomplete="off"/>
    <br><br>
    <input type="submit" value="Create User"/>&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="reset" value="Clear"/>
    <br><br>
    Already have an account? Sign in <a href="index.php">here</a>.
</form>

<?php
   include 'utility.php';
   $conn = getSQLConnection();

    $fname = isset($_POST["firstname"]) ? $_POST["firstname"] : "";
    $lname = isset($_POST["lastname"]) ? $_POST["lastname"] : "";
    $userid = isset($_POST["userid"]) ? $_POST["userid"] : "";
	$password = isset($_POST["password1"]) ? $_POST["password1"] : "";
	$libpassword = isset($_POST["librarianpassword"]) ? $_POST["librarianpassword"] : "";

	$correctpassword = "marburglibrary";

	if ($libpassword != "") {
		if ($libpassword != $correctpassword) {
			echo "Incorrect librarian password. Please try again or sign up as a reader.<br>";
		}
		else {
			if($userid!=""){
				//Create the SQL query
				$sql = "select librarian_pk from librarian";
				$sql = $sql . " where librarian_pk = '$userid'";
				
				//Run the query
				$result = $conn->query($sql);
			
				if ($result->num_rows == 0) 
				{
					$sql2 = "insert into librarian(first_name,last_name,librarian_pk,password) values(";
					$sql2 = $sql2 . "'$fname','$lname','$userid','$password')";
					$result = $conn->query($sql2);
					echo "<br><a href='index.php'>Login</a>";
		
				} 
				else
				{
					echo "Sorry! That userid already exists!";
					echo "<br><a href='signup.php'>Try again</a>";
				}
				}
		}
	}

	else {
		if($userid!=""){
			//Create the SQL query
			$sql = "select reader_pk from reader";
			$sql = $sql . " where reader_pk = '$userid'";
			
		//Run the query
		$result = $conn->query($sql);
		
		if ($result->num_rows == 0) 
		{
			$sql2 = "insert into reader(first_name,last_name,reader_pk,password) values(";
			$sql2 = $sql2 . "'$fname','$lname','$userid','$password')";
			$result = $conn->query($sql2);
			echo $sql2;
				
			echo "<br><a href='index.php'>Login</a>";
	
		} 
		else
		{
			echo "Sorry! That userid already exists!";
			echo "<br><a href='signup.php'>Try again</a>";
		}
		}
	}    
	
    $conn->close();
    
?>
</body>
</html>

