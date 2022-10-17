var chartDom = document.getElementById("line-item-chart");
var lineItemChart = echarts.init(chartDom);
var option;

option = {
  xAxis: {
    type: "category",
    data: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
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
  yAxis: {
    type: "value",
    min: 800,
    splitLine: {
      show: false,
    },
    axisLabel: {
      show: false,
    },
  },
  tooltip: {
    trigger: 'axis',
    axisPointer: {
      type: 'cross',
      label: {
        backgroundColor: '#6a7985'
      }
    }
  },
  series: [
    {
      data: [820, 2000, 900,2500, 880, 3000, 900],
      type: "line",
      smooth: true,
      color: 'white'
    },
  ],
};

option && lineItemChart.setOption(option);
