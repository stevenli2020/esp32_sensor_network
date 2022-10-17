

var cpuDom = document.getElementById('cpu-chart');
var cpuChart = echarts.init(cpuDom);
var option;

function updateCpu(val){
  option = {
    series: [
      {
        type: 'gauge',
        center: ['50%', '60%'],
        startAngle: 200,
        endAngle: -20,
        min: 0,
        max: 100,
        itemStyle: {
          color: '#FFAB91'
        },
        progress: {
          show: true,
          width: 10
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
  
  option && cpuChart.setOption(option);
}


