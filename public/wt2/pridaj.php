<?php
include_once 'config.php';
/*$conn = mysqli_connect($servername, $username, $password, $dbname);

if( isset($_POST['submit3']))
{
    $userID=$_POST['user_id'];

    $sql = "INSERT INTO route (startLng, startLat, finistLng, finistLat, typ, id_user)
VALUES ('".$_POST['gpsStartLng']."','".$_POST['gpsStartLat']."','".$_POST['gpsCielLng']."','".$_POST['gpsCielLat']."','".$_POST['mod']."','".$userID."')";

    if ($conn->query($sql) === TRUE) {
        echo "Trasa bola uložená!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    //header("Location: zoznam.php");

}*/
$conn = mysqli_connect($servername, $username, $password, $dbname);
$userID=$_POST['user_id'];




$sql = "INSERT INTO route (startLng, startLat, finistLng, finistLat, typ, id_user)
VALUES ('".$_POST['q1']."','".$_POST['q2']."','".$_POST['q3']."','".$_POST['q4']."','".$_POST['q5']."','".$userID."')";

if ($conn->query($sql) === TRUE) {
    // echo "New record created successfully";
    $sql2 = "SELECT * FROM route WHERE id_user=".$userID." AND typ='private' OR typ='public' ORDER BY ID DESC LIMIT 1";
    $result = $conn->query($sql2);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo $row["id"];
            echo "<tr class='uziv' id='".$row["id"]."'> <td  class='".$row["id"]."'>" . $_POST['q1'] . "</td><td>" . $_POST['q2'] ."</td><td>" . $_POST['q3'] ."</td><td>" . $_POST['q4'] ."</td><td>neaktivna</td><td>" . $_POST['q5'] ."</td><td><button onclick='myFunction(".$userID.",".$row["id"].")'>Aktivuj</button></td></tr>";
        }
    }


} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();




?>