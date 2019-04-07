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
<script src="CustomJs/AjaxPhotos.js"></script>
<link rel="stylesheet" href="media/lightbox.css">
<link rel="stylesheet" href="projecto.css">
<script type="text/javascript" src="CustomJs/lightbox.js"></script>
</head>
<body onload="Photos(1);">
<div class="container" style="background-color:green;" >
<span style="color:white; font-size:70px; ">Photomemories</span><span style="float:right;color:white;padding-top:15px;"><?php echo $response1 ?></span>
<br>
<a href="index.php" style="color:white;">Main|</a><a href="aboutus.php" style="color:white;">About us|</a><a href="UploadImage.php" style="color:white;">Upload Image|</a><a href="ViewPhotos.php" style="color:white;">View Uploaded Images|</a><a style="color:white;" href="beer.php">Have a beer with us</a><?php echo $response2; ?>
</div>
<div class="container" style="margin-top:30px;" id="result2">
</div>
<div class="container" style="margin-top:30px;" id="result">
</div>
</body>
</html>