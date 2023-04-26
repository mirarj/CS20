<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Two Owls Cafe - Menu</title>
<style>
	html,body,select {font-size: 25px;}
	h1 {margin-bottom:0px}
	h2 {margin-top:0px}
	table {width:80%; max-width:800px}
	td {text-align:center; width:200px; border-bottom:1px dotted}
	td:first-child {max-width:100px}
	td:last-child {max-width:100px}
	a.home{text-decoration: none; color: black;}
</style>
</head>

<body>

<a href='./orders_admin.php'>Admin</a>
<a class='home' href='./index.php'><h1>Two Owls Cafe</h1></a>
<h2>Hours: 8pm - 3am Daily</h2>
<h3>Menu</h3>


<form method="get" id="form1" action="order_details.php">
	<table border="0" cellpadding="3">
		<tr>
			<th>Quantity</th>
			<!-- <th></th> -->
			<th>Item</th>
			<th>Cost</th>
		</tr>
	<?php
		//establish connection info
		$server = "35.212.65.183";
		$userid = "u0qw5mzxxutfs";
		$pw = "k1nwmps94r8z";
		$db = "dbvbgpkarre4xg";
		$conn = new mysqli($server, $userid, $pw, $db);

		// get data
		$sql = "SELECT * from menu_items ORDER BY name";
		$result = $conn->query($sql);

		// display data
		foreach ($result as $rowid=>$rowdata) {
			echo "<tr>";
			echo "<td class='selectQuantity'><select name='quant_".$rowdata["id"]."' size='1'>";
			for ($i = 0; $i <= 10; $i++) {
				echo "<option>".$i."</option>";
			}
			echo "</select></td>";
			// echo "<td><img width=50px src=./test_img.jpg".$rowdata["image"]."></td>";
			echo "<td>".$rowdata["name"]."</td>";
			echo "<td class='itemCost'> \$".$rowdata["cost"]."</td>";
			echo"</tr>";
		}
		$conn->close();
	?>
	</table>

	<p class="userInfo"><label>First Name:</label> <input type="text"  name='fname' /></p>
	<p class="userInfo"><label>Last Name:</label>  <input type="text"  name='lname' /></p>
	<p class="userInfo"><label>Special Instructions:</label>  <input type="textarea" name='instructions' /></p>

	<input type = "hidden" name="timeoffset" id="timeoffset" hidden="true">

	<input type = "submit" value = "Submit Order" />
</form>

<script>

	item_quants = document.querySelectorAll("td.selectQuantity select");
	form_obj = document.querySelector("#form1");
	date = document.querySelector("#timeoffset");
	userinfo = document.querySelectorAll(".userInfo input");

	form_obj.onsubmit = function() { 
		
		// validate name is entered
		if (userinfo[0].value=='' || userinfo[1].value=='') {
			alert("Please enter your full name.");
			return false;
		}

		// validate some item ordered
		something_ordered = false;
		item_quants.forEach(e => {
			if (e.value != '0') {
				something_ordered = true;
			}
		});
		if (!something_ordered) {
			alert("Please order at least one item.");
			return false;
		}

		// validate time
		now = new Date();
		date.value = now.getTimezoneOffset();

		open = new Date();
		open.setHours(20,0,0,0);
		close = new Date();
		close.setHours(2,30,0,0);

		if (now>close && now<open) {
			alert("Sorry, we only accept orders between 8:00 PM and 2:30 AM.")
			return false;
		}

		return true;

	}

</script>


</body>
</html>
