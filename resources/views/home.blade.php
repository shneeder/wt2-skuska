@extends('layouts.app')

@section('content')

    <script>

        function sendFormDataUpdate() {
            var form = $('#add-route');
            form.submit(function (event) {
                event.preventDefault()
            });
            // Submit the form using AJAX.
            $.post("wt2/pridaj.php",
                {
                    "mod": form.serializeArray()[0].value,
                    "gpsStartLat": form.serializeArray()[1].value,
                    "gpsStartLng": form.serializeArray()[2].value,
                    "gpsCielLat": form.serializeArray()[3].value,
                    "gpsCielLng": form.serializeArray()[4].value,
                    "user_id": form.serializeArray()[5].value,
                    "submit3": "Submit"
                },
                function (data) {
                    alert(data);
                }).fail(function (err) {
                console.log(err);
                alert("Error occured!");
            });
        }
    </script>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    @if (Auth::user()->isAdmin == 1)
                        <div class="card-header"><h1>Administrátorský účet</h1> <br><hr>
                            <a href="/admin">Správa používateľkých účtov</a><hr>
                        <a href="/home/active">Aktuálne aktívny tréning</a><hr>
                            <a href="/adminnews">Zadávanie aktualít</a><hr>
                            <a href="/training/{{  Auth::user()->id }}">Prehľad osobných výkonov</a></div>
                    @else
                        <div class="card-header"><h1>Štandardný účet</h1><hr>
                        <a href="/home/active">Aktuálne aktívny tréning</a><hr>
                            <a href="/newsletter">Aktuality</a><hr>
                            <a href="/training/{{  Auth::user()->id }}">Prehľad osobných výkonov</a></div>
                    @endif
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

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
                                        require $_SERVER['DOCUMENT_ROOT']."/wt2/config.php";

                                        // Create connection
                                        //$_SESSION['user_id'] = Auth::user()->id;
                                        session(['user_id' => Auth::user()->id]);
                                        $userID = session('user_id');
                                        $conn = mysqli_connect($servername, $username, $password, $dbname);
                                        $rola=0;
                                        $sql = "SELECT * FROM users where id='$userID'";
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            // output data of each row
                                            while($row = $result->fetch_assoc()) {
                                                $rola= $row["isAdmin"];
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
                                        if($rola==1)
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
                                    <form id="myForm" action="/home/route" method="get">

                                        <input type='hidden' name='idcko' id="idcko" value='0'>
                                    </form>
                                    <script>

                                        $("#zoznam tr").click(function() {
                                            var pom=parseInt( document.getElementById(this.id).children[0].className);
                                            document.getElementById("idcko").value = pom;
                                            document.getElementById('myForm').submit();

                                        });

                                        function myFunction(id_u,id){
                                            var url = "wt2/zmen.php";
                                            $.post(url, {user:id_u, cesta:id}).success(function (data) {
                                                alert(data);
                                            })
                                        }

                                    </script>
                                </div>

                                <div class="row">

                                    <form  >
                                        <h1>Pridaj novu trasu</h1>
                                        <label>Mod</label>
                                        <select id="mod" name="mod">
                                            <option value="private">private</option>
                                            <option value="public">public</option>
                                            <option value="stafeta">stafeta</option>
                                        </select><br>

                                        <label for="gpsStartLat">gpsStartLat</label>
                                        <input id="gpsStartLat" type="text" name="gpsStartLat" value="0" ><br>

                                        <label for="gpsStartLng">gpsStartLng</label>
                                        <input id="gpsStartLng" type="text" name="gpsStartLng" value="0" ><br>

                                        <label for="gpsCielLat">gpsCielLat</label>
                                        <input id="gpsCielLat" type="text" name="gpsCielLat" value="0"><br>

                                        <label for="gpsCielLng">gpsCielLng</label>
                                        <input id="gpsCielLng" type="text" name="gpsCielLng" value="0"><br>
                                        <input id="user_id" name="user_id" value="{{session('user_id')}}" hidden>
                                        <button type="button" id="odosli" onclick="insertData()">Click Me!</button>

                                    </form>
                                </div>


                                <script type="text/javascript">

                                    function insertData() {
                                        var q2=$("#gpsStartLat").val();
                                        var q1=$("#gpsStartLng").val();
                                        var q4=$("#gpsCielLat").val();
                                        var q3=$("#gpsCielLng").val();
                                        var q5=$("#mod").val();
// AJAX code to send data to php file.
                                        $.ajax({
                                            type: "POST",
                                            url: "wt2/pridaj.php",
                                            data: {q1:q1,q2:q2,q3:q3,q4:q4,q5:q5,
                                                user_id: $('#user_id').val()
                                            },
                                            success: function(data) {
                                                console.log(data);
                                                $("#zoznam").append(data);
                                            },
                                            error: function(err,data) {
                                                alert(err);
                                            }
                                        });
                                    }

                                </script>
                                <!--<div class="row">

                                    <form id="add-route" onsubmit="sendFormDataUpdate(); return false;">
                                        <h1>Pridaj novu trasu</h1>
                                        <label>Mod</label>
                                        <select id="mod" name="mod">
                                            <option value="private">private</option>
                                            <option value="public">public</option>
                                            <option value="stafeta">stafeta</option>
                                        </select><br>


                                        <label for="gpsStartLat">gpsStartLat</label>
                                        <input id="gpsStartLat" type="text" name="gpsStartLat" value="0" ><br>

                                        <label for="gpsStartLng">gpsStartLng</label>
                                        <input id="gpsStartLng" type="text" name="gpsStartLng" value="0" ><br>

                                        <label for="gpsCielLat">gpsCielLat</label>
                                        <input id="gpsCielLat" type="text" name="gpsCielLat" value="0"><br>

                                        <label for="gpsCielLng">gpsCielLng</label>
                                        <input id="gpsCielLng" type="text" name="gpsCielLng" value="0"><br>
                                        <input id="user_id" name="user_id" value="{{session('user_id')}}" hidden>
                                        <input class="subm" type="submit" value="Submit" name="submit3">

                                    </form>
                                </div>-->
                                <?php
                                if($rola==1){
                                    echo"<div class='row'>";
                                    echo"<h1>Trasy uzivatela</h1>";
                                    echo"</div>";

                                    echo"<div class='row'>";

                                    require $_SERVER['DOCUMENT_ROOT']."/wt2/config.php";
                                    $conn = mysqli_connect($servername, $username, $password, $dbname);

                                    $query = "SELECT * FROM users";
                                    $result = $conn->query ($query);
                                    echo "<form method='get' >";

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

                                    if( isset($_GET['submit2']))
                                    {
                                        $conn = mysqli_connect($servername, $username, $password, $dbname);

                                        echo " <table id='zoznam2'><tr><th>start lng</th><th>start lat</th><th>ciel lng</th><th>ciel lat</th><th>stav</th><th>mod</th><th></th></tr>";
                                        $sql = "SELECT * FROM route JOIN active ON route.id = active.is_route where active.id_user=".$_GET['dropdown']."";
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            // output data of each row
                                            while($row = $result->fetch_assoc()) {
                                                echo "<tr class='uziv' id='".$row["id"]."'> <td  class='".$row["id"]."'>" . $row["startLng"] . "</td><td>" . $row["startLat"] ."</td><td>" . $row["finistLng"] ."</td><td>" . $row["finistLat"] ."</td><td>aktivna</td><td>" . $row["typ"] ."</td></tr>";
                                            }
                                        }

                                        $sql = "SELECT * FROM route WHERE id_user=".$_GET['dropdown']." AND typ='private' OR typ='public'";

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

                            </div>



                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
