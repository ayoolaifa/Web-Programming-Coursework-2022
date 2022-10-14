<?php
$capacity = $_REQUEST["Capacity"];
$grade = $_REQUEST["Grade"];
$date = $_REQUEST["Date"];

$new_date = date("Y-m-d", strtotime($date));


$servername = "sci-mysql";
$username = "coa123wuser";
$password = "grt64dkh!@2FD";
$dbname = 'coa123wdb';

$conn = new mysqli($servername, $username, $password, $dbname);

if (mysqli_connect_error()) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql ="SELECT 
venue_booking.venue_id,
capacity, 
name, 
weekend_price,  
weekday_price, 
licensed,
cost,
COUNT(booking_date) AS 'TotalBookings'
FROM venue 
INNER JOIN catering 
ON catering.venue_id = venue.venue_id
INNER JOIN venue_booking
ON venue_booking.venue_id = catering.venue_id
WHERE capacity >= ". $capacity ."
AND grade = ".$grade."
GROUP BY name, capacity, licensed, grade, cost, weekend_price, weekday_price, venue_id;";


		
$result = mysqli_query($conn, $sql);
$ResultArray = array();


if(mysqli_num_rows($result) > 0){
	$previousVenue = 0 ;
	while($row = mysqli_fetch_array($result)){	
		$newrow = array('venue_id' => $row[0], 'capacity' => $row[1], 'name' => $row[2],'weekend_price' => $row[3],'weekday_price' => $row[4],
		'licensed' => $row[5],'cost' => $row[6], 'TotalBookings' => $row[7], 'booking_date' => $date);
			
		$sql2 = "SELECT venue_id, booking_date FROM venue_booking WHERE venue_id = ". $row[0]. " AND booking_date = '".$new_date."';";
		$secondresult = mysqli_query($conn, $sql2);
			
		if(mysqli_num_rows($secondresult) == 0){
			array_push($ResultArray, $newrow);	
		}
	}	
}	

echo json_encode($ResultArray);
?>