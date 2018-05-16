<!DOCTYPE html>
<html lang="sk">
  <head>
    <meta charset="utf-8">
    <title>Zadanie final - geocoding </title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="clickHandler.js"></script>
  </head>
  
	<body>
  <br>
  <button id="showSko"> Školy </button>
  <button id="showByd"> Bydliská </button>
  <p>Tlačidlá pre prepínanie zobrazenie dát. Prednastavená možnosť je zobrazenie dát ohľadom navštevovaných škôl.
  </p>

<?php

require('config.php');
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
$query0 = 'SELECT id, adress as adresa, name as ssNazov, latitude AS lat, longtitude AS lng FROM school ORDER BY adress';
$result = mysqli_query($link, $query0);
if (mysqli_num_rows($result) > 0 ){
  while($obj = mysqli_fetch_object($result)){
    
    if (strlen($obj->adresa) < 5) ;
    else {  
      array_push($skola, $obj->adresa);
      array_push($skola, $obj->ssNazov);
      array_push($skola, $obj->lat);
      array_push($skola, $obj->lng);
    
      $query1 = 'SELECT CONCAT(first_name, " ",last_name) as student FROM users WHERE school_id ="'.$obj->id.'"';
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
//print("<pre>".print_r($poleSkoly,true)."</pre>");       //kontrolny vypis
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
      //print("<pre>".print_r($pieces,true)."</pre>");
    
      $query1 = 'SELECT CONCAT(first_name, " ",last_name) as osoba FROM users WHERE (street = "'.$pieces[0].'" AND postal_code = '.intval($pieces[2]).' AND town = "'.$pieces[1].'")';
      //print_r($query1);
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
//print("<pre>".print_r($poleAdresy,true)."</pre>");       //kontrolny vypis
}


?>
  
  <div id="mapaData" style="margin-left:2cm;
        height: 400px;
        width: 750px;
        border-collapse: collapse;
        border-style: solid;
        border-color: #4d0000;
        border-radius: 10px;
        border-spacing: 2px;">
  </div>
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
	</body>  
</html>
