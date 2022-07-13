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

async function UpdateBar(time, sensorType){
  if(checkEl('Bar') != null){
    if(checkEl('lineChart')){
      removeEl('lineChart')
    }
  } else {
    if(checkEl('lineChart')){
      removeEl('lineChart')
    }
    createEl('Bar')
  }
  var barChart = echarts.init(document.getElementById("Bar"));
  seriesName = "Average Air Quality in 5 mins"
  label = "Average Air Quality"
  if(sensorType == "Air")
    label = "Average Air Quality"
  else if(sensorType == "Motion")
    label = "Total Detection"
  else
    label = "Average Trash Distance mm From Trash Cover"
  x = []
  y = []
  if(time == "1 Hour"){
    default_data = await API_Call("HOUR", sensorType, "1st Proto")
    seriesName = `${label} in 5 mins`
    axisLabel = AxisLabel(0, 40)
    if(default_data['CODE'] == 0)
      default_data['DATA'].forEach(d => {
        x.push(d['TIME'].slice(11, 16))
        y.push(Math.round(d['SENSOR_DATA']))
      });
  }    
  else if(time == "1 Day"){
    default_data = await API_Call("DAY", sensorType, "1st Proto")
    seriesName = `${label} in 30 mins`
    if(default_data['DATA']?.length > 30)
      axisLabel = AxisLabel(3, 30)
    else if(default_data['DATA']?.length > 13)
      axisLabel = AxisLabel(2, 30)
    else
      axisLabel = AxisLabel(0, 30)
    if(default_data['CODE'] == 0)
      default_data['DATA'].forEach(d => {
        x.push(d['TIME'].slice(0, 16))
        y.push(Math.round(d['SENSOR_DATA']))
      });
  }
  else if(time == "1 Week"){
    default_data = await API_Call("WEEK", sensorType, "1st Proto")
    seriesName = `${label} in 12 Hours`
    axisLabel = AxisLabel(1, 30);
    if(default_data['CODE'] == 0)
      default_data['DATA'].forEach(d => {
        x.push(d['TIME'].slice(0, 16))
        y.push(Math.round(d['SENSOR_DATA']))
      });
  }
  else if(time == "1 Month"){
    default_data = await API_Call("MONTH", sensorType, "1st Proto")
    seriesName = `${label} in 2 Days`
    axisLabel = AxisLabel(1, 30);
    if(default_data['CODE'] == 0)
      default_data['DATA'].forEach(d => {
        x.push(d['TIME'].slice(0, 10))
        y.push(Math.round(d['SENSOR_DATA']))
      });
  }
  else if(time == "1 Year"){
    default_data = await API_Call("YEAR", sensorType, "1st Proto")
    seriesName = `${label} in 30 Days`
    axisLabel = AxisLabel(0, 30);
    if(default_data['CODE'] == 0)
      default_data['DATA'].forEach(d => {
        x.push(d['TIME'].slice(0, 10))
        y.push(Math.round(d['SENSOR_DATA']))
      });
  }
  // else
    // default_data = await API_Call("DAY", "Air", "Female Toilet")

  
  
  // barChart.hideLoading();
  // console.log(default_data)
  // console.log(x, y)
  barChart.setOption({
    legend: {
      data: [seriesName]
    },
    yAxis: {},
    xAxis: {
      axisLabel: axisLabel,
      data: x
    },
    series: [
      {
        type: "bar",
        name: seriesName,
        data: y
      }
    ]
  })
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
