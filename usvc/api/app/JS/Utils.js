async function API_Call(time, sensorType, location) {
  let response = [];
  let Rdata = {};
  action = "events";
  Rdata = {
    TIME: time,
    TYPE: sensorType,
    LOCATION: location
  };
  await fetch(`http://167.99.77.130/API/?act=${action}`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(Rdata),
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(data)
      // if(data["CODE"] == 0)
      // response = data["DATA"];      
      response = data;      
    })
    .catch((error) => {
      console.error("Error:", error);
    });
  // console.log(response);
  return response;
}

function AxisLabel(interval, rotate){
  return {interval, rotate}
}

const getDate = () => {
  const newDate = new Date();
  const year = newDate.getFullYear();
  const month = newDate.getMonth() + 1;
  const d = newDate.getDate();
  
  return `${year}-${month.toString().padStart(2, '0')}-${d.toString().padStart(2, '0')}`;
}

function checkEl(el){
  return document.getElementById(el)
}

function removeEl(el){
  var ele = document.getElementById(el)
  ele.remove()
}

function createEl(id){
  var con = document.getElementById("chartParent")
  var ele = document.createElement('div')
  ele.setAttribute('id', id)
  con.appendChild(ele)
}
