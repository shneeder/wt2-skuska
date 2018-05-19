
<!DOCTYPE html>
<html lang="sk">
  <head>
    <meta charset='utf-8'>
    <title>Zadanie final - geocoding </title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="clickHandler.js"></script>
  </head>

<?php

/*  Nacitanie dat z excelu osoby2.csv po riadkoch */
$riadky = array();

if(isset($_FILES['excelFile']) && !empty($_FILES['excelFile']['tmp_name']) ){
  $excel = fopen(($_FILES['excelFile']['tmp_name']),'r');
  if ($excel) {
    $counter = 0;
    while (($line = fgets($excel)) !== false) {

      $line = iconv("UTF-8", "UTF-8", $line);
      if ($counter == 0) $counter += 1;
      else {

        if(strlen($line) > 5) array_push($riadky, $line);
      }
      if(feof($excel)) break;
    }

    fclose($excel);
  } else {
  // error opening the file.
  }
}
//print("<pre>".print_r($riadky,true)."</pre>");

/*    Spracovanie pola - rozlozenie jednotlivych stringov z $riadky na zaznamy,
      ulozenie zaznamov do noveho pola
*/

$data = array();
for ($i=0; $i<sizeof($riadky); $i++){
  $zaznam = array();
  $pieces = explode(";", $riadky[$i]);
  array_push($data, $pieces);
}

//usporiadanie podla adries skol
function querySort ($x, $y) {
    return strcasecmp($x[5], $y[5]);
}
usort($data, 'querySort');
print("<pre>".print_r($data,true)."</pre>");

/* vkladanie do databazy*/

require('config.php');
//napojenie na DB
$link = mysqli_connect($dbconfig['hostname'],$dbconfig['username'],$dbconfig['password'],$dbconfig['dbname']) or die("Error " . mysqli_connect_error($link));
mysqli_set_charset($link,"utf8");

if (!empty($data)){
  for($i=0; $i<sizeof($data); $i++){
    //kontrola ci je uz dana skola v databaze
    //$query1 = 'SELECT id, adress FROM school WHERE adress ="'.$data[$i][5].'"';
    //$result = mysqli_query($link, $query1);
    //ak adresa uz je v tabulke skol, pridat len data k user tabulke
    //if (mysqli_num_rows($result) > 0 ){
      //$obj = mysqli_fetch_object($result);
      $heslo = strval(123456 + $i);
      $hash_heslo = password_hash($heslo, PASSWORD_BCRYPT);
      $query2 =  'INSERT INTO users(name, email, password, first_name, last_name, school_name, school_address, street, postal_code, town)';
      $query2 .= 'VALUES ("excel", "'.$data[$i][3].'", "'.$hash_heslo.'", "'.$data[$i][2].'", "'
      .$data[$i][1].'", "'.$data[$i][4].'", "'.$data[$i][5].'", "'.$data[$i][6].'", '.intval($data[$i][7]).', "'.$data[$i][8].'")';
      echo "<h3>";
      echo $query2;
      echo "</h3>";
      //kontrola ci sa pridal zaznam do databazy, odoslanie heslo na dany mail
      if(!mysqli_query($link, $query2)) print("<pre>".print_r(mysqli_error($link),true)."</pre>");
      else {
        $msg = 'Úspešne ste boli zaregistrovaný na stránke http://147.175.98.234/  Vaše heslo je '.$heslo.'';
        //mail($data[$i][3],"WT2 - zaverecny projekt",$msg);
      }
    //}
    /*else {  // skola este nie je v databaze
      $query3 =  'INSERT INTO school(name, adress)';
      $query3 .= 'VALUES ("'.$data[$i][4].'", "'.$data[$i][5].'")';
      if(!mysqli_query($link, $query3)) print("<pre>".print_r(mysqli_error($link),true)."</pre>");
      else {
        $query4 =  'SELECT id as id FROM school WHERE adress = "'.$data[$i][5].'"';
        $result4 = mysqli_query($link, $query4);
        $id = mysqli_fetch_object($result);
        $heslo = strval(4242*$i);
        $query2 =  'INSERT INTO users(name, email, password, first_name, last_name, school_id, street, postal_code, town)';
        $query2 .= 'VALUES ("excel", "'.$data[$i][3].'", '.$heslo.', "'.$data[$i][2].'", "'
        .$data[$i][1].'", '.$id->id.', "'.$data[$i][6].'", '.intval($data[$i][7]).', "'.$data[$i][8].'")';
        if(!mysqli_query($link, $query2)) print("<pre>".print_r(mysqli_error($link),true)."</pre>");
        else {
          $msg = 'Úspešne ste boli zaregistrovaný na stránke http://147.175.98.234/  Vaše heslo je '.$heslo.'';
          mail($data[$i][3],"WT2 - zaverecny projekt",$msg);
        }
      }
    }*/

  }
}
mysqli_close($link);
?>

	<body>
    <form action ="" method="POST" enctype="multipart/form-data">
      <input type="file" name="excelFile">
      <input type="submit" value="Potvrď">
    </form>
    <p>Načítanie adries zo súboru. Testované je načítanie z .txt súboru, keďže s excelom je problém pri utf-8.
       Čiže obsah osoby2.csv bol prekopírovaný do napr. osoby2.txt a načítaný bol potom tento .txt súbor.
    </p>


    <br>
    <button id="startGeocode"> Geocode </button>
    <p>Tlačidlo pre priradenie zemepisnej šírky a dĺžky jednotlivým adresám v databáze.
    <br>
    (Geocoder má limit 2500 volaní za deň, a na každú adresu sa musí volať osobitne.
    Kebyže sme api implementovali na hlavnej stránke, tak už len pre dáta z excelu je potrebné volať api cca 100 krát, takže to musí robiť len admin.)
    </p>

	</body>
</html>
