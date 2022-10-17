// offcanvas
const offcanvasLogin = document.getElementById("offcanvas-login");
const offcanvasLogout = document.getElementById("offcanvas-logout");
const offcanvasHeader = document.getElementById("offcanvas-header");
// tab
const hourTab = document.getElementById("hour-tab");
const dayTab = document.getElementById("day-tab");
const weekTab = document.getElementById("week-tab");
const monthTab = document.getElementById("month-tab");
// past alerts
const pastDayAlert = document.getElementById("detail-alert-day");
const pastWeekAlert = document.getElementById("detail-alert-week");
const pastMonthAlert = document.getElementById("detail-alert-month");
// alert modal
const detailAlertModal = document.getElementById("detail-alert-modal");
const detailAlertXBtn = document.getElementById("detail-alert-X-btn");
const detailAlertCloseBtn = document.getElementById("detail-alert-close-btn");
const detailAlertModalBody = document.getElementById("detail-alert-modal-body");
const detailAlertModalFooter = document.getElementById("detail-alert-modal-footer");
// alert table
const detailAlertTable = document.getElementById("detail-fault-table")

var curPage = window.location.href.split("=")[1].replaceAll("%20", " ");
curPage = curPage.split("&");
// console.log(curPage[0], curPage[1], curPage[2]);

offcanvasChildElRemove("offcanvasEl");
offcanvasHomeliCreate("offcanvasEl", "Home");
offcanvasHomeliCreate("offcanvasEl", "Dash Board");
UNAME = getCookie("USERNAME");
TYPE = getCookie("TYPE");
if (checkLogin()) {  
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
var sensorName = curPage[0];
var sensorID = curPage[1];
var sensorType = curPage[2];
if (curPage[2] == air) updateLine("HOUR", sensorName, sensorID);
else UpdateBar("HOUR", sensorName, sensorID, sensorType);

hourTab.addEventListener("click", (e) => {
  chartTimeSelect("HOUR");
});

dayTab.addEventListener("click", (e) => {
  chartTimeSelect("DAY");
});

weekTab.addEventListener("click", (e) => {
  chartTimeSelect("WEEK");
});

monthTab.addEventListener("click", (e) => {
  chartTimeSelect("MONTH");
});

function chartTimeSelect(timeSelect) {
  document.querySelector("#Close-button").click();

  if (sensorType == air) {
    updateLine(timeSelect, sensorName, sensorID);
  } else if (sensorType == motion || sensorType == distance) {
    UpdateBar(timeSelect, sensorName, sensorID, sensorType);
  }
  // console.log(timeSelect, sensorName, sensorID, sensorType)
}
window.onscroll = function() {

  // @var int totalPageHeight
  var totalPageHeight = document.body.scrollHeight; 

  // @var int scrollPoint
  var scrollPoint = window.scrollY + window.innerHeight;
  // console.log(Math.round(totalPageHeight), Math.round(scrollPoint))
  // check if we hit the bottom of the page
  if(Math.round(scrollPoint) >= totalPageHeight)
  {
    // console.log("at the bottom");
    var lastRow = detailAlertTable.rows[detailAlertTable.rows.length - 1].cells[0].innerText
    // console.log(lastRow)
    reData = {
      NODE_ID: curPage[1],
      NODE_NAME: curPage[0],
      ALERT_ID: lastRow
    };
    Object.assign(reData, RequestData());
    fetch(`${domain}API/?act=getDetailAlertsData`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(reData),
    })
      .then((response) => response.json())
      .then((data) => {
        // console.log(data);
        if (data.CODE == 0) {
          data.DATA.forEach((al) => {
            var date, time;
            date = al.TIME.split(" ");
            time = date[1];
            date = new Date(date);
            // console.log(date.toDateString(), time)
            user = al.NOTIFIED_USERS.replaceAll('"', "");
            user = user.replaceAll("[", "");
            user = user.replaceAll("]", "");
            if (user.includes(",")) user = user.split(",");
            newRow = $(
              "<tr onclick=clickedRow(" +
                al.ID +
                ") style='cursor: pointer;'><td>" +
                al.ID +
                "</td><td>" +
                date.toDateString() +
                "</td><td>" +
                time +
                "</td><td>" +
                al.MESSAGE +
                "</td><td>" +
                user.map(
                  (u) =>
                    '<button class="btn btn-primary" id="detail-alert-sentTo" disabled>'+u+'</button>'
                ) +
                "</td></tr>"
            );
            $("#detail-fault-table tbody").append(newRow);
          });
        }
      })
      .catch((error) => console.log(error));
  }
}

let reData = {
  NODE_ID: curPage[1],
  NODE_NAME: curPage[0],
};
Object.assign(reData, RequestData());
fetch(`${domain}API/?act=getPastAlerts`, {
  method: "POST",
  headers: {
    "Content-Type": "application/json",
  },
  body: JSON.stringify(reData),
})
  .then((response) => response.json())
  .then((data) => {
    // console.log(data);
    if (data.CODE == 0) {
      data.DATA.map((al) => {
        Object.entries(al).forEach((entry) => {
          const [key, value] = entry;
          if (key.includes("Past_Day_Alerts")) {
            pastDayAlert.innerText = value;
          } else if (key.includes("Past_Week_Alerts")) {
            pastWeekAlert.innerText = value;
          } else if (key.includes("Past_Month_Alerts")) {
            pastMonthAlert.innerText = value;
          }
        });
      });
    }
  })
  .catch((error) => console.log(error));

reData = {
  NODE_ID: curPage[1],
  NODE_NAME: curPage[0],
};
Object.assign(reData, RequestData());
fetch(`${domain}API/?act=getDetailAlertsData`, {
  method: "POST",
  headers: {
    "Content-Type": "application/json",
  },
  body: JSON.stringify(reData),
})
  .then((response) => response.json())
  .then((data) => {
    // console.log(data);
    if (data.CODE == 0) {
      data.DATA.forEach((al) => {
        var date, time, message
        date = al.TIME.split(" ");
        time = date[1];
        date = new Date(date);
        message = al.MESSAGE
        // console.log(date.toDateString(), time)
        user = al.NOTIFIED_USERS.replaceAll('"', "");
        user = user.replaceAll("[", "");
        user = user.replaceAll("]", "");
        if (user.includes(",")) user = user.split(",");
        // $("#detail-fault-table").width($(window).width());
        if(message.includes('%20')) message = message.replaceAll('%20', ' ')
        newRow = $(
          "<tr onclick=clickedRow(" +
            al.ID +
            ") style='cursor: pointer;'><td>" +
            al.ID +
            "</td><td>" +
            date.toDateString() +
            "</td><td>" +
            time +
            "</td><td>" +
            message +
            // "</td><td>" +
            // al.NOTIFIED_USERS +
            // "</td></tr>"
            "</td><td>" +
            user.map(
              (u) =>
                '<button class="btn btn-primary" id="detail-alert-sentTo" disabled>'+u+'</button>'
            ) +
            "</td></tr>"
        );
        $("#detail-fault-table tbody").append(newRow);
      });
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
        detailAlertModal.classList.add("fade");
        detailAlertModal.classList.add("show");
        detailAlertModal.style = "display: block;";
        if (checkEl("detail-alert-modal-footer-childBtn")) {
          removeEl("detail-alert-modal-footer-childBtn");
        }
        removeChildEl("detail-alert-modal-body");
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
          detailAlertModalBody.appendChild(pId);
          detailAlertModalBody.appendChild(pTime);
          detailAlertModalBody.appendChild(pMessage);
          detailAlertModalBody.appendChild(pNotiUsers);
          detailAlertModalBody.appendChild(pStatus);
          if (user.includes(UNAME) && al.STATUS == 0) {
            // console.log(UNAME)
            var btn = document.createElement("button");
            btn.setAttribute("type", "button");
            btn.setAttribute("class", "btn btn-primary");
            btn.setAttribute("onclick", `detailAck(${al.ID})`);
            btn.setAttribute("id", "detail-alert-modal-footer-childBtn");
            btn.innerText = "Acknowledge";
            detailAlertModalFooter.appendChild(btn);
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

function detailAck(id) {
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
      // console.log(data);
      if (data.CODE == 0) {

        document.querySelector("#detail-alert-close-btn").click();
        // location.reload();
      }
      if (data.CODE == -1) {
        alert(data.MESSAGE);
        // window.location.href = dashBoardPage
      }
    })
    .catch((error) => console.log(error));
}

detailAlertCloseBtn.addEventListener("click", (e) => {
  detailAlertModal.classList.remove("fade");
  detailAlertModal.classList.remove("show");
  detailAlertModal.style = "display: none;";
});

detailAlertXBtn.addEventListener("click", (e) => {
  detailAlertModal.classList.remove("fade");
  detailAlertModal.classList.remove("show");
  detailAlertModal.style = "display: none;";
});