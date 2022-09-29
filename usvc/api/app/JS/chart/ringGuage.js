var chartDom = document.getElementById('ring-guage');
var ringGuage = echarts.init(chartDom);
var option;

ringGuage.showLoading();
const gaugeData = [
  {
    value: 20,
    name: 'Motion',
    title: {
      offsetCenter: ['0%', '-45%']
    },
    detail: {
      valueAnimation: true,
      offsetCenter: ['0%', '-30%']
    }
  },
  {
    value: 40,
    name: 'Air Quality',
    title: {
      offsetCenter: ['0%', '-15%']
    },
    detail: {
      valueAnimation: true,
      offsetCenter: ['0%', '0%']
    }
  },
  {
    value: 60,
    name: 'Distance %',
    title: {
      offsetCenter: ['0%', '15%']
    },
    detail: {
      valueAnimation: true,
      offsetCenter: ['0%', '30%']
    }
  }
];
option = {
  series: [
    {
      type: 'gauge',
      startAngle: 90,
      endAngle: -270,
      pointer: {
        show: false
      },
      progress: {
        show: true,
        overlap: false,
        roundCap: true,
        clip: false,
        itemStyle: {
          borderWidth: 1,
          borderColor: '#464646'
        }
      },
      axisLine: {
        lineStyle: {
          width: 20
        }
      },
      splitLine: {
        show: false,
        distance: 0,
        length: 10
      },
      axisTick: {
        show: false
      },
      axisLabel: {
        show: false,
        distance: 50
      },
      data: gaugeData,
      title: {
        fontSize: 10
      },
      detail: {
        width: 50,
        height: 8,
        fontSize: 10,
        color: 'inherit',
        // borderColor: 'inherit',
        // borderRadius: 10,
        // borderWidth: 1,
        formatter: '{value}'
      }
    }
  ]
};
// setInterval(function () {
//   gaugeData[0].value = +(Math.random() * 100).toFixed(2);
//   gaugeData[1].value = +(Math.random() * 100).toFixed(2);
//   gaugeData[2].value = +(Math.random() * 100).toFixed(2);
//   console.log(gaugeData)
//   ringGuage.setOption({
//     series: [
//       {
//         data: gaugeData,
//         pointer: {
//           show: false
//         }
//       }
//     ]
//   });
// }, 2000);
ringGuage.hideLoading();
option && ringGuage.setOption(option);