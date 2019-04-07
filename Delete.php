<?php 
session_start();

if(isset($_SESSION["user"]))
{
	$user = $_SESSION["user"];
	$response1 = "Welcome, ". $user . "<br>" ."<button class='btn btn-light' onclick=\"location.href = 'LogOut.php'\">Log Out</button>";
	$response2 = "<a style=\"float:right;color:white;\" href=\"Delete.php\" >Delete my account</a>";
}
else
{
	$response1 = "<center>Not a member?<br><button class='btn btn-light' onclick=\"location.href = 'LogIn.php'\">Log In</button>&nbsp;<button class='btn btn-light' onclick=\"location.href = 'SignUp.php'\">Sign Up</button></center>";
    $response2 = "";
}

if(isset($_POST["submit"]))
{
	$x = $_SESSION["user"];
	
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
		rmdir("memories/".$x);
				
		$getdata_PRST = $CONNPDO->prepare("DELETE FROM memories WHERE username = :name ");
		$getdata_PRST->bindValue(":name",$x);
		$getdata_PRST->execute() or die($CONNPDO->errorInfo());
		
		$getdata_PRST = $CONNPDO->prepare("DELETE FROM members WHERE username = :name ");
		$getdata_PRST->bindValue(":name",$x);
		$getdata_PRST->execute() or die($CONNPDO->errorInfo());
		
		$_SESSION["user"]="";
		session_destroy(); 
        header("location:index.php");
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
</head>
<body>
<div class="container" style="background-color:green;" >
<span style="color:white; font-size:70px; ">Photomemories</span><span style="float:right;color:white;padding-top:15px;"><?php echo $response1 ?></span>
<br>
<a href="index.php" style="color:white;">Main|</a><a href="aboutus.php" style="color:white;">About us|</a><a href="UploadImage.php" style="color:white;">Upload Image|</a><a href="ViewPhotos.php" style="color:white;">View Uploaded Images|</a><a style="color:white;" href="beer.php">Have a beer with us</a><?php echo $response2; ?>
</div>
<div class="container" style="margin-top:30px;">
<center>
<p> If you delete your account all your memories that are saved here will be lost!Are you sure that you want to bid us farewell?<p>
<form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
<input type="submit" name="submit" value="Yes I bid you farewell!">
<a href="index.php"><button>No,I changed my mind</button>
</center>
</div>
</body>
</html>
