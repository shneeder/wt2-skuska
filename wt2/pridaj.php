<?php
include_once 'config.php';
$conn = mysqli_connect($servername, $username, $password, $dbname);

if( isset($_POST['submit3']))
{
    $userID=1;

    $sql = "INSERT INTO route (startLng, startLat, finistLng, finistLat, typ, id_user)
VALUES ('".$_POST['gpsStartLng']."','".$_POST['gpsStartLat']."','".$_POST['gpsCielLng']."','".$_POST['gpsCielLat']."','".$_POST['mod']."','".$userID."')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    header("Location: zoznam.php");

}




?>