async function overAllStatic(){
    fetch(`${domain}API/?act=getOverallStatistics`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify(RequestData())
    })
    .then(response => response.json())
    .then(data => {
      // console.log(data)
      let pData=[];
      // let gData=[];
      // data.DATA.map(d => {
      //   Object.entries(d).forEach(entry => {
      //     const [key, value] = entry
      //     // console.log(key, value)
      //     if(key.includes("Past_Hour_Detection")){
      //       gaugeData[0].value = value??0;
      //     } else if(key.includes("Past_Hour_Avg_Air_Quality")){
      //       gaugeData[1].value = Math.round(value);
      //     } else if(key.includes("Past_Hour_Avg_Fill_Level")){
      //       gaugeData[2].value = Math.round(value)??0;
      //     } else 
      //       pData.push({value: Math.round(value), name: key.replaceAll('_', " ")})
      //   })
      // })
      // console.log(gaugeData)
      // ringGuage.setOption({
      //   series: [
      //     {
      //       data: gaugeData,
      //       pointer: {
      //         show: false
      //       }
      //     }
      //   ]
      // });
    
      // donut.setOption({
      //   tooltip:{
      //     position: ['50%', '50%']
      //   },
      //   legend:{
      //     show: false
      //   },
      //   series: [{
      //     name: 'Factilities',
      //     data: pData
      //   }]
      // })
    })
    .catch(error => console.log(error))
  }
  overAllStatic()
  setInterval(overAllStatic, 60000)


  // fetch(`${domain}API/?act=getLocationss`, {
//   method: "POST",
//   headers: {
//     "Content-Type": "application/json"
//   },
//   body: JSON.stringify(RequestData())
// })
// .then((response) => response.json())
// .then(data => {
//   console.log(data)
// })
// .catch(error => console.log(error))
// fetch(`${domain}API/?act=getTotalDetection`, {
//   method: "POST",
//   headers: {
//     "Content-Type": "application/json",
//   },
//   body: JSON.stringify({ VALUE: "" }),
// })
//   .then((response) => response.json())
//   .then((data) => {
//     // console.log(data)
//     var t = new Date();
//     var date = t.getFullYear() + "/" + (t.getMonth() + 1) + "/" + t.getDate();
//     if (data["CODE"] == 0) {
//       totalCount.innerHTML = convertToInternationalCurrencySystem(
//         data["DATA"][0].TOTAL_DETECTION
//       );
//       upToday.innerHTML = "up to " + date;
//       dCount.innerHTML = convertToInternationalCurrencySystem(
//         data["DATA"][1].DAY_DETECTION
//       );
//       let dPercent = getPercentageIncrease(
//         parseInt(data["DATA"][1].DAY_DETECTION),
//         parseInt(data["DATA"][2].PERCENT_DAY_DETECTION)
//       );
//       let upArrow = '<i class="fa fa-sort-asc green">';
//       let downArrow = '<i class="fa fa-sort-desc red">';
//       let arrowIcon = dPercent < 0 ? downArrow : upArrow;
//       dChange.innerHTML = `${arrowIcon}<span style="font-family: Helvetica Neue,Roboto,Arial,Droid Sans,sans-serif;">&nbsp;${dPercent}%<span></span></span></i>`;
//       wCount.innerHTML = convertToInternationalCurrencySystem(
//         data["DATA"][3].WEEK_DETECTION
//       );
//       let wPercent = getPercentageIncrease(
//         parseInt(data["DATA"][3].WEEK_DETECTION),
//         parseInt(data["DATA"][4].PERCENT_WEEK_DETECTION)
//       );
//       arrowIcon = wPercent < 0 ? downArrow : upArrow;
//       wChange.innerHTML = `${arrowIcon}<span style="font-family: Helvetica Neue,Roboto,Arial,Droid Sans,sans-serif;">&nbsp;${wPercent}%<span></span></span></i>`;
//       mCount.innerHTML = convertToInternationalCurrencySystem(
//         data["DATA"][5].MONTH_DETECTION
//       );
//       let mPercent = getPercentageIncrease(
//         parseInt(data["DATA"][5].MONTH_DETECTION),
//         parseInt(data["DATA"][6].PERCENT_MONTH_DETECTION)
//       );
//       arrowIcon = mPercent < 0 ? downArrow : upArrow;
//       mChange.innerHTML = `${arrowIcon}<span style="font-family: Helvetica Neue,Roboto,Arial,Droid Sans,sans-serif;">&nbsp;${mPercent}%<span></span></span></i>`;
//       qCount.innerHTML = convertToInternationalCurrencySystem(
//         data["DATA"][7].QUARTER_DETECTION
//       );
//       let qPercent = getPercentageIncrease(
//         parseInt(data["DATA"][7].QUARTER_DETECTION),
//         parseInt(data["DATA"][8].PERCENT_QUARTER_DETECTION)
//       );
//       arrowIcon = qPercent < 0 ? downArrow : upArrow;
//       qChange.innerHTML = `${arrowIcon}<span style="font-family: Helvetica Neue,Roboto,Arial,Droid Sans,sans-serif;">&nbsp;${qPercent}%<span></span></span></i>`;
//     }
//   })
//   .catch((error) => {
//     console.error("Error:", error);
//   });

// autocomplete(facName, countries);

// fetch('https://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&key=AIzaSyD0sYUSro6h_goOpkpnPYRnwI70B_cY4vo', { method: "GET"}).then(response => response.json()).then(data => console.log(data))


// async function registerNewNode() {
//   registerSubmitBtn.disabled = true;
//   facName.style.border = "1px solid #ced4da";
//   MAC.style.border = "1px solid #ced4da";
//   clusterID.style.border = "1px solid #ced4da";
//   nameError.innerHTML = "";
//   macError.innerHTML = "";
//   clusterError.innerHTML = "";
//   RData = {
//     NAME: facName.value,
//     MAC: MAC.value,
//     CLUSTER_ID: clusterID.value,
//     ADDR: addressNode.value,
//     LATITUDE: latitudeNode.value,
//     LONGITUDE: longitudeNode.value,
//     DESCRPTIONS: descriptionsNode.value,
//   };
//   // console.log(RData)
//   await fetch(`${domain}API/?act=addFacility`, {
//     method: "POST",
//     headers: {
//       "Content-Type": "application/json",
//     },
//     body: JSON.stringify(RData),
//   })
//     .then((response) => response.json())
//     .then((data) => {
//       registerSubmitBtn.disabled = false;
//       // console.log(data)
//       if (data["CODE"] == -1) {
//         if (data["MESSAGE"].length > 0) {
//           nameError.innerHTML = data["MESSAGE"].filter((val) =>
//             val.includes("Name")
//           );
//           macError.innerHTML = data["MESSAGE"].filter((val) =>
//             val.includes("MAC")
//           );
//           clusterError.innerHTML = data["MESSAGE"].filter((val) =>
//             val.includes("Cluster")
//           );
//           if (
//             data["MESSAGE"].filter((val) => val.includes("Name")).length > 0
//           ) {
//             facName.style.border = "1px solid red";
//           }
//           if (data["MESSAGE"].filter((val) => val.includes("MAC")).length > 0) {
//             // console.log('here', data['MESSAGE'].filter(val => val.includes('MAC')))
//             MAC.style.border = "1px solid red";
//           }
//           if (
//             data["MESSAGE"].filter((val) => val.includes("Cluster")).length > 0
//           ) {
//             // console.log('here', data['MESSAGE'].filter(val => val.includes('MAC')))
//             clusterID.style.border = "1px solid red";
//           }
//         }
//       }
//       if (data["CODE"] == 0) {
//         facName.value = "";
//         MAC.value = "";
//         CLUSTER_ID.value = "";
//         addressNode.value = "";
//         latitudeNode.value = "";
//         longitudeNode.value = "";
//         descriptionsNode.value = "";
//         document.querySelector("#register-close-btn").click();
//       }
//     })
//     .catch((error) => {
//       console.error("Error:", error);
//     });
// }