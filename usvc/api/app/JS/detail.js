// offcanvas
const offcanvasLogin = document.getElementById("offcanvas-login");
const offcanvasLogout = document.getElementById("offcanvas-logout");
const offcanvasHeader = document.getElementById("offcanvas-header");
// tab
const hourTab = document.getElementById("hour-tab")
const dayTab = document.getElementById("day-tab")
const weekTab = document.getElementById("week-tab")
const monthTab = document.getElementById("month-tab")

var curPage = window.location.href.split("=")[1].replaceAll("%20", " ");
curPage = curPage.split("&");
// console.log(curPage[0], curPage[1], curPage[2]);

offcanvasChildElRemove("offcanvasEl");
offcanvasHomeliCreate("offcanvasEl", "Home");
offcanvasHomeliCreate("offcanvasEl", "Dash Board");

if (checkLogin()) {
  TYPE = getCookie("TYPE");
  //   console.log(TYPE, typeof(TYPE), TYPE != 0)
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
  // document.getElementById("addSensor").addEventListener("click", () => {
  //   document.querySelector("#Close-button").click();
  // });

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
  location.href = loginPage;
}
var sensorName = curPage[0]
var sensorID = curPage[1]
var sensorType = curPage[2]
if (curPage[2] == air) updateLine("HOUR", sensorName, sensorID, sensorType);
else UpdateBar("HOUR", sensorName, sensorID, sensorType);

hourTab.addEventListener('click', e => {
  chartTimeSelect('HOUR')
})

dayTab.addEventListener('click', e => {
  chartTimeSelect('DAY')
})

weekTab.addEventListener('click', e => {
  chartTimeSelect('WEEK')
})

monthTab.addEventListener('click', e => {
  chartTimeSelect('MONTH')
})

function chartTimeSelect(timeSelect) {
  document.querySelector("#Close-button").click();

  if (sensorType == air) {
    updateLine(timeSelect, sensorName, sensorID);
  } else if (sensorType == motion || sensorType == distance) {
    UpdateBar(timeSelect, sensorName, sensorID, sensorType);
  }
  // console.log(timeSelect, sensorName, sensorID, sensorType)
}
