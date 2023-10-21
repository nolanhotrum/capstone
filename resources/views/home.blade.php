@extends("layout")

@section("content")
<h1>Home Page</h1>

<div id="style-selector-control" class="map-control">
  <input type="radio" name="show-hide" id="hide-poi" class="selector-control" />
  <label for="hide-poi">Hide</label>
  <input type="radio" name="show-hide" id="show-poi" class="selector-control" checked="checked" />
  <label for="show-poi">Show</label>
</div>

<div id="map" style="width: 100%; height: 600px;"></div>

<!-- <script>
  let map;
  const styles = {
    default: [],
    hide: [{
        featureType: "poi.business",
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
    ]
  };

  let locations;
  try {
    locations = JSON.parse('{!! addslashes($locationsJson) !!}');
  } catch (error) {
    console.error("Error parsing JSON data:", error);
  }


  function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
      center: {
        lat: 43.24008953941643,
        lng: -79.88734404054566
      },
      zoom: 12,
      mapTypeControl: false,
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

    // Add markers for each location
    locations.forEach(location => {
      let markerOptions = {
        position: {
          lat: parseFloat(location.latitude),
          lng: parseFloat(location.longitude),
        },
        map: map,
        title: location.park_name,
      };

      let marker = new google.maps.Marker(markerOptions);
      let type = location.type_id === 1 ? "Park" : location.type_id === 2 ? "Trail" : "Unknown";

      // Create an info window for this marker
      let infoWindow = new google.maps.InfoWindow({
        content: `
          <h3>${location.park_name}</h3>
          <p><strong>Address:</strong> ${location.address}</p>
          <p><strong>Type:</strong> ${type}</p>
          <p><strong>Community:</strong> ${location.community}</p>
          <p>${location.add_info}</p>
        `,
      });

      // Add a click event listener to the marker
      marker.addListener('click', () => {
        infoWindow.open(map, marker);
      });
    });
  }

  // Load the Google Maps API asynchronously
  function loadGoogleMapsScript() {
    const script = document.createElement("script");
    script.src = `https://maps.googleapis.com/maps/api/js?key=AIzaSyD-7uGxcXtxOHLNCj867iBF6CfAP0IDeFw&callback=initMap&v=weekly`;
    script.defer = true;
    document.head.appendChild(script);
  }

  // Call the function to load the API
  loadGoogleMapsScript();
</script> -->


<script>
  let map;
  const styles = {
    default: [],
    hide: [{
        featureType: "poi.business",
        stylers: [{
          visibility: "off",
        }, ],
      },
      {
        featureType: "transit",
        elementType: "labels.icon",
        stylers: [{
          visibility: "off",
        }, ],
      },
    ],
  };

  // Function to cache marker data in local storage
  function cacheLocations(locations) {
    localStorage.setItem("cachedLocations", JSON.stringify(locations));
  }

  // Function to get cached marker data from local storage
  function getCachedLocations() {
    let cachedData = localStorage.getItem("cachedLocations");
    return cachedData ? JSON.parse(cachedData) : null;
  }

  // Function to add markers to the map
  function addMarkersToMap(locations) {
    locations.forEach((location) => {
      let markerOptions = {
        position: {
          lat: parseFloat(location.latitude),
          lng: parseFloat(location.longitude),
        },
        map: map,
        title: location.park_name,
      };

      let marker = new google.maps.Marker(markerOptions);
      let type = location.type_id === 1 ? "Park" : location.type_id === 2 ? "Trail" : "Unknown";

      let infoWindow = new google.maps.InfoWindow({
        content: `
          <h3>${location.park_name}</h3>
          <p><strong>Address:</strong> ${location.address}</p>
          <p><strong>Type:</strong> ${type}</p>
          <p><strong>Community:</strong> ${location.community}</p>
          <p>${location.add_info}</p>
        `,
      });

      marker.addListener("click", () => {
        infoWindow.open(map, marker);
      });
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

    // If no cached data is available, use the data from $locationsJson
    let cachedLocations = getCachedLocations();
    if (!cachedLocations) {
      let locations = JSON.parse('{!! addslashes($locationsJson) !!}');
      cacheLocations(locations); // Cache the data for future use
      addMarkersToMap(locations);
    } else {
      addMarkersToMap(cachedLocations);
    }
  }

  function loadGoogleMapsScript() {
    const script = document.createElement("script");
    script.src = `https://maps.googleapis.com/maps/api/js?key=AIzaSyD-7uGxcXtxOHLNCj867iBF6CfAP0IDeFw&callback=initMap&v=weekly`;
    script.defer = true;
    document.head.appendChild(script);
  }

  loadGoogleMapsScript();
</script>








@endsection