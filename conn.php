<?php
$servername = "localhost";
$dusername = "root";
$dpassword = "";
$dbname = "inventory";

$conn = new mysqli($servername, $dusername, $dpassword, $dbname);
if($conn->connect_error) { echo $conn->connect_error; exit(); }

function cleanItem($item,$type) { // An SQL protection
	global $conn; // against SQL injection
	$newVar = false;
	
	((($type==0 && isset($_POST[$item])) && $newVar = $_POST[$item]) || (($type==1 && isset($_REQUEST[$item])) && $newVar = revASCII($_REQUEST[$item])) || (($type==2 && isset($_COOKIE[$item])) && $newVar = $_COOKIE[$item]));
	
	if($newVar or $newVar=="") {
		return mysqli_real_escape_string($conn, stripslashes($newVar));
	} else {
		return -10000;
	}
}

function revASCII($str) {
	$actStr = "";
	if(strlen($str)>0) {
		$lastX = 0;
		for($i=0;$i<substr_count($str,"x");$i++) {
			$newEnd = strpos($str,"x",$lastX);
			if(gettype($newEnd)=="integer") {
				$inStr = substr($str,$lastX,$newEnd-$lastX);
				$char = chr($inStr);
				#echo "  ", $i, "::", $lastX, "::", $newEnd, "::", $inStr, "::", $char, "  ";
				if(gettype($char)=="string") {
					$actStr = $actStr . $char;
				}
			}
			$lastX = $newEnd+1;
		}
	}
	return $actStr;
}

function priceTxt($val) {
	$str = (string)$val;
	$sLen = strlen($str);
	if(strlen($str)<=2) {
		return "$0." . str_repeat("0",2-$sLen) . $str;
	} else {
		return "$" . substr_replace($str,".",-2,0);
	}
}
# Insert Javascript code important to all connectable pages.
$encStuff = "<script>

function prepSend(str) {
	var encStr = '';
	for(var i=0; i<str.length; i++) {
		var newItm = str.charCodeAt(i);
		if(newItm) {
			encStr = encStr+newItm+'x';
		}
	}
	return encStr;
}

function prepID(str) {
	var itm = document.getElementById(str);
	if(itm && itm.value) {
		return prepSend(itm.value);
	} else {
		return '';
	}
}

</script>";
?>