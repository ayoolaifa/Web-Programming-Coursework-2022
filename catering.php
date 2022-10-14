<!DOCTYPE html>
<html lang ="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width"/>
<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3' crossorigin='anonymous'>
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p' crossorigin='anonymous'></script>
</head>

<body>


<?php
$min = $_GET["min"];
$max = $_GET["max"];
$colums = array($_GET["c1"],$_GET["c2"],$_GET["c3"],$_GET["c4"],$_GET["c5"]);

echo "<table class='table table-striped table-hover'>";
echo "<th><pre>cost per person -> 
↓ party size.</pre></th>";
foreach ($colums as $item){
	echo "<th>$item</th>";
}

for ($i=$min;$i<=$max;$i+=5){
	echo "<tr>";
	echo "<th>$i</th>";
	foreach ($colums as $item){
		echo '<td>£'.$i*$item.'</td>';
	}
	echo "</tr>";
}
echo "</table>";

?>

</body>
</html>