<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>WT 2 - projekt</title>

    <!-- Scripts -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="bod11/clickHandler.js"></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
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

        <div class="py-4">
          <div class="container">
              <div class="row justify-content-center">
                  <div class="col-md-8">

            <button id="showSko"> Školy </button>
            <button id="showByd"> Bydliská </button>
            <p>Tlačidlá pre prepínanie zobrazenie dát. Prednastavená možnosť je zobrazenie dát ohľadom navštevovaných škôl.
            </p>
            <?php
            require $_SERVER['DOCUMENT_ROOT'].'/bod11/config.php';
            //napojenie na DB
            $link = mysqli_connect($dbconfig['hostname'],$dbconfig['username'],$dbconfig['password'],$dbconfig['dbname']) or die("Error " . mysqli_connect_error($link));
            mysqli_set_charset($link,"utf8");


            //hodnoty, ktore sa neskor vyuziju v javascripte na vykreslenie markerov
            $poleSkoly = array();        //pole vsetkych skol - pocet markerov
            $skola = array();            //pole s udejmi pre danu skolu
            $skolaStudenti = array();    //pole studentov pre skolu

            $poleAdresy = array();
            $adresa = array();
            $adresaOsoby = array();

            //prepinanie medzi datami adries skol alebo bydlisk
            $def = "skoly";
            if(isset($_GET['show'])){
              if($_GET['show']=="bydliska") $def = "bydliska";
              elseif($_GET['show']=="skoly") $def = "skoly";
            }

            if($def == "skoly"){
            //zistenie poctu skol a ich adresy
            //$query0 = 'SELECT CONCAT(first_name, " ",last_name) as student,
            //      school_address as adresa, school_name as ssNazov, school_lat AS lat, school_lng AS lng
            $query0 = 'SELECT DISTINCT school_address as adresa, school_name as ssNazov, school_lat AS lat, school_lng AS lng
                  FROM users ORDER BY school_address';

            $result = mysqli_query($link, $query0);
            if (mysqli_num_rows($result) > 0 ){
              while($obj = mysqli_fetch_object($result)){

                if (strlen($obj->adresa) < 5) ;
                else {
                  array_push($skola, $obj->adresa);
                  array_push($skola, $obj->ssNazov);
                  array_push($skola, $obj->lat);
                  array_push($skola, $obj->lng);
                  //array_push($skola, $obj->student);

                  $query1 = 'SELECT CONCAT(first_name, " ",last_name) as student FROM users WHERE school_name ="'.$obj->ssNazov.'"';
                         $result1 = mysqli_query($link, $query1);
                         while($student = mysqli_fetch_object($result1)){
                           array_push($skolaStudenti, $student->student);
                         }
                         mysqli_free_result($result1);
                  array_push($skola, $skolaStudenti);

                  //pridanie do vysledneho pola a resetovanie pola $skola
                  array_push($poleSkoly, $skola);
                  unset($skolaStudenti);
                  unset($skola);
                  $skola = array();
                  $skolaStudenti = array();
                }
              }
            }
            mysqli_free_result($result);
            }
            elseif($def == "bydliska"){
            //zistenie poctu adries registrovanych uzivatelov
            $query0 = 'SELECT DISTINCT CONCAT(street, ", ", town, ", ", postal_code) as adresa, latitude as lat, longtitude as lng FROM users ORDER BY adresa';
            $result = mysqli_query($link, $query0);
            if (mysqli_num_rows($result) > 0 ){
              while($obj = mysqli_fetch_object($result)){

                if (strlen($obj->adresa)<5) ; //nezadana adresa
                else{
                  array_push($adresa, $obj->adresa);
                  array_push($adresa, $obj->lat);
                  array_push($adresa, $obj->lng);

                  $pieces = explode(", ", $obj->adresa);

                  $query1 = 'SELECT CONCAT(first_name, " ",last_name) as osoba FROM users WHERE (street = "'.$pieces[0].'" AND postal_code = '.intval($pieces[2]).' AND town = "'.$pieces[1].'")';
                  $result1 = mysqli_query($link, $query1);
                  while($osoba = mysqli_fetch_object($result1)){
                    array_push($adresaOsoby, $osoba->osoba);
                  }
                  mysqli_free_result($result1);
                  array_push($adresa, $adresaOsoby);
                  //pridanie do vysledneho pola a resetovanie pola $skola
                  array_push($poleAdresy, $adresa);
                  unset($adresaOsoby);
                  unset($adresa);
                  $adresa = array();
                  $adresaOsoby = array();
                }
              }
            }
            mysqli_free_result($result);
            }
            ?>
                <!-- div s mapou -->
                <div id="mapaData"
                style="
                    height: 400px;
                    width: 750px;
                    border-collapse: collapse;
                    border-style: solid;
                    border-color: #4d0000;
                    border-radius: 10px;
                    border-spacing: 2px;"
                >
                </div>

                <!-- js pre zobrazenie mapy-->
                <script>
                var def = "<?php echo $def ?>";
                if (def == "skoly"){
            	    var pole = new Array();
            	    pole = <?php print_r(json_encode($poleSkoly)) ?>;
            	    console.log(pole);

                  var map;
                  var dataCenter = {lat: 48.669026, lng: 19.699024};  //defaultne pri nacitani stranky je to Slovensko
                  function initMap() {
                    map = new google.maps.Map(document.getElementById('mapaData'), {
                      center: dataCenter,
                      zoom: 7
                    });

                    for(var i=0; i<pole.length; i++){
            	         var skola = pole[i];
                      //console.log(skola[0]);


                      //vytvorenie zoznamu studentov
                      var studenti = '';
                      for(var j=0; j<skola[4].length; j++){
                        studenti += '   '+skola[4][j]+'\n';
                      }
                      //console.log(studenti);

                      var contentString = skola[1] + '\n'+
                                        'Adresa:  '+ skola[0] + '\n'+
                                        'Poloha:  '+skola[2]+', '+ skola[3]+ '\n'+
                                        'Študenti:'+'\n'+studenti;

                      var poz = {lat:parseFloat(skola[2]),lng:parseFloat(skola[3])};
            	        //console.log(poz);
            	        var marker = new google.maps.Marker({
                        map: map,
                        position: poz,
            	          title: contentString
                      });
            	      }
                  }
                }
                if(def == "bydliska"){
                  var pole = new Array();
            	    pole = <?php print_r(json_encode($poleAdresy)) ?>;
            	    console.log(pole);

                  var map;
                  var dataCenter = {lat: 48.669026, lng: 19.699024};  //defaultne pri nacitani stranky je to Slovensko
                  function initMap() {
                    map = new google.maps.Map(document.getElementById('mapaData'), {
                      center: dataCenter,
                      zoom: 7
                    });

                    for(var i=0; i<pole.length; i++){
            	         var adresa = pole[i];
                      //console.log(adresa[0]);


                      //vytvorenie zoznamu osob na danej adrese
                      var osoby = '';
                      for(var j=0; j<adresa[3].length; j++){
                        osoby += '   '+adresa[3][j]+'\n';
                      }
                      //console.log(studenti);

                      var contentString ='Adresa:  '+ adresa[0] + '\n'+
                                        'Poloha:  '+adresa[1]+', '+ adresa[2]+ '\n'+
                                        'Osoby:'+'\n'+osoby;

                      var poz = {lat:parseFloat(adresa[1]),lng:parseFloat(adresa[2])};
            	        //console.log(poz);
            	        var marker = new google.maps.Marker({
                        map: map,
                        position: poz,
            	          title: contentString
                      });


            	      }
                  }
                }
                </script>
                <script async defer
                  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDNR8tp7L03rEX6lCXnoK6DrylRznvGYeY&callback=initMap">
                </script>
              </div>
            </div>
          </div>
        </div>
    </div>
</body>
</html>
