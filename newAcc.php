<?php
include("conn.php");

$usrName = cleanItem("usrName",1);
$pass = cleanItem("pass",1);
$email = cleanItem("email",1);

function errEc($itm) {
	if($itm!="") {
		echo $itm;
	} else {
		echo "An error has occurred. Please try again.";
	}
	exit();
}

if($usrName==-10000 || $pass==-10000 || $email==-10000) {
	errEc("");
}

if(strlen($usrName)<=6 || strlen($usrName)>=15) {
	errEc("The username is not the correct length.");
}
if(strlen($pass)<=7 || strlen($pass)>=20) {
	errEc("The password is not the correct length.");
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	errEc("The email given was invalid; please try again.");
}

$existAcc = $conn->query("SELECT * FROM `userdata` WHERE Username='$usrName'");

if($existAcc->num_rows==0) {
	$existEmail = $conn->query("SELECT * FROM `userdata` WHERE Email='$email'");
	if($existEmail->num_rows==0) {
		$encPass = password_hash($pass, PASSWORD_DEFAULT);
		$newUser = $conn->query("SELECT `UserTrack` FROM `seedKeys`")->fetch_assoc()["UserTrack"]+1; // Obtain the new user key
		$atmpt = $conn->query("UPDATE `seedkeys` SET UserTrack=$newUser");
		if($atmpt) {
			$lel = $conn->query("INSERT INTO `userdata`(`UserSeed`,`Username`,`Password`,`Email`,`volumeOpt`) VALUES ($newUser,'$usrName','$encPass','$email',50)");
			echo "1";
		} else {
			errEc("");
		}
	} else {
		errEc("This email is already under use.");
	}
} else {
	errEc("This username is already taken.");
}

?>