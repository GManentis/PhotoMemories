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
	$response1 = "<center>Not a member?<br><button class='btn btn-light' onclick=\"location.href = 'LogIn.php'\" >Log In</button>&nbsp;<button class='btn btn-light' onclick=\"location.href = 'SignUp.php'\" >Sign Up</button></center>";
    $response2 = "";
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
		<a href="index.php" style="color:white;">Main|</a><a href="aboutus.php" style="color:white;">About us|</a><a href="UploadImage.php" style="color:white;">Upload Image|</a><a href="ViewPhotos.php" style="color:white;">View Uploaded Images|</a><a style="color:white;" href="beer.php">Have a beer with us</a><?php echo $response2;?>
	</div>
	<div class="container" style="margin-top:30px;">
		<center><h2 style="color:grey;">Ask And Learn</h3></center>
		<button class="btn btn-light" onclick="toggle1();">What's the purpose of this page?</button>
		<br>
		<div id="answer1" style="display:none;" >
		<br>
		<p>The purpose of this site is to store important for the users' photos so that they shall endure through the passage of time</p>
		</div>
		<br>
		<button class="btn btn-light" onclick="toggle2();">About the creator of this page</button>
		<br>
		<div id="answer2" style="display:none;"  >
		<br>
		<p>The developer of this site is your everyday person whose wants to test and hone his coding and web designing skills</p>
		<br>
		</div>
		<br>
		<button class="btn btn-light" onclick="toggle3();">More Info</button>
		<br>
		<div id="answer3" style="display:none;"  >
		<br>
		<p>Many images and media used may be copyrighted.I don't own anything,all rights belong to their respective owners</p>
		<br>
		</div>
		<br>
	</div>
</body>
</html>