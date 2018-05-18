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
  <button id="naspat"> Naspäť</button>

<?php
//polia pre udaje z databazy

$poleEmail = array();
$poleSSadresa= array();
$poleOBadresa= array();

require('config.php');
//napojenie na DB
$link = mysqli_connect($dbconfig['hostname'],$dbconfig['username'],$dbconfig['password'],$dbconfig['dbname']) or die("Error " . mysqli_connect_error($link));
mysqli_set_charset($link,"utf8");


/*   Nacitanie do poli pre spracovanie zemepisnych udajov    */ 
$query1 = 'SELECT id, adress FROM school';
$result = mysqli_query($link, $query1);

if (mysqli_num_rows($result) > 0 ){
  while ($obj = mysqli_fetch_object($result)){
    if (strlen($obj->adress) < 5) {      
      //nezadana adresa
      ;
    }
    else {
  
      //prevod na url a zapisanie zemepusnych dat do databazy
      $urlSkola = rawurlencode($obj->adress);
      
      $url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$urlSkola.'&key=AIzaSyDNR8tp7L03rEX6lCXnoK6DrylRznvGYeY';
      $djson = file_get_contents($url);
      $data = (json_decode($djson));
      if ($data->status != 'OK') echo '<p>Chyba pri geolokacii adresi '.$obj->adress.' </p>';
      else {
           //print("<pre>".print_r($data->results[0]->geometry->location,true)."</pre>");          //kontrolny vypis
      
           $query2  = 'UPDATE school SET latitude = '.$data->results[0]->geometry->location->lat.', 	longtitude= '.$data->results[0]->geometry->location->lng.' ';
           $query2 .= 'WHERE id = "'.$obj->id.'"';
           if(!mysqli_query($link, $query2)) echo '<p>Nastala chyba pri aktualizácii údajov zemepisnej polohy pre adresu '.$obj->ssAdresa.'</p>';
      }      
    }
  }
  mysqli_free_result($result);     
}
else echo '<p>Chyba pri načítaní údajov z databázy</p>';

$query1 = 'SELECT email, CONCAT(street, ", ",town, ", ", postal_code) AS obAdresa FROM users';
$result = mysqli_query($link, $query1);

if (mysqli_num_rows($result) > 0 ){
  while ($obj = mysqli_fetch_object($result)){
    if (strlen($obj->obAdresa) < 5) {      
      //nezadana adresa
      ;
    }
    else {
  
      //prevod na url a zapisanie zemepusnych dat do databazy
      $urlObec = rawurlencode($obj->obAdresa);
      
      $url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$urlObec.'&key=AIzaSyDNR8tp7L03rEX6lCXnoK6DrylRznvGYeY';
      $djson = file_get_contents($url);
      $data = (json_decode($djson));
      if ($data->status != 'OK') echo '<p>Chyba pri geolokacii adresi '.$obj->obAdresa.' </p>';
      else {
           //print("<pre>".print_r($data->results[0]->geometry->location,true)."</pre>");          //kontrolny vypis
      
           $query2  = 'UPDATE users SET latitude = '.$data->results[0]->geometry->location->lat.', 	longtitude= '.$data->results[0]->geometry->location->lng.' ';
           $query2 .= 'WHERE email = "'.$obj->email.'"';
           if(!mysqli_query($link, $query2)) echo '<p>Nastala chyba pri aktualizácii údajov zemepisnej polohy pre adresu '.$obj->ssAdresa.'</p>';
      }      
    }
  }
  mysqli_free_result($result);     
}
else echo '<p>Chyba pri načítaní údajov z databázy</p>';
mysqli_close($link);
?>

	</body>  
</html>
