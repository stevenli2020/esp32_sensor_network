var app = {};

var eventDOM = document.getElementById("events-chart");
var eventsChart = echarts.init(eventDOM);
var option;
var eventXaxis = [];
var eventYaxis = [];
function updateEvents(xData, yData) {
  eventXaxis = xData;
  eventYaxis = yData;
  option = {
    tooltip: {
      trigger: "axis",
      axisPointer: {
        type: "cross",
        label: {
          backgroundColor: "#283b56",
        },
      },
    },
    xAxis: [
      {
        type: "category",
        boundaryGap: true,
        data: eventXaxis,
        axisLabel: {
          show: false,
        },
        axisLine: {
          show: false,
        },
        axisTick: {
          show: false,
        },
      },
    ],
    yAxis: [
      {
        type: "value",
        scale: true,
        // max: 2048,
        min: 0,
        boundaryGap: [0.2, 0.2],
        splitLine: {
          show: false,
        },
        axisLabel: {
          show: false,
        },
      },
    ],
    series: [
      {
        type: "bar",
        // xAxisIndex: 1,
        // yAxisIndex: 1,
        data: eventYaxis,
        color: "white",
      },
    ],
  };

  option && eventsChart.setOption(option);
}
app.count = 5
function shiftEvents(time, val) {
  // console.log("events: "+time+" val: " + val)
  eventXaxis.shift();
  eventXaxis.push(time);
  eventYaxis.shift();
  eventYaxis.push(val);
  eventsChart.setOption({
    xAxis: [
      {
        data: eventXaxis,
      },
    ],
    series: [
      {
        data: eventYaxis,
      },
    ],
  });
}
