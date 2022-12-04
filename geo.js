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
}

window.initMap = initMap;