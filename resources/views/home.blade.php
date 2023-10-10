@extends("layout")

@section("content")
<h1>Home Page</h1>

<div id="map" style="width: 100%; height: 600px;"></div>

<script>
let map;

function initMap() {
  map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: 43.24030926648237, lng: -79.88980693002755 },
    zoom: 13,
  });
}

// Load the Google Maps API asynchronously
function loadGoogleMapsScript() {
  const script = document.createElement("script");
  script.src = `https://maps.googleapis.com/maps/api/js?key=AIzaSyD-7uGxcXtxOHLNCj867iBF6CfAP0IDeFw&callback=initMap`;
  script.defer = true;
  document.head.appendChild(script);
}

// Call the function to load the API
loadGoogleMapsScript();
</script>


@endsection