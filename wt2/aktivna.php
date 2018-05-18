<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" >
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">

    <title>Directions service</title>
    <style>
        /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
        #map {
            height: 700px;
            width: 700px;
        }
        /* Optional: Makes the sample page fill the window. */

    </style>
</head>
<body>
<div class="container">
    <div class="row mb-2">
        <h1>Mapa</h1>

        <div id="map"></div>
    </div>
    <div class="row mb-2">
        <h1>Treningy</h1>

        <table id="zoznam">
            <tr>
                <th>km</th>
                <th>datum</th>
                <th>cas zaciatok</th>
                <th>cas ciel</th>
                <th>hodnotenie</th>
                <th>poznamka</th>
                <th>gpsStartLng</th>
                <th>gpsStartLat</th>
                <th>gpsCielLng</th>
                <th>gpsCielLat</th>

            </tr>

            <?php
            require "./config.php";
            // Create connection
            $userID=2;
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            $i=1;
            $prejdeneKM=0;
            $pLng=0;
            $pLat=0;
            $kLng=0;
            $kLat=0;


            $sql = "SELECT * FROM route JOIN active ON active.is_route=route.id  where active.id_user = '$userID'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {

                    $pLng=$row["startLng"];
                    $pLat=$row["startLat"];
                    $kLng=$row["finistLng"];
                    $kLat=$row["finistLat"];
                }
            }

            $sql = "SELECT * FROM active where id_user = '$userID'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    $cesta=$row["is_route"];
                }
            }

            $sql = "SELECT sum(already_run_km) as prejdeneKM FROM Training JOIN active ON Training.user_id = active.id_user where Training.user_id = '$userID' AND Training.route_id ='$cesta'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    $prejdeneKM= $row["prejdeneKM"];
                }
            }


            $sql = "SELECT * FROM Training JOIN active ON Training.user_id = active.id_user where Training.user_id = '$userID' AND Training.route_id ='$cesta'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    if ($i==$result->num_rows)
                        $pom=$row["gpsCielLng"];
                    $pom2=$row["gpsCielLat"];
                    echo "<tr class='uziv' id='".$row["id"]."'> <td >" . $row["already_run_km"] . "</td><td>" . $row["datum"] ."</td><td>" . $row["exact_time"] ."</td><td>" . $row["finish_time"] ."</td><td>" . $row["evaluation"] ."</td><td>" . $row["note"] ."</td><td>" . $row["gpsStartLng"] ."</td><td>" . $row["gpsStartLat"] ."</td><td>" . $row["gpsCielLng"] ."</td><td>" . $row["gpsCielLat"] ."</td></tr>";
                    $i++;
                }
            }

            ?>
        </table>
    </div>
    <div class="row mb-2">
        <div class="col-md-6">
            <h1>Info o trase</h1>

            <label for="prejdeneKm">Prejdene KM</label>
            <input id="prejdeneKm" type="number" name="prejdeneKm" value="<?php echo htmlspecialchars($prejdeneKM);?>" disabled><br>

            <label for="celkoveKM">Celkove KM</label>
            <input id="celkoveKM" type="text" name="celkoveKM" value="0" disabled><br>

            <label for="ostavaKM">Ostava KM</label>
            <input id="ostavaKM" type="text" name="ostavaKM" value="0" disabled><br>

            <label for="pociatLat">pociatLat</label>
            <input id="pociatLat" type="text" name="pociatLat" value="<?php echo htmlspecialchars($pLat);?>" disabled><br>

            <label for="pociatLng">pociatLng</label>
            <input id="pociatLng" type="text" name="pociatLng" value="<?php echo htmlspecialchars($pLng);?>" disabled><br>

            <label for="koncLat">koncLat</label>
            <input id="koncLat" type="text" name="koncLat" value="<?php echo htmlspecialchars($kLat);?>" disabled><br>

            <label for="koncLng">koncLng</label>
            <input id="koncLng" type="text" name="koncLng" value="<?php echo htmlspecialchars($kLng);?>" disabled><br>

        </div>



        <div class="col-md-6">

            <form action="test.php" method="post">
                <h1>Pridaj trening</h1>
                <label for="km">KM</label>
                <span class="red" >*</span>
                <input id="km" type="number" name="km" min="0.01" step="0.01"required onchange="kontrola()" value="1"><br>
                <p class="red" id="red" hidden>prekrocena hodnota</p>

                <label for="datum">datum</label>
                <input id="datum" type="date" name="datum"><br>

                <label for="casZaciatok">casZaciatok</label>
                <input id="casZaciatok" type="time" name="casZaciatok"><br>

                <label for="casKoniec">casKoniec</label>
                <input id="casKoniec" type="time" name="casKoniec"><br>

                <label for="gpsStartLat">gpsStartLat</label>
                <input id="gpsStartLat" type="text" name="gpsStartLat" value="0" ><br>

                <label for="gpsStartLng">gpsStartLng</label>
                <input id="gpsStartLng" type="text" name="gpsStartLng" value="0" ><br>

                <label for="gpsCielLat">gpsCielLat</label>
                <input id="gpsCielLat" type="text" name="gpsCielLat" value="0"><br>

                <label for="gpsCielLng">gpsCielLng</label>
                <input id="gpsCielLng" type="text" name="gpsCielLng" value="0"><br>

                <label for="evaluation">evaluation</label>
                <input  class="radiob" type="radio" name="evaluation" value="1" checked="checked"> 1
                <input class="radiob"type="radio" name="evaluation" value="2"> 2
                <input class="radiob"type="radio" name="evaluation" value="3"> 3
                <input class="radiob"type="radio" name="evaluation" value="4"> 4
                <input class="radiob"type="radio" name="evaluation" value="5"> 5<br>

                <label for="poznamka">poznamka</label>
                <textarea id="poznamka" name="poznamka" ></textarea><br>

                <input id="submit" class="subm" type="submit" value="Submit" onclick="kontrola()" name="submit" disabled>
            </form>
        </div>
    </div>

    <script>
        function kontrola() {
            console.log(document.getElementById("km").value);
            console.log(document.getElementById("ostavaKM").value);

            if (document.getElementById("km").value > document.getElementById("ostavaKM").value){
                document.getElementById("submit").disabled = true;
                document.getElementById("red").hidden=false;
            }
            else {
                document.getElementById("submit").disabled = false;
                document.getElementById("red").hidden=true;

            }
        }
    </script>
    <script src="script.js"></script>
</div>
</body>

<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDdRr8acovj726mIoPSN1_vu9lULH4aZSI&libraries=places&&callback=initMap">
</script>
</html>
