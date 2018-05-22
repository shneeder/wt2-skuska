<?php
include_once 'config.php';
$conn = mysqli_connect($servername, $username, $password, $dbname);


$user = $_POST['user'];
$cesta = $_POST['cesta'];

$sql = "SELECT * FROM active where id_user='$user'";
$result = $conn->query($sql);




if ($result->num_rows == 0) {
    // output data of each row
    $sql2 = "INSERT INTO active (is_route, id_user)  VALUES ('".intval($cesta)."','".intval($user)."')";

}
else
    $sql2 = "UPDATE active SET is_route='".intval($cesta)."'WHERE id_user= '$user'";

echo $sql2;

if ($conn->query($sql2) === TRUE) {
    //header("Location: /home/active");
    echo "Update bol vykonany!";

} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();


?>