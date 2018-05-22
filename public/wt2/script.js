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
    var centruj = new google.maps.LatLng(48.14816, 17.10674);
    var directionsService = new google.maps.DirectionsService;
    var directionsDisplay = new google.maps.DirectionsRenderer;
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: centruj
    });

    start = new google.maps.LatLng(startlat, startlng);
    ciel = new google.maps.LatLng(ciellat, ciellng);
    directionsDisplay.setMap(map);

    //if (start == null && ciel==null)
    if (start && ciel)
    {

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

            vykresli(directionsService, directionsDisplay, response)

        } else {
            window.alert('Directions request failed due to ' + status);
        }
    });
}

function vykresli(directionsService, directionsDisplay, response2) {
    var celkove =(response2.routes[0].legs[0].distance.value / 1000).toFixed(2);
    document.getElementById("celkoveKM").value = celkove;
    document.getElementById("ostavaKM").value = (celkove - km).toFixed(2);
    if (km>0){
        console.log(response2.routes[0]);

        console.log(response2.routes[0].legs[0].distance.value / 1000);
        km=parseFloat(km);
        if (celkove - km==0)
            km=km-0.01;
        var pom = km  * 1000;
        pom = parseFloat(pom);
        var pom2 = 0;
        var cesta;
        var dlzka = response2.routes[0].legs[0].steps.length;
        for (var i = 0; i < dlzka; i++) {

            if (pom > pom2 && pom < response2.routes[0].legs[0].steps[i].distance.value + pom2) {
                console.log("a" + i);
                console.log(pom);
                console.log(pom2);

                console.log(response2.routes[0].legs[0].steps[i].distance.value + pom2);
                var pom3 = pom - pom2;
                var pom4 = Math.floor(pom3 / (response2.routes[0].legs[0].steps[i].distance.value / 100));
                var path = (Math.floor(response2.routes[0].legs[0].steps[i].path.length / 100) ) * pom4;
                if(response2.routes[0].legs[0].distance.value/1000-km<0.2)
                    path=Math.floor(response2.routes[0].legs[0].steps[i].path.length)-1;
                console.log(i);

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
        }, function (response, status) {
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
}