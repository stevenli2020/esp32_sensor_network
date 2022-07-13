var parent = document.getElementById("card");
var barChartTitle = document.getElementById("lineChartTitle");
var lineChart = document.getElementById("lineChart");
var barChart = document.getElementById("barChart");
// var AirQualityFemaleToiletlineChart = document.getElementById("#AirQ")
var MotionDetectionSensorForFemaleToiletBarChart = document.querySelectorAll("#motion-detection-sensor-for-female-toilet-barChart li")
var TrashBinSensorForFemaleToiletBarChart = document.querySelectorAll("#trash-bin-sensor-for-female-toilet-barChart li")
// AirQualityFemaleToiletlineChart.addEventListener('click', async (e) => {
//     document.querySelector("#Close-button").click();
//     updateLine("YEAR", "Air")
// })
    
MotionDetectionSensorForFemaleToiletBarChart.forEach((item, index) => {
    item.addEventListener('click', (e) => {
        // alert(`${e.currentTarget.innerHTML} item was click`);
        barChartTitle.innerHTML = "Female Toilet";
        document.querySelector("#Close-button").click();        
        let text = e.currentTarget.innerHTML
        if(text.includes("1 Hour")){
            UpdateBar("1 Hour", "Motion")
            // console.log("Sensor 1 HOUR")
        } else if(text.includes("1 Day")) {
            UpdateBar("1 Day", "Motion")
            // console.log("Sensor 1 DAY")
        } else if(text.includes("1 Week")) {
            UpdateBar("1 Week", "Motion")
            // console.log("Sensor 1 WEEK")
        } else if(text.includes("1 Month")) {
            UpdateBar("1 Month", "Motion")
            // console.log("Sensor 1 MONTH")
        } else if(text.includes("1 Year")) {
            UpdateBar("1 Year", "Motion")
            // console.log("Sensor 1 YEAR")
        } else {
            // UpdateBar("1 Hour", "Motion")
            // console.log("Sensor CUSTOM")
        }
    })
})
TrashBinSensorForFemaleToiletBarChart.forEach((item, index) => {
    item.addEventListener('click', async (e) => {
        // alert(`${e.currentTarget.innerHTML} item was click`);
        barChartTitle.innerHTML = "Female Toilet Trash Bin";
        document.querySelector("#Close-button").click();
        let text = e.currentTarget.innerHTML
        if(text.includes("1 Hour")){
            UpdateBar("1 Hour", "Trash")
        } else if(text.includes("1 Day")) {
            UpdateBar("1 Day", "Trash")

        } else if(text.includes("1 Week")) {
            UpdateBar("1 Week", "Trash")

        } else if(text.includes("1 Month")) {
            UpdateBar("1 Month", "Trash")

        } else if(text.includes("1 Year")) {
            UpdateBar("1 Year", "Trash")

        } else {
            // UpdateBar("1 Year", "Trash")

        }
    })
})
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
