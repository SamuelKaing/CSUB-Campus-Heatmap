
function initMap() {
  // The location of Csub
  const csub = { lat: 35.3503, lng: -119.1025 };
  // The map, centered at csub
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 15,
    center: csub,
  });
  // The marker, positioned at csub
  const marker = new google.maps.Marker({
    position: csub,
    map: map,
  });

  const locationButton = document.createElement("button");
  locationButton.textContent = "Move to current location";
  locationButton.classList.add("custom-map-control-button");
  map.controls[google.maps.ControlPosition.TOP_CENTER].push(locationButton);

  locationButton.addEventListener("click", () => {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function (position) {
          map.panTo({lat: position.coords.latitude, lng: position.coords.longitude});
        })
    }
  })

  const csubButton = document.createElement("button");
  csubButton.textContent = "Move to campus";
  csubButton.classList.add("custom-map-control-button");
  map.controls[google.maps.ControlPosition.TOP_CENTER].push(csubButton);

  csubButton.addEventListener("click", () => {
    map.panTo(csub);
  })
  
  var heatmapCoords = [
    {location: new google.maps.LatLng(35.3470426, -119.1031204), weight: 10},
    {location: new google.maps.LatLng(35.3470426, -119.1016183), weight: 5},
    {location: new google.maps.LatLng(35.3451703, -119.1031204), weight: 3},
    {location: new google.maps.LatLng(35.3451703, -119.1016499), weight: 1},
    {location: new google.maps.LatLng(35.34905, -119.103735), weight: 1} // SCI III
  ];

  var heatmapColors = [
    'rgba(0, 0, 0, 0)',
    'rgba(255,243,59, 1)',
    'rgba(253,199,12, 1)',
    'rgba(243,144,63, 1)',
    'rgba(237,104,60, 1)',
    'rgba(233,62,58, 1)'
  ];

  var heatmap = new google.maps.visualization.HeatmapLayer({
    data: heatmapCoords,
    map: map,
    radius: 50,
    gradient: heatmapColors,
    maxIntensity: 10
  });

  
}

window.initMap = initMap;

var slider = document.getElementById("myRange");
var value = document.getElementById("f");
value.innerHTML = slider.value;

// Update the current slider value (each time you drag the slider handle)
slider.oninput = function() {
  value.innerHTML = this.value;
}