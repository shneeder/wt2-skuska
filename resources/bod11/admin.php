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
  <button id="startGeocode"> Geocode </button>
  <p>Tlačidlo pre priradenie zemepisnej šírky a dĺžky jednotlivým adresám v databáze.
  <br>
  (Geocoder má limit 2500 volaní za deň, a na každú adresu sa musí volať osobitne.
   Kebyže sme api implementovali na hlavnej stránke, tak už len pre dáta z excelu je potrebné volať api cca 100 krát, takže to musí robiť len admin.)
  </p>

	</body>  
</html>
