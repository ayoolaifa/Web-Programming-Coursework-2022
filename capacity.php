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
$min = $_GET["minCapacity"];
$max = $_GET["maxCapacity"];
$servername = "sci-mysql";
$username = "coa123wuser";
$password = "grt64dkh!@2FD";
$dbname = 'coa123wdb';
echo "<style> h1 { color:red; } </style>";
if(intval($max) < 0){
	echo "<center><h1>Input A Maximum Value That is Greater Than Zero</h1></center>";
}else if (intval($min) < 0){
	echo "<center><h1>Input A Minimum Value That is Greater Than Zero</h1></center>";
}else if (intval($max) < intval($min)){
	echo "<center><h1>Input A Maximum Value That is Greater Than The Minimum Value</h1></center>";
}else{

	$conn = new mysqli($servername, $username, $password, $dbname);

	if (mysqli_connect_error()) {
	  die("Connection failed: " . mysqli_connect_error());
	}

	$sql ="SELECT name, capacity, weekend_price, weekday_price, grade, cost
						FROM venue INNER JOIN catering 
						ON catering.venue_id = venue.venue_id 
						WHERE capacity >= ". $min . 
						" AND capacity <= " . $max ."
						AND licensed >0 ORDER BY capacity;";

	$result = mysqli_query($conn, $sql);

	if(mysqli_num_rows($result) > 0){
		echo "<table class = 'table table-striped table-hover'>";
		echo "<td>name</td><td>capacity</td><td>weekend_price</td><td>weekday_price</td><td>Grade</td><td>Cost Per Person</td>";
		while($row = mysqli_fetch_array($result)){
			echo "<tr>";
			echo "<td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>£" . $row[2] . "</td><td>£" . $row[3] . "</td><td>" . $row[4] . "</td><td>£" . $row[5] . "</td>";
			echo "</tr>";
		}
		echo "</table>";
	}else{
		echo "<p>No Venues Have Been Found</p>";
	}
}
?>

</body>
</html>