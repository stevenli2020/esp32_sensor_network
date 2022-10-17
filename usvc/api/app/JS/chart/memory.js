
var memoryDom = document.getElementById('memory-chart');
var memoryChart = echarts.init(memoryDom);
var option;

function updateMem(val){
  option = {
    series: [
      {
        type: 'gauge',
        min: 0,
        max: 2048,
        axisLine: {
          lineStyle: {
            width: 10,
            color: [
              [0.3, '#67e0e3'],
              [0.7, '#FFAB91'],
              [1, '#fd666d']
            ]
          }
        },
        pointer: {
          itemStyle: {
            color: 'auto'
          }
        },
        axisTick: {
          show: false
        },
        splitLine: {
          show: false
        },
        axisLabel: {
          show: false
        },
        detail: {
          show: false
        },
        data: [
          {
            value: val
          }
        ]
      }
    ]
  };  
  
  option && memoryChart.setOption(option);
}
