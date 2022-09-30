var parent = document.getElementById("card");
var barChartTitle = document.getElementById("lineChartTitle");
var lineChart = document.getElementById("lineChart");
var barChart = document.getElementById("barChart");
const offcanvasLogin = document.getElementById('offcanvas-login')
const offcanvasLogout = document.getElementById('offcanvas-logout')
let nodeName = getNodeName()
let nodeData;
// console.log(nodeName)

if(checkLogin()){
    UNAME = getCookie("USERNAME")
    offcanvasLogin.innerHTML = `<a class="nav-link" aria-current="page">${UNAME} <i class="fa-solid fa-user"></i></a>`
    offcanvasLogin.setAttribute('onclick', '')
    offcanvasLogout.setAttribute('type', 'button')
    offcanvasLogout.innerHTML = '<a class="nav-link" aria-current="page" >Log Out <i class="fa-solid fa-right-from-bracket"></i></a>'
} else {
    offcanvasLogin.setAttribute('onclick', 'gotologin()')
    offcanvasLogin.setAttribute('type', 'button')
    offcanvasLogin.innerHTML = `<a class="nav-link" aria-current="page" >Login <i class="fa-solid fa-user"></i></a>`
    offcanvasLogout.innerHTML = ''
}

// var AirQualityFemaleToiletlineChart = document.getElementById("#AirQ")
// var MotionDetectionSensorForFemaleToiletBarChart = document.querySelectorAll("#motion-detection-sensor-for-female-toilet-barChart li")
// var TrashBinSensorForFemaleToiletBarChart = document.querySelectorAll("#trash-bin-sensor-for-female-toilet-barChart li")
// AirQualityFemaleToiletlineChart.addEventListener('click', async (e) => {
//     document.querySelector("#Close-button").click();
//     updateLine("YEAR", "Air")
// })
// http://167.99.77.130/API/?act=getAllNodes
rData = {
    NAME: nodeName
}
Object.assign(rData, RequestData());
fetch(`${domain}API/?act=getAllNodes`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(rData),
})
.then((response) => response.json())
.then((data) => {
    // console.log(data)    
    if(data.CODE == 0){
        nodeData = data.DATA
        // console.log(nodeData)
        offcanvasChildElRemove('offcanvasEl')
        offcanvasHomeliCreate('offcanvasEl', 'Home')
        offcanvasHomeliCreate('offcanvasEl', 'Dash Board')
        nodeData.forEach(element => {
            // console.log(element)
            if(element.SENSOR_TYPE == air){
                offcanvasliCreate('offcanvasEl', 'li', 'a', 'nav-item', 'nav-link', element.NAME, 'AirQ', 'button','updateLine()',null, null, `<i class="fa-solid fa-chart-column"></i> ${element.NAME}`)
            }
            if(element.SENSOR_TYPE == motion){
                offcanvasliCreate('offcanvasEl', 'li', 'a', 'nav-item dropdown', 'nav-link dropdown-toggle', element.NAME, 'offcanvasNavbarDropdown', 'button',null, 'dropdown', null, `<i class="fa-solid fa-chart-column"></i> ${element.NAME}`)
            }
        });
    }  
})
.catch((error) => {
    console.error("Error:", error);
});
    
// MotionDetectionSensorForFemaleToiletBarChart.forEach((item, index) => {
//     item.addEventListener('click', (e) => {
//         // alert(`${e.currentTarget.innerHTML} item was click`);
//         barChartTitle.innerHTML = "Female Toilet";
//         document.querySelector("#Close-button").click();        
//         let text = e.currentTarget.innerHTML
//         if(text.includes("1 Hour")){
//             // console.log(nodeName)
//             UpdateBar("1 Hour", "Motion", nodeName)
//             // updateGuage("Motion")
//             // console.log("Sensor 1 HOUR")
//         } else if(text.includes("1 Day")) {
//             // console.log(nodeName)
//             UpdateBar("1 Day", "Motion", nodeName)
//             // updateGuage("Motion")
//             // console.log("Sensor 1 DAY")
//         } else if(text.includes("1 Week")) {
//             UpdateBar("1 Week", "Motion", nodeName)
//             // updateGuage("Motion")
//             // console.log("Sensor 1 WEEK")
//         } else if(text.includes("1 Month")) {
//             UpdateBar("1 Month", "Motion", nodeName)
//             // updateGuage("Motion")
//             // console.log("Sensor 1 MONTH")
//         } else if(text.includes("1 Year")) {
//             UpdateBar("1 Year", "Motion", nodeName)
//             // updateGuage("Motion")
//             // console.log("Sensor 1 YEAR")
//         } else {
//             // UpdateBar("1 Hour", "Motion")
//             // console.log("Sensor CUSTOM")
//         }
//     })
// })
// TrashBinSensorForFemaleToiletBarChart.forEach((item, index) => {
//     item.addEventListener('click', async (e) => {
//         // alert(`${e.currentTarget.innerHTML} item was click`);
//         barChartTitle.innerHTML = "Female Toilet Trash Bin";
//         document.querySelector("#Close-button").click();
//         let text = e.currentTarget.innerHTML
//         if(text.includes("1 Hour")){
//             UpdateBar("1 Hour", "Trash")
//             updateGuage("Trash")
//         } else if(text.includes("1 Day")) {
//             UpdateBar("1 Day", "Trash")
//             updateGuage("Trash")
//         } else if(text.includes("1 Week")) {
//             UpdateBar("1 Week", "Trash")
//             updateGuage("Trash")
//         } else if(text.includes("1 Month")) {
//             UpdateBar("1 Month", "Trash")
//             updateGuage("Trash")
//         } else if(text.includes("1 Year")) {
//             UpdateBar("1 Year", "Trash")
//             updateGuage("Trash")
//         } else {
//             // UpdateBar("1 Year", "Trash")

//         }
//     })
// })
// async function getEvents() {
//   // console.log("button clicked")
//   events = await API_Call();
//   // console.log(events)
//   events.forEach((x) => {
//     var child = document.createElement("div");
//     child.class = "card-body";
//     child.innerHTML = `ID:${x.ID}, TIME:${x.TIME}, COORDINATOR:${x.COORDINATOR}, CLUSTER ID:${x.CLUSTER_ID}, NODE ID:${x.NODE_ID}, TYPE:${x.TYPE}, DATA TYPE:${x.DATA_TYPE}, EVENT ID:${x.EVENT_ID}, BATTERY LEVEL:${x.BAT_LVL}, SENSOR DATA:${x.SENSOR_DATA}`;
//     parent.appendChild(child);
//   });
// }








