<?php

include("checkLogin.php");
if(!$encTok=="") {
	echo "1";
} elseif(!$usrInfo) {
	header("Location: index.php");
	exit();
}

?>