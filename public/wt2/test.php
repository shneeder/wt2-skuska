<?php
include_once 'config.php';
$conn = mysqli_connect($servername, $username, $password, $dbname);

echo "fasdfasd ahoj";
echo $_REQUEST['user_id_test'];
echo $_REQUEST['submit'];
echo $_REQUEST['km'];

if( isset($_REQUEST['submit']))
{
    $userID=$_REQUEST['user_id_test'];
    $cesta=0;
    $sql = "SELECT * FROM active where id_user = '$userID'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $cesta=$row["is_route"];
        }
    }
    $sql = "INSERT INTO training (already_run_km, datum, exact_time, finish_time, user_id, route_id, evaluation, note, gpsStartLng,gpsStartLat,gpsCielLng,gpsCielLat)
VALUES ('".$_REQUEST['km']."','".$_REQUEST['datum']."','".$_REQUEST['casZaciatok']."','".$_REQUEST['casKoniec']."','".$userID."','".$cesta."','".$_REQUEST['evaluation']."','".$_REQUEST['poznamka']."',
'".$_REQUEST['gpsStartLng']."','".$_REQUEST['gpsStartLat']."','".$_REQUEST['gpsCielLng']."','".$_REQUEST['gpsCielLat']."')";

    if ($conn->query($sql) === TRUE) {
        echo "Bol pridanný nový tréning.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    //echo "<script>definuj()</script>";


    header("Location: /home/active");

} else {
    echo "Nedostali sme sa kam sme sa dostat mali...";
}




?>