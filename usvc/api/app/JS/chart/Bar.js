// Initialize the echarts instance based on the prepared dom

axisLabel = { interval: 0, rotate: 0 };
// if (window.innerWidth <= 600) {
//   axisLabel = { interval: 0, rotate: 30 };
// } else {
//   axisLabel = { interval: 0, rotate: 0 };
// }
// window.onresize = function () {
//   if (window.innerWidth <= 600) {
//     axisLabel = { interval: 0, rotate: 30 };
//   } else {
//     axisLabel = { interval: 0, rotate: 0 };
//   }
//   option = {
//     xAxis: {
//       axisLabel: axisLabel,
//     },
//   };
//   barChart.setOption(option);
//   barChart.resize();
// };
// UpdateBar("1 Hour", "Air")

async function UpdateBar(timeSelect, sensorName, sensorID, sensorType) {
  // console.log(timeSelect, sensorName, sensorID, sensorType)
  // if (checkEl("Bar") != null) {
  //   if (checkEl("lineChart")) {
  //     removeEl("lineChart");
  //   }
  // } else {
  //   if (checkEl("lineChart")) {
  //     removeEl("lineChart");
  //   }
  //   createEl("Bar");
  // }
  if(checkEl("Bar") != null){
    if(checkEl("lineChart")){
      removeChildEl('chart-id')
    }
  } else {
    removeChildEl('chart-id')
    createChartEl('chart-id', 'Bar')
  }
  document.querySelector("#Close-button").click();
  // updateGuage(sensorType, nodeName)
  var barChart = echarts.init(document.getElementById("Bar"));

  // label = "Average Air Quality";
  barChart.showLoading();
  seriesName = "Total Detection in 5 mins";
  if (sensorType == motion) {
    if (timeSelect == "HOUR") seriesName = "Total Detection in 5 mins";
    else if (timeSelect == "DAY") seriesName = "Total Detection in 30 mins";
    else if (timeSelect == "WEEK") seriesName = "Total Detection in 6 Hours";
    else seriesName = "Total Detection 1 Day";
    label = "Total Detection";
  } else {
    if (timeSelect == "HOUR") seriesName = "Avg Fill Levle in 5 mins";
    else if (timeSelect == "DAY") seriesName = "Avg Fill Levle in 30 mins";
    else if (timeSelect == "WEEK") seriesName = "Avg Fill Levle in 6 Hours";
    else seriesName = "Avg Fill Levle 1 Day";
    label = "Average Trash Distance mm From Trash Cover";
  }
  x = [];
  y = [];
  let rData = {
    TIME: timeSelect,
    SENSOR_NAME: sensorName,
    SENSOR_ID: sensorID,
  };
  Object.assign(rData, RequestData());
  await fetch(`${domain}API/?act=getEventData`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(rData),
  })
    .then((response) => response.json())
    .then((data) => {
      // console.log(data);
      sensorValue = data["DATA"] ? data["DATA"] : null;
      if (data.CODE == 0) {
        data.DATA.forEach((d) => {
          if (timeSelect == "HOUR") x.push(d["TIME"].slice(11, 16));
          else if (timeSelect == "DAY") x.push(d["TIME"].slice(11, 16));
          else if (timeSelect == "WEEK") x.push(d["TIME"].slice(5, 16));
          else x.push(d["TIME"].slice(5, 10));
          y.push(Math.round(d["SENSOR_DATA"]));
        });
      }
      // console.log(sensorValue);
      updateBattery(sensorValue?sensorValue[sensorValue.length - 1]["BATT_PCT"]:0);
    })
    .catch((error) => console.log(error));
  // if (timeSelect == "1 Hour") {
  //   default_data = await API_Call("HOUR", sensorType, nodeName);
  //   seriesName = `${label} in 5 mins`;
  //   // axisLabel = AxisLabel(0, 40);
  //   if (default_data["CODE"] == 0)
  //     default_data["DATA"].forEach((d) => {
  //       x.push(d["TIME"].slice(11, 16));
  //       y.push(Math.round(d["SENSOR_DATA"]));
  //     });
  // } else if (timeSelect == "1 Day") {
  //   default_data = await API_Call("DAY", sensorType, nodeName);
  //   seriesName = `${label} in 30 mins`;
  //   if (default_data["DATA"]?.length > 30) axisLabel = AxisLabel(3, 30);
  //   else if (default_data["DATA"]?.length > 13) axisLabel = AxisLabel(0, 50);
  //   else axisLabel = AxisLabel(0, 30);
  //   if (default_data["CODE"] == 0) {
  //     // updateBatt(default_data["DATA"][default_data["DATA"].length - 1]["BATT_PCT"])
  //     // updateBattery(default_data["DATA"][default_data["DATA"].length - 1]["BATT_PCT"])
  //     default_data["DATA"].forEach((d) => {
  //       x.push(d["TIME"].slice(11, 16));
  //       y.push(Math.round(d["SENSOR_DATA"]));
  //     });
  //   }
  // } else if (timeSelect == "1 Week") {
  //   default_data = await API_Call("WEEK", sensorType, nodeName);
  //   seriesName = `${label} in 6 Hours`;
  //   // axisLabel = AxisLabel(1, 30);
  //   if (default_data["CODE"] == 0) {
  //     // updateBatt(default_data["DATA"][default_data["DATA"].length - 1]["BATT_PCT"])
  //     // updateBattery(default_data["DATA"][default_data["DATA"].length - 1]["BATT_PCT"])
  //     default_data["DATA"].forEach((d) => {
  //       x.push(d["TIME"].slice(0, 16));
  //       y.push(Math.round(d["SENSOR_DATA"]));
  //     });
  //   }
  // } else if (timeSelect == "1 Month") {
  //   default_data = await API_Call("MONTH", sensorType, nodeName);
  //   seriesName = `${label} in 1 Days`;
  //   // axisLabel = AxisLabel(1, 30);
  //   if (default_data["CODE"] == 0) {
  //     // updateBatt(default_data["DATA"][default_data["DATA"].length - 1]["BATT_PCT"])
  //     // updateBattery(default_data["DATA"][default_data["DATA"].length - 1]["BATT_PCT"])
  //     default_data["DATA"].forEach((d) => {
  //       x.push(d["TIME"].slice(0, 10));
  //       y.push(Math.round(d["SENSOR_DATA"]));
  //     });
  //   }
  // } else if (timeSelect == "1 Year") {
  //   default_data = await API_Call("YEAR", sensorType, nodeName);
  //   seriesName = `${label} in 7 Days`;
  //   // axisLabel = AxisLabel(0, 30);
  //   if (default_data["CODE"] == 0) {
  //     // updateBatt(default_data["DATA"][default_data["DATA"].length - 1]["BATT_PCT"])
  //     // updateBattery(default_data["DATA"][default_data["DATA"].length - 1]["BATT_PCT"])
  //     default_data["DATA"].forEach((d) => {
  //       x.push(d["TIME"].slice(0, 10));
  //       y.push(Math.round(d["SENSOR_DATA"]));
  //     });
  //   }
  // }
  // else
  // default_data = await API_Call("DAY", "Air", "Female Toilet")

  // barChart.hideLoading();
  // console.log(default_data)
  // console.log(x, y)
  barChart.hideLoading();
  barChart.setOption({
    backgroundColor: "#0f375f",
    tooltip: {
      trigger: "axis",
      axisPointer: {
        type: "shadow",
      },
    },
    legend: {
      data: [seriesName, seriesName],
      textStyle: {
        color: "#ccc",
      },
    },
    yAxis: {
      splitLine: { show: false },
      axisLine: {
        lineStyle: {
          color: "#ccc",
        },
      },
    },
    xAxis: {
      // axisLabel: axisLabel,
      axisLine: {
        lineStyle: {
          color: "#ccc",
        },
      },
      data: x,
    },
    series: [
      {
        name: seriesName,
        type: "line",
        smooth: true,
        showAllSymbol: true,
        symbol: "emptyCircle",
        symbolSize: 10,
        data: y,
      },
      {
        name: seriesName,
        type: "bar",
        barWidth: 10,
        itemStyle: {
          borderRadius: 5,
          color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
            { offset: 0, color: "#14c8d4" },
            { offset: 1, color: "#43eec6" },
          ]),
        },
        data: y,
      },
      {
        name: seriesName,
        type: "bar",
        barGap: "-100%",
        barWidth: 10,
        itemStyle: {
          color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
            { offset: 0, color: "rgba(20,200,212,0.5)" },
            { offset: 0.2, color: "rgba(20,200,212,0.2)" },
            { offset: 1, color: "rgba(20,200,212,0)" },
          ]),
        },
        z: -12,
        data: y,
      },
    ],
  });
}

// Specify the configuration items and data for the chart
// default_data = await API_Call("HOUR", "Air", "Female Toilet")
// var option = {
//   title: {
//     text: "",
//   },
//   tooltip: {},
//   legend: {
//     data: ["Average Air Quality in 5 mins"],
//   },
//   xAxis: {
//     axisLabel: axisLabel,
//     // data: default_data["TIME"],
//     data: ["Shirts", "Cardigans", "Chiffons", "Pants", "Heels", "Socks"],
//   },
//   yAxis: {},
//   series: [
//     {
//       name: "sales",
//       type: "bar",
//       // data: default_data["SENSOR_DATA"],
//       data: [5, 20, 36, 10, 10, 20],
//     },
//   ],
// };

// // Display the chart using the configuration items and data just specified.
// barChart.showLoading();
// barChart.setOption(option);
