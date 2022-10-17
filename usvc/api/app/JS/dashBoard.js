// add facility form
const facName = document.getElementById("fac-name");
const MAC = document.getElementById("MAC");
const facAddress = document.getElementById("fac-address");
const facLatitude = document.getElementById("fac-latitude");
const facLongitude = document.getElementById("fac-longitude");
const registerSubmitBtn = document.getElementById("register-submit-btn");
const facImgLink = document.getElementById("fac-image-link");
const facNameSugg = document.getElementById("fac-name-suggest")
const facAddrSugg = document.getElementById("fac-addr-suggest")
const suggestionAddr = document.getElementById("nameSuggestedModal");
const Suggestion = document.getElementById("nameSuggestedModalSm");
const nameError = document.getElementById("nameError");
const addrError = document.getElementById("addrError");
const latError = document.getElementById("latError");
const lonError = document.getElementById("lonError");
const imgLinkError = document.getElementById('imgLinkError'); 

const clusterID = document.getElementById("cluster-id");
const totalCount = document.getElementById("totalcount");
const upToday = document.getElementById("up-today");
const dCount = document.getElementById("dcount");
const dChange = document.getElementById("dchange");
const wCount = document.getElementById("wcount");
const wChange = document.getElementById("wchange");
const mCount = document.getElementById("mcount");
const mChange = document.getElementById("mchange");
const qCount = document.getElementById("qcount");
const qChange = document.getElementById("qchange");
// add user form
const fullName = document.getElementById("fullname");
const userName = document.getElementById("username-register");
const email = document.getElementById("email-register");
const phNum = document.getElementById("phone-number-register");
const userType = document.getElementById("userType");
const usernameError = document.getElementById("username-register-error");
const fullNameError = document.getElementById("fullNameError");
const emailError = document.getElementById("email-register-error");
const phNumError = document.getElementById("phone-register-error");
const userTypeError = document.getElementById("user-type-error");
const userSubmitBtn = document.getElementById("user-register-submit-btn");
const offcanvasLogin = document.getElementById("offcanvas-login");
const offcanvasLogout = document.getElementById("offcanvas-logout");
// update facility form
const updateFacForm = document.getElementById('updateFacilityForm');
const updateFacHeaderCloseBtn = document.getElementById('update-fac-btn');
const updateFacCloseBtn = document.getElementById('update-fac-close-btn');
const updateFacName = document.getElementById('update-fac-name');
const updateFacAddr = document.getElementById('update-fac-address');
const updateFacLat = document.getElementById('update-fac-latitude');
const updateFacLon = document.getElementById('update-fac-longitude');
const updateFacImgLink = document.getElementById('update-fac-image-link');
const updateFacNameError = document.getElementById('updateNameError');
const updateFacAddrError = document.getElementById('updateAddrError');
const updateFacLatError = document.getElementById('updateLatError');
const updateFacLonError = document.getElementById('updateLonError');
const updateFacImgLinkError = document.getElementById('updateImgLinkError');
const updateFacSubmitBtn = document.getElementById('update-fac-submit-btn');
// delete facility form
const deleteFacFormModal = document.getElementById('deleteFacilityForm');
const deleteFacFormModalBody = document.getElementById('deleteFacilityFormBody')
const deleteFacXbtn = document.getElementById('delete-fac-x-btn')
const deleteFacCloseBtn = document.getElementById('delete-fac-close-btn')
const deleteFacSubmitBtn = document.getElementById('delete-fac-submit-btn')
// Sensor Table
const dashBoardTableBody = document.getElementById('dashboard-table').getElementsByTagName('tbody')[0]
// dashBoardHeaderChart
const cpuHeader = document.getElementById('cpu-header')
const memHeader = document.getElementById('mem-header')
const bytesHeader = document.getElementById('bytes-header')
const eventsHeader = document.getElementById('events-header')

var mqtt;
var reconnectTimeout = 2000;
var host="data.fssn.ezmote.com";
var port = 8888;

offcanvasChildElRemove("offcanvasEl");
offcanvasHomeliCreate("offcanvasEl", "Home");
offcanvasHomeliCreate("offcanvasEl", "Dash Board");
if (checkLogin()) {
  
  TYPE = getCookie("TYPE");
//   console.log(TYPE, typeof(TYPE), TYPE != 0)
  if(TYPE != 0){
    offcanvasliCreate(
        "offcanvasEl",
        "li",
        "a",
        "nav-item",
        "nav-link",
        "addFacility",
        "addFacilityFormModal",
        "button",
        "addFacility",
        "modal",
        "#addFacilityForm",
        '<i class="fa-solid fa-city"></i> Add New Facility'
      );
      offcanvasliCreate(
        "offcanvasEl",
        "li",
        "a",
        "nav-item",
        "nav-link",
        "registerUser",
        "registerUserModal",
        "button",
        "registerUser",
        "modal",
        "#registerUserForm",
        '<i class="fa-solid fa-address-card"></i> Add New User'
      );
      document.getElementById("addFacility").addEventListener("click", () => {
        document.querySelector("#Close-button").click();
      });
      
      document.getElementById("registerUserModal").addEventListener("click", () => {
        document.querySelector("#Close-button").click();
      });
  }
  UNAME = getCookie("USERNAME");
  offcanvasLogin.innerHTML = `<a class="nav-link" aria-current="page">${UNAME} <i class="fa-solid fa-user"></i></a>`;
  offcanvasLogin.setAttribute("onclick", `userDetail('${UNAME}')`);
  offcanvasLogin.setAttribute("type", "button");
  offcanvasLogout.setAttribute("type", "button");
  offcanvasLogout.innerHTML =
    '<a class="nav-link" aria-current="page" >Log Out <i class="fa-solid fa-right-from-bracket"></i></a>';
} else {
  offcanvasLogin.setAttribute("onclick", "gotologin()");
  offcanvasLogin.setAttribute("type", "button");
  offcanvasLogin.innerHTML = `<a class="nav-link" aria-current="page" >Login <i class="fa-solid fa-user"></i></a>`;
  offcanvasLogout.innerHTML = "";
}

var counter = 1;
var maxCounter = 5;
var delayms = 2000;

function addTableRow(time, fac, loc, batt, type, val) {
  var newRow = $("<tr style='background-color:#9da;'><td>" + time + "</td><td>"+ fac +"</td><td>"+loc+"</td><td>"+batt+"</td><td>"+type+"</td><td>"+val+"</td></tr>");

  newRow.fadeIn(400).delay(2000).animate({
      backgroundColor: "#fff"
  }, 2000);
  // $("#dashboard-table>tbody>tr").eq(4).fadeTo("fast", 0.01, function(){
  //   $(this).remove()
  // })
  $("#dashboard-table>tbody>tr").eq(0).before(newRow);  
    
}

// addTableRow();



function onConnect(){
  // console.log('Connected')
  // message = new Paho.MQTT.Message('Hello World');
  // message.destinationName = 'sensor1';
  // mqtt.send(message);
  mqtt.subscribe('/FSSN/#')
}

async function onMessageArrived(message) {
  // console.log("onMessageArrived: " + message.payloadString, message.destinationName.split('/'), message);
  mac = message.destinationName.split('/')
  mac = mac[mac.length - 1]
  dataR = message.payloadString.split(":")
  // console.log(`${dataR[0]} : ${parseInt(dataR[1], 16)} : ${parseInt(dataR[2], 16)} : ${parseInt(dataR[3], 16)}, ${mac}, ${mac.length}`)
  if(mac.length == 12){
    RData = {
      MAC: mac
    };
    Object.assign(RData, RequestData())
    await fetch(`${domain}API/?act=getRLLocNode`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(RData),
    })
    .then((response) => response.json())
    .then((data) => {
      // console.log(data)  
      if(data.CODE == 0){
        dashBoardTableBody.deleteRow(4)
        var today = new Date();
        var time = (today.getHours()<10?`0${today.getHours()}`:today.getHours()) + ":" + (today.getMinutes()<10?`0${today.getMinutes()}`:today.getMinutes()) + ":" + (today.getSeconds()<10?`0${today.getSeconds()}`:today.getSeconds());
        var batT, typeT, facT, locT
        if(dataR[0] == air) typeT = 'air'
        else if(dataR[0] == motion) typeT = 'motion'
        else if(dataR[0] == distance)typeT = 'distance'
        if(parseInt(dataR[2], 16) >= 4200) batT = '100 %'
        else if(parseInt(dataR[2], 16) < 3200) batT = '0 %'
        else batT = (parseInt(dataR[2], 16)-3200)/10 + ' %'
        data.DATA.forEach(sensor => {
          facT = sensor.FACILITY_NAME
          locT = sensor.LOCATION_NAME        
        })
        addTableRow(time, facT, locT, batT, typeT, parseInt(dataR[3], 16))
      }  
    })
    .catch((error) => {
      console.error("Error:", error);
    });
  }
  
}

function MQTTconnect(){
  // console.log("connecting to "+host+" "+port);
  // mqtt = new Paho.MQTT.Client(host, port, "steven-fssn1234");
  mqtt = new Paho.MQTT.Client(host, port, "1234");
  // client.onConnectionLost = onConnectionLost;
  mqtt.onMessageArrived = onMessageArrived;
  var options = {
    timeout: 3,
    onSuccess: onConnect,
    onFailure:doFail,
    userName : "js-client",
		password : "c764eb2b5fa2d259dc667e2b9e195218"
    // useSSL: true
  }
  mqtt.connect(options);
}

function doFail(e){
  console.log(e);
}

MQTTconnect();

async function getStatus(val=1){
  rData = {
    VALUE: val
  }
  Object.assign(rData, RequestData())
  fetch(`${domain}API/?act=getStatus`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify(rData)
  })
  .then(response => response.json())
  .then(data => {
    // console.log(data)
    if(data.CODE == 0){
      if(data.DATA.length > 1){
        time = [], cpu = [], mem = [], byt = [], evt = []
        data.DATA.forEach(sta => {
          cpu.push(Math.round(sta.CPU*100))
          mem.push(sta.MEM_USED)
          byt.push(parseFloat(sta.BPS_SEND) + parseFloat(sta.BPS_RCVD))
          time.push(sta.TIME)
          evt.push(convertToInternationalCurrencySystem(sta.EVENTS_PER_HOUR))
        })
        // console.log(time, cpu, mem, byt, evt)
        cpuHeader.innerText = cpu[cpu.length-1] + " %"
        memHeader.innerText = convertToInternationalCurrencySystem(mem[mem.length-1]*1000000) + "B"
        bytesHeader.innerText = Math.round(byt[byt.length-1]) + " B"
        eventsHeader.innerText = evt[evt.length-1]
        updateCpu(cpu[cpu.length -1 ])
        updateMem(mem[mem.length - 1])
        updateByte(time, byt)
        updateEvents(time, evt)
      } else {
        data.DATA.forEach(sta => {
          updateCpu(Math.round(sta.CPU*100))
          cpuHeader.innerText = Math.round(sta.CPU*100) + " %"
          updateMem(sta.MEM_USED)
          memHeader.innerText = convertToInternationalCurrencySystem(sta.MEM_USED*1000000) + "B"
          shiftByte(sta.TIME, Math.round(parseFloat(sta.BPS_SEND) + parseFloat(sta.BPS_RCVD)))
          bytesHeader.innerText = Math.round(parseFloat(sta.BPS_SEND) + parseFloat(sta.BPS_RCVD)) + " B"
          shiftEvents(sta.TIME, sta.EVENTS_PER_HOUR)
          eventsHeader.innerText = convertToInternationalCurrencySystem(sta.EVENTS_PER_HOUR)
        })
      }
      
    }
  })
  .catch(error => console.log(error))
}
getStatus(5)
setInterval(getStatus, 10000)



function facDelete(fname, uid){
  // console.log('clicked '+ fname + uid)
  // let paragraph = document.createElement('p')
  // paragraph.innerHTML = `Are you sure, you want to delete <strong>${fname}</strong> Facility?`
  deleteFacCloseBtn.addEventListener('click', e => {
    deleteFacFormModal.classList.remove('show');
    deleteFacFormModal.setAttribute('style', 'display: none;')
    deleteFacFormModal.removeAttribute('aria-modal')
    deleteFacFormModal.removeAttribute('role')
    deleteFacFormModal.setAttribute('aria-hidden', 'true')
    deleteFacFormModalBody.innerHTML = ''
    deleteFacSubmitBtn.setAttribute('uid', '')
  })
  deleteFacXbtn.addEventListener('click', e => {
    deleteFacFormModal.classList.remove('show');
    deleteFacFormModal.setAttribute('style', 'display: none;')
    deleteFacFormModal.removeAttribute('aria-modal')
    deleteFacFormModal.removeAttribute('role')
    deleteFacFormModal.setAttribute('aria-hidden', 'true')
    deleteFacFormModalBody.innerHTML = ''
    deleteFacSubmitBtn.setAttribute('uid', '')
  })
  deleteFacFormModal.classList.add('show')
  deleteFacFormModal.setAttribute('style', 'display: block;')
  deleteFacFormModal.setAttribute('aria-modal', 'true');
  deleteFacFormModal.setAttribute('role', 'dialog');
  deleteFacFormModal.removeAttribute('aria-hidden');
  deleteFacFormModalBody.innerHTML = `Are you sure, you want to delete <strong>${fname}</strong> Facility?`;
  deleteFacSubmitBtn.setAttribute('uid', uid)
  // deleteFacFormModalBody.appendChild(paragraph)
}

async function facUpdate(fname){
  // console.log('clicked '+ fname) 
  updateFacName.value = '';
  updateFacAddr.value = '';
  updateFacLat.value = '';
  updateFacLon.value = '';
  updateFacImgLink.value = '';
  updateFacSubmitBtn.setAttribute('uid', '');
  updateFacName.setAttribute('oriName', '');
  updateFacImgLink.addEventListener('input', e => {
    if(updateFacImgLink.value != ''){
      if(isImage(e.target.value)){
        updateFacImgLink.style.border = '1px solid #ced4da'
        updateFacImgLinkError.innerHTML = ""
      } else {
        updateFacImgLink.style.border = '1px solid red'
        updateFacImgLinkError.innerHTML = "URL is not an image"
      }
    } else {
      updateFacImgLink.style.border = '1px solid #ced4da'
      updateFacImgLinkError.innerHTML = ""
    }    
  }) 
  updateFacHeaderCloseBtn.addEventListener('click', e => {
    updateFacForm.classList.remove('show');
    updateFacForm.setAttribute('style', 'display: none;')
    updateFacForm.removeAttribute('aria-modal')
    updateFacForm.removeAttribute('role')
    updateFacForm.setAttribute('aria-hidden', 'true')
  })
  updateFacCloseBtn.addEventListener('click', e => {
    updateFacForm.classList.remove('show');
    updateFacForm.setAttribute('style', 'display: none;')
    updateFacForm.removeAttribute('aria-modal')
    updateFacForm.removeAttribute('role')
    updateFacForm.setAttribute('aria-hidden', 'true')
  })
  updateFacForm.setAttribute('class', 'modal fade show')
  updateFacForm.setAttribute('style', 'display: block;')
  updateFacForm.setAttribute('aria-modal', 'true');
  updateFacForm.setAttribute('role', 'dialog');
  updateFacForm.removeAttribute('aria-hidden');
  RData = {
    VALUE: fname,
  };
  Object.assign(RData, RequestData())
  await fetch(`${domain}API/?act=getFacilitySuggestion`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(RData),
  })
  .then((response) => response.json())
  .then((data) => {
    // console.log(data)
    if(data.CODE == 0){
      updateFacName.style.border = '1px solid #ced4da';
      updateFacNameError.innerHTML = '';
      updateFacName.value = data.DATA[0].NAME;
      updateFacAddr.value = data.DATA[0].ADDR;
      updateFacLat.value = data.DATA[0].LATITUDE;
      updateFacLon.value = data.DATA[0].LONGITUDE;
      updateFacImgLink.value = data.DATA[0].IMG_LINK;
      updateFacSubmitBtn.setAttribute('uid', data.DATA[0].UID);
      updateFacName.setAttribute('oriName', fname);
    } else {
      updateFacName.style.border = '1px solid red';
      updateFacNameError.innerHTML = 'Facility Name Not Found';
    }
  })
  .catch((error) => {
    console.error("Error:", error);
  });
}



document.getElementById("register-node-btn").addEventListener("click", () => {
  Suggestion.classList.remove("show");
  Suggestion.style.display = "";
});

facImgLink.addEventListener('input', e => {
  if(e.target.value != ""){
    if(isImage(e.target.value)){
      facImgLink.style.border = '1px solid #ced4da'
      imgLinkError.innerHTML = ""
    } else {
      facImgLink.style.border = '1px solid red'
      imgLinkError.innerHTML = "URL is not an image"
    }
  }
})

facName.addEventListener("input", (e) => {
  setTimeout(async () => {
    // console.log(e.target.value)

    if (e.target.value != "") {
      RData = {
        VALUE: e.target.value,
      };
      Object.assign(RData, RequestData())
      await fetch(`${domain}API/?act=getFacilitySuggestion`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(RData),
      })
        .then((response) => response.json())
        .then((data) => {
          removeChildEl("fac-name-suggest")
          // console.log(data)
          // if(data["CODE"] == 0)
          // response = data["DATA"];
          // response = data;
          // offcanvasChildElRemove("suggest-list-name");
          if (data["CODE"] == 0) {
            data["DATA"].forEach(fac => {
              b = document.createElement("DIV");
              b.innerHTML = fac.NAME;
              facNameSugg.appendChild(b);
            })
            // Suggestion.classList.add("show");
            // Suggestion.style.display = "block";
            // data["DATA"].forEach((element) => {
            //   // console.log(element.NAME)
            //   appendChildEl(
            //     "suggest-list-name",
            //     "button",
            //     "button",
            //     "list-group-item list-group-item-action",
            //     element.NAME,
            //     element.NAME
            //   );
            // });
          } else if (data["MESSAGE"] == "NO DATA") {
            // console.log(data["MESSAGE"]);
            // Suggestion.classList.remove("show");
            // Suggestion.style.display = "";
          }
        })
        .catch((error) => {
          console.error("Error:", error);
        });

      // if (!moblieCheck()) {
      //   Suggestion.style.top = "21%";
      //   Suggestion.style.left = "-7%";
      // } else {
      //   Suggestion.style.top = "155px";
      //   // Suggestion.style.left = "-7%"
      // }
    } else {
      removeChildEl("fac-name-suggest")
      // Suggestion.classList.remove("show");
      // Suggestion.style.display = "";
    }
    // Suggestion.addEventListener("click", (e) => {
    //   Suggestion.classList.remove("show");
    //   Suggestion.style.display = "";
    //   // console.log(e.target.nodeName)
    //   if (e.target.nodeName == "BUTTON") coordinatorName.value = e.target.id;
    // });
  }, 300);
});


// autocomplete(facName, countries);
facAddress.addEventListener("input", (e) => {
  // var loc = [];

  setTimeout(async () => {
    if (e.target.value != "" && e.target.value.length > 4) {
      await fetch(
        `https://maps.googleapis.com/maps/api/geocode/json?address=${e.target.value}&key=AIzaSyD0sYUSro6h_goOpkpnPYRnwI70B_cY4vo`,
        { method: "GET" }
      )
        .then((response) => response.json())
        .then((data) => {
          removeChildEl("fac-addr-suggest")
          if (data["status"] == "OK") {
            // console.log(data['results'])
            addr = []
            data["results"].forEach(loc => {
              addr.push(loc)
              let b, val = facAddress.value;
              if (!val) {
                return false;
              }
              currentFocus = -1;
              /*create a DIV element that will contain the items (values):*/
              
              b = document.createElement("DIV");
              
              b.innerHTML = loc.formatted_address;
              /*append the DIV element as a child of the autocomplete container:*/    
              b.addEventListener("click", function (e) {
                
                if (e.target.nodeName == "DIV") {
                  removeChildEl("fac-addr-suggest");
                  facAddress.value = e.target.innerHTML;
                  var locat = addr.filter((val) =>
                    val.formatted_address.includes(e.target.innerHTML)
                  );
                  if (locat.length > 0) {
                    facLatitude.value = locat[0].geometry.location.lat;
                    facLongitude.value = locat[0].geometry.location.lng;
                  }
                }
              });          
              facAddrSugg.appendChild(b);
            })
          } else if (data["status"] == "ZERO_RESULTS") {
            suggestionAddr.classList.remove("show");
            suggestionAddr.style.display = "";
          }
          
        })
        .catch((error) => {
          console.error("Error:", error);
        });
      // if (!moblieCheck()) suggestionAddr.style.top = "33%";
      // else {
      //   suggestionAddr.style.top = "160px";
      // }
      // suggestionAddr.addEventListener("click", (e) => {
      //   suggestionAddr.classList.remove("show");
      //   suggestionAddr.style.display = "";
      //   if (e.target.nodeName == "BUTTON") {
      //     facAddress.value = e.target.id;
      //     var locat = loc.filter((val) =>
      //       val.formatted_address.includes(e.target.id)
      //     );
      //     if (locat.length > 0) {
      //       facLatitude.value = locat[0].geometry.location.lat;
      //       facLongitude.value = locat[0].geometry.location.lng;
      //     }
      //   }
      // });
    } else
    removeChildEl("fac-addr-suggest")
  }, 300);
});

window.addEventListener("click", (e) => {
  // console.log(e.path[0].id, e.path[2].id, e)
  if(e.path[0].id == 'fac-image'){
    window.location.href = `${facilityPage}?name=${e.path[2].id}`
  }
  if(e.path[1].id == 'fac-list'){
    window.location.href = `${facilityPage}?name=${e.path[3].id}`
  }
  if(e.path[2].id == 'fac-list'){
    window.location.href = `${facilityPage}?name=${e.path[4].id}`
  }
});

async function deleteFacility(){
  // console.log(deleteFacSubmitBtn.getAttribute('uid'))
  RData = {
    UID: deleteFacSubmitBtn.getAttribute('uid')
  }
  Object.assign(RData, RequestData())
  await fetch(`${domain}API/?act=removeFacility`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(RData),
  })
  .then((response) => response.json())
  .then((data) => {
    if(data.CODE == 0){
      document.querySelector('#delete-fac-close-btn').click();
      location.reload();
    } else {
      alert("Can't delete Facility")
    }
  })
  .catch((error) => {
    console.error("Error:", error);
  });
}

async function updateFacility(){
  updateFacImgLink.style.border = '1px solid #ced4da'
  updateFacImgLinkError.innerHTML = ''
  RData = {
    ADDR: updateFacAddr.value,
    LATITUDE: updateFacLat.value,
    LONGITUDE: updateFacLon.value,
    IMG_LINK: updateFacImgLink.value,
    UID: updateFacSubmitBtn.getAttribute('uid')
  }
  if(updateFacName.getAttribute('oriName') == updateFacName.value){
    Object.assign(RData, { NAME: updateFacName.value})
  } else {
    Object.assign(RData, { NAME:updateFacName.getAttribute('oriName'), UPDATENAME: updateFacName.value})
  }
  Object.assign(RData, RequestData())
  // console.log('update ' + JSON.stringify(RData))
  await fetch(`${domain}API/?act=updateFacility`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(RData),
  })
  .then((response) => response.json())
  .then((data) => {
    if(data.CODE == 0){
      document.querySelector('#update-fac-close-btn').click();
      location.reload();
    }
    if(data.CODE == -1){
      updateFacImgLink.style.border = '1px solid red'
      updateFacImgLinkError.innerHTML = data.MESSAGE
    }
  })
  .catch((error) => {
    console.error("Error:", error);
  });
}

async function addFacility() {
  registerSubmitBtn.disabled = true;
  facName.style.border = "1px solid #ced4da";
  nameError.innerHTML = "";
  facAddress.style.border = "1px solid #ced4da";
  addrError.innerHTML = "";
  facLatitude.style.border = "1px solid #ced4da";
  latError.innerHTML = "";
  facLongitude.style.border = "1px solid #ced4da";
  lonError.innerHTML = "";
  RData = {
    NAME: facName.value,
    ADDR: facAddress.value,
    LATITUDE: facLatitude.value,
    LONGITUDE: facLongitude.value,
    IMG_LINK: facImgLink.value,
  };
  Object.assign(RData, RequestData())
  // console.log(RData)
  await fetch(`${domain}API/?act=addFacility`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(RData),
  })
  .then((response) => response.json())
  .then((data) => {
    registerSubmitBtn.disabled = false;
    // console.log(data)
    if (data["CODE"] == -1) {
      if (data["MESSAGE"].length > 0) {
        nameError.innerHTML = data["MESSAGE"].filter((val) =>
          val.includes("Name")
        );
        addrError.innerHTML = data["MESSAGE"].filter((val) =>
          val.includes("Address")
        );
        latError.innerHTML = data["MESSAGE"].filter((val) =>
          val.includes("Latitude")
        );
        lonError.innerHTML = data["MESSAGE"].filter((val) =>
          val.includes("Longitude")
        );
        if (
          data["MESSAGE"].filter((val) => val.includes("Name")).length > 0
        ) {
          facName.style.border = "1px solid red";
        }
        if (data["MESSAGE"].filter((val) => val.includes("Address")).length > 0) {
          // console.log('here', data['MESSAGE'].filter(val => val.includes('MAC')))
          facAddress.style.border = "1px solid red";
        }
        if (
          data["MESSAGE"].filter((val) => val.includes("Latitude")).length > 0
        ) {
          // console.log('here', data['MESSAGE'].filter(val => val.includes('MAC')))
          facLatitude.style.border = "1px solid red";
        }
        if (
          data["MESSAGE"].filter((val) => val.includes("Longitude")).length > 0
        ) {
          // console.log('here', data['MESSAGE'].filter(val => val.includes('MAC')))
          facLongitude.style.border = "1px solid red";
        }
      }
    }
    if (data["CODE"] == 0) {
      facName.value = "";
      facAddress.value = "";
      facLatitude.value = "";
      facLongitude.value = "";
      facImgLink.value = "";
      document.querySelector("#register-close-btn").click();
      location.reload();
    }
  })
  .catch((error) => {
    console.error("Error:", error);
  });
}

async function registerNewUser() {
  userSubmitBtn.disabled = true;
  fullName.style.border = "1px solid #ced4da";
  userName.style.border = "1px solid #ced4da";
  email.style.border = "1px solid #ced4da";
  phNum.style.border = "1px solid #ced4da";
  userType.style.border = "1px solid #ced4da";
  fullNameError.innerHTML = "";
  usernameError.innerHTML = "";
  emailError.innerHTML = "";
  phNumError.innerHTML = "";
  userTypeError.innerHTML = "";
  // console.log(userType.value)
  RData = {
    DISPLAY_NAME: fullName.value,
    NEW_USER_NAME: userName.value,
    EMAIL: email.value,
    PHONE: phNum.value,
    USER_TYPE: userType.value,
    AUTH: 0,
  };
  Object.assign(RData, RequestData())
  // console.log(RData)
  await fetch(`${domain}API/?act=addUser`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(RData),
  })
    .then((response) => response.json())
    .then((data) => {
      // registerSubmitBtn.disabled = false
      // console.log(data)
      if (data["CODE"] == -1) {
        if (data["MESSAGE"].length > 0) {
          userSubmitBtn.disabled = false;
          fullNameError.innerHTML = data["MESSAGE"].filter((val) =>
            val.includes("Full")
          );
          usernameError.innerHTML = data["MESSAGE"].filter((val) =>
            val.includes("Login")
          );
          emailError.innerHTML = data["MESSAGE"].filter((val) =>
            val.includes("Email")
          );
          phNumError.innerHTML = data["MESSAGE"].filter((val) =>
            val.includes("Phone")
          );
          userTypeError.innerHTML = data["MESSAGE"].filter((val) =>
            val.includes("Type")
          );
          if (
            data["MESSAGE"].filter((val) => val.includes("Full")).length > 0
          ) {
            fullName.style.border = "1px solid red";
          }
          if (
            data["MESSAGE"].filter((val) => val.includes("Login")).length > 0
          ) {
            userName.style.border = "1px solid red";
          }
          if (
            data["MESSAGE"].filter((val) => val.includes("Email")).length > 0
          ) {
            email.style.border = "1px solid red";
          }
          if (
            data["MESSAGE"].filter((val) => val.includes("Phone")).length > 0
          ) {
            phNum.style.border = "1px solid red";
          }
          if (
            data["MESSAGE"].filter((val) => val.includes("Type")).length > 0
          ) {
            userType.style.border = "1px solid red";
          }
        }
      }
      if (data["CODE"] == 0) {
        userSubmitBtn.disabled = false;
        fullName.value = "";
        userName.value = "";
        email.value = "";
        phNum.value = "";
        userType.value = "User Type";
        document.querySelector("#register-user-btn").click();
      }
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}
