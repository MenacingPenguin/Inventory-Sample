<?php

include("checkLogin.php");
if($usrInfo) {
	header("Location: companyPage.php");
	exit();
}
echo $encStuff;


include("header.php"); #Begin HTML

?>

<section class="wrapper style1 special">
	<h3>Login</h3>
	<div style="margin-left:35%; width:30%">
		<input type="text" id="username" style="text-align:center; margin-bottom:1em" value="" placeholder="Username"/>
		<input type="password" id="password" style="text-align:center; margin-bottom:1em" value="" placeholder="Password"/>
		<div style="margin-bottom:1em">
			<button type="submit" onclick="logAttmpt()" class="freeBtnGreen" id="submit">Sign In</button>
		</div>
		<div style="margin-bottom:1em">
			<a href="forgotPass.php">Forgot Password?</a>
		</div>
		<div>
			<p style="color:#dddddd; display:inline">Don't have an account?</p>
			<a href="signup.php" style="display:inline">Sign up!</a>
		</div>
	</div>
</section>
<?php include("footer.php"); #End HTML ?>

<script>

function logAttmpt() {
	var usrName = prepID("username"); // Access username and password info
	var passW = prepID("password");
	if(usrName!="" && passW!="") {
		var xhttp = new XMLHttpRequest(); // Request for data
		xhttp.onreadystatechange = function() {
			if(this.readyState == 4 && this.status == 200) {
				if(this.responseText=="1") {
					window.location.href = "companyPage.php"; // Go here if successful
				} else {
					console.log(this.responseText); // Otherwise tell the error.
				}
			}
		};
		xhttp.open("GET", "attmptLog.php?username="+usrName+"&password="+passW, true); // Send values using secluded "GET"
		xhttp.send();
	}
}

document.addEventListener("keypress", function(key){ // Activates if enter key is pressed.
    if(key.which == 13) {
        logAttmpt();
    }
});

</script>

</html>