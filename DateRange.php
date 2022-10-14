<?php

function getDateArray($startdate, $enddate ){
	$dates = array();
	$current = strtotime($startdate);
	$last = strtotime($enddate);
	$count = 0;
	while ($current <= $last && $count <7){
		$dates[] = date("Y-m-d", $current);	
		$current = strtotime("+1 day", $current);
		$count+=1;
	
	}
	return $dates;
}

$capacity = $_REQUEST["Capacity"];
$grade = $_REQUEST["Grade"];
$startdate = $_REQUEST["StartDate"];
$enddate = $_REQUEST["EndDate"];

$new_start_date = date("Y-m-d", strtotime($startdate));
$new_end_date = date("Y-m-d", strtotime($enddate));


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
$dateArray = array();

foreach (getDateArray($startdate, $enddate) as $items){
	$dateArray[] = $items;
}

if(mysqli_num_rows($result) > 0){
	$previousVenue = 0 ;
	while($row = mysqli_fetch_array($result)){	
	
		foreach ($dateArray as $date){
			
			$newrow = array('venue_id' => $row[0], 'capacity' => $row[1], 'name' => $row[2],'weekend_price' => $row[3],'weekday_price' => $row[4],
			'licensed' => $row[5],'cost' => $row[6], 'TotalBookings' => $row[7], 'booking_date' => $date);
			
			$sql2 = "SELECT venue_id, booking_date FROM venue_booking WHERE venue_id = ". $row[0]. " AND booking_date = '".$date."';";
			$secondresult = mysqli_query($conn, $sql2);
			
			if(mysqli_num_rows($secondresult) == 0){
				array_push($ResultArray, $newrow);	
			}
		
		}
		
	}	
}
//$finalResultArray = array();

//foreach ($ResultArray as $Result){
//	if($Result != NULL){
//		$finalResultArray[] = $Result;
//	}
//}
echo json_encode($ResultArray);




?>