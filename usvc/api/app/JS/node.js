// offcanvas
const offcanvasLogin = document.getElementById("offcanvas-login");
const offcanvasLogout = document.getElementById("offcanvas-logout");
const offcanvasHeader = document.getElementById("offcanvas-header");
// tabs
const homeTabFac = document.getElementById("home-tab");
const profileTabFac = document.getElementById("profile-tab");
const contactTabFac = document.getElementById("contact-tab");
// add node form
const addSensorForm = document.getElementById("addSensorForm");
const addSensorName = document.getElementById("add-sensor-name");
const addSensorNameError = document.getElementById("addSensorNameError");
const addSensorXBtn = document.getElementById("add-sensor-X-btn");
const addSensorFacName = document.getElementById("add-sensor-fac-name");
const addSensorFacSugg = document.getElementById("add-sensor-fac-suggest");
const addSensorFacNameError = document.getElementById("addSensorFacNameError");
const addSensorLocName = document.getElementById("add-sensor-loc-name");
const addSensorLocSugg = document.getElementById("add-sensor-loc-suggest");
const addSensorLocNameError = document.getElementById("addSensorLocNameError");
const addSensorMAC = document.getElementById("add-sensor-mac");
const addSensorMACSugg = document.getElementById("add-sensor-mac-suggest");
const addSensorMACError = document.getElementById("addSensorMACError");
const addSensorType = document.getElementById("add-sensor-type");
const addSensorTypeError = document.getElementById("addSensorTypeError");
const addSensorCloseBtn = document.getElementById("add-sensor-close-btn");
const addSensorSubmitBtn = document.getElementById("add-sensor-submit-btn");
const addSensorAlertVal = document.getElementById("add-sensor-alert-value");
// update node form
const updateSensorForm = document.getElementById("updateSensorForm");
const updateSensorName = document.getElementById("update-sensor-name");
const updateSensorNameError = document.getElementById("updateSensorNameError");
const updateSensorXBtn = document.getElementById("update-sensor-X-btn");
const updateSensorFacName = document.getElementById("update-sensor-fac-name");
const updateSensorFacSugg = document.getElementById(
  "update-sensor-fac-suggest"
);
const updateSensorFacNameError = document.getElementById(
  "updateSensorFacNameError"
);
const updateSensorLocName = document.getElementById("update-sensor-loc-name");
const updateSensorLocSugg = document.getElementById(
  "update-sensor-loc-suggest"
);
const updateSensorLocNameError = document.getElementById(
  "updateSensorLocNameError"
);
const updateSensorMAC = document.getElementById("update-sensor-mac");
const updateSensorMACSugg = document.getElementById(
  "update-sensor-mac-suggest"
);
const updateSensorMACError = document.getElementById("updateSensorMACError");
const updateSensorType = document.getElementById("update-sensor-type");
const updateSensorTypeError = document.getElementById("updateSensorTypeError");
const updateSensorCloseBtn = document.getElementById("update-sensor-close-btn");
const updateSensorSubmitBtn = document.getElementById(
  "update-sensor-submit-btn"
);
const updateSensorAlertVal = document.getElementById(
  "update-sensor-alert-value"
);
// delete node form
const delSensorForm = document.getElementById("deleteSensorForm");
const delSensorXBtn = document.getElementById("delete-sensor-x-btn");
const deleteSensorFormBody = document.getElementById("deleteSensorFormBody");
const delSensorCloseBtn = document.getElementById("delete-sensor-close-btn");
const delSensorSubmitBtn = document.getElementById("delete-sensor-submit-btn");
// alert modal
const nodeAlertModal = document.getElementById("node-alert-modal");
const nodeAlertXBtn = document.getElementById("node-alert-X-btn");
const nodeAlertCloseBtn = document.getElementById("node-alert-close-btn");
const nodeAlertModalBody = document.getElementById("node-alert-modal-body");
const nodeAlertModalFooter = document.getElementById("node-alert-modal-footer");

// get current page
var curPage = window.location.href.split("=")[1].replaceAll("%20", " ");
curPage = curPage.split("&");
// console.log(curPage)

removeChildEl("locations-list");
offcanvasChildElRemove("offcanvasEl");
offcanvasHomeliCreate("offcanvasEl", "Home");
offcanvasHomeliCreate("offcanvasEl", "Dash Board");
UNAME = getCookie("USERNAME");
if (checkLogin()) {
  TYPE = getCookie("TYPE");
  //   console.log(TYPE, typeof(TYPE), TYPE != 0)
  if (TYPE != 0) {
    offcanvasliCreate(
      "offcanvasEl",
      "li",
      "a",
      "nav-item",
      "nav-link",
      "addSensor",
      "addSensorFormModal",
      "button",
      "addSensor",
      "modal",
      "#addSensorForm",
      '<i class="fa-solid fa-microchip"></i> Add New Sensor'
    );
    document.getElementById("addSensor").addEventListener("click", () => {
      document.querySelector("#Close-button").click();
    });
  }
  // offcanvasliCreate(
  //   "offcanvasEl",
  //   "li",
  //   "a",
  //   "nav-item dropdown",
  //   "nav-link dropdown-toggle",
  //   curPage[0],
  //   "offcanvasNavbarDropdown",
  //   "button",
  //   null,
  //   "dropdown",
  //   null,
  //   `<i class="fa-solid fa-chart-column"></i> ${curPage[0]}`
  // );

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
  LOCATION_ID: curPage[1],
  TIME: "DAY",
  SENSOR_TYPE: air,
};
Object.assign(reqD, RequestData());
fetch(`${domain}API/?act=getLocationEventData`, {
  method: "POST",
  headers: {
    "Content-Type": "application/json",
  },
  body: JSON.stringify(reqD),
})
  .then((response) => response.json())
  .then((data) => {
    // console.log(data);
    let xLabel = [];
    let lineD = [];
    // let barDtemp = [];
    // let barDT = [];
    // let barD = [];
    // let dotD = [];
    data.DATA?.forEach((air) => {
      xLabel.push(air["TIME"].slice(11, 16));
      lineD.push(Math.round(air["AVG(EVENTS.SENSOR_DATA)"]));
    });
    // data.DATA[1]?.MOTION.forEach((motion) => {
    //   barDtemp.push(motion["SUM(EVENTS.SENSOR_DATA)"]);
    // });
    // if (data.DATA.length < 3) {
    //   for (i = 0; i < xLabel.length; i++) {
    //     dotD.push(0);
    //   }
    // }
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
  LOC_UID: curPage[1],
  NODE_NAME: curPage[0],
};
Object.assign(rData, RequestData());
fetch(`${domain}API/?act=getSensors`, {
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
      removeChildEl("locations-list");
      data.DATA.forEach((node) => {
        // if(node.SENSOR_TYPE == air){
        //   sensor.air.push(node.MAC)
        // } else if(node.SENSOR_TYPE == motion){
        //   sensor.motion.push(node.MAC)
        // } else {
        //   sensor.distance.push(node.MAC)
        // }
        createFacilitiesList(
          "locations-list",
          node.NODE_ID,
          node.NODE_ID,
          null,
          node.NAME,
          null,
          node.SENSOR_TYPE
        );
      });
      // console.log(sensor)
    }
    if (data.CODE == -1) {
      // alert(data.MESSAGE)
      // window.location.href = dashBoardPage
    }
  })
  .catch((error) => console.log(error));

fetch(`${domain}API/?act=getLocationAlertsData`, {
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
          "<tr onclick=clickedRow(" +
            alert.ID +
            ") style='cursor: pointer;'><td>" +
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
        $("#node-fault-table tbody").append(newRow);
      });
    }
    if (data.CODE == -1) {
    }
  })
  .catch((error) => console.log(error));

function clickedRow(id) {
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
        nodeAlertModal.classList.add("fade");
        nodeAlertModal.classList.add("show");
        nodeAlertModal.style = "display: block;";
        if (checkEl("node-alert-modal-footer-childBtn")) {
          removeEl("node-alert-modal-footer-childBtn");
        }
        removeChildEl("node-alert-modal-body");
        data.DATA.forEach((al) => {
          // console.log(al)
          var pId = document.createElement("p");
          var pTime = document.createElement("p");
          var pMessage = document.createElement("p");
          var pNotiUsers = document.createElement("p");
          var pStatus = document.createElement("p");
          pId.innerHTML = "<strong>ID:</strong> " + al.ID;
          pTime.innerHTML = "<strong>Time:</strong> " + al.TIME;
          pMessage.innerHTML = "<strong>Alert Message:</strong> " + al.MESSAGE;
          // user = al.NOTIFIED_USERS.replaceAll(/\"\[\]/g, "")
          user = al.NOTIFIED_USERS.replaceAll('"', "");
          user = user.replaceAll("[", "");
          user = user.replaceAll("]", "");
          if (user.includes(",")) user = user.split(",");
          pNotiUsers.innerHTML =
            "<strong>Notified Users:</strong> " +
            user.map(
              (u) =>
                `<button class="btn btn-outline-primary" disabled>${u}</button>`
            );
          if (al.STATUS == 0)
            pStatus.innerHTML = "<strong>Status:</strong> In Progress";
          else
            pStatus.innerHTML = `<strong>Acknowledged by</strong> <button class="btn btn-outline-primary" disabled>${al.ACK_USER}</button>`;
          nodeAlertModalBody.appendChild(pId);
          nodeAlertModalBody.appendChild(pTime);
          nodeAlertModalBody.appendChild(pMessage);
          nodeAlertModalBody.appendChild(pNotiUsers);
          nodeAlertModalBody.appendChild(pStatus);
          if (user.includes(UNAME) && al.STATUS == 0) {
            // console.log(UNAME)
            var btn = document.createElement("button");
            btn.setAttribute("type", "button");
            btn.setAttribute("class", "btn btn-primary");
            btn.setAttribute("onclick", `nodeAck(${al.ID})`);
            btn.setAttribute("id", "node-alert-modal-footer-childBtn");
            btn.innerText = "Acknowledge";
            nodeAlertModalFooter.appendChild(btn);
          }
        });
      }
      if (data.CODE == -1) {
        alert(data.MESSAGE);
        // window.location.href = dashBoardPage
      }
    })
    .catch((error) => console.log(error));
}

function nodeAck(id) {
  // console.log(id)
  rData = {
    ID: id,
    LOGIN_NAME: UNAME,
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
      console.log(data);
      if (data.CODE == 0) {
        document.querySelector("#node-alert-close-btn").click();
        location.reload();
      }
      if (data.CODE == -1) {
        alert(data.MESSAGE);
        // window.location.href = dashBoardPage
      }
    })
    .catch((error) => console.log(error));
}

nodeAlertCloseBtn.addEventListener("click", (e) => {
  nodeAlertModal.classList.remove("fade");
  nodeAlertModal.classList.remove("show");
  nodeAlertModal.style = "display: none;";
});

nodeAlertXBtn.addEventListener("click", (e) => {
  nodeAlertModal.classList.remove("fade");
  nodeAlertModal.classList.remove("show");
  nodeAlertModal.style = "display: none;";
});

function chartTimeSelect(timeSelect) {
  document.querySelector("#Close-button").click();
  type = air;
  legendName = "";
  lineS = 10;
  dottedBar.showLoading();
  // console.log(timeSelect, locName, locID, sensorType);
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
    LOCATION_ID: curPage[1],
    TIME: timeSelect,
    SENSOR_TYPE: type,
  };
  Object.assign(RData, RequestData());
  fetch(`${domain}API/?act=getLocationEventData`, {
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

window.addEventListener("click", (e) => {
  // console.log(e.path[0].id, e.path[2].id, e, e.target.innerHTML)
  if (e.path[0].id == "fac-image") {
    // console.log(e.target.nextSibling.outerText, e)
    window.location.href = `${detailPage}?name=${e.target.nextSibling.outerText}&${e.path[2].id}&${e.path[1].id}`;
  }
  if (e.path[0].id == "fac-list") {
    // console.log(e.target.innerText, e)
    window.location.href = `${detailPage}?name=${e.target.innerText}&${e.path[2].id}&${e.path[1].id}`;
  }
  if (e.path[2].id == "fac-list") {
    // console.log(e.target.innerText, e)
    window.location.href = `${detailPage}?name=${e.target.innerText}&${e.path[4].id}&${e.path[3].id}`;
  }
});

async function sensorUpdate(sensorName, ID) {
  // console.log(sensorName, sensorUID)
  updateSensorName.value = "";
  updateSensorFacName.value = "";
  updateSensorFacName.setAttribute("uid", "");
  updateSensorLocName.value = "";
  updateSensorLocName.setAttribute("uid", "");
  updateSensorMAC.value = "";
  updateSensorType.value = "";
  updateSensorSubmitBtn.setAttribute("uid", "");
  updateSensorAlertVal.value = "";
  updateSensorCloseBtn.addEventListener("click", (e) => {
    updateSensorForm.classList.remove("show");
    updateSensorForm.setAttribute("style", "display: none;");
    updateSensorForm.removeAttribute("aria-modal");
    updateSensorForm.removeAttribute("role");
    updateSensorForm.setAttribute("aria-hidden", "true");
  });
  updateSensorXBtn.addEventListener("click", (e) => {
    updateSensorForm.classList.remove("show");
    updateSensorForm.setAttribute("style", "display: none;");
    updateSensorForm.removeAttribute("aria-modal");
    updateSensorForm.removeAttribute("role");
    updateSensorForm.setAttribute("aria-hidden", "true");
  });
  updateSensorForm.setAttribute("class", "modal fade show");
  updateSensorForm.setAttribute("style", "display: block;");
  updateSensorForm.setAttribute("aria-modal", "true");
  updateSensorForm.setAttribute("role", "dialog");
  updateSensorForm.removeAttribute("aria-hidden");
  RData = {
    ID: ID,
  };
  Object.assign(RData, RequestData());
  await fetch(`${domain}API/?act=getSensor`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(RData),
  })
    .then((response) => response.json())
    .then((data) => {
      // console.log(data);
      if (data.CODE == 0) {
        updateSensorName.style.border = oriBorder;
        updateSensorNameError.innerHTML = "";
        updateSensorName.value = data.DATA[0].SENSOR_NAME;
        updateSensorFacName.value = data.DATA[0].FACILITY_NAME;
        updateSensorFacName.setAttribute("uid", data.DATA[0].FACILITY_UID);
        updateSensorLocName.value = data.DATA[0].LOCATION_NAME;
        updateSensorLocName.setAttribute("uid", data.DATA[0].LOCATION_UID);
        updateSensorMAC.value = data.DATA[0].MAC;
        updateSensorType.value = data.DATA[0].SENSOR_TYPE;
        updateSensorAlertVal.value = data.DATA[0].THRESHOLD;
        updateSensorSubmitBtn.setAttribute("uid", data.DATA[0].ID);
      } else {
        updateSensorName.style.border = redBorder;
        updateSensorNameError.innerHTML = "Sensor Name Not Found";
      }
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

function sensorDelete(sensorName, sensorUID) {
  //   console.log(sensorName, sensorUID);
  delSensorCloseBtn.addEventListener("click", (e) => {
    delSensorForm.classList.remove("show");
    delSensorForm.setAttribute("style", "display: none;");
    delSensorForm.removeAttribute("aria-modal");
    delSensorForm.removeAttribute("role");
    delSensorForm.setAttribute("aria-hidden", "true");
  });
  delSensorXBtn.addEventListener("click", (e) => {
    delSensorForm.classList.remove("show");
    delSensorForm.setAttribute("style", "display: none;");
    delSensorForm.removeAttribute("aria-modal");
    delSensorForm.removeAttribute("role");
    delSensorForm.setAttribute("aria-hidden", "true");
  });
  delSensorForm.setAttribute("class", "modal fade show");
  delSensorForm.setAttribute("style", "display: block;");
  delSensorForm.setAttribute("aria-modal", "true");
  delSensorForm.setAttribute("role", "dialog");
  delSensorForm.removeAttribute("aria-hidden");
  deleteSensorFormBody.innerHTML = `Are you sure, you want to delete <strong>${sensorName}</strong> Location?`;
  delSensorSubmitBtn.setAttribute("uid", sensorUID);
}

async function addSensor() {
  addSensorNameError.innerHTML = "";
  addSensorName.style.border = oriBorder;
  addSensorFacNameError.innerHTML = "";
  addSensorFacName.style.border = oriBorder;
  addSensorLocNameError.innerHTML = "";
  addSensorLocName.style.border = oriBorder;
  addSensorTypeError.innerHTML = "";
  addSensorType.style.border = oriBorder;
  RData = {
    NODE_NAME: addSensorName.value,
    FAC_UID: addSensorFacName.getAttribute("uid"),
    LOC_UID: addSensorLocName.getAttribute("uid"),
    MAC: addSensorMAC.value,
    SENSOR_TYPE: addSensorType.value,
    THRESHOLD: addSensorAlertVal.value,
  };
  Object.assign(RData, RequestData());
  await fetch(`${domain}API/?act=addSensor`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(RData),
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      if (data.CODE == -1) {
        addSensorNameError.innerHTML = data.MESSAGE.filter((val) =>
          val.includes("Node")
        );
        if (data.MESSAGE.filter((val) => val.includes("Node")).length > 0) {
          addSensorName.style.border = redBorder;
        }
        addSensorFacNameError.innerHTML = data.MESSAGE.filter((val) =>
          val.includes("Facility")
        );
        if (data.MESSAGE.filter((val) => val.includes("Facility")).length > 0) {
          addSensorFacName.style.border = redBorder;
        }
        addSensorLocNameError.innerHTML = data.MESSAGE.filter((val) =>
          val.includes("Location")
        );
        if (data.MESSAGE.filter((val) => val.includes("Location")).length > 0) {
          addSensorLocName.style.border = redBorder;
        }
        addSensorTypeError.innerHTML = data.MESSAGE.filter((val) =>
          val.includes("Sensor")
        );
        if (data.MESSAGE.filter((val) => val.includes("Sensor")).length > 0) {
          addSensorType.style.border = redBorder;
        }
      }
      if (data.CODE == 0) {
        addSensorName.value = "";
        addSensorFacName.value = "";
        addSensorLocName.value = "";
        addSensorType.value = "";
        addSensorAlertVal.value = "";
        location.reload();
      }
    })
    .catch((error) => console.log(error));
}

async function updateSensor() {
  updateSensorNameError.innerHTML = "";
  updateSensorName.style.border = oriBorder;
  updateSensorFacNameError.innerHTML = "";
  updateSensorFacName.style.border = oriBorder;
  updateSensorLocNameError.innerHTML = "";
  updateSensorLocName.style.border = oriBorder;
  updateSensorTypeError.innerHTML = "";
  updateSensorType.style.border = oriBorder;
  RData = {
    NODE_NAME: updateSensorName.value,
    FAC_UID: updateSensorFacName.getAttribute("uid"),
    LOC_UID: updateSensorLocName.getAttribute("uid"),
    MAC: updateSensorMAC.value,
    SENSOR_TYPE: updateSensorType.value,
    ID: updateSensorSubmitBtn.getAttribute("uid"),
    THRESHOLD: updateSensorAlertVal.value,
  };
  Object.assign(RData, RequestData());
  await fetch(`${domain}API/?act=updateSensor`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(RData),
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      if (data.CODE == -1) {
        updateSensorNameError.innerHTML = data.MESSAGE.filter((val) =>
          val.includes("Node")
        );
        if (data.MESSAGE.filter((val) => val.includes("Node")).length > 0) {
          updateSensorName.style.border = redBorder;
        }
        updateSensorFacNameError.innerHTML = data.MESSAGE.filter((val) =>
          val.includes("Facility")
        );
        if (data.MESSAGE.filter((val) => val.includes("Facility")).length > 0) {
          updateSensorFacName.style.border = redBorder;
        }
        updateSensorLocNameError.innerHTML = data.MESSAGE.filter((val) =>
          val.includes("Location")
        );
        if (data.MESSAGE.filter((val) => val.includes("Location")).length > 0) {
          updateSensorLocName.style.border = redBorder;
        }
        updateSensorTypeError.innerHTML = data.MESSAGE.filter((val) =>
          val.includes("Sensor")
        );
        if (data.MESSAGE.filter((val) => val.includes("Sensor")).length > 0) {
          updateSensorType.style.border = redBorder;
        }
      }
      if (data.CODE == 0) {
        updateSensorName.value = "";
        updateSensorFacName.value = "";
        updateSensorLocName.value = "";
        updateSensorType.value = "";
        updateSensorAlertVal.value = "";
        location.reload();
      }
    })
    .catch((error) => console.log(error));
}

async function deleteSensor() {
  console.log(delSensorSubmitBtn.getAttribute("uid"));
  RData = {
    ID: delSensorSubmitBtn.getAttribute("uid"),
  };
  Object.assign(RData, RequestData());
  await fetch(`${domain}API/?act=removeSensor`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(RData),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.CODE == 0) {
        document.querySelector("#delete-sensor-close-btn").click();
        location.reload();
      } else {
        alert("Can't delete Sensor");
      }
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

homeTabFac.addEventListener("click", (e) => {
  // console.log('home tab clicked')
  dottedBar.showLoading();
  reqD = {
    LOCATION_ID: curPage[1],
    TIME: "DAY",
    SENSOR_TYPE: air,
  };
  Object.assign(reqD, RequestData());
  fetch(`${domain}API/?act=getLocationEventData`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(reqD),
  })
    .then((response) => response.json())
    .then((data) => {
      // console.log(data);
      dottedBar.hideLoading();
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
});

profileTabFac.addEventListener("click", (e) => {
  dottedBar.showLoading();
  reqD = {
    LOCATION_ID: curPage[1],
    TIME: "DAY",
    SENSOR_TYPE: motion,
  };
  Object.assign(reqD, RequestData());
  fetch(`${domain}API/?act=getLocationEventData`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(reqD),
  })
    .then((response) => response.json())
    .then((data) => {
      // console.log(data);
      dottedBar.hideLoading();
      let xLabel = [];
      let lineD = [];
      data.DATA?.forEach((air) => {
        xLabel.push(air["TIME"].slice(11, 16));
        lineD.push(Math.round(air["SUM(EVENTS.SENSOR_DATA)"]));
      });
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
  // console.log('contact clicked')
  reqD = {
    LOCATION_ID: curPage[1],
    TIME: "DAY",
    SENSOR_TYPE: distance,
  };
  Object.assign(reqD, RequestData());
  fetch(`${domain}API/?act=getLocationEventData`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(reqD),
  })
    .then((response) => response.json())
    .then((data) => {
      // console.log(data);
      dottedBar.hideLoading();
      let xLabel = [];
      let lineD = [];
      data.DATA?.forEach((air) => {
        xLabel.push(air["TIME"].slice(11, 16));
        lineD.push(Math.round(air["AVG(EVENTS.SENSOR_DATA)"]));
      });
      updateDottedBar(
        xLabel,
        "Average Fill Level in 30 mins",
        lineD,
        8,
        "Average Fill Level in 30 mins"
      );
    })
    .catch((error) => console.log(error));
});

addSensorMAC.addEventListener("input", (e) => {
  if (e.target.value != "") {
    addSensorMAC.setAttribute("uid", "");
    RData = {
      VALUE: e.target.value,
    };
    Object.assign(RData, RequestData());
    fetch(`${domain}API/?act=getMACSuggestion`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(RData),
    })
      .then((response) => response.json())
      .then((data) => {
        removeChildEl("add-sensor-mac-suggest");
        // console.log(data);
        if (data["CODE"] == 0) {
          // console.log(data)
          data["DATA"].forEach((node) => {
            b = document.createElement("DIV");
            b.innerHTML = node.MAC;
            b.addEventListener("click", function (e) {
              if (e.target.nodeName == "DIV") {
                removeChildEl("add-sensor-mac-suggest");
                addSensorName.value = node.NAME;
                addSensorMAC.value = e.target.innerHTML;
                addSensorMAC.setAttribute("uid", node.ID);
                addSensorType.value = node.SENSOR_TYPE;
                addSensorMAC.style.border = oriBorder;
                addSensorMACError.innerHTML = "";
              }
            });
            addSensorMACSugg.appendChild(b);
          });
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  } else {
    removeChildEl("add-sensor-mac-suggest");
    addSensorMAC.style.border = oriBorder;
    addSensorMACError.innerHTML = "";
  }
});

addSensorFacName.addEventListener("input", (e) => {
  if (e.target.value != "") {
    addSensorFacName.setAttribute("uid", "");
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
        removeChildEl("add-sensor-fac-suggest");
        // console.log(data);
        if (data["CODE"] == 0) {
          // console.log(data)
          data["DATA"].forEach((fac) => {
            b = document.createElement("DIV");
            b.innerHTML = fac.NAME;
            b.addEventListener("click", function (e) {
              if (e.target.nodeName == "DIV") {
                removeChildEl("add-sensor-fac-suggest");
                addSensorFacName.value = e.target.innerHTML;
                addSensorFacName.setAttribute("uid", fac.UID);
                addSensorFacName.style.border = oriBorder;
                addSensorFacNameError.innerHTML = "";
              }
            });
            addSensorFacSugg.appendChild(b);
          });
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  } else {
    removeChildEl("add-sensor-fac-suggest");
    addSensorFacName.style.border = oriBorder;
    addSensorFacNameError.innerHTML = "";
  }
});

updateSensorFacName.addEventListener("input", (e) => {
  if (e.target.value != "") {
    updateSensorFacName.setAttribute("uid", "");
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
        removeChildEl("update-sensor-fac-suggest");
        // console.log(data);
        if (data["CODE"] == 0) {
          // console.log(data)
          data["DATA"].forEach((fac) => {
            b = document.createElement("DIV");
            b.innerHTML = fac.NAME;
            b.addEventListener("click", function (e) {
              if (e.target.nodeName == "DIV") {
                removeChildEl("update-sensor-fac-suggest");
                updateSensorFacName.value = e.target.innerHTML;
                updateSensorFacName.setAttribute("uid", fac.UID);
                updateSensorFacName.style.border = oriBorder;
                updateSensorFacNameError.innerHTML = "";
              }
            });
            updateSensorFacSugg.appendChild(b);
          });
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  } else {
    removeChildEl("update-sensor-fac-suggest");
    updateSensorFacName.style.border = oriBorder;
    updateSensorFacNameError.innerHTML = "";
  }
});

addSensorLocName.addEventListener("input", (e) => {
  if (
    addSensorFacName.value != null &&
    addSensorFacName.getAttribute("uid") != null
  ) {
    addSensorLocName.style.border = oriBorder;
    addSensorLocNameError.innerHTML = "";
    if (addSensorLocName != null) {
      addSensorLocName.setAttribute("uid", "");
      RData = {
        VALUE: e.target.value,
        FACILITY_UID: addSensorFacName.getAttribute("uid"),
      };
      Object.assign(RData, RequestData());
      fetch(`${domain}API/?act=getLocationSuggestion`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(RData),
      })
        .then((response) => response.json())
        .then((data) => {
          removeChildEl("add-sensor-loc-suggest");
          //   console.log(data);
          if (data["CODE"] == 0) {
            // console.log(data)
            data["DATA"].forEach((fac) => {
              b = document.createElement("DIV");
              b.innerHTML = fac.LOCATION_NAME;
              b.addEventListener("click", function (e) {
                if (e.target.nodeName == "DIV") {
                  removeChildEl("add-sensor-loc-suggest");
                  addSensorLocName.value = e.target.innerHTML;
                  addSensorLocName.setAttribute("uid", fac.LOCATION_UID);
                  addSensorLocName.style.border = oriBorder;
                  addSensorLocNameError.innerHTML = "";
                }
              });
              addSensorLocSugg.appendChild(b);
            });
          }
        })
        .catch((error) => {
          console.error("Error:", error);
        });
    } else {
    }
  } else {
    addSensorFacName.style.border = redBorder;
    addSensorFacNameError.innerHTML = "Please Key In Facility Name First";
  }
});

updateSensorLocName.addEventListener("input", (e) => {
  if (
    updateSensorLocName.value != null &&
    updateSensorLocName.getAttribute("uid") != null
  ) {
    updateSensorLocName.style.border = oriBorder;
    updateSensorLocNameError.innerHTML = "";
    if (updateSensorLocName != null) {
      updateSensorLocName.setAttribute("uid", "");
      RData = {
        VALUE: e.target.value,
        FACILITY_UID: updateSensorFacName.getAttribute("uid"),
      };
      Object.assign(RData, RequestData());
      fetch(`${domain}API/?act=getLocationSuggestion`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(RData),
      })
        .then((response) => response.json())
        .then((data) => {
          removeChildEl("update-sensor-loc-suggest");
          //   console.log(data);
          if (data["CODE"] == 0) {
            console.log(data);
            data["DATA"].forEach((fac) => {
              b = document.createElement("DIV");
              b.innerHTML = fac.LOCATION_NAME;
              b.addEventListener("click", function (e) {
                if (e.target.nodeName == "DIV") {
                  removeChildEl("update-sensor-loc-suggest");
                  updateSensorLocName.value = e.target.innerHTML;
                  updateSensorLocName.setAttribute("uid", fac.LOCATION_UID);
                  updateSensorLocName.style.border = oriBorder;
                  updateSensorLocNameError.innerHTML = "";
                }
              });
              updateSensorLocSugg.appendChild(b);
            });
          }
        })
        .catch((error) => {
          console.error("Error:", error);
        });
    } else {
    }
  } else {
    updateSensorFacName.style.border = redBorder;
    updateSensorFacNameError.innerHTML = "Please Key In Facility Name First";
  }
});
