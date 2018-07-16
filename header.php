<?php
$initStyl = '';
$initClicker = '';
$initSidenav = '';
$potComp = '';
$potButton = '';
$potPopUp = '';

if($usrInfo) { // Makes sure only logged on users see the menu items
	$initStyl = '<link rel="stylesheet" href="assets/css/newElems.css" />';
	$initClicker = '<span style="position:absolute; display:inline-block; font-size:30px; cursor:pointer; margin-left:1.5%; width:4%; top:20%; height:60%" onclick="togMenu()">&#9776;</span>';
	$initSidenav = '<div id="mySidenav" class="sidenav">
		<a onclick="logOut()"><img src="http://i.imgur.com/T9RDtUN.png" style="width:3em; height:3em" /></a>
		<a href="companypage.php"><img src="http://i.imgur.com/H5H9BQP.png" style="width:3em; height:3em" /></a>
		<a href="itempage.php"><img src="http://i.imgur.com/e4xoiIW.png" style="width:3em; height:3em" /></a>
		<a href="TasksScreen.php"><img src="http://i.imgur.com/zWQaDTk.png" style="width:3em; height:3em" /></a>
	</div>';
	
	$potComp = '<select id="compList" onchange="updatePg(this.value)" value="" style="position:absolute; left:7%; width:20%; top:10%; height:80%">';
	$request = $conn->query("SELECT * FROM `compusers` WHERE `UserSeed`=" . $usrInfo['UserSeed']);
	
	if($request->num_rows>0) {
		while($row = $request->fetch_assoc()) {
			echo $row["CompanySeed"];
			$compName = $conn->query("SELECT `Name` FROM `companydata` WHERE `DataSeed`=" . $row['CompanySeed'])->fetch_assoc()['Name'];
			$potComp = $potComp . '<option value="' . $row["CompanySeed"] . '"';
			if($usrInfo["CompanySeed"]==$row["CompanySeed"]) {
				$potComp = $potComp . ' selected="selected"';
			}
			$potComp = $potComp . '>' . $compName . '</option>';
		}
	} else {
		$potComp = $potComp . '<option value="" selected="selected" style="left:10%">No Company Available</option>';
	}
	$potComp = $potComp . '</select>';
	$potPopUp = '<div id="popupper" style="display:none; position:fixed; left:22%; width:56%; top:6%; height:88%; z-index:3; background-color:#3377DD; border:4px solid; border-radius:1em">
		<span style="position:absolute; display:inline-block; font-size:40px; cursor:pointer; right:0%; width:8%; top:2%; height:4%" onclick="closePop()">&#10006;</span>
		<div class="ghostDiv" id="newItem">
			<input id="itemNameNew" class="itemInput forceCent" style="width:27em; top:7%; height:2.5em; font-size:1.1em" placeholder="Item Name*">
			<img id="PicItmNew" class="forceCent" src="http://i.imgur.com/W4pXiKR.png" style="position:absolute; width:12em; top:20%; height:18%"/>
			<input id="itemPicNew" class="itemInput forceCent" style="width:20em; top:45%; height:1.8em" placeholder="URL for Picture (.PNG, .JPEG, etc.)">
			<input id="stockNew" class="itemInput" type="number" style="left:4em; width:12em; top:55%; height:1.8em" placeholder="Initial Stock*">
			<input id="soldNew" class="itemInput" type="number" style="left:4em; width:12em; top:64%; height:1.8em" placeholder="Initial Sold*">
			<input id="costNew" class="itemInput" type="number" style="right:4em; width:12em; top:55%; height:1.8em" placeholder="Cost*">
			<input id="priceNew" class="itemInput" type="number" style="right:4em; width:12em; top:64%; height:1.8em" placeholder="Selling Price*">
			<p class="forceCent" style="top:70%">Fields with * are required.</p>
		</div>
		<div class="ghostDiv" id="editItem">
			<h2 class="forceCent" style="top:3%; height:15%">Tableset with Drawers</h2>
			<img class="forceCent" src="http://i.imgur.com/6j1JxYJ.png" style="width:12em; top:17%; height:26%"/>
			
			<h4 style="position:absolute; left:7%; top:50%">In Stock: 7</h4>
			<h4 style="position:absolute; left:7%; top:57%">Amount Sold: 1</h4>
			<h4 style="position:absolute; right:10em; top:50%">Cost:</h4>
			<input id="costCh" class="itemInput" type="number" style="right:3.8em; width:6em; top:49.7%; height:2em" placeholder="$70.00">
			<h4 style="position:absolute; right:10em; top:57%">Selling Price:</h4>
			<input id="sellCh" class="itemInput" type="number" style="right:3.8em; width:6em; top:56.7%; height:2em" placeholder="$96.00">
			<h3 class="forceCent" style="top:64%">Profit per Item: $26.00</h3>
			
			<h4 style="position:absolute; left:3.3em; top:74%">Stock Added:</h4>
			<input id="stockAdd" class="itemInput" type="number" style="left:13.3em; width:6em; top:73.7%; height:2em" placeholder="0">
			<h4 style="position:absolute; right:10em; top:74%">Stock Sold:</h4>
			<input id="stockSold" class="itemInput" type="number" style="right:4em; width:6em; top:73.7%; height:2em" placeholder="0">
			
			<p class="forceCent" style="top:80%">*Stock values are additive to the current values.*</p>
		</div>
		<div class="ghostDiv" id="newComp">
			<input id="compNam" class="itemInput forceCent" style="width:27em; top:7%; height:2.5em; font-size:1.1em" placeholder="Company Name*">
			<img id="potPicComp" class="forceCent" src="http://i.imgur.com/W4pXiKR.png" style="position:absolute; width:15em; top:20%; height:23%"/>
			<input id="compPic" class="itemInput forceCent" style="width:25em; top:50%; height:2em" placeholder="URL for Logo (.PNG, .JPEG, etc.)">
			<p class="forceCent" style="top:58%">Fields with * are required.</p>
		</div>
		<div class="ghostDiv" id="newUser">
			<input id="potUser" class="itemInput forceCent" style="width:20em; top:15%; height:2.5em" placeholder="Username*">
			<h4 class="forceCent" style="top:30%">Role*</h4>
			<select id="rankList" class="selector forceCent" value="member" style="width:20em; top:36%; height:2em">
				<option value="0">Member</option>
				<option value="1">Inventory Keeper</option>
				<option value="2">Admin</option>
			</select>
			<p class="forceCent" style="top:58%">Fields with * are required.</p>
		</div>
		<div class="ghostDiv" id="editUser">
		</div>
		<div class="ghostDiv" id="newTask">
		</div>
		<div class="ghostDiv" id="editTask">
		</div>
		
		<button class="freeBtnImgGreen forceCent" style="width:9em; top:88%; height:3.3em" onclick="confirm()">
			<img id="confBtn" src="http://i.imgur.com/vIvMw9b.png" style="width:100%; height:100%" />
		</button>
		<h5 id="errTxt" class="forceCent" style="width:80%; top:95%; color:#000000; style:bold"></h5>
	</div>';
}
if(isset($curPag)) {
	if($curPag=="item") {
		$potButton = '<button class="freeBtnImgGreen" onclick="getPop(\'newItem\')" style="position:absolute; display:inline-block; right:.9em; width:12.5em; top:10%; height:80%">
			<img src="http://i.imgur.com/65hRDgs.png" style="width:100%; height:100%" />
		</button>';
	} elseif($curPag=="comp") {
		$potButton = '<button class="freeBtnImgBlue" onclick="getPop(\'newUser\')" style="position:absolute; display:inline-block; right:15em; width:11em; top:10%; height:80%">
			<img src="http://i.imgur.com/nrDdPCh.png" style="width:100%; height:100%"/>
		</button>
		<button class="freeBtnImgGreen" onclick="getPop(\'newComp\')" style="position:absolute; display:inline-block; right:.9em; width:13em; top:10%; height:80%">
			<img src="http://i.imgur.com/RaFpW0l.png" style="width:100%; height:100%"/>
		</button>';
	}
}

?>

<html lang="en"> <!-- Start the HTML document and set the language to english. -->

<head> <!-- Find the CSS asset file located in the root directory located on the server (computer).
			Use it for all future elements as the tool for styling. Also set the character values -->
	<title>Inter-Inventory</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="icon" href="http://i.imgur.com/80teapr.png">
	<link rel="stylesheet" href="assets/css/style.css" />
	<?php echo $initStyl; ?>
</head>

<div style="position:fixed; z-index:2; top:0; left:0; height:3em; width:100%; background-color:#123">
	<?php echo $initClicker; echo $potComp; ?>
	<img src="http://i.imgur.com/80teapr.png" style="position:absolute; left:50%; width:3.1em; top:5%; height:90%; transform:translate(-400%)" />
	<h2 style="position:absolute; display:inline-block; margin-left:30%; width:40%; top:15%; height:60%; text-align:center">Inter-Inventory</h2>
	<img src="http://i.imgur.com/80teapr.png" style="position:absolute; left:50%; width:3.1em; top:5%; height:90%; transform:translate(300%)" />
	<?php echo $potButton; ?>
</div>

<?php
echo $initSidenav;
echo $potPopUp;
?>
<body style="background-color:#000">
	<div id="mainItm" style="margin-top:1em; transition:.3s">
<?php 
echo '<script>

var sideNav = document.getElementById("mySidenav");
var mainItm = document.getElementById("mainItm");
var popupper = document.getElementById("popupper");
var confBtn = document.getElementById("confBtn");
var curSel = "";
var idVal = 0;

var pops = ["newItem","editItem","newComp","newUser","editUser","newTask","editTask"];

var errTxt = document.getElementById("errTxt");
var errCont = 0;

function runErr() {
	errCont += 1;
	var curErr = errCont;
	errTxt.style.color = "#FFAAAA";
	setTimeout(function () {
		if(errCont==curErr) {
			errTxt.style.color = "#000000";
		}
    }, 500);
	setTimeout(function () {
		if(errCont==curErr) {
			errTxt.innerHTML = "";
		}
    }, 2000);
}

function confirm() {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if(this.readyState == 4 && this.status == 200) {
			window.location.href = "companyPage.php";
			if(this.responseText!="") {
				errTxt.innerHTML = "The required "+this.responseText+" field has not been appropriately filled."
			} else {
				closePop();
				if(curSel=="newComp") {
					
				}
			}
		}
	};
	if(curSel=="newItem") {
		xhttp.open("GET", "addItem.php?nam="+prepID("itemNameNew")+"&itmPic="+prepID("itemPicNew")+"&stock="+prepID("stockNew")+"&sold="+prepID("soldNew")+"&cost="+prepID("costNew")+"&price="+prepID("priceNew"), true);
	} else if(curSel=="editItem") {
		xhttp.open("GET", "changeItem.php?itmSeed="+prepSend(idVal)+"&costCh="+prepID("costCh")+"&sellCh="+prepID("sellCh")+"&stockAdd="+prepID("stockAdd")+"&stockSold="+prepID("stockSold"), true);
	} else if(curSel=="newComp") {
		xhttp.open("GET", "addComp.php?name="+prepID("compNam")+"&pic="+prepID("compPic"), true);
	} else if(curSel=="newUser") {
		xhttp.open("GET", "addUser.php?name="+prepID("potUser")+"&rank="+prepID("rankList"), true);
	}
	xhttp.send();
	closePop();
}

function togMenu() {
	if(popupper) {
		closePop();
	}
	if(sideNav.style.width=="10em") {
		sideNav.style.width = "0em";
		darkener(1);
	} else {
		sideNav.style.width = "10em";
		darkener(.6);
	}
}

function darkener(val) {
	mainItm.style.opacity = val.toString();
}

function getPop(val) {
	for(i=0; i<pops.length; i++) {
		document.getElementById(pops[i]).style.display = "none";
	}
	document.getElementById(val).style.display = "block";
	curSel = val;
	if(val.substring(0,4)=="edit") {
		confBtn.src = "http://i.imgur.com/vIvMw9b.png";
	} else {
		confBtn.src = "http://i.imgur.com/PiunnWN.png";
	}
	
	popupper.style.display = "block";
	sideNav.style.width = "0em";
	darkener(.6);
	
}

function closePop() {
	popupper.style.display = "none";
	curSel = "";
	darkener(1);
}

function logOut() {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if(this.readyState == 4 && this.status == 200) {
			window.location.href = "index.php";
		}
	};
	xhttp.open("GET", "logoutUser.php", true);
	xhttp.send();
}';

if(isset($curPag)) {
	echo 'function updatePg(val) {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if(this.readyState == 4 && this.status == 200) {
			document.getElementById("usersTab").innerHTML = this.responseText;
		}
	}
	xhttp.open("GET", "compChange.php?setComp="+prepID(val)+"&curPag="+prepSend("' . $curPag . '"), true);
	xhttp.send();
	}

updatePg(0);';

}
echo '</script>';
?>