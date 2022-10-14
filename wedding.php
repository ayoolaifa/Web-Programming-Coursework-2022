<!DOCTYPE html>
<html lang ='en'>
<head>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width'/>
<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3' crossorigin='anonymous'>
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p' crossorigin='anonymous'></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
	$("#WeddingForm").submit(function(){
		let usercapacity = $("#Capacity").val();
		let grade = $("#Grade").val();
		let start = $("#startdate").val();
		let end = $("#enddate").val();
		let error = document.getElementById("errorMessage");
		error.style.color = "red";
		
		if($('#MultiDay').is(':checked')){
			if (grade == "Select from list"){
				error.innerHTML = "Please Select Desired Catering Grade";	
			}else if (new Date(end) < new Date(start)){
				error.innerHTML = "Please Select A End Date That Is After The Start Date"
			}else if (start == end){
				error.innerHTML = "Please Select A Range Of Dates"
			}else{	
				error.innerHTML ="";
				$.post("DateRange.php",{
					Capacity : usercapacity,
					Grade : grade,
					StartDate : start,
					EndDate : end
				}, 		
				function(responseData){
				
					let length = responseData.length;	
					let htmlresult = "";
					let previousVenueID ="";
					for (let i = 0; i < length; i++){	
						let venueID = responseData[i].venue_id;
						let capacity = responseData[i].capacity;
						let name = responseData[i].name;
						let weekend_price = responseData[i].weekend_price;
						let weekday_price = responseData[i].weekday_price;
						let grade = responseData[i].grade;
						let licensed = responseData[i].licensed
						let cost = responseData[i].cost;
						let totalbooking = responseData[i].TotalBookings;
							
						if(licensed == 0){
							licensed = "Yes";
						}else{
							licensed = "No";
						}
						if(venueID != previousVenueID){
							htmlresult += '<div class="card mb-3" style="max-width: 1500px;"><div class="row g-0"><div class="col-md-4"><img src="'+venueID+'.jpg" class="img-fluid rounded-start" alt="'+venueID+'" style="height: 600px"></div><div class="col-md-8">';
							htmlresult += '<div class="card-body">';
							htmlresult += '<h5 class="card-title">'+name+'</h5>';
							htmlresult += '<p class="card-text">Capacity: '+capacity+'</p>';
							htmlresult += '<p class="card-text">Weekday Price: £'+weekday_price+'</p>';
							htmlresult += '<p class="card-text">Weekend Price: £'+weekend_price+'</p>';
							htmlresult += '<p class="card-text">Cost Per Person (Catering): £'+cost+'</p>';
							htmlresult += '<p class="card-text">Licensed: '+licensed+'</p>';
							htmlresult += '<p class="card-text">Number Of Past Bookings: '+totalbooking+'</p>';
							htmlresult += '<h5 class="card-title">Available Dates And Their Total Prices</h5>';
						
							previousVenueID = venueID;
						
							let insertTable = "<table class='table table-striped table-hover'><td>Booking Date</td><td>Day</td><td>Total Price</td>";
							for (let j = 0; j < length; j++){
								let venueID_2 = responseData[j].venue_id;
								if(venueID_2 == venueID){
									let booking_date = responseData[j].booking_date;
									let booking_day = new Date(booking_date).getDay();
									
									let total_price;
									
									if (booking_day == 0 || booking_day == 6){
										total_price = parseInt(weekend_price) + (parseInt(cost) * usercapacity);
									}
									else {
										total_price = parseInt(weekday_price) + (parseInt(cost) * usercapacity);
									}
								
								
									if(booking_day == 0){
										booking_day = "Sunday";
									}else if(booking_day == 1){
										booking_day = "Monday";
									}else if(booking_day == 2){					
										booking_day = "Tuesday";					
									}else if(booking_day == 3){
										booking_day = "Wednesday";					
									}else if(booking_day == 4){
										booking_day = "Thursday";					
									}else if(booking_day == 5){
										booking_day = "Friday";						
									}else if(booking_day == 6){
										booking_day = "Saturday";
									}
								
									insertTable +=  "<tr>" + "<td>" + booking_date + "</td>" + 
													"<td>" + booking_day + "</td>" +
													"<td>£" + total_price + "</td>" +
													"</tr>";
														
								}
							}
							insertTable += "</table>";
							htmlresult += insertTable +'</div></div></div></div>';				
						}
					}
					$("#result").html(htmlresult);
				}, "json");
			}
		}else{
			if (grade == "Select from list"){
				error.innerHTML = "Please Select Desired Catering Grade";	
			}else{
				error.innerHTML ="";
				$.post("SingleDate.php",{
					Capacity : usercapacity,
					Grade : grade,
					Date : start
				}, 		
				function(responseData){
					let length = responseData.length;	
					let htmlresult = "";
					let previousVenueID ="";
					for (let i = 0; i < length; i++){	
						let venueID = responseData[i].venue_id;
						let capacity = responseData[i].capacity;
						let name = responseData[i].name;
						let weekend_price = responseData[i].weekend_price;
						let weekday_price = responseData[i].weekday_price;
						let grade = responseData[i].grade;
						let licensed = responseData[i].licensed
						let cost = responseData[i].cost;
						let totalbooking = responseData[i].TotalBookings;
						let booking_date = responseData[i].booking_date;
						let booking_day = new Date(booking_date).getDay();
									
						let total_price;
							
						if(licensed == 0){
							licensed = "Yes";
						}else{
							licensed = "No";
						}
						
						if (booking_day == 0 || booking_day == 6){
							total_price = parseInt(weekend_price) + (parseInt(cost) * usercapacity);
						}
						else {
							total_price = parseInt(weekday_price) + (parseInt(cost) * usercapacity);
						}
					
					
						if(booking_day == 0){
							booking_day = "Sunday";
						}else if(booking_day == 1){
							booking_day = "Monday";
						}else if(booking_day == 2){					
							booking_day = "Tuesday";					
						}else if(booking_day == 3){
							booking_day = "Wednesday";					
						}else if(booking_day == 4){
							booking_day = "Thursday";					
						}else if(booking_day == 5){
							booking_day = "Friday";						
						}else if(booking_day == 6){
							booking_day = "Saturday";
						}
						
						htmlresult += '<div class="card mb-3" style="max-width: 1500px;"><div class="row g-0"><div class="col-md-4"><img src="'+venueID+'.jpg" class="img-fluid rounded-start" alt="'+venueID+'" style="height: 600px"></div><div class="col-md-8">';
						htmlresult += '<div class="card-body">';
						htmlresult += '<h5 class="card-title">'+name+'</h5>';
						htmlresult += '<p class="card-text">Capacity: '+capacity+'</p>';
						htmlresult += '<p class="card-text">Weekday Price: £'+weekday_price+'</p>';
						htmlresult += '<p class="card-text">Weekend Price: £'+weekend_price+'</p>';
						htmlresult += '<p class="card-text">Cost Per Person (Catering): £'+cost+'</p>';
						htmlresult += '<p class="card-text">Licensed: '+licensed+'</p>';
						htmlresult += '<p class="card-text">Number Of Past Bookings: '+totalbooking+'</p>';
						htmlresult += '<p class="card-text">Available Booking Date: '+booking_date+'</p>';
						htmlresult += '<p class="card-text">Day Of Available Booking: '+booking_day+'</p>';
						htmlresult += '<p class="card-text">Total Price: '+total_price+'</p>';
						htmlresult += '</div></div></div></div>';	
					
					}
					$("#result").html(htmlresult);
				}, "json");
			}
		}
	});
});
</script>

<style>
	.col-md {
		padding-top: 10px; //just top padding
		padding-right: 10px; //just right padding
		padding-bottom: 15px; //just bottom padding
		padding-left: 20px; //just left padding
	}
</style>
</head>

<body>
<header>
  <nav class='navbar navbar-expand-md navbar-dark fixed-top bg-dark'>
  </nav>
</header>

<main style="background-color: #eae7e2";>
<nav class="navbar" style="background-color: #eae7e2";>
  <div class="container-fluid">
  <img width = "150px" src ="hossein.jpg">
  <h1>Hossein & A's Wedding Venue Bookers</h1>
  </div>
</nav>

  <div id='carouselExampleCaptions' class='carousel slide' data-bs-ride='carousel'>

  <div class='carousel-indicators'>
    <button type='button' data-bs-target='#carouselExampleCaptions' data-bs-slide-to='0' class='active' aria-current='true' aria-label='Slide 1'></button>
    <button type='button' data-bs-target='#carouselExampleCaptions' data-bs-slide-to='1' aria-label='Slide 2'></button>
    <button type='button' data-bs-target='#carouselExampleCaptions' data-bs-slide-to='2' aria-label='Slide 3'></button>
  </div>
  <div class='carousel-inner' >
    <div class='carousel-item active' data-bs-interval="10000">
      <img height="600px" src='wedding_picture_1.jpg' class='d-block w-100' alt='1'>
      <div class='carousel-caption d-none d-md-block'>
        <h2>Book Your Perfect Wedding Venue Now</h2>
      </div>
    </div>
    <div class='carousel-item' data-bs-interval="10000">
      <img  height="600px" src='wedding_picture_2.jpg' class='d-block w-100' alt='2'>
      <div class='carousel-caption d-none d-md-block'>
        <h2>Choose Venue Based On Different Criterias </h2>
      </div>
    </div>
    <div class='carousel-item' data-bs-interval="10000">
      <img height="600px" src='wedding_picture_3.jpg' class='d-block w-100' alt='3'>
      <div class='carousel-caption d-none d-md-block'>
      <h2>View When Venues Are Available</h2>
      </div>
    </div>
  </div>
  <button class='carousel-control-prev' type='button' data-bs-target='#carouselExampleCaptions' data-bs-slide='prev'>
    <span class='carousel-control-prev-icon' aria-hidden='true'></span>
    <span class='visually-hidden'>Previous</span>
  </button>
  <button class='carousel-control-next' type='button' data-bs-target='#carouselExampleCaptions' data-bs-slide='next'>
    <span class='carousel-control-next-icon' aria-hidden='true'></span>
    <span class='visually-hidden'>Next</span>
  </button>
</div>
 
<hr class='featurette-divider'>    
<div class="form-check form-switch form-check-inline">
	<input class="form-check-input" type="radio" name="flexRadioDefault" id="SingleDay" onchange="checkRadio(this)"  checked>
	<label class="form-check-label" for="flexRadioDefault1">Single Day Search</label>
</div>
<div class="form-check form-switch form-check-inline" >
	<input class="form-check-input" type="radio" name="flexRadioDefault" id="MultiDay"  onchange="checkRadio(this)">
	<label class="form-check-label" for="flexRadioDefault2">Multiple Day Search</label>
</div>
<hr class='featurette-divider'>   	
	<form id='WeddingForm' method = 'POST' onSubmit='return false'>
			<div class="row g-2">
				<div class="col-md">
					<div class="form-floating">
						<label class="form-label" for='Capacity'>Capacity: <span id="capacityNum"></span></label>
						<input name='Capacity' type='range' class="form-range" id='Capacity' value='50' min= "50" max = "1000" step="50" required>				
					</div>
				</div>
				<div class="col-md" padding="5px 10px 15px 20px">
					<div class="form-floating">
						<select class="form-select" id='Grade' required>
							<option selected>Select from list</option>
							<option value="1">1 - Okay</option>
							<option value="2">2 - Fair</option>
							<option value="3">3 - Good</option>
							<option value="4">4 - Great</option>
							<option value="5">5 - Excellent</option>
						</select>
						<label for="Grade" class="form-label">Grade</label>
					</div>
				</div>
			</div>
			<div class="row g-2">
				<div class="col-md" padding: 5px 10px 15px 20px;>
					<div class="form-floating">
						<input name='StartDate'class="form-control" type='date' id='startdate' min = '2022-01-01' required>
						<label for='Date'class="form-label">Start Date:</label>
					</div>
				</div>
				<div class="col-md">
					<div class="form-floating">	
						<input name='EndDate' class="form-control" type='date' id='enddate' min = '2022-01-01' disabled='true' required><br>
						<label for='Date' class="form-label">End Date:</label>
					</div>
				</div>
			<br>
			</div>
		<div class="d-grid gap-2 col-6 mx-auto">	
			<input class="btn btn-primary btn-light btn-outline-dark" type='submit' name='submit' id='capacitySubmit' value='Submit' on/>
		</div>
		
	</form>
	 <center><span id="errorMessage"></span></center>

    <hr class='featurette-divider'>
<div id='result'></div>
 <script>
 document.getElementById('startdate').setAttribute('min', new Date().toISOString().split('T')[0]);
 document.getElementById('enddate').setAttribute('min',  new Date().toISOString().split('T')[0]);
 
var slider = document.getElementById("Capacity");
var outputSpam = document.getElementById("capacityNum");
outputSpam.innerHTML = "&emsp;" + slider.value;

slider.oninput = function() {
  outputSpam.innerHTML ="&emsp;" + this.value;
}
function checkRadio(radio){
	if(radio.checked && radio.id == 'SingleDay'){
		document.getElementById('enddate').disabled = true;
	}else{
		document.getElementById('enddate').disabled = false;
	}
}
  
</script>

</main>
</body>
</html>

