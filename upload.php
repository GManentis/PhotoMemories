<?php
session_start();

$errorR="";

if(isset($_SESSION["user"]))
{
	$user = $_SESSION["user"];
	$response1 = "Welcome, ". $user . "<br>" ."<button class='btn btn-light' onclick=\"location.href = 'LogOut.php'\">Log Out</button>";
	$response2 = "<a style=\"float:right;color:white;\" href=\"Delete.php\" >Delete my account</a>";

	$target_dir = "memories/".$_SESSION["user"]."/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	

	if(isset($_POST["submit"])) 
	{
		
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check != false)
		{
			$uploadOk = 1;
		} 
		else 
		{
			$errorR .= "File is not an image". "<br>";
			$uploadOk = 0;
		}
	}

	if (file_exists($target_file)) 
	{
		$errorR .= "Sorry, file already exists." . "<br>";
		$uploadOk = 0;
	}

	if ($_FILES["fileToUpload"]["size"] > 500000000) 
	{
	   $errorR .= "Sorry, your file is too large." . "<br>";
	   $uploadOk = 0;
	}

	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "GIF" ) 
	{
		$errorR .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed." . "<br>";
		$uploadOk = 0;
	}

	if ($uploadOk == 0) 
	{
		$errorR .= "Sorry, your file was not uploaded." . "<br>" ."<a href=\"index.php\"> Go back to main </a>";

	} 
	else 
	{
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
		{   
			$user = $_SESSION["user"];
			$name = basename($_FILES["fileToUpload"]["name"]);
			
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
						$adddata_PRST = $CONNPDO->prepare("INSERT INTO memories(username, name) VALUES(:user, :name)");
						$adddata_PRST->bindValue(":user", $user);
						$adddata_PRST->bindValue(":name", $name);
						$adddata_PRST->execute() or die($CONNPDO->errorInfo());		
				}
				else
				{
					$errorR = "No Connection!";
				}
			
			$errorR .= "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
			$errorR .= "<br><a href=\"index.php\"> Go back to main </a>";
		} 
		else 
		{
			$errorR .= "Sorry, there was an error uploading your file." . "<br>";
			$errorR .= "<a href=\"index.php\"> Go back to main </a>";
		}
  }
}
else
{
	header("Location:index.php");
	$response1 = "<center>Not a member?<br><button class='btn btn-light' onclick=\"location.href = 'LogIn.php'\">Log In</button>&nbsp;<button class='btn btn-light' onclick=\"location.href = 'SignUp.php'\">Sign Up</button></center>";
    $response2 = "";
	$errorR = "You can't upload if not a member.Please go <a href=\"index.php\" > back <a>";
	
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
	<a href="index.php" style="color:white;">Main|</a><a href="aboutus.php" style="color:white;">About us|</a><a href="UploadImage.php" style="color:white;">Upload Image|</a><a href="ViewPhotos.php" style="color:white;">View Uploaded Images|</a><a style="color:white;" href="#">Have a beer with us</a><?php echo $response2; ?>
	</div>
<div class="container" style="margin-top:30px;"  >
<center>
<?php echo $errorR; ?>
</center>
</div>
</body>
</html>
