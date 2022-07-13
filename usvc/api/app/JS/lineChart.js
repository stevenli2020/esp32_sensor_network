updateLine()

async function updateLine () {
  if(checkEl('lineChart') != null){
    if(checkEl('Bar')){
      removeEl('Bar')
    }
  } else {
    if(checkEl('Bar')){
      removeEl('Bar')
    }
    createEl('lineChart')
  }
  var chartDom = document.getElementById('lineChart');
  var lineChart = echarts.init(chartDom);
  // var option;
  document.querySelector("#Close-button").click();
  today = getDate()
  console.log(today)
  default_data = await API_Call("YEAR", "Air", "1st Proto")
  data = default_data["DATA"]?default_data["DATA"]:null
  lineChart.hideLoading()
  lineChart.setOption(
    (option = {
      title: {
        text: 'Average Air Quality',
        left: '1%'
      },
      tooltip: {
        trigger: 'axis'
      },
      grid: {
        left: '5%',
        right: '15%',
        bottom: '10%'
      },
      xAxis: {
        data: data.map(function (item) {
          return item["TIME"];
        })
      },
      yAxis: {},
      toolbox: {
        right: 10,
        feature: {
          dataZoom: {
            yAxisIndex: 'none'
          },
          restore: {},
          saveAsImage: {}
        }
      },
      dataZoom: [
        {
          startValue: today + " 00:00:00"
        },
        {
          type: 'inside'
        }
      ],
      visualMap: {
        top: 50,
        right: 10,
        pieces: [
          {
            gt: 0,
            lte: 900,
            color: '#93CE07'
          },
          {
            gt: 900,
            lte: 950,
            color: '#FBDB0F'
          },
          {
            gt: 950,
            lte: 1000,
            color: '#FC7D02'
          },
          {
            gt: 1000,
            lte: 1100,
            color: '#FD0100'
          },
          {
            gt: 1100,
            lte: 1200,
            color: '#AA069F'
          },
          {
            gt: 1200,
            color: '#AC3B2A'
          }
        ],
        outOfRange: {
          color: '#999'
        }
      },
      series: {
        name: 'Average Air Quality',
        type: 'line',
        data: data.map(function (item) {
          return item["SENSOR_DATA"];
        }),
        markLine: {
          silent: true,
          lineStyle: {
            color: '#333'
          },
          data: [
            {
              yAxis: 900
            },
            {
              yAxis: 950
            },
            {
              yAxis: 1000
            },
            {
              yAxis: 1100
            },
            {
              yAxis: 1200
            }
          ]
        }
      }
    })
  );
}
// lineChart.showLoading();

// option && lineChart.setOption(option);
