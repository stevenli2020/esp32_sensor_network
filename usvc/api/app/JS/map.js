async function initMap() {
  var addrs;
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 11,
    center: { lat: 1.3521, lng: 103.8198 },
  });
  const infoWindow = new google.maps.InfoWindow({
    content: "",
    // disableAutoPan: true,
  });

  
  await fetch(`${domain}API/?act=getFacilities`, {    
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(RequestData()),
  })
  .then((response) => response.json())
  .then((data) => {
    if(data.CODE == 0){
      // console.log(data.DATA)
      addrs = data.DATA  

    }
  })
  .catch((error) => {
      console.error("Error:", error);
  });

  // Create an array of alphabetical characters used to label the markers.
  const labels = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  // Add some markers to the map.
  var boxList = [];
  const markers = addrs.map((addr) => {
    // const label = labels[i % labels.length];
    // const marker = new google.maps.Marker({
    //   position,
    //   label,
    // });
    position = {lat: parseFloat(addr.LATITUDE), lng: parseFloat(addr.LONGITUDE)}
    var Nname = String(addr.NAME)
    // var name = String(addr.DESCRPTIONS)
    // console.log(name, typeof(name))
    // const label = 
    // '<div id="content">' +
    // '<div id="siteNotice">' +
    // "</div>" +
    // `<h5 id="firstHeading" type="button" class="firstHeading">${name}</h5>` +
    // '<div id="bodyContent">' +
    // `<p>${addr.ADDR}</p>` +
    // `<p>${addr.DESCRPTIONS} </p> ` +
    // // `<button id="${name}" type="button" onclick="detail(${name})">Detail</button>` +
    // "</div>" +
    // "</div>";
    if(addr.IMG_LINK == "")
      addr.IMG_LINK = null
    createFacilitiesList('facilities-list', addr.UID, addr.NAME, addr.IMG_LINK, addr.NAME, addr.ADDR)

    const marker = new google.maps.Marker({
      position,
    })
    // markers can only be keyboard focusable when they have click listeners
    // open info window when marker is clicked
    marker.addListener("click", () => {
      var firstDiv = document.createElement('div');
      var heading = document.createElement('h5');
      var secondDiv = document.createElement('div');
      var firstP = document.createElement('p')
      // var secondP = document.createElement('p')
      var btn = document.createElement('button')
      heading.setAttribute('id', "firstHeading")
      heading.setAttribute('class', "firstHeading")
      secondDiv.setAttribute('id', "bodyContent")
      btn.setAttribute('id', Nname)
      btn.setAttribute('type', 'button')
      btn.setAttribute('class', 'button-85')
      btn.onclick = function(){detail(addr.NAME,Nname)};
      btn.innerHTML = 'Go to Details'
      heading.innerHTML = addr.NAME
      firstP.innerHTML = String(addr.ADDR)
      // secondP.innerHTML = String(Nname)
      firstDiv.appendChild(heading)
      firstDiv.appendChild(secondDiv)
      secondDiv.appendChild(firstP)
      // secondDiv.appendChild(secondP)
      secondDiv.appendChild(btn)
      infoWindow.close();
      infoWindow.setContent(firstDiv);
      infoWindow.open(marker.getMap(), marker);
    });
    return marker;
  });

  
  // Add a marker clusterer to manage the markers.
  const markerCluster = new markerClusterer.MarkerClusterer({ map, markers });
  // Create the search box and link it to the UI element.
  const input = document.getElementById("pac-input");
  const searchBox = new google.maps.places.SearchBox(input);

  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

  // Bias the SearchBox results towards current map's viewport.
  map.addListener("bounds_changed", () => {
    searchBox.setBounds(map.getBounds());
  });

  let pointers = [];

  // Listen for the event fired when the user selects a prediction and retrieve
  // more details for that place.
  searchBox.addListener("places_changed", () => {
    const places = searchBox.getPlaces();

    if (places.length == 0) {
      return;
    }

    // Clear out the old markers.
    pointers.forEach((pointer) => {
      pointer.setMap(null);
    });
    pointers = [];

    // For each place, get the icon, name and location.
    const bounds = new google.maps.LatLngBounds();

    places.forEach((place) => {
      if (!place.geometry || !place.geometry.location) {
        console.log("Returned place contains no geometry");
        return;
      }

      const icon = {
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(25, 25),
      };

      // Create a marker for each place.
      pointers.push(
        new google.maps.Marker({
          map,
          icon,
          title: place.name,
          position: place.geometry.location,
        })
      );
      // markers can only be keyboard focusable when they have click listeners
      // open info window when marker is clicked
      // markers.addListener("click", () => {
      //   infoWindow.setContent(label);
      //   infoWindow.open(map, marker);
      // });

      if (place.geometry.viewport) {
        // Only geocodes have viewport.
        bounds.union(place.geometry.viewport);
      } else {
        bounds.extend(place.geometry.location);
      }
    });
    map.fitBounds(bounds);
  });
}

function detail(Hname, Nname){
  // console.log("clicked button " + name)
  var curPage = window.location.href
  // console.log(curPage)
  window.location = curPage + "Facility/?name=" + Hname
}

// function iwClick(str){
//   console.log(str);
// };

// function initMap() {
//   const map = new google.maps.Map(document.getElementById("map"), {
//     center: { lat: 1.3521, lng: 103.8198 },
//     zoom: 11,
//     mapTypeId: "roadmap",
//   });

//   // Create the search box and link it to the UI element.
//   const input = document.getElementById("pac-input");
//   const searchBox = new google.maps.places.SearchBox(input);

//   map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

//   // Bias the SearchBox results towards current map's viewport.
//   map.addListener("bounds_changed", () => {
//     searchBox.setBounds(map.getBounds());
//   });

//   let markers = [];

//   // Listen for the event fired when the user selects a prediction and retrieve
//   // more details for that place.
//   searchBox.addListener("places_changed", () => {
//     const places = searchBox.getPlaces();

//     if (places.length == 0) {
//       return;
//     }

//     // Clear out the old markers.
//     markers.forEach((marker) => {
//       marker.setMap(null);
//     });
//     markers = [];

//     // For each place, get the icon, name and location.
//     const bounds = new google.maps.LatLngBounds();

//     places.forEach((place) => {
//       if (!place.geometry || !place.geometry.location) {
//         console.log("Returned place contains no geometry");
//         return;
//       }

//       const icon = {
//         url: place.icon,
//         size: new google.maps.Size(71, 71),
//         origin: new google.maps.Point(0, 0),
//         anchor: new google.maps.Point(17, 34),
//         scaledSize: new google.maps.Size(25, 25),
//       };

//       // Create a marker for each place.
//       markers.push(
//         new google.maps.Marker({
//           map,
//           icon,
//           title: place.name,
//           position: place.geometry.location,
//         })
//       );
//       // markers can only be keyboard focusable when they have click listeners
//       // open info window when marker is clicked
//       // markers.addListener("click", () => {
//       //   infoWindow.setContent(label);
//       //   infoWindow.open(map, marker);
//       // });

//       if (place.geometry.viewport) {
//         // Only geocodes have viewport.
//         bounds.union(place.geometry.viewport);
//       } else {
//         bounds.extend(place.geometry.location);
//       }
//     });
//     map.fitBounds(bounds);
//   });
//   // Create an array of alphabetical characters used to label the markers.
//   const labels = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
//   // Add some markers to the map.
//   const clusters = locations.map((position, i) => {
//     const label = labels[i % labels.length];
//     const cluster = new google.maps.Marker({
//       position,
//       label,
//     });

//     // markers can only be keyboard focusable when they have click listeners
//     // open info window when marker is clicked
//     cluster.addListener("click", () => {
//       infoWindow.setContent(label);
//       infoWindow.open(map, cluster);
//     });
//     return cluster;
//   });


//   const markerCluster = new markerClusterer.MarkerClusterer({ map, clusters });
// }

const locations = [
  { lat: 1.3175067, lng: 103.8796882 },
  { lat: 1.279458 , lng: 103.852931 },
  { lat: 1.3122385, lng: 103.885843 },
  { lat: 1.3114113, lng: 103.8847267 },
  { lat: 1.3116751, lng: 103.8809937 },
  { lat: 1.3116458, lng: 103.8797734 },
  { lat: 1.3124484, lng: 103.8747473 }
];

if(checkLogin()){
  window.initMap = initMap;
} else {
  window.location.href = loginPage
}




