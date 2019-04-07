<?php
session_start();

if( isset($_SESSION["user"]) && isset($_POST["image"]))
{
  $x = $_SESSION["user"];
  $z = $_POST["image"];
  
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
		$getdata_PRST = $CONNPDO->prepare("SELECT * FROM memories WHERE name = :src AND username = :name ");
		$getdata_PRST->bindValue(":name",$x);
		$getdata_PRST->bindValue(":src",$z);
		$getdata_PRST->execute() or die($CONNPDO->errorInfo());
		$counter = $getdata_PRST->rowCount();
		
		if($counter == 1)
		{
			$getdata_PRST = $CONNPDO->prepare("DELETE FROM memories WHERE name = :src AND username = :name ");
			$getdata_PRST->bindValue(":name",$x);
			$getdata_PRST->bindValue(":src",$z);
			$getdata_PRST->execute() or die($CONNPDO->errorInfo());
			
			$deleteImage = "C:/xampp/htdocs/ProjectPhotoMemories/memories/".$x."/".$z ;
			unlink($deleteImage);
		}
			
				
		$resp = "<center><b style=\"color:red;\"> The Photo Has been Deleted ! Please refresh the page!<script>window.location.href = \"index.php\"</script></b></center><br><br><br>";
		echo $resp;
	}
	else
	{
		echo "<center><b <span style=\"color:red;\">An error occured :( </span></center>";
	}	
}
else
{
	echo "<center><span style=\"color:red;\">A fatal error occured we apologise for the inconvenience</span></center>";
}

?>