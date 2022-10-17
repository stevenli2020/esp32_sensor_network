// offcanvas
const offcanvasLogin = document.getElementById("offcanvas-login");
const offcanvasLogout = document.getElementById("offcanvas-logout");
const offcanvasHeader = document.getElementById("offcanvas-header");
// tabs
const homeTabFac = document.getElementById("home-tab");
const profileTabFac = document.getElementById("profile-tab");
const contactTabFac = document.getElementById("contact-tab");
// add location form
const addLocName = document.getElementById("add-loc-name");
const addLocFacName = document.getElementById("add-loc-fac-name");
const addLocFacNameSugg = document.getElementById("add-loc-fac-suggest");
const addLocSupervisor = document.getElementById("add-loc-supervisor");
const addLocSupervisorSugg = document.getElementById(
  "add-loc-supervisor-suggest"
);
const addLocCleaner = document.getElementById("add-loc-cleaner");
const addLocCleanerSugg = document.getElementById("add-loc-cleaner-suggest");
const addLocImgLink = document.getElementById("add-loc-image-link");
const addLocNameError = document.getElementById("addLocNameError");
const addLocFacNameError = document.getElementById("addLocFacNameError");
const addLocSupervisorError = document.getElementById("addLocSupervisorError");
const addLocCleanerError = document.getElementById("addLocCleanerError");
const addLocImgLinkError = document.getElementById("addLocImgLinkError");
// update location form
const updateLocForm = document.getElementById("updateLocationForm");
const updateLocXBtn = document.getElementById("update-loc-X-btn");
const updateLocName = document.getElementById("update-loc-name");
const updateLocNameError = document.getElementById("updateLocNameError");
const updateLocFacName = document.getElementById("update-loc-fac-name");
const updateLocFacNameSugg = document.getElementById(
  "update-loc-fac-name-suggest"
);
const updateLocFacNameError = document.getElementById("updateLocFacNameError");
const updateLocSupervisor = document.getElementById("update-loc-supervisor");
const updateLocSupervisorSugg = document.getElementById(
  "update-loc-supervisor-suggest"
);
const updateLocSupervisorError = document.getElementById(
  "updateLocSupervisorError"
);
const updateLocCleaner = document.getElementById("update-loc-cleaner");
const updateLocCleanerSugg = document.getElementById(
  "update-loc-cleaner-suggest"
);
const updateLocClanerError = document.getElementById("updateLocClanerError");
const updateLocImgLink = document.getElementById("update-loc-image-link");
const updateLocImgLinkError = document.getElementById("updateLocImgLinkError");
const updateLocCloseBtn = document.getElementById("update-loc-close-btn");
const updateLocSubmitBtn = document.getElementById("update-loc-submit-btn");
// delete location form
const delLocForm = document.getElementById("deleteLocationForm");
const delLocXBtn = document.getElementById("delete-loc-x-btn");
const deleteLocationFormBody = document.getElementById(
  "deleteLocationFormBody"
);
const delLocClostBtn = document.getElementById("delete-loc-close-btn");
const delLocSubmitBtn = document.getElementById("delete-loc-submit-btn");
// alert modal
const facAlertModal = document.getElementById("fac-alert-modal");
const facAlertXBtn = document.getElementById("fac-alert-X-btn");
const facAlertCloseBtn = document.getElementById("fac-alert-close-btn");
const facAlertModalBody = document.getElementById("fac-alert-modal-body");
const facAlertModalFooter = document.getElementById("fac-alert-modal-footer");
// get current page
const curPage = window.location.href.split("=")[1].replaceAll("%20", " ");
// console.log(curPage);

removeChildEl("locations-list");
offcanvasChildElRemove("offcanvasEl");
offcanvasHomeliCreate("offcanvasEl", "Home");
offcanvasHomeliCreate("offcanvasEl", "Dash Board");
TYPE = getCookie("TYPE");
UNAME = getCookie("USERNAME");
if (checkLogin()) {
  //   console.log(TYPE, typeof(TYPE), TYPE != 0)
  if (TYPE != 0) {
    offcanvasliCreate(
      "offcanvasEl",
      "li",
      "a",
      "nav-item",
      "nav-link",
      "addLocation",
      "addLocationFormModal",
      "button",
      "addLocation",
      "modal",
      "#addLocationForm",
      '<i class="fa-solid fa-restroom"></i> Add New Location'
    );
    document.getElementById("addLocation").addEventListener("click", () => {
      document.querySelector("#Close-button").click();
    });
  }

  
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
  location.href = loginPage;
}

let reqD = {
  FACILITY_NAME: curPage,
  TIME: "DAY",
  SENSOR_TYPE: air,
};
Object.assign(reqD, RequestData());
fetch(`${domain}API/?act=getFacilityEventData`, {
  method: "POST",
  headers: {
    "Content-Type": "application/json",
  },
  body: JSON.stringify(reqD),
})
  .then((response) => response.json())
  .then((data) => {
    let xLabel = [];
    let lineD = [];
    data.DATA?.forEach((air) => {
      xLabel.push(air["TIME"].slice(11, 16));
      lineD.push(Math.round(air["AVG(EVENTS.SENSOR_DATA)"]));
    });
    updateDottedBar(
      xLabel,
      "Average Air Quality in 30 mins",
      lineD,
      8,
      "Average Air Quality in 30 mins"
    );
  })
  .catch((error) => console.log(error));

let rData = {
  FACILITY_NAME: curPage,
};
Object.assign(rData, RequestData());
fetch(`${domain}API/?act=getLocations`, {
  method: "POST",
  headers: {
    "Content-Type": "application/json",
  },
  body: JSON.stringify(rData),
})
  .then((response) => response.json())
  .then((data) => {
    // console.log(data)
    if (data.CODE == 0) {
      removeChildEl("locations-list");
      data.DATA.forEach((fac) => {
        createFacilitiesList(
          "locations-list",
          fac.LOCATION_UID,
          fac.LOCATION_UID,
          fac.LOCATION_IMG_LINK,
          fac.LOCATION_NAME
        );
      });
    }
    if (data.CODE == -1) {
      // alert(data.MESSAGE)
      // window.location.href = dashBoardPage
    }
  })
  .catch((error) => console.log(error));

fetch(`${domain}API/?act=getFacilityAlertsData`, {
  method: "POST",
  headers: {
    "Content-Type": "application/json",
  },
  body: JSON.stringify(rData),
})
  .then((response) => response.json())
  .then((data) => {
    // console.log(data);
    if (data.CODE == 0) {
      data.DATA.forEach((alert) => {
        msg = alert.MESSAGE.replaceAll("%20", "").split("at");
        // console.log(msg)
        var loc, category, status, action;
        if (msg.length > 2) {
          msg = msg[msg.length - 1];
        } else {
          msg = msg[1];
        }
        if (msg.includes("traffic")) {
          loc = msg.split("traffic")[0];
          category = "Traffic Counter";
        } else {
          loc = msg.split("air-quality")[0];
          category = "Air Quality";
        }
        if (alert.STATUS == 0) {
          status =
            '<span style="color: #fcba03;"><i class="fa-solid fa-arrow-trend-up"></i></span> In Progress';
          action =
            '<span style="color: #fcba03;"><i class="fa-solid fa-square-pen"></i></span> Update';
        } else if (alert.STATUS == 1) {
          action =
            '<span style="color: green;"><i class="fa-solid fa-circle-check"></i></span> Updated';
          status =
            '<span style="color: green;"><i class="fa-solid fa-circle-check"></i></span> Acknowledge';
        }
        newRow = $(
          "<tr onclick=clickedRow("+alert.ID+") style='cursor: pointer;'><td>" +
            alert.ID +
            "</td><td>" +
            alert.TIME +
            "</td><td>" +
            loc +
            "</td><td>" +
            category +
            "</td><td>" +
            status +
            "</td><td>" +
            action +
            "</td></tr>"
        );
        $("#fac-fault-table tbody").append(newRow);
      });
    }
    if (data.CODE == -1) {
    }
  })
  .catch((error) => console.log(error));

function clickedRow(id){
  // console.log(id)  
  rData = {
    ID: id,
  };
  Object.assign(rData, RequestData());
  fetch(`${domain}API/?act=getAlert`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(rData),
  })
    .then((response) => response.json())
    .then((data) => {
      // console.log(data)
      if (data.CODE == 0) {
        facAlertModal.classList.add('fade')
        facAlertModal.classList.add('show')
        facAlertModal.style = "display: block;"
        if(checkEl('fac-alert-modal-footer-childBtn')){
          removeEl('fac-alert-modal-footer-childBtn')
        }
        removeChildEl('fac-alert-modal-body')
        data.DATA.forEach(al => {
          // console.log(al)
          var pId = document.createElement('p')
          var pTime = document.createElement('p')
          var pMessage = document.createElement('p')
          var pNotiUsers = document.createElement('p')
          var pStatus = document.createElement('p')
          pId.innerHTML = "<strong>ID:</strong> "+al.ID
          pTime.innerHTML = "<strong>Time:</strong> "+al.TIME
          pMessage.innerHTML = "<strong>Alert Message:</strong> "+al.MESSAGE
          // user = al.NOTIFIED_USERS.replaceAll(/\"\[\]/g, "")
          user = al.NOTIFIED_USERS.replaceAll('"', "")
          user = user.replaceAll('[','')
          user = user.replaceAll(']','')
          if(user.includes(',')) user = user.split(',')
          pNotiUsers.innerHTML = "<strong>Notified Users:</strong> "+user.map(u => `<button class="btn btn-outline-primary" disabled>${u}</button>`)
          if(al.STATUS == 0) pStatus.innerHTML = "<strong>Status:</strong> In Progress"
          else pStatus.innerHTML = `<strong>Acknowledged by</strong> <button class="btn btn-outline-primary" disabled>${al.ACK_USER}</button>`
          facAlertModalBody.appendChild(pId)
          facAlertModalBody.appendChild(pTime)
          facAlertModalBody.appendChild(pMessage)
          facAlertModalBody.appendChild(pNotiUsers)
          facAlertModalBody.appendChild(pStatus)
          if(user.includes(UNAME) && al.STATUS == 0){
            // console.log(UNAME)
            var btn = document.createElement('button')
            btn.setAttribute('type', 'button')
            btn.setAttribute('class', 'btn btn-primary')
            btn.setAttribute('onclick', `facAck(${al.ID})`)
            btn.setAttribute('id', 'fac-alert-modal-footer-childBtn')
            btn.innerText = "Acknowledge"
            facAlertModalFooter.appendChild(btn)
          }
        })
      }
      if (data.CODE == -1) {
        alert(data.MESSAGE)
        // window.location.href = dashBoardPage
      }
    })
    .catch((error) => console.log(error));
}

function facAck(id){
  // console.log(id)
  rData = {
    ID: id,
    LOGIN_NAME: UNAME
  };
  Object.assign(rData, RequestData());
  fetch(`${domain}API/?act=updateAlert`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(rData),
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(data)
      if (data.CODE == 0) {
        document.querySelector('#fac-alert-close-btn').click()
        location.reload()
      }
      if (data.CODE == -1) {
        alert(data.MESSAGE)
        // window.location.href = dashBoardPage
      }
    })
    .catch((error) => console.log(error));
}

facAlertCloseBtn.addEventListener('click', e => {
  facAlertModal.classList.remove('fade')
  facAlertModal.classList.remove('show')
  facAlertModal.style = "display: none;"
})

facAlertXBtn.addEventListener('click', e => {
  facAlertModal.classList.remove('fade')
  facAlertModal.classList.remove('show')
  facAlertModal.style = "display: none;"
})

window.addEventListener("click", (e) => {
  // console.log(e);
  // if(TYPE != 0){
  if (e.path[0].id == "fac-image" || e.path[0].id == "fac-list") {
    window.location.href = `${nodePage}?name=${e.target.innerText}&${e.path[2].id}`;
  }
  if (e.path[2].id == "fac-list") {
    window.location.href = `${nodePage}?name=${e.target.innerText}&${e.path[4].id}`;
  }
  // } else {

  // }
});

function chartTimeSelect(timeSelect) {
  type = air;
  legendName = "";
  lineS = 10;
  dottedBar.showLoading();
  if (homeTabFac.classList.contains("active")) {
    type = air;
    legendName = "Average Air Quality in";
    if (timeSelect == "HOUR") legendName = `${legendName} 5 mins`;
    else if (timeSelect == "DAY") {
      legendName = `${legendName} 30 mins`;
      if (window.innerWidth < 500) lineS = 6;
    } else if (timeSelect == "WEEK") legendName = `${legendName} 6 hours`;
    else {
      legendName = `${legendName} 1 day`;
      if (window.innerWidth < 500) lineS = 8;
    }
  } else if (profileTabFac.classList.contains("active")) {
    type = motion;
    legendName = "Total Detection in";
    if (timeSelect == "HOUR") legendName = `${legendName} 5 mins`;
    else if (timeSelect == "DAY") {
      legendName = `${legendName} 30 mins`;
      if (window.innerWidth < 500) lineS = 6;
    } else if (timeSelect == "WEEK") legendName = `${legendName} 6 hours`;
    else {
      legendName = `${legendName} 1 day`;
      if (window.innerWidth < 500) lineS = 8;
    }
  } else if (contactTabFac.classList.contains("active")) {
    type = distance;
    legendName = "Average Fill Level in";
    if (timeSelect == "HOUR") legendName = `${legendName} 5 mins`;
    else if (timeSelect == "DAY") {
      legendName = `${legendName} 30 mins`;
      if (window.innerWidth < 500) lineS = 6;
    } else if (timeSelect == "WEEK") legendName = `${legendName} 6 hours`;
    else {
      legendName = `${legendName} 1 day`;
      if (window.innerWidth < 500) lineS = 8;
    }
  }
  RData = {
    FACILITY_NAME: curPage,
    TIME: timeSelect,
    SENSOR_TYPE: type,
  };
  Object.assign(RData, RequestData());
  fetch(`${domain}API/?act=getFacilityEventData`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(RData),
  })
    .then((response) => response.json())
    .then((data) => {
      // console.log(data);
      let xLabel = [];
      let lineD = [];
      if (type == air || type == distance) {
        data.DATA?.forEach((air) => {
          if (timeSelect == "HOUR" || timeSelect == "DAY")
            xLabel.push(air["TIME"].slice(11, 16));
          else if (timeSelect == "WEEK") xLabel.push(air["TIME"].slice(5, 16));
          else xLabel.push(air["TIME"].slice(5, 10));
          lineD.push(Math.round(air["AVG(EVENTS.SENSOR_DATA)"]));
        });
      } else {
        data.DATA?.forEach((motion) => {
          if (timeSelect == "HOUR" || timeSelect == "DAY")
            xLabel.push(motion["TIME"].slice(11, 16));
          else if (timeSelect == "WEEK")
            xLabel.push(motion["TIME"].slice(5, 16));
          else xLabel.push(motion["TIME"].slice(5, 10));
          lineD.push(motion["SUM(EVENTS.SENSOR_DATA)"]);
        });
      }
      dottedBar.hideLoading();
      updateDottedBar(xLabel, legendName, lineD, lineS, legendName);
    })
    .catch((error) => console.log(error));
}

async function locUpdate(locName, locUID) {
  // console.log(locName, locUID)
  updateLocName.value = "";
  updateLocFacName.value = "";
  updateLocSupervisor.value = "";
  updateLocCleaner.value = "";
  updateLocImgLink.value = "";
  updateLocFacName.setAttribute("uid", "");
  updateLocSupervisor.setAttribute("uid", "");
  updateLocCleaner.setAttribute("uid", "");
  updateLocSubmitBtn.setAttribute("uid", "");
  updateLocCloseBtn.addEventListener("click", (e) => {
    updateLocForm.classList.remove("show");
    updateLocForm.setAttribute("style", "display: none;");
    updateLocForm.removeAttribute("aria-modal");
    updateLocForm.removeAttribute("role");
    updateLocForm.setAttribute("aria-hidden", "true");
  });
  updateLocXBtn.addEventListener("click", (e) => {
    updateLocForm.classList.remove("show");
    updateLocForm.setAttribute("style", "display: none;");
    updateLocForm.removeAttribute("aria-modal");
    updateLocForm.removeAttribute("role");
    updateLocForm.setAttribute("aria-hidden", "true");
  });
  updateLocForm.setAttribute("class", "modal fade show");
  updateLocForm.setAttribute("style", "display: block;");
  updateLocForm.setAttribute("aria-modal", "true");
  updateLocForm.setAttribute("role", "dialog");
  updateLocForm.removeAttribute("aria-hidden");
  RData = {
    LOCATION_UID: locUID,
  };
  Object.assign(RData, RequestData());
  await fetch(`${domain}API/?act=getLocations`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(RData),
  })
    .then((response) => response.json())
    .then((data) => {
      // console.log(data)
      if (data.CODE == 0) {
        updateLocName.style.border = oriBorder;
        updateLocNameError.innerHTML = "";
        updateLocName.value = data.DATA[0].LOCATION_NAME;
        updateLocFacName.value = data.DATA[0].FACILITY;
        updateLocFacName.setAttribute("uid", data.DATA[0].FACILITY_UID);
        updateLocSupervisor.value = data.DATA[0].SUPERVISOR;
        updateLocSupervisor.setAttribute("uid", data.DATA[0].SUPERVISOR_UID);
        updateLocCleaner.value = data.DATA[0].CLEANER;
        updateLocCleaner.setAttribute("uid", data.DATA[0].CLEANER_UID);
        updateLocImgLink.value = data.DATA[0].LOCATION_IMG_LINK;
        updateLocSubmitBtn.setAttribute("uid", data.DATA[0].LOCATION_UID);
        // updateLocName.setAttribute('oriName', fname);
      } else {
        updateLocName.style.border = redBorder;
        updateLocNameError.innerHTML = "Location Name Not Found";
      }
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

async function locDelete(locName, locUID) {
  // console.log(locName, locUID)
  delLocClostBtn.addEventListener("click", (e) => {
    delLocForm.classList.remove("show");
    delLocForm.setAttribute("style", "display: none;");
    delLocForm.removeAttribute("aria-modal");
    delLocForm.removeAttribute("role");
    delLocForm.setAttribute("aria-hidden", "true");
  });
  delLocXBtn.addEventListener("click", (e) => {
    delLocForm.classList.remove("show");
    delLocForm.setAttribute("style", "display: none;");
    delLocForm.removeAttribute("aria-modal");
    delLocForm.removeAttribute("role");
    delLocForm.setAttribute("aria-hidden", "true");
  });
  delLocForm.setAttribute("class", "modal fade show");
  delLocForm.setAttribute("style", "display: block;");
  delLocForm.setAttribute("aria-modal", "true");
  delLocForm.setAttribute("role", "dialog");
  delLocForm.removeAttribute("aria-hidden");
  deleteLocationFormBody.innerHTML = `Are you sure, you want to delete <strong>${locName}</strong> Location?`;
  delLocSubmitBtn.setAttribute("uid", locUID);
}

async function updateLocation() {
  updateLocName.style.border = oriBorder;
  updateLocFacName.style.border = oriBorder;
  updateLocSupervisor.style.border = oriBorder;
  updateLocCleaner.style.border = oriBorder;
  updateLocNameError.innerHTML = "";
  updateLocFacNameError.innerHTML = "";
  updateLocSupervisorError.innerHTML = "";
  updateLocClanerError.innerHTML = "";
  let RData = {
    LOCATION_NAME: updateLocName.value,
    FACILITY_UID: updateLocFacName.getAttribute("uid"),
    SUPERVISOR_UID: updateLocSupervisor.getAttribute("uid"),
    CLEANER_UID: updateLocCleaner.getAttribute("uid"),
    LOCATION_IMG_LINK: updateLocImgLink.value,
    LOCATION_UID: updateLocSubmitBtn.getAttribute("uid"),
  };
  Object.assign(RData, RequestData());
  await fetch(`${domain}API/?act=updateLocation`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(RData),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.CODE == 0) {
        document.querySelector("#update-loc-close-btn").click();
        location.reload();
      }
      if (data.CODE == -1) {
        if (data.MESSAGE.length > 0) {
          updateLocNameError.innerHTML = data.MESSAGE.filter((val) =>
            val.includes("Location")
          );
          updateLocFacNameError.innerHTML = data.MESSAGE.filter((val) =>
            val.includes("Facility")
          );
          updateLocSupervisorError.innerHTML = data.MESSAGE.filter((val) =>
            val.includes("Supervisor")
          );
          updateLocClanerError.innerHTML = data.MESSAGE.filter((val) =>
            val.includes("Cleaner")
          );
          if (data.MESSAGE.filter((val) => val.includes("Location")).length > 0)
            updateLocName.style.border = redBorder;
          if (data.MESSAGE.filter((val) => val.includes("Facility")).length > 0)
            updateLocFacName.style.border = redBorder;
          if (
            data.MESSAGE.filter((val) => val.includes("Supervisor")).length > 0
          )
            updateLocSupervisor.style.border = redBorder;
          if (data.MESSAGE.filter((val) => val.includes("Cleaner")).length > 0)
            updateLocCleaner.style.border = redBorder;
        }
      }
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

async function deleteLocation() {
  // console.log(delLocSubmitBtn.getAttribute('uid'))
  RData = {
    LOCATION_UID: delLocSubmitBtn.getAttribute("uid"),
  };
  Object.assign(RData, RequestData());
  await fetch(`${domain}API/?act=removeLocation`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(RData),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.CODE == 0) {
        document.querySelector("#delete-loc-close-btn").click();
        location.reload();
      } else {
        alert("Can't delete Location");
      }
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

homeTabFac.addEventListener("click", (e) => {
  dottedBar.showLoading();
  reqD = {
    FACILITY_NAME: curPage,
    TIME: "DAY",
    SENSOR_TYPE: air,
  };
  Object.assign(reqD, RequestData());
  fetch(`${domain}API/?act=getFacilityEventData`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(reqD),
  })
    .then((response) => response.json())
    .then((data) => {
      let xLabel = [];
      let lineD = [];
      data.DATA?.forEach((air) => {
        xLabel.push(air["TIME"].slice(11, 16));
        lineD.push(Math.round(air["AVG(EVENTS.SENSOR_DATA)"]));
      });
      dottedBar.hideLoading();
      updateDottedBar(
        xLabel,
        "Average Air Quality in 30 mins",
        lineD,
        8,
        "Average Air Quality in 30 mins"
      );
    })
    .catch((error) => console.log(error));
});

profileTabFac.addEventListener("click", (e) => {
  dottedBar.showLoading();
  reqD = {
    FACILITY_NAME: curPage,
    TIME: "DAY",
    SENSOR_TYPE: motion,
  };
  Object.assign(reqD, RequestData());
  fetch(`${domain}API/?act=getFacilityEventData`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(reqD),
  })
    .then((response) => response.json())
    .then((data) => {
      let xLabel = [];
      let lineD = [];
      data.DATA?.forEach((motion) => {
        xLabel.push(motion["TIME"].slice(11, 16));
        lineD.push(Math.round(motion["SUM(EVENTS.SENSOR_DATA)"]));
      });
      dottedBar.hideLoading();
      updateDottedBar(
        xLabel,
        "Total Detection in 30 mins",
        lineD,
        8,
        "Total Detection in 30 mins"
      );
    })
    .catch((error) => console.log(error));
});

contactTabFac.addEventListener("click", (e) => {
  dottedBar.showLoading();
  reqD = {
    FACILITY_NAME: curPage,
    TIME: "DAY",
    SENSOR_TYPE: distance,
  };
  Object.assign(reqD, RequestData());
  fetch(`${domain}API/?act=getFacilityEventData`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(reqD),
  })
    .then((response) => response.json())
    .then((data) => {
      let xLabel = [];
      let lineD = [];
      data.DATA?.forEach((distance) => {
        xLabel.push(distance["TIME"].slice(11, 16));
        lineD.push(Math.round(distance["AVG(EVENTS.SENSOR_DATA)"]));
      });
      dottedBar.hideLoading();
      updateDottedBar(
        xLabel,
        "Average Trash Fill Level in 30 mins",
        lineD,
        8,
        "Average Trash Fill Level in 30 mins"
      );
    })
    .catch((error) => console.log(error));
});

addLocImgLink.addEventListener("input", (e) => {
  if (e.target.value != "") {
    if (isImage(e.target.value)) {
      addLocImgLink.style.border = oriBorder;
      addLocImgLinkError.innerHTML = "";
    } else {
      addLocImgLink.style.border = redBorder;
      addLocImgLinkError.innerHTML = "URL is not an image";
    }
  } else {
    addLocImgLink.style.border = oriBorder;
    addLocImgLinkError.innerHTML = "";
  }
});

updateLocImgLink.addEventListener("input", (e) => {
  if (e.target.value != "") {
    if (isImage(e.target.value)) {
      updateLocImgLink.style.border = oriBorder;
      updateLocImgLinkError.innerHTML = "";
    } else {
      updateLocImgLink.style.border = redBorder;
      updateLocImgLinkError.innerHTML = "URL is not an image";
    }
  } else {
    updateLocImgLink.style.border = oriBorder;
    updateLocImgLinkError.innerHTML = "";
  }
});

async function addLocation() {
  RData = {
    LOCATION_NAME: addLocName.value,
    FACILITY_UID: addLocFacName.getAttribute("uid"),
    SUPERVISOR_UID: addLocSupervisor.getAttribute("uid"),
    CLEANER_UID: addLocCleaner.getAttribute("uid"),
    LOCATION_IMG_LINK: addLocImgLink.value,
  };
  addLocNameError.innerHTML = "";
  addLocName.style.border = oriBorder;
  addLocFacNameError.innerHTML = "";
  addLocFacName.style.border = oriBorder;
  Object.assign(RData, RequestData());
  fetch(`${domain}API/?act=addLocation`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(RData),
  })
    .then((response) => response.json())
    .then((data) => {
      // console.log(data);
      if (data.CODE == -1) {
        addLocNameError.innerHTML = data["MESSAGE"].filter((val) =>
          val.includes("Location")
        );
        if (
          data["MESSAGE"].filter((val) => val.includes("Location")).length > 0
        ) {
          addLocName.style.border = redBorder;
        }
        addLocFacNameError.innerHTML = data["MESSAGE"].filter((val) =>
          val.includes("Facility")
        );
        if (
          data["MESSAGE"].filter((val) => val.includes("Facility")).length > 0
        ) {
          addLocFacName.style.border = redBorder;
        }
      }
      if (data.CODE == 0) {
        addLocName.value = "";
        addLocFacName.value = "";
        addLocSupervisor.value = "";
        addLocCleaner.value = "";
        addLocImgLink.value = "";
        location.reload();
      }
    })
    .catch((error) => console.log(error));
}

updateLocSupervisor.addEventListener("input", (e) => {
  if (e.target.value != "") {
    updateLocSupervisor.setAttribute("uid", "");
    RData = {
      VALUE: e.target.value,
    };
    Object.assign(RData, RequestData());
    fetch(`${domain}API/?act=getUserSuggestion`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(RData),
    })
      .then((response) => response.json())
      .then((data) => {
        removeChildEl("update-loc-supervisor-suggest");
        console.log(data);
        if (data["CODE"] == 0) {
          data["DATA"].forEach((fac) => {
            b = document.createElement("DIV");
            b.innerHTML = fac.LOGIN_NAME;
            b.addEventListener("click", function (e) {
              if (e.target.nodeName == "DIV") {
                removeChildEl("update-loc-supervisor-suggest");
                updateLocSupervisor.value = e.target.innerHTML;
                updateLocSupervisor.setAttribute("uid", fac.CODE);
                updateLocSupervisor.style.border = oriBorder;
                updateLocSupervisorError.innerHTML = "";
              }
            });
            updateLocSupervisorSugg.appendChild(b);
          });
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  } else {
    removeChildEl("update-loc-supervisor-suggest");
  }
});

addLocSupervisor.addEventListener("input", (e) => {
  if (e.target.value != "") {
    addLocSupervisor.setAttribute("uid", "");
    RData = {
      VALUE: e.target.value,
    };
    Object.assign(RData, RequestData());
    fetch(`${domain}API/?act=getUserSuggestion`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(RData),
    })
      .then((response) => response.json())
      .then((data) => {
        removeChildEl("add-loc-supervisor-suggest");
        // console.log(data);
        if (data["CODE"] == 0) {
          data["DATA"].forEach((fac) => {
            b = document.createElement("DIV");
            b.innerHTML = fac.LOGIN_NAME;
            b.addEventListener("click", function (e) {
              if (e.target.nodeName == "DIV") {
                removeChildEl("add-loc-supervisor-suggest");
                addLocSupervisor.value = e.target.innerHTML;
                addLocSupervisor.setAttribute("uid", fac.CODE);
              }
            });
            addLocSupervisorSugg.appendChild(b);
          });
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  } else {
    removeChildEl("add-loc-supervisor-suggest");
  }
});

updateLocCleaner.addEventListener("input", (e) => {
  if (e.target.value != "") {
    updateLocCleaner.setAttribute("uid", "");
    RData = {
      VALUE: e.target.value,
    };
    Object.assign(RData, RequestData());
    fetch(`${domain}API/?act=getUserSuggestion`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(RData),
    })
      .then((response) => response.json())
      .then((data) => {
        removeChildEl("update-loc-cleaner-suggest");
        // console.log(data);
        if (data["CODE"] == 0) {
          data["DATA"].forEach((fac) => {
            b = document.createElement("DIV");
            b.innerHTML = fac.LOGIN_NAME;
            b.addEventListener("click", function (e) {
              if (e.target.nodeName == "DIV") {
                removeChildEl("update-loc-cleaner-suggest");
                updateLocCleaner.value = e.target.innerHTML;
                updateLocCleaner.setAttribute("uid", fac.CODE);
                updateLocCleaner.style.border = oriBorder;
                updateLocClanerError.innerHTML = "";
              }
            });
            updateLocCleanerSugg.appendChild(b);
          });
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  } else {
    removeChildEl("update-loc-cleaner-suggest");
  }
});

addLocCleaner.addEventListener("input", (e) => {
  if (e.target.value != "") {
    addLocCleaner.setAttribute("uid", "");
    RData = {
      VALUE: e.target.value,
    };
    Object.assign(RData, RequestData());
    fetch(`${domain}API/?act=getUserSuggestion`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(RData),
    })
      .then((response) => response.json())
      .then((data) => {
        removeChildEl("add-loc-cleaner-suggest");
        // console.log(data);
        if (data["CODE"] == 0) {
          data["DATA"].forEach((fac) => {
            b = document.createElement("DIV");
            b.innerHTML = fac.LOGIN_NAME;
            b.addEventListener("click", function (e) {
              if (e.target.nodeName == "DIV") {
                removeChildEl("add-loc-cleaner-suggest");
                addLocCleaner.value = e.target.innerHTML;
                addLocCleaner.setAttribute("uid", fac.CODE);
              }
            });
            addLocCleanerSugg.appendChild(b);
          });
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  } else {
    removeChildEl("add-loc-cleaner-suggest");
  }
});

updateLocFacName.addEventListener("input", (e) => {
  if (e.target.value != "") {
    updateLocFacName.setAttribute("uid", "");
    RData = {
      VALUE: e.target.value,
    };
    Object.assign(RData, RequestData());
    fetch(`${domain}API/?act=getFacilitySuggestion`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(RData),
    })
      .then((response) => response.json())
      .then((data) => {
        removeChildEl("update-loc-fac-name-suggest");
        console.log(data);
        if (data["CODE"] == 0) {
          data["DATA"].forEach((fac) => {
            b = document.createElement("DIV");
            b.innerHTML = fac.NAME;
            b.addEventListener("click", function (e) {
              if (e.target.nodeName == "DIV") {
                removeChildEl("update-loc-fac-name-suggest");
                updateLocFacName.value = e.target.innerHTML;
                updateLocFacName.setAttribute("uid", fac.UID);
                updateLocFacName.style.border = oriBorder;
                updateLocFacNameError.innerHTML = "";
              }
            });
            updateLocFacNameSugg.appendChild(b);
          });
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  } else {
    removeChildEl("update-loc-fac-name-suggest");
  }
});

addLocFacName.addEventListener("input", (e) => {
  if (e.target.value != "") {
    addLocFacName.setAttribute("uid", "");
    RData = {
      VALUE: e.target.value,
    };
    Object.assign(RData, RequestData());
    fetch(`${domain}API/?act=getFacilitySuggestion`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(RData),
    })
      .then((response) => response.json())
      .then((data) => {
        removeChildEl("add-loc-fac-suggest");
        // console.log(data);
        if (data["CODE"] == 0) {
          data["DATA"].forEach((fac) => {
            b = document.createElement("DIV");
            b.innerHTML = fac.NAME;
            b.addEventListener("click", function (e) {
              if (e.target.nodeName == "DIV") {
                removeChildEl("add-loc-fac-suggest");
                addLocFacName.value = e.target.innerHTML;
                addLocFacName.setAttribute("uid", fac.UID);
              }
            });
            addLocFacNameSugg.appendChild(b);
          });
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  } else {
    removeChildEl("add-loc-fac-suggest");
  }
});
