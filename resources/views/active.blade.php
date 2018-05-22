<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>WT 2 - projekt</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="{{ asset('bod11/clickHandler.js') }}"></script>
    <script src="{{ asset('wt2/script.js') }}"></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
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
<script>

    function sendTestDataUpdate() {
        var form = $('#add-test');
        form.submit(function (event) {
            event.preventDefault()
        });
        var name0 = form.serializeArray()[0].name;
        var name1 = form.serializeArray()[1].name;
        var name2 = form.serializeArray()[2].name;
        var name3 = form.serializeArray()[3].name;
        var name4 = form.serializeArray()[4].name;
        var name5 = form.serializeArray()[5].name;
        var name6 = form.serializeArray()[6].name;
        var name7 = form.serializeArray()[7].name;
        var name8 = form.serializeArray()[8].name;
        var name9 = form.serializeArray()[9].name;
        // Submit the form using AJAX.
        $.post("wt2/test.php",
            {
                km: parseInt(form.serializeArray()[0].value),
                datum: document.getElementById('datum').value,
                casZaciatok: document.getElementById('casZaciatok').value,
                casKoniec: document.getElementById('casKoniec').value,
                gpsStartLat: document.getElementById('gpsStartLat').value,
                gpsStartLng: document.getElementById('gpsStartLng').value,
                gpsCielLat: document.getElementById('gpsCielLat').value,
                gpsCielLng: document.getElementById('gpsCielLng').value,
                evaluation: document.getElementById('evaluation').value,
                poznamka: document.getElementById('poznamka').value,
                user_id_test: document.getElementById('user_id').value
            },
            function (data) {
                alert(data);
            }).fail(function (err) {
            console.log(err);
            alert("Error occured!");
        });
    }
</script>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                WT 2 - záverečný projekt
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                    <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                    <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Aktívna trasa <hr><a href="/home">Zoznam tréningov</a></div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

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
                                        require $_SERVER['DOCUMENT_ROOT']."/wt2/config.php";
                                        // Create connection
                                        $userID=session('user_id');

                                        $conn = mysqli_connect($servername, $username, $password, $dbname);
                                        $i=1;
                                        $prejdeneKM=0;
                                        $pLng=0;
                                        $pLat=0;
                                        $kLng=0;
                                        $kLat=0;
                                        $cesta=0;

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

                                        $sql = "SELECT sum(already_run_km) as prejdeneKM FROM training JOIN active ON training.user_id = active.id_user where training.user_id = '$userID' AND training.route_id ='$cesta'";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            // output data of each row
                                            while($row = $result->fetch_assoc()) {
                                                $prejdeneKM= $row["prejdeneKM"];
                                            }
                                        }
                                        if ($prejdeneKM == null)
                                            $prejdeneKM=0;

                                        $sql = "SELECT * FROM training JOIN active ON training.user_id = active.id_user where training.user_id = '$userID' AND training.route_id ='$cesta'";
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

                                        <form id="add-test" action="../wt2/test.php" method="post">
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
                                            <input id="user_id" name="user_id_test" value="{{session('user_id')}}" hidden>
                                            <input id="submit" class="subm" type="submit" value="Submit" onclick="kontrola()" name="submit" >
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

                                <!--<script src="wt2/script.js"></script>-->
                                <script src="{{ asset('wt2/script.js') }}"></script>
                            </div>
                            <script async defer
                                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDdRr8acovj726mIoPSN1_vu9lULH4aZSI&libraries=places&&callback=initMap">
                            </script>
                    </div>
                </div>
            </div>
        </div>
    </div>


    </main>
    </div>
</body>
</html>
