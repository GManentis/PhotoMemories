function Photos(x) {	
	try {				
		var xmlhttp;

		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
			// most browsers
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			// internet explorer
		}
		
				
		xmlhttp.onreadystatechange = function() {			
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				var strOut;			
				strOut = xmlhttp.responseText;
				document.getElementById("result").innerHTML = strOut;
			}
		}
		
		xmlhttp.open("POST", "CustomJs/GetPhotos.php", true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");			
		xmlhttp.send("page="+x);
	}
	catch(err) {
		alert(err);
	}
}

function DeleteImage(w)
{
	var z = "Are you sure you want to delete this image?";
	a = confirm(z);
	if(a)
	{
		try 
		{				
			var xmlhttp2;

			if (window.XMLHttpRequest) 
			{
				xmlhttp2 = new XMLHttpRequest();
				// most browsers
			} 
			else 
			{
				xmlhttp2 = new ActiveXObject("Microsoft.XMLHTTP");
				// internet explorer
			}
		
		var sendo = w;
				
		xmlhttp2.onreadystatechange = function()
		{			
			if (xmlhttp2.readyState == 4 && xmlhttp2.status == 200) 
			{
				var strOut2;			
				strOut2 = xmlhttp2.responseText;
				document.getElementById("result2").innerHTML = strOut2;
				window.location = "http://localhost/ProjectPhotoMemories/ViewPhotos.php";
			}
		}
		
		xmlhttp2.open("POST", "CustomJs/DeletePhotos.php", true);
		xmlhttp2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");			
		xmlhttp2.send("image="+w);
		}
		catch(err) 
		{
			alert(err);
		}
	 window.location.href = "http://localhost/ProjectPhotoMemories/ViewPhotos.php";
	}
}