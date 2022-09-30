// updateLine('1 Hour')

async function updateLine(timeSelect, sensorName, sensorID) {
  // if (checkEl("lineChart") != null) {
  //   if (checkEl("Bar")) {
  //     removeEl("Bar");
  //   }
  // } else {
  //   if (checkEl("Bar")) {
  //     removeEl("Bar");
  //   }
  //   createEl("lineChart");
  // }
  if(checkEl("lineChart") != null){
    if(checkEl("Bar")){
      removeChildEl('chart-id')
    }
  } else {
    removeChildEl('chart-id')
    createChartEl('chart-id', 'lineChart')
  }
  var chartDom = document.getElementById("lineChart");
  var lineChart = echarts.init(chartDom);
  lineChart.showLoading();
  // var option;
  document.querySelector("#Close-button").click();
  today = getDate();
  // console.log(today)
  let sensorValue;
  // default_data = await API_Call("YEAR", "Air", sensorName)
  // data = default_data["DATA"]?default_data["DATA"]:null
  // console.log(data[data.length - 1]["BATT_PCT"])
  // updateBattery(data[data.length - 1]["BATT_PCT"])
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
      // console.log(data)
      sensorValue = data["DATA"] ? data["DATA"] : null;
      // console.log(sensorValue);
      updateBattery(sensorValue[sensorValue.length - 1]["BATT_PCT"]);
    })
    .catch((error) => console.log(error));
  // updateGuage("Air", sensorID);
  lineChart.hideLoading();
  lineChart.setOption(
    (option = {
      backgroundColor: '#0f375f',
      textStyle: {
        color: '#ccc'
      },
      title: {
        text: "Average Air Quality",
        left: "1%",
        textStyle: {
          color: "#ccc"
        }
      },
      tooltip: {
        trigger: "axis",
      },
      grid: {
        left: "5%",
        right: "15%",
        bottom: "10%",
      },
      xAxis: {
        data: sensorValue
          ? sensorValue.map(function (item) {
              return item["TIME"];
            })
          : null,
      },
      yAxis: {
        min: sensorValue
          ? Math.min(
              sensorValue.map(function (item) {
                return item["TIME"];
              })
            )
          : null,
      },
      toolbox: {
        right: 10,
        feature: {
          dataZoom: {
            yAxisIndex: "none",
          },
          restore: {},
          saveAsImage: {},
        },
      },
      dataZoom: [
        {
          // startValue: today + " 00:00:00"
        },
        {
          type: "inside",
        },
      ],
      visualMap: {
        top: 50,
        right: 10,
        textStyle: {
          color: "#ccc"
        },
        pieces: [
          {
            gt: 0,
            lte: 900,
            color: "#93CE07",
          },
          {
            gt: 900,
            lte: 1100,
            color: "#FBDB0F",
          },
          {
            gt: 1100,
            lte: 1200,
            color: "#FC7D02",
          },
          {
            gt: 1200,
            lte: 1400,
            color: "#FD0100",
          },
          {
            gt: 1400,
            lte: 1600,
            color: "#AA069F",
          },
          {
            gt: 1600,
            color: "#AC3B2A",
          },
        ],
        outOfRange: {
          color: "#999",
        },
      },
      series: {
        name: "Average Air Quality",
        type: "line",
        data: sensorValue
          ? sensorValue.map(function (item) {
              // console.log(Math.round(item["SENSOR_DATA"]))
              return Math.round(item["SENSOR_DATA"]);
            })
          : null,
        markLine: {
          silent: true,
          lineStyle: {
            color: "#ccc",
          },
          data: [
            {
              yAxis: 900,
            },
            {
              yAxis: 1100,
            },
            {
              yAxis: 1300,
            },
            {
              yAxis: 1500,
            },
            {
              yAxis: 1700,
            },
          ],
        },
      },
    })
  );
}
// lineChart.showLoading();

// option && lineChart.setOption(option);
