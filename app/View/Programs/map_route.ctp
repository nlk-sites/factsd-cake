<script type="text/javascript"
    src="http://maps.googleapis.com/maps/api/js?sensor=false">
</script>
<style type="text/css">
  /*html { height: 100% }
  body { height: 100%; margin: 0; padding: 0 }*/
  #map_canvas { height: 100% }
</style>

<script type="text/javascript">
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
var map;

function initialize() {
    directionsDisplay = new google.maps.DirectionsRenderer();
    var myOptions = {
        zoom:9,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        //center: san_diego,
        disableDefaultUI: true,
        zoomControl: true,
        //zoomControlOptions: {
        //    style: google.maps.ZoomControlStyle.SMALL
        //},
        minZoom: 8
    }
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    <?php if(empty($origin) && empty($destination)){?>
        var san_diego = new google.maps.LatLng(33.023758, -116.800286);
        map.setCenter(san_diego);
    <?php }else if(empty($origin) || empty($destination)){?>
        dropMarker('<?php echo reset(array_filter(array($origin, $destination)));?>');
    <?php }else{?>
        calcRoute();
    <?php }?>
    directionsDisplay.setMap(map);
    directionsDisplay.setPanel(document.getElementById("directionsPanel"));
}

function dropMarker(address){
    geocoder = new google.maps.Geocoder();
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location
        });
      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });
}

function calcRoute() {
    var start = '<?php echo urldecode($origin);?>';
    var end = '<?php echo urldecode($destination);?>';
    var request = {
        origin:start,
        destination:end,
        travelMode: google.maps.TravelMode.DRIVING,
        provideRouteAlternatives: false
    };
    directionsService.route(request, function(result, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            $('#trip_duration').text(result.routes[0].legs[0].distance['text']+', '+result.routes[0].legs[0].duration['text']).show();
            directionsDisplay.setDirections(result);
        }
    });
}

$(document).ready(function(){initialize();});

</script>
<div id="map_canvas" style="float:left; width:70%; height:500px"></div>
<div id="directionsPanel" style="float:right; width:30%; height:100%"></div>