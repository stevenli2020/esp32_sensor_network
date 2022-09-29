// updateBatt(10)
async function updateGuage(sensorType, nodeName) {
  // console.log(nodeName)
  var chartDom = document.getElementById("battGuage");
  var myChart = echarts.init(chartDom);
  var option, sensorData, battData = 0

  default_data = await API_Call("REAL", sensorType, nodeName);
  valColor = "#FFAB91"
  if (default_data["CODE"] == 0){
    default_data = default_data['DATA'][0];
    sensorData = default_data['SENSOR_DATA']
    // console.log(default_data[0]['BATT_PCT'])
    updateBattery(default_data['BATT_PCT']?default_data['BATT_PCT']:0)
    if(sensorData < 901)
      valColor = "#93CE07"
    else if(sensorData < 951)
      valColor = '#FBDB0F'
    else if(sensorData < 1001)
      valColor = '#FC7D02'
    else if(sensorData < 1101)
      valColor = '#FD0100'
    else if(sensorData < 1201)
      valColor = '#AA069F'
    else
      valColor = '#AC3B2A'
  } else {
    default_data = null
    updateBattery(0)
  }
    
  
  
  option = {
    series: [
      {
        type: "gauge",
        center: ["50%", "60%"],
        startAngle: 200,
        endAngle: -20,
        min: 0,
        max: sensorData?sensorData:100,
        splitNumber: 10,
        itemStyle: {
          color: valColor,
        },
        progress: {
          show: true,
          width: 30,
        },
        pointer: {
          show: false,
        },
        axisLine: {
          lineStyle: {
            width: 30,
          },
        },
        axisTick: {
          distance: -45,
          splitNumber: 5,
          lineStyle: {
            width: 2,
            color: "#999",
          },
        },
        splitLine: {
          distance: -52,
          length: 14,
          lineStyle: {
            width: 3,
            color: "#999",
          },
        },
        axisLabel: {
          distance: -10,
          color: "#999",
          fontSize: 15,
        },
        anchor: {
          show: false,
        },
        title: {
          show: true,
        },
        detail: {
          valueAnimation: true,
          width: "60%",
          lineHeight: 40,
          borderRadius: 8,
          offsetCenter: [0, "-15%"],
          fontSize: 35,
          fontWeight: "bolder",
          formatter: "{value}",
          color: "auto",
        },
        data: [
          {
            value: sensorData?sensorData:0,
            name: "Real Time"
          },
        ],
      }
    ],
  }; 

  option && myChart.setOption(option);
}
