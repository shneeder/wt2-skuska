<!DOCTYPE html>
<html>
<head>
    <title>Tina - zad8</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" >

    <link rel="stylesheet" href="style.css">

</head>
<body>
<div class="container">

    <div class="row">
        <h1>Zoznam trás</h1>
    </div>
    <div class="row">

        <table id="zoznam">

            <tr>
                <th>start lng</th>
                <th>start lat</th>
                <th>ciel lng</th>
                <th>ciel lat</th>
                <th>stav</th>
                <th>mod</th>
                <th></th>

            </tr>

            <?php
            require "./config.php";

            // Create connection
            $userID=2;
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            $rola=1;
            $sql = "SELECT * FROM role_user where user_id='$userID'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    $rola= $row["role_id"];
                }
            }

            $sql = "SELECT * FROM route JOIN active ON route.id = active.is_route where active.id_user='$userID'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr class='uziv' id='".$row["id"]."'> <td  class='".$row["id"]."'>" . $row["startLng"] . "</td><td>" . $row["startLat"] ."</td><td>" . $row["finistLng"] ."</td><td>" . $row["finistLat"] ."</td><td>aktivna</td><td>" . $row["typ"] ."</td></tr>";
                }
            }


            $sql = "SELECT * FROM route WHERE id_user=".$userID." AND typ='private' OR typ='public'";
            if($rola==2)
                $sql = "SELECT * FROM route";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr class='uziv' id='".$row["id"]."'> <td  class='".$row["id"]."'>" . $row["startLng"] . "</td><td>" . $row["startLat"] ."</td><td>" . $row["finistLng"] ."</td><td>" . $row["finistLat"] ."</td><td>neaktivna</td><td>" . $row["typ"] ."</td><td><button onclick='myFunction(".$userID.",".$row["id"].")'>Aktivuj</button></td></tr>";
                }
            }

            ?>
        </table>
        <form id="myForm" action="trasa.php" method="post">

            <input type='hidden' name='idcko' id="idcko" value='0'>
        </form>
        <script>

            $("#zoznam tr").click(function() {
                var pom=parseInt( document.getElementById(this.id).children[0].className);
                document.getElementById("idcko").value = pom;
                document.getElementById('myForm').submit();

            });

            function myFunction(id_u,id){
                $.post("zmen.php", {user:id_u, cesta:id})
            }

        </script>
    </div>

    <?php
    if($rola==2){
        echo"<div class='row'>";
        echo"<h1>Trasy uzivatela</h1>";
        echo"</div>";

        echo"<div class='row'>";

        include_once ('config.php');
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        $query = "SELECT * FROM users join role_user on users.id=role_user.user_id where role_user.role_id=1";
        $result = $conn->query ($query);
        echo "<form method='post' >";

        echo "<select name='dropdown'  id='dropdown' >";
        //echo "<option value='0'></option>";
        while($r = $result->fetch_assoc()) {
            echo "<option value=".$r['id'].">".$r['email']."</option>";
        }
        echo "</select>";
        echo "<input class='subm' type='submit' value='Submit' name='submit2'>";

        echo "</form>";
        echo"</div>";
        echo"<div class='row'>";

        $conn->close();

        if( isset($_POST['submit2']))
        {
            $conn = mysqli_connect($servername, $username, $password, $dbname);

            echo " <table id='zoznam2'><tr><th>start lng</th><th>start lat</th><th>ciel lng</th><th>ciel lat</th><th>stav</th><th>mod</th><th></th></tr>";
            $sql = "SELECT * FROM route JOIN active ON route.id = active.is_route where active.id_user=".$_POST['dropdown']."";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr class='uziv' id='".$row["id"]."'> <td  class='".$row["id"]."'>" . $row["startLng"] . "</td><td>" . $row["startLat"] ."</td><td>" . $row["finistLng"] ."</td><td>" . $row["finistLat"] ."</td><td>aktivna</td><td>" . $row["typ"] ."</td></tr>";
                }
            }

            $sql = "SELECT * FROM route WHERE id_user=".$_POST['dropdown']." AND typ='private' OR typ='public'";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr class='uziv' id='".$row["id"]."'> <td  class='".$row["id"]."'>" . $row["startLng"] . "</td><td>" . $row["startLat"] ."</td><td>" . $row["finistLng"] ."</td><td>" . $row["finistLat"] ."</td><td>neaktivna</td><td>" . $row["typ"] ."</td></tr>";
                }
            }

            $conn->close();

            echo "</table>";
        }

        echo"</div>";

    }
    ?>

    <div class="row">

        <form action="pridaj.php" method="post">
            <h1>Pridaj novu trasu</h1>
            <label>Mod</label>
            <select id="mod" name="mod">
                <option value="private">private</option>
                <option value="public">public</option>
                <option value="stafeta">stafeta</option>
            </select><br>

            <label for="gpsStartLng">gpsStartLng</label>
            <input id="gpsStartLng" type="text" name="gpsStartLng" value="<?php echo htmlspecialchars($pom); ?>" ><br>

            <label for="gpsStartLat">gpsStartLat</label>
            <input id="gpsStartLat" type="text" name="gpsStartLat" value="<?php echo htmlspecialchars($pom2); ?>" ><br>

            <label for="gpsCielLng">gpsCielLng</label>
            <input id="gpsCielLng" type="text" name="gpsCielLng" value="0"><br>

            <label for="gpsCielLat">gpsCielLat</label>
            <input id="gpsCielLat" type="text" name="gpsCielLat" value="0"><br>

            <input class="subm" type="submit" value="Submit" name="submit3">

        </form>
    </div>
</div>

</body>
</html>