<?php
include("conn.php");
$usrInfo = false;
$encTok = "";

$token = cleanItem("loginStay",2); #Check for potential login token (as a cookie) already on the user.
if($token!=-10000) {
	$result = $conn->query("SELECT * FROM loginseeds WHERE `loginHash`='$token'");
	if($result->num_rows==1) {
		$usrNum = $result->fetch_assoc()["UserSeed"];
		$request = $conn->query("SELECT * FROM `userdata` WHERE `UserSeed`='$usrNum'");
		$potInfo = $request->fetch_assoc();
		if($request->num_rows==1) {
			$usrInfo = $potInfo;
			$curTim = time();
			$afterTim = $curTim + 3600;
			$conn->query("UPDATE `loginseeds` SET `lastAccess`=$curTim WHERE `loginHash`='$token'");
			$encTok = $token;
			setcookie("loginStay",$token,$afterTim);
		}
	}
}

if(!$usrInfo) { // If there are no cookies then confirm potential given values.
	$usr = cleanItem("username",1);
	$pass = cleanItem("password",1);
	if($usr!=-10000 && $pass!=-10000) { #Check for a given username and password.
		$result = $conn->query("SELECT * FROM `userdata` WHERE `Username`='$usr'");
		$potInfo = $result->fetch_assoc();
		if($result->num_rows==1 && password_verify($pass,$potInfo["Password"])) {
			$usrInfo = $potInfo;
			$usrNum = $usrInfo["UserSeed"]; #Find the userseed for storing as well as a timestamp.
			$curTim = time();
			$afterTim = $curTim + 3600;
			$token = openssl_random_pseudo_bytes(128); #Creates a binary digit with 128 bytes.
			$encTok = hash("sha256",$token); #Hashes the binary digit beyond recognition.
			$conn->query("INSERT INTO `loginseeds`(`UserSeed`,`loginHash`,`lastAccess`) VALUES ($usrNum,'$encTok',$curTim)"); #Stores encrypted token.
			setcookie("loginStay",$encTok,$afterTim); #Give the user an encrypted login token as a cookie.
		}
	}
}

?>