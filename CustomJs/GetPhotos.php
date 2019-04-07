<?php
session_start();

if( isset($_SESSION["user"]) && isset($_POST["page"]))
{
  $x = $_SESSION["user"];
  if ($_POST["page"] <= 1) 
  {
	(int)$page = 0;
  }
  else
  {
	(int)$page = $_POST["page"];
  }
  if ($page == 0)
  {
	(int)$var = 0;
  }
  else
  {
	(int)$var = ($page*14-14);  
  }

  
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
				
		$getdata_PRST = $CONNPDO->prepare("SELECT * FROM memories WHERE username = :name ORDER BY id LIMIT :var,14 ");
		$getdata_PRST->bindValue(":name",$x);
		$getdata_PRST->bindValue(":var",$var,PDO::PARAM_INT);
		$getdata_PRST->execute() or die($CONNPDO->errorInfo());
		$rows = $getdata_PRST->rowCount();
		$counter = 0;
		$resp = "<table><center>";
		if ($rows != 0)
		{
			while ($getdata_RSLT = $getdata_PRST->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) 
			{  
         		++$counter;
				$rImageName= $getdata_RSLT["name"];
				if( $rImageName != "" ) 
				{   if($counter == 1 || $counter%8 == 0 )
				 {
					$resp .= "<tr><td><a href=\"memories/$x/$rImageName\" data-lightbox=\"memorytrain\" data-title=\"$rImageName\"><img class=\"Pnt\" src=\"memories/$x/$rImageName\"  width=\"150\"  height=\"150\" ></a><br><center><button class=\"btn btn-xs\" name=\"submit\" onclick=\"DeleteImage('$rImageName')\" >Delete</button></center></td>";
				 }
				 elseif($counter%7 == 0)
				 {
					$resp .= "<td><a href=\"memories/$x/$rImageName\" data-lightbox=\"memorytrain\" data-title=\"$rImageName\"><img class=\"Pnt\" src=\"memories/$x/$rImageName\"  width=\"150\"  height=\"150\" ></a><br><center><button class=\"btn btn-xs\" name=\"submit\" onclick=\"DeleteImage('$rImageName')\" >Delete</button></center></td></tr>";
				 }
				 else
				 {
					$resp .= "<td><a href=\"memories/$x/$rImageName\" data-lightbox=\"memorytrain\" data-title=\"$rImageName\"><img class=\"Pnt\" src=\"memories/$x/$rImageName\"  width=\"150\"  height=\"150\" ></a><br><center><button class=\"btn btn-xs\" name=\"submit\" onclick=\"DeleteImage('$rImageName')\" >Delete</button></center></td>"; 
				 }
				}
			}
		$resp .= "</table><br><br><br><ul class=\"pagination\">";
		
		$getdata_PRST = $CONNPDO->prepare("SELECT COUNT(id) AS number FROM memories WHERE username = :name");
		$getdata_PRST->bindValue(":name",$x);
		$getdata_PRST->execute() or die($CONNPDO->errorInfo());
		while ($getdata_RSLT = $getdata_PRST->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) 
		{
				$rows2 = $getdata_RSLT["number"];
				
		}
		
		$pPages1 = $rows2/14;
		if(is_int($pPages1))
		{
			$pPages = $pPages1;
		}
		else
		{
			$pPages = (floor($pPages1)+1);
		}
		
		for($i = 1; $i <= $pPages; $i++)
		{
			if ($i == $_POST["page"])
			{
				$resp .= "<li class=\"page-item active\"><a class=\"page-link\" href=\"#\" onclick=\"Photos($i);\">$i</a></li>";
			}
			else
			{
				$resp .= "<li class=\"page-item\"><a class=\"page-link\" href=\"#\" onclick=\"Photos($i)\">$i</a></li>";
			}
		}
		$resp .= "</ul></center>";
		 echo $resp;
		}
		else
		{
			echo "<center><span style=\"color:red;\">You haven't uploaded anything yet :( </span></center>";
		}	
	}
	else
	{
		echo "<center><span style=\"color:red;\">A fatal error occured we apologise for the inconvenience</span></center>";
	}
}
else
{
	echo "<center><span style=\"color:red;\">You must be logged in to view images</span></center>";
}
?>