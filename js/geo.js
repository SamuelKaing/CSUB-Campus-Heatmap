var sums = []; // Current Pop at the Hour
var max_day_pop = []; // Max Pop of the Day
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


  //var sci3Coords = [
  //  {location: new google.maps.LatLng(35.3451703, 119.1016499), weight: 10}, // MaxPop
  //  {location: new google.maps.LatLng(35.34905, -119.103735), weight: 5} // SCI III
//
  //];



  var heatmapColors = [
    'rgba(0,0,0,0)',
    'rgba(255,243,59, 1)',
    'rgba(253,199,12, 1)',
    'rgba(243,144,63, 1)',
    'rgba(237,104,60, 1)',
    'rgba(233,62,58, 1)',
    'rgba(233,62,58,  0)'
  ];

  // Set new coord variables to display
  var coordinates = [
    { lat: 35.34851004056744, lng: -119.10511322767425, weight: sums[0]}, // DLC
    { lat: 35.3488103071228, lng: -119.1049281552524, weight: sums[1]}, // BDC
    { lat: 35.350314357770046, lng: -119.10460494910889, weight: sums[2]}, // EDUC
    { lat: 35.35041170991977, lng: -119.10366215260566, weight: sums[3]}, // DDH
    { lat: 35.35145030767175, lng: -119.10324909237707, weight: sums[4]}, // WSL
    { lat: 35.35191244929372, lng: -119.10589643262507, weight: sums[5]}, // MUS
    { lat: 35.34905, lng: -119.103735 , weight: sums[6]}, // SCI3
    { lat: 35.348341037610666, lng: -119.10494961286662 , weight: sums[7]}, // EXTU
    { lat: 35.35131904803069, lng: -119.10514407286801 , weight: sums[8]}, // FA
    { lat: 35.35039858379907, lng: -119.10527281908283, weight: sums[9]}, // VA
    { lat: 35.351922293680644, lng: -119.10664879235516, weight: sums[10]}, // HUM
    { lat: 35.3496279672356, lng: -119.1032698794434, weight: sums[11]}, // SCI2
    { lat: 35.34970945930878, lng: -119.10462506563853, weight: sums[12]}, // RNEC
    { lat: 35.34968922304935, lng: -119.10380162740101, weight: sums[13]}, // SCI1
    { lat: 35.347826916348836, lng: -119.10472095436253, weight: sums[14]}, // EC1
    { lat: 35.34804405092345, lng: -119.10481684346193, weight: sums[15]}, // EC2
    { lat: 35.34826720123105, lng: -119.1027421548079, weight: sums[16]}, // PE
    { lat: 35.34895633801285, lng: -119.10161294482636, weight: sums[17]}, // SRC
    { lat: 35.35228598903685, lng: -119.10531439315079, weight: sums[18]} // DT
  ];

  // Going to push all the Coords in here
  var dataCoords = [];

  for (var i = 0; i < coordinates.length; i++) {
    var location = new google.maps.LatLng(coordinates[i].lat, coordinates[i].lng);
    var weight = coordinates[i].weight;
    if (weight == 0) {
      weight == 0;
    } else {
      dataCoords.push({location: location, weight: weight});
    }
  }

  var heatmap = new google.maps.visualization.HeatmapLayer({
      data: dataCoords,
      map: map,
      radius: 50,
      gradient: heatmapColors,
  });


//var coords = [
    //  {location: new google.maps.LatLng(35.3451703, 119.1016499), weight: 10}, // MaxPop
    //  {location: new google.maps.LatLng(35.34905, -119.103735), weight: 5} // SCI III
    //];
  //
    //var heatmap = new google.maps.visualization.HeatmapLayer({
    //  data: coords,
    //  map: map,
    //  radius: 50,
    //  gradient: heatmapColors,
    //});


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
}
