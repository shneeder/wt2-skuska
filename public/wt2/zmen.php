<?php
include_once 'config.php';
$conn = mysqli_connect($servername, $username, $password, $dbname);


$user = $_POST['user'];
$cesta = $_POST['cesta'];

$sql = "SELECT * FROM active where id_user='$user'";
$result = $conn->query($sql);


$sql = "UPDATE active SET is_route='".$cesta."'WHERE id_user= '$user'";


if ($result->num_rows == 0) {
    // output data of each row
    $sql = "INSERT INTO active (is_route, id_user)  VALUES ('".$cesta."','$user')";

}


if ($conn->query($sql) === TRUE) {
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
//header("Location: zoznam.php");


?>