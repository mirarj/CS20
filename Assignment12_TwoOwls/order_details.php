<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Two Owls Cafe - Order Details</title>
<style>
	html,body,select {font-size: 25px;}
	h1 {margin-bottom:0px}
	h2 {margin-top:0px}
	table {width:80%; max-width:800px}
    table.totals {font-weight:bold}
	td {min-width:200px; border-bottom:1px dotted}
    a.home{text-decoration: none; color: black;}
</style>

</head>

<body>

<a class='home' href='./index.php'><h1>Two Owls Cafe</h1></a>
<h2>Hours: 8pm - 3am Daily</h2>
<h3>Order Details</h3>
<p>Thank you for ordering! Print this page to save your receipt.</p>

<?php
    //establish connection info
    $server = "35.212.65.183";
    $userid = "u0qw5mzxxutfs";
    $pw = "k1nwmps94r8z";
    $db = "dbvbgpkarre4xg";
    $conn = new mysqli($server, $userid, $pw, $db);

    // get data
    $sql = "SELECT * from menu_items";
    $result = $conn->query($sql);

    $subtotal = 0;
    echo "<table>";
	foreach ($result as $rowid=>$rowdata) {

        $varname = "quant_".$rowdata['id'];
        $quant = $_GET[$varname];

        if ($quant > 0) {
        
            $itemtotal = $quant * $rowdata['cost'];
            $subtotal = $subtotal + $itemtotal;
            echo "<tr><td>" . $rowdata['name'] . " (".$quant.") :</td><td>$" . number_format($itemtotal,2) . "</td></tr>";    

        }

    }
    $tax = $subtotal * 0.0625;
    $total = $subtotal + $tax;

    echo "</table class='totals'><br><table>";
    echo "<tr><td>Subtotal :</td><td>$" . number_format($subtotal, 2) . "</td></tr>";
    echo "<tr><td>Tax :</td><td>$" . number_format($tax, 2) . "</td></tr>";
    echo "<tr><td>Total :</td><td>$" . number_format($total, 2) . "</td></tr>";
    echo "</table>";

    $now = new DateTimeImmutable("now", $timezone=new DateTimeZone("UTC"));
    $now = $now->getTimestamp();
    $ordered = $now - ($_GET['timeoffset'] * 60);
    $pickup = $ordered + (15 * 60);
    $ordered = new DateTimeImmutable("@".$ordered);
    $pickup = new DateTimeImmutable("@".$pickup);
    echo "<br>Pickup at ".$pickup->format('g:i A D M d')."<br>";

    $ordered_format = $ordered->format('Y-m-d H:i:s');
    $sql = "INSERT INTO `orders`(`id`, `FirstName`, `LastName`, `Date`, `TotalPrice`) VALUES ('DEFAULT','".$_GET['fname']."','".$_GET['lname']."','".$ordered_format."','".$total."')";
    $result = $conn->query($sql);

?>
</body>
</html>