var speed = [];
var startlng=0;
var startlat=0;
var ciellng=0;
var ciellat=0;
var stredlng=0;
var stredlat=0;
var km=0;


function definuj(){
    if(document.getElementById("pociatLng").innerHTML  != null){
        startlng=document.getElementById("pociatLng").value;
        startlat=document.getElementById("pociatLat").value;
        ciellng=document.getElementById("koncLng").value;
        ciellat=document.getElementById("koncLat").value;
        km=document.getElementById("prejdeneKm").value;
    }



}
var start =0;
var ciel =0;

function initMap() {
    definuj();
    start = new google.maps.LatLng(startlat, startlng);
    ciel = new google.maps.LatLng(ciellat, ciellng);
    var directionsService = new google.maps.DirectionsService;
    var directionsDisplay = new google.maps.DirectionsRenderer;
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: start
    });

     var marker1 = new google.maps.Marker({
         position: start,
         map: map,
         title: 'Start'
     });
    var marker2 = new google.maps.Marker({
        position: ciel,
        map: map,
        title: 'Ciel'
    });


    directionsDisplay.setMap(map);
        calculateAndDisplayRoute(directionsService, directionsDisplay);

}

function calculateAndDisplayRoute(directionsService, directionsDisplay) {
    // directionsDisplay = new google.maps.DirectionsRenderer({ polylineOptions: { strokeColor: "#8b0013" } });

    directionsService.route({
        origin: start,
        destination: ciel,
        travelMode: 'DRIVING',
    }, function(response, status) {
        if (status === 'OK') {
            //let distances = _.flatMap(response.routes, route => _.flatMap(route.legs, leg => leg.distance.value));

            // console.log(response.routes[0].overview_path);
            if(km>0)
                vykresli(directionsService, directionsDisplay, response)

        } else {
            window.alert('Directions request failed due to ' + status);
        }
    });
}

function vykresli(directionsService, directionsDisplay, response2){
    document.getElementById("celkoveKM").value=response2.routes[0].legs[0].distance.value/1000;
    document.getElementById("ostavaKM").value=response2.routes[0].legs[0].distance.value/1000-km;

    console.log(response2.routes[0]);

    console.log(response2.routes[0].legs[0].distance.value/1000);
    console.log(response2.routes[0].legs[0].steps.length);
    console.log(typeof km);
    var pom=km*1000;
    var pom2=0;
    var cesta;
    var dlzka =response2.routes[0].legs[0].steps.length;
    for(var i=0; i<dlzka; i++) {

        if (pom > pom2 && pom < response2.routes[0].legs[0].steps[i].distance.value + pom2) {
            console.log("a" + i);

            console.log(pom2);
            var pom3 = pom - pom2;
            var pom4 = Math.floor(pom3 / (response2.routes[0].legs[0].steps[i].distance.value / 100));
            var path = (Math.floor(response2.routes[0].legs[0].steps[i].path.length / 100) + 1) * pom4;
            console.log("treba prejst" + pom3);

            console.log("pom4" + pom4);
            console.log("path" + path);
            console.log("asd" + response2.routes[0].legs[0].steps[i].path[path]);
            cesta = response2.routes[0].legs[0].steps[i].path[path];
            break;
        }
        else
            pom2 += response2.routes[0].legs[0].steps[i].distance.value;
    }
    directionsService.route({
        origin: start,
        destination: cesta,
        travelMode: 'DRIVING',
    }, function(response, status) {
        if (status === 'OK') {
            //let distances = _.flatMap(response.routes, route => _.flatMap(route.legs, leg => leg.distance.value));

            // console.log(response.routes[0].overview_path);


            //response.legs[0].distance.value=10000;
            directionsDisplay.setDirections(response);
            //vykresli2(directionsService, directionsDisplay, response2)

        } else {
            window.alert('Directions request failed due to ' + status);
        }
    });

}