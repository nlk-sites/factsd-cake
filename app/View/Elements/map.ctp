<script type="text/javascript"
    src="http://maps.googleapis.com/maps/api/js?sensor=false">
</script>
<style type="text/css">
  /*html { height: 100% }
  body { height: 100%; margin: 0; padding: 0 }*/
  #map_canvas { height: 100% }
</style>

<script type="text/javascript">
var directionsService = new google.maps.DirectionsService();
var geocoder = new google.maps.Geocoder();
var map;
var san_diego;
var all_markers = [];
function initialize() {
  san_diego = new google.maps.LatLng(32.963758, -116.800286);
  var myOptions = {
    region:'us',
    zoom:7,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    center: san_diego,
    disableDefaultUI: true,
    zoomControl: true,
    zoomControlOptions: {
        style: google.maps.ZoomControlStyle.SMALL
    },
    minZoom: 6
  }
  map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
  //directionsDisplay.setMap(map);
   
}

function dropMarker(address){
    geocoder.geocode( { 'address': address}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location);
            marker = new google.maps.Marker({
                map: map,
                position: results[0].geometry.location
            });
            all_markers.push(marker);
        } else {
            alert("Geocode was not successful for the following reason: " + status);
        }
    });
}

function clearMarkers(){
    if(all_markers.length > 0){
        for(i in all_markers){
            all_markers[i].setMap(null);
            all_markers[i] = null;
        }
    }
    all_markers = [];
}

function calcRoute() {
    var start = $('#AddressOrigin').val();
    var end = $('#AddressDestination').val();
    clearMarkers();
    if(start == '' && end == ''){
        map.setCenter(san_diego);
    }else if(start == ''){
        dropMarker(end);
    }else if(end == ''){
        dropMarker(start);
    }else{
        var request = {
            region:'us',
            origin:start,
            destination:end,
            travelMode: google.maps.TravelMode.DRIVING,
            provideRouteAlternatives: false
        };
        directionsService.route(request, function(result, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay = new google.maps.DirectionsRenderer({
                    suppressInfoWindows: true,
                    map: map,
                    hideRouteList: true
                });
                //directionsDisplay.setMap(map);
                $('#trip_duration').text(result.routes[0].legs[0].distance['text']+', '+result.routes[0].legs[0].duration['text']).show();
                directionsDisplay.setDirections(result);
                all_markers.push(directionsDisplay);
            }
        });
    }
}

$(document).ready(function(){initialize();});

</script>
<div>
  <div id="map_canvas" style="height:96px;<!-- width:200px; -->"></div>
</div>