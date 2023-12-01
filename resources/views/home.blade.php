@extends("layout")

@section("content")
<h1>Home Page</h1>

<div id="style-selector-control" class="map-control">
  <input type="radio" name="show-hide" id="hide-poi" class="selector-control" />
  <label for="hide-poi">Hide</label>
  <input type="radio" name="show-hide" id="show-poi" class="selector-control" checked="checked" />
  <label for="show-poi">Show</label>
</div>

<div id="map" style="width: 100%; height: 700px;"></div>

<script>
  let map;
  const styles = {
    default: [],
    hide: [{
        featureType: "poi",
        elementType: "labels",
        stylers: [{
          visibility: "off"
        }],
      },
      {
        featureType: "poi",
        elementType: "geometry",
        stylers: [{
          visibility: "off"
        }],
      },
      {
        featureType: "transit",
        elementType: "labels.icon",
        stylers: [{
          visibility: "off"
        }],
      },
      {
        featureType: "transit",
        elementType: "labels.text.fill",
        stylers: [{
          visibility: "off"
        }],
      },
    ],
  };

  // Pass locations from PHP to JavaScript
  const locations = @json($locations);

  function cacheLocations(locations) {
    localStorage.setItem("cachedLocations", JSON.stringify(locations));
  }

  function getCachedLocations() {
    let cachedData = localStorage.getItem("cachedLocations");
    return cachedData ? JSON.parse(cachedData) : null;
  }

  function addMarkersToMap(locations) {
    const markers = [];
    let currentInfoWindow = null;

    locations.forEach((location) => {
      let markerOptions = {
        position: {
          lat: parseFloat(location.latitude),
          lng: parseFloat(location.longitude),
        },
        map: map,
        title: location.park_name,
        icon: 'https://maps.google.com/mapfiles/ms/icons/blue.png',
      };

      let marker = new google.maps.Marker(markerOptions);
      markers.push(marker);

      let type = location.type_id === 1 ? "Park" : location.type_id === 2 ? "Trail" : "Unknown";

      let infoWindow = new google.maps.InfoWindow({
        content: `
          <h3><a href="{{ url('/locations') }}/${location.id}">${location.park_name}</a></h3>
          <p><strong>Address:</strong> ${location.address}</p>
          <p><strong>Type:</strong> ${type}</p>
          <p><strong>Community:</strong> ${location.community}</p>
          <p>${location.add_info}</p>
        `,
      });

      marker.addListener("click", () => {
        if (currentInfoWindow) {
          currentInfoWindow.close();
        }

        infoWindow.open(map, marker);
        currentInfoWindow = infoWindow;
      });
    });

    // Marker clustering
    const markerCluster = new MarkerClusterer(map, markers, {
      imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m',
    });
  }

  function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
      center: {
        lat: 43.24008953941643,
        lng: -79.88734404054566,
      },
      zoom: 12,
      mapTypeControl: false,
      styles: styles["hide"], // Set 'hide' style by default
    });

    const styleControl = document.getElementById("style-selector-control");
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(styleControl);

    document.getElementById("hide-poi").addEventListener("click", () => {
      map.setOptions({
        styles: styles["hide"],
      });
    });

    document.getElementById("show-poi").addEventListener("click", () => {
      map.setOptions({
        styles: styles["default"],
      });
    });

    let cachedLocations = getCachedLocations();
    if (!cachedLocations) {
      cacheLocations(locations);
      addMarkersToMap(locations);
    } else {
      addMarkersToMap(cachedLocations);
    }
  }

  function loadGoogleMapsScript() {
    const script = document.createElement("script");
    script.src = `https://maps.googleapis.com/maps/api/js?key=AIzaSyD-7uGxcXtxOHLNCj867iBF6CfAP0IDeFw&callback=initMap&v=weekly&libraries=visualization,geometry,places`;
    script.defer = true;
    document.head.appendChild(script);
  }

  loadGoogleMapsScript();
</script>
@endsection