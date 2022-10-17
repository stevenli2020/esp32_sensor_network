
var app = {};

var ByteDOM = document.getElementById("bytes-chart");
var bytesChart = echarts.init(ByteDOM);
var option;
var byteXaxis = []
var byteYaxis = []
function updateByte(xData, YData){
  byteXaxis = xData
  byteYaxis = YData
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
        data: byteXaxis,
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
        max: 100,
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
        //   name: "Dynamic Line",
        type: "line",
        data: byteYaxis,
        color: 'white'
      },
    ],
  };
  option && bytesChart.setOption(option);
}

app.count = 5;
function shiftByte(time, val){
  // console.log("bytes: "+time+" val: " + val)
  byteXaxis.shift()
  byteXaxis.push(time)
  byteYaxis.shift()
  byteYaxis.push(val)
  bytesChart.setOption({
    xAxis : [
      {
        data: byteXaxis
      }
    ],
    series : [
      {
        data: byteYaxis
      }
    ]
  })
}
