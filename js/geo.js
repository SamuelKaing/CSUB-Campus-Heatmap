
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
    {location: new google.maps.LatLng(35.3470426, -119.1031204), weight: 3},
    {location: new google.maps.LatLng(35.3470426, -119.1016183), weight: 3},
    {location: new google.maps.LatLng(35.3451703, -119.1031204), weight: 3},
    {location: new google.maps.LatLng(35.3451703, -119.1016499), weight: 3}
  ];


  var heatmap = new google.maps.visualization.HeatmapLayer({
    data: heatmapCoords,
    map: map
  });

  /*heatmap.set('gradient', [
    'rgba(0, 255, 255, 0)',
    'rgba(0, 63, 255, 1)',
    'rgba(0, 191, 255, 1)',
    'rgba(0, 127, 255, 1)'
  ])
  
  heatmap.set('opacity', 0.8);
  heatmap.set('radius', 20);
  */ 
}

window.initMap = initMap;