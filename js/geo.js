var sums = [];
var max_day_pop = [];
var buildings = [];

function getArray(json_sums, json_max_day_pop, json_buildings) {
  sums = JSON.parse(json_sums);
  max_day_pop = JSON.parse(json_max_day_pop);
  buildings = JSON.parse(json_buildings);
}

function initMap() {
  // The location of Csub
  const csub = { lat: 35.3503, lng: -119.1025 };
  // The map, centered at csub
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 15,
    center: csub
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
  
  //var enrolled_sci3 = document.getElementById("CurrentPop").getAttribute("data-value");
  //var total_sci3 = document.getElementById("MaxPop").getAttribute("data-value");

  //console.log(total_sci3);
  //console.log(enrolled_sci3);


  // Find Max amount of pop at a certain time. Set that as the max weight 


  console.log(sums);
  console.log(max_day_pop);
  console.log(buildings);


  var sci3Coords = [
    {location: new google.maps.LatLng(35.3451703, 119.1016499), weight: 10}, // MaxPop
    {location: new google.maps.LatLng(35.34905, -119.103735), weight: 5} // SCI III

  ];



  var heatmapColors = [
    'rgba(0,0,0,0)',
    'rgba(255,243,59, 1)',
    'rgba(253,199,12, 1)',
    'rgba(243,144,63, 1)',
    'rgba(237,104,60, 1)',
    'rgba(233,62,58, 1)',
    'rgba(233,62,58,  0)'
  ];


  var heatmap = new google.maps.visualization.HeatmapLayer({
    data: sci3Coords,
    map: map,
    radius: 50,
    gradient: heatmapColors,
  });

  
}

window.initMap = initMap;

var slider = document.getElementById("my_range");
var value = document.getElementById("time_display");

// Update the current slider value (each time you drag the slider handle)
slider.oninput = function() {
  // Shows slider value in standard time
  if(this.value > 12) {
    value.innerHTML = this.value - 12;
    value.innerHTML = value.innerHTML + ":00 pm" ;
  } 
  else {
    value.innerHTML = this.value;
    value.innerHTML = value.innerHTML + ":00 am" ;
  }
}

