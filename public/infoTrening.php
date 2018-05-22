<html lang="sk">
<head>
    <meta charset="UTF-8">
	<link rel="icon" type="image/png" href="./ico/ico.png">
	<link rel="stylesheet" href="style.css">
    <title >Zadanie2</title> 
	<style>
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}
</style>
</head>
<body>
<p class="nadpis" ><b>uloha 8</b></p>
<table id="myTable" class="table" border='1' cellpadding='10'>
<tr><th>Meno</th> <th>Vzdialenost(KM)</th> <th>Datum</th> <th>GPSstartSIRKA</th> <th>GPSstartVYSKA</th> <th>GPScielSIRKA</th> <th>GPScielVYSKA</th> <th>Zaciatok</th> <th>Koniec</th> <th>Poznámka</th> </tr>

<?php
include('config.php');

$id = $_SESSION['id'];
$JeAdmin = "SELECT isAdmin FROM users WHERE id = '$id'";
$result = $conn->query($JeAdmin);
$row = $result->fetch_assoc();
$isAdmin = $row['isAdmin'];




if ($isAdmin == 1){
	$sql = "SELECT * FROM users u JOIN training t ON u.id = t.user_id";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		echo 'Prihlaseny je: "ADMIN"'; 
		while ($row = $result->fetch_assoc()) {
			?>
				<tr>
				<td><?php echo $row['name'] ?></td>
				<td><?php echo $row['already_run_km'] ?></td>
				<td><?php echo $row['datum'] ?></td>
				<td><?php echo $row['gpsStartLng'] ?></td>
				<td><?php echo $row['gpsStartLat'] ?></td>
				<td><?php echo $row['gpsCielLng'] ?></td>
				<td><?php echo $row['gpsCielLat'] ?></td>
				<td><?php echo $row['finish_time'] ?></td>
				<td><?php echo $row['exact_time'] ?></td>
				<td><?php echo $row['note'] ?></td>
			</tr>
			
			<?php
		}
	}
}
else{
	$sql2 = "SELECT * FROM users u JOIN training t ON u.id = t.user_id WHERE user_id = '$id'";
	$result = $conn->query($sql2);
	if($result->num_rows > 0) {
		echo 'Prihlaseny je: "USER"'; 
		while ($row = $result->fetch_assoc()) {  
			?>
				<tr>
				<td><?php echo $row['name'] ?></td>
				<td><?php echo $row['already_run_km'] ?></td>
				<td><?php echo $row['datum'] ?></td>
				<td><?php echo $row['gpsStartLng'] ?></td>
				<td><?php echo $row['gpsStartLat'] ?></td>
				<td><?php echo $row['gpsCielLng'] ?></td>
				<td><?php echo $row['gpsCielLat'] ?></td>
				<td><?php echo $row['(finish_time-exact_time)'] ?></td>
				<td><?php echo $row['(already_run_km/(finish_time-exact_time))'] ?></td>
				<td><?php echo $row['note'] ?></td>
			</tr>
			<?php
		}
	}
}



?>

</body>
</html>