var chartDom = document.getElementById('pie-chart');
var donut = echarts.init(chartDom);
var option;

donut.showLoading();
option = {
  tooltip: {
    trigger: 'item'
  },
  // legend: {
  //   show: false,
  //   top: '5%',
  //   left: 'left',
  //   itemWidth: 15,
  //   // fontSize: '10'
  // },
  series: [
    {
      name: 'Access From',
      type: 'pie',
      radius: ['40%', '70%'],
      avoidLabelOverlap: false,
      itemStyle: {
        borderRadius: 10,
        borderColor: '#fff',
        borderWidth: 2
      },
      label: {
        show: false,
        position: 'center'
      },
      emphasis: {
        label: {
          show: false,
          fontSize: '20',
          fontWeight: 'bold'
        }
      },
      labelLine: {
        show: false
      },
      data: [
        { value: 1048, name: 'Search Engine' },
        { value: 735, name: 'Direct' },
        { value: 580, name: 'Email' },
        { value: 484, name: 'Union Ads' },
        { value: 300, name: 'Video Ads' }
      ]
    }
  ]
};
donut.hideLoading();
option && donut.setOption(option);
