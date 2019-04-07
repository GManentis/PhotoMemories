<?php 
session_start();

$raspa = "";

if(isset($_SESSION["user"]))
{
	$user = $_SESSION["user"];
	$response1 = "Welcome, ". $user . "<br>" ."<button class='btn btn-light' onclick=\"location.href = 'LogOut.php'\">Log Out</button>";
	$response2 = "<a style=\"float:right;color:white;\" href=\"Delete.php\" >Delete my account</a>";
}
else
{
	$response1 = "<center>Not a member?<br><button class='btn btn-light' onclick=\"location.href = 'LogIn.php'\" >Log In</button>&nbsp;<button class='btn btn-light' onclick=\"location.href = 'SignUp.php'\" >Sign Up</button></center>";
    $response2 = "";
}


if(isset($_POST["submit"]))
{
    if(!empty($_POST["name"]) && !empty($_POST["pass"]))
	{
		$name = $_POST["name"];
		$pass = $_POST["pass"];
		
	 	$hostname_DB = "127.0.0.1";
		$database_DB = "photomemories";
		$username_DB = "root";
		$password_DB = "";

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
			$getdata_PRST = $CONNPDO->prepare("SELECT password FROM members WHERE username = :name");
			$getdata_PRST->bindValue(":name", $name);
			$getdata_PRST->execute() or die($CONNPDO->errorInfo());
			$count = $getdata_PRST->rowCount();
			
		   if($count != 0)
		   {
			while($getdata_RSLT = $getdata_PRST->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) 
			{ 
		        $hashed_password = $getdata_RSLT["password"];
		        if(password_verify($pass, $hashed_password))
				{
					$_SESSION["user"] = $name;
				}
				
				
			}
			$raspa = "Welcome back! :) ";
			$response1 = "Welcome, ". $name . "<br>" ."<button class='btn btn-light' onclick=\"location.href = 'LogOut.php'\">Log Out</button>";
			$response2 = "<a style=\"float:right;color:white;\" href=\"Delete.php\" >Delete my account</a>";			
		   }
		   else
		   {
			   
			   $raspa = "User not found!! :( ";
			   $response1 = "<center>Not a member?<br><button class='btn btn-light' onclick=\"location.href = 'LogIn.php'\" >Log In</button>&nbsp;<button class='btn btn-light' onclick=\"location.href = 'SignUp.php'\" >Sign Up</button></center>";
		       $response2 = "";
		   }
		}
		else
		{
			$raspa = "No Pdo Connection";
			
	    }
			
	}
	else
	{ 
		  $raspa = "Connction issues";
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
		<h2>Welcome back,Log In to Resume your Trip to Nostalgia</h2>
		<br><br>
		<form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
		<table>
			<tr><td>Username:</td><td><input type="text" name="name" onkeydown = "if (event.keyCode == 13)document.getElementById('go').click()" ></td></tr>
			<tr><td>Password:</td><td><input type="password" name="pass" onkeydown = "if (event.keyCode == 13)document.getElementById('go').click()"></td></tr>
		</table>
		<br>
		<input type="submit" name="submit" id="go" value="Log in!">
		</form>
	</div>
	<div class="container">
		<center>
		<?php echo $raspa; ?>
		</center>
	</div>
	
</body>
</html>