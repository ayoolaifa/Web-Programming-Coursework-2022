<!DOCTYPE html>
<html lang ="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</head>

<body>


<?php
$month = $_GET["month"];
if (intval($month) < 10){
	$month = '0'.$month;
}
$servername = "sci-mysql";
$username = "coa123wuser";
$password = "grt64dkh!@2FD";
$dbname = 'coa123wdb';

$conn = new mysqli($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql ="SELECT name, COUNT(booking_date) 
		FROM venue INNER JOIN venue_booking 
		WHERE venue.venue_id = venue_booking.venue_id 
		AND booking_date LIKE '%-$month-%' 
		GROUP BY name 
		ORDER BY COUNT(booking_date) DESC;";
		
				

$result = mysqli_query($conn, $sql);

echo "<style> table, th, td {border: 1px solid black;} </style>";
if ($month == "01"){
	$month = "January";
}if ($month == "02"){
	$month = "February";
}if ($month == "03"){
	$month = "March";
}if ($month == "04"){
	$month = "April";
}if ($month == "05"){
	$month = "May";
}if ($month == "06"){
	$month = "June";
}if ($month == "07"){
	$month = "July";
}if ($month == "08"){
	$month = "August";
}if ($month == "09"){
	$month = "September";
}if ($month == "10"){
	$month = "October";
}if ($month == "11"){
	$month = "November";
}if ($month == "12"){
	$month = "December";
}
if(mysqli_num_rows($result) > 0){
	echo "<table class = 'table table-striped table-hover'>";
	echo "<td>Venue Name</td><td>No Of Previous Bookings In Month Of " . $month . "</td>";
	while($row = mysqli_fetch_array($result)){
		echo "<tr>";
		echo "<td>" . $row[0] . "</td><td>" . $row[1] . "</td>";
		echo "</tr>";
	}
	echo "</table>";
}
?>

</body>
</html>