<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Two Owls Cafe - Show Orders</title>
<style>
	html,body,select {font-size: 25px;}
	h1 {margin-bottom:0px}
	h2 {margin-top:0px}
	table {width:80%; max-width:800px}
    td {text-align:center; width:200px; border-bottom:1px dotted}
    a.home{text-decoration: none; color: black;}
</style>

</head>

<body>

<a class='home' href='./index.php'><h1>Two Owls Cafe</h1></a>
<h2>Hours: 8pm - 3am Daily</h2>
<h3>Order History</h3>

<?php
    //establish connection info
    $server = "35.212.65.183";
    $userid = "u0qw5mzxxutfs";
    $pw = "k1nwmps94r8z";
    $db = "dbvbgpkarre4xg";
    $conn = new mysqli($server, $userid, $pw, $db);

    // get data
    $sql = "SELECT * from orders ORDER BY date DESC";
    $result = $conn->query($sql);

    $subtotal = 0;
    echo "<table><tr><th>Name</th><th>Date</th><th>Total</th></tr>";
	foreach ($result as $rowid=>$rowdata) {
        $date = new DateTimeImmutable($rowdata['Date']);
        $date_format = $date->format('m/d/y h:i A');
        echo "<tr><td>" . $rowdata['LastName'] . ", " . $rowdata['FirstName'] . "</td><td>" . $date_format . "</td><td>$" . number_format($rowdata['TotalPrice'],2) . "</td></tr>";
    }

    echo "</table>";

?>
</body>
</html>