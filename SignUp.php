<?php 
session_start();
$resp = "";
if(isset($_SESSION["user"]))
{
	$user = $_SESSION["user"];
	$response1 = "Welcome, ". $user . "<br>" ."<button class='btn btn-light' onclick=\"location.href = 'LogOut.php'\">Log Out</button>";
	$response2 = "<a style=\"float:right;color:white;\" href=\"Delete.php\" >Delete my account</a>";
}
else
{
	$response1 = "<center>Not a member?<br><button class='btn btn-light' onclick=\"location.href = 'LogIn.php'\" >Log In</button>&nbsp;<button class='btn btn-light' onclick=\"location.href = 'SignUp.php'\" >Sign Up</button></center>";
    $response2 ="";
}

$response="";



if(isset($_POST["submit"]))
{   
    if(!empty($_POST["user"]) && !empty($_POST["pass"]) && !empty($_POST["mail"]) && !empty($_POST["gender"]))
	{  
		function test_input($data) 
		{
		  $data = trim($data);
		  $data = stripslashes($data);
		  $data = htmlspecialchars($data);
		  return $data;
		}
		
		$status = 1;
		$gen  = $_POST["gender"];
		
		$hostname_DB = "127.0.0.1";
		$database_DB = "photomemories";
		$username_DB = "root";
		$password_DB = "";
		
		$name = test_input($_POST["user"]);
		if (preg_match("/^[a-zA-Z ]*$/",$name)) 
		{
		  $user = $_POST["user"];
		}
		else
		{
		  $status = 0;
		}
		
		$pName = test_input($_POST["pass"]);
		if (preg_match("/^[a-zA-Z ]*$/",$pName)) 
		{
		  $pass = $_POST["pass"];
		  $passhash = password_hash($pass, PASSWORD_DEFAULT);
		}
		else
		{
		  $status = 0;
		}
		
		$email = test_input($_POST["mail"]);
		if (filter_var($email, FILTER_VALIDATE_EMAIL))
		{
		  $mail = $_POST["mail"];
		}
		else
		{
		  $status = 0;
		}
		
		if( $status == 1 )
		{

			try 
			{
				$CONNPDO = new PDO("mysql:host=".$hostname_DB.";dbname=".$database_DB.";charset=UTF8", $username_DB, $password_DB, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_TIMEOUT => 3));
			} 
			catch (PDOException $e) 
			{
				$CONNPDO = null;
			}
			if ($CONNPDO != null)
			{
				    $getdata_PRST = $CONNPDO->prepare("SELECT username FROM members WHERE username = :user OR email = :mail ");
					$getdata_PRST->bindValue(":user", $user);
					$getdata_PRST->bindValue(":mail", $mail);
					$getdata_PRST->execute() or die($CONNPDO->errorInfo());
					$count = $getdata_PRST->rowCount();
				
					if( $count == 0)
					{						
						$adddata_PRST = $CONNPDO->prepare("INSERT INTO members(username, password, email, gender) VALUES(:user, :pass, :mail, :gen)");
						$adddata_PRST->bindValue(":user", $user);
						$adddata_PRST->bindValue(":pass", $passhash);
						$adddata_PRST->bindValue(":mail", $mail);
						$adddata_PRST->bindValue(":gen", $gen);
						$adddata_PRST->execute() or die($CONNPDO->errorInfo());
						
						mkdir('memories/'.$user, 0777, true);
						
						$resp = "Your registration has been successful,Welcome Aboard!"; 
						$_SESSION["user"] = $user;
						$response1 = "Welcome, ". $user . "<br>" ."<button class='btn btn-light' onclick=\"location.href = 'LogOut.php'\">Log Out</button>";
						$response2 = "<a style=\"float:right;color:white;\" href=\"Delete.php\" >Delete my account</a>";
					}
					else
					{
						$resp = "The username and/or mail are already used";
					}
			}
			else
			{
				$resp = "No Connection!";
			}
			
		}
		else
		{
		   $resp = "Please insert legit info,thank you";
		}
    }
	else
	{
		$resp = "Please insert legit info,thank you";
	}
}


?>
<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Photomemories</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script type="text/javascript" src="jquery-3.3.1.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="projecto.css">
	<script type="text/javascript" src="CustomJs/Aboutus.js"></script>
</head>
<body>
	<div class="container" style="background-color:green;" >
		<span style="color:white; font-size:70px;">Photomemories</span><span style="float:right;color:white;padding-top:15px;"><?php echo $response1 ?></span>
		<br>
		<a href="index.php" style="color:white;">Main|</a><a href="aboutus.php" style="color:white;">About us|</a><a href="UploadImage.php" style="color:white;">Upload Image|</a><a href="ViewPhotos.php" style="color:white;">View Uploaded Images|</a><a style="color:white;" href="beer.php">Have a beer with us</a><?php echo $response2; ?>
	</div>
	<div class="container" style="margin-top:30px;">
	<center>
	<h2>Sign Up and start your Trip today!</h2>
	<br><br>
	<table>
	<form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
	<tr><td>Username:</td><td><input type="text" name="user" onkeydown = "if (event.keyCode == 13)document.getElementById('go').click()"></td></tr>
	<tr><td>Password:</td><td><input type="password" name="pass" onkeydown = "if (event.keyCode == 13)document.getElementById('go').click()"></td></tr>
	<tr><td>E-mail:</td><td><input type="text" name="mail" onkeydown = "if (event.keyCode == 13)document.getElementById('go').click()" ></td></tr>
	<tr><td>Gender:</td><td><input type="radio" name="gender" value="Male" onkeydown = "if (event.keyCode == 13)document.getElementById('go').click()">Male&nbsp;&nbsp;<input type="radio" name="gender" value="Female" onkeydown = "if (event.keyCode == 13)document.getElementById('go').click()">Female</td></tr>
	</table>
	<br>
	<input type="submit" name="submit" id="go" value="Sign Up!">
	
	</div>
	<br>
	<div>
	<center>
	<?php echo $resp; ?>
	</center>
	</div>
</body>
</html>