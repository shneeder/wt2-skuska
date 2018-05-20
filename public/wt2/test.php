<?php
include_once 'config.php';
$conn = mysqli_connect($servername, $username, $password, $dbname);

if( isset($_POST['user_id_test']))
{
    $userID=$_POST['user_id_test'];
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
VALUES ('".$_POST['km']."','".$_POST['datum']."','".$_POST['casZaciatok']."','".$_POST['casKoniec']."','".$userID."','".$cesta."','".$_POST['evaluation']."','".$_POST['poznamka']."',
'".$_POST['gpsStartLng']."','".$_POST['gpsStartLat']."','".$_POST['gpsCielLng']."','".$_POST['gpsCielLat']."')";

    if ($conn->query($sql) === TRUE) {
        echo "Bol pridanný nový tréning.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    //echo "<script>definuj()</script>";


    //header("Location: aktivna.php");

}




?>