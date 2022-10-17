// const domain = 'http://167.99.77.130/'

// console.log(nodeName)
// if(window.location.href.includes("=")){
  
// }
// update userform modal
const fullNameUpdate = document.getElementById('fullname-update')
const userNameUpdate = document.getElementById('username-update')
const emailUpdate = document.getElementById('email-update')
const phNumberUpdate = document.getElementById('phone-number-update')
const modalFooter = document.getElementById('modal-footer')
const updateUserForm = document.getElementById("updateUserForm");
const updateXBtn = document.getElementById("update-user-X-btn");
const updateUserFileBtn = document.getElementById("update-user-file-btn");

function getRandomInt (min, max) {
  return Math.floor(Math.random() * (max - min + 1)) + min;
}

function getNodeName() {
  let nodeName = document.location.href;
  nodeName = nodeName?.split("&");
  return nodeName[1]?.replace("%20", " ");
}

async function API_Call(time, sensorType, location) {
  let response = [];
  let Rdata = {};
  action = "events";
  Rdata = {
    TIME: time,
    TYPE: sensorType,
    LOCATION: location,
  };
  Object.assign(Rdata, RequestData());

  await fetch(`${domain}API/?act=${action}`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(Rdata),
  })
    .then((response) => response.json())
    .then((data) => {
      // console.log(data)
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

function AxisLabel(interval, rotate) {
  return { interval, rotate };
}

const getDate = () => {
  const newDate = new Date();
  const year = newDate.getFullYear();
  const month = newDate.getMonth() + 1;
  const d = newDate.getDate();

  return `${year}-${month.toString().padStart(2, "0")}-${d
    .toString()
    .padStart(2, "0")}`;
};

function checkEl(el) {
  return document.getElementById(el);
}

function removeEl(el) {
  var ele = document.getElementById(el);
  ele.remove();
}

function insertAfter(newNode, referenceNode) {
  referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
}

function createEl(id) {
  var con = document.getElementById("battGuage");
  var ele = document.createElement("div");
  ele.setAttribute("id", id);
  con.parentNode.insertBefore(ele, con.previousSibling);
  // insertAfter(ele, con)
}

function createChartEl(parentId, chartId){
  let parentEl = document.getElementById(parentId)
  let ele = document.createElement('div')
  ele.setAttribute("id", chartId);
  parentEl.appendChild(ele)
}

function offcanvasHomeliCreate(parentId, liInput) {
  var parentId = document.getElementById(parentId);
  var li = document.createElement("li");
  var aLink = document.createElement("a");
  li.setAttribute("class", "nav-item");
  aLink.setAttribute("class", "nav-link");

  if (liInput == "Home") {
    aLink.setAttribute("href", "/");
    aLink.innerHTML = '<i class="fa-solid fa-house-chimney"></i> Home';
  } else if (liInput == "Dash Board") {
    aLink.setAttribute("href", "/dashBoard/");
    aLink.innerHTML = '<i class="fa-solid fa-chart-line"></i> Dash Board';
  }

  parentId.appendChild(li);
  li.appendChild(aLink);
}

function offcanvasliCreate(
  parentId,
  El1,
  El2,
  El1Cl,
  El2Cl,
  El1Id,
  El2Id,
  role,
  onclickF,
  toggle,
  target,
  html
) {
  var parentId = document.getElementById(parentId);
  var li = document.createElement(El1);
  var aLink = document.createElement(El2);
  li.setAttribute("class", El1Cl);
  li.setAttribute("id", El1Id);
  aLink.setAttribute("class", El2Cl);
  aLink.setAttribute("id", El2Id);
  aLink.setAttribute("onclick", onclickF);
  aLink.setAttribute("role", role);
  aLink.setAttribute("data-bs-toggle", toggle);
  aLink.setAttribute("data-bs-target", target);
  aLink.innerHTML = html;
  parentId.appendChild(li);
  li.appendChild(aLink);
  if (toggle == "dropdown") {
    var ul = document.createElement("ul");
    var hourli = document.createElement("li");
    var dayli = document.createElement("li");
    var weekli = document.createElement("li");
    var monthli = document.createElement("li");
    // var yearli = document.createElement("li");
    ul.setAttribute("class", "dropdown-menu");
    hourli.innerHTML = '<a class="dropdown-item">1 Hour</a>';
    hourli.setAttribute(
      "onclick",
      `chartTimeSelect("HOUR", '${curPage[0]}', '${curPage[1]}', '${curPage[2]}')`
    );
    dayli.innerHTML = '<a class="dropdown-item">1 Day</a>';
    dayli.setAttribute(
      "onclick",
      `chartTimeSelect("DAY", '${curPage[0]}', '${curPage[1]}', '${curPage[2]}')`
    );
    dayli.setAttribute("type", "button");
    weekli.setAttribute(
      "onclick",
      `chartTimeSelect("WEEK", '${curPage[0]}', '${curPage[1]}', '${curPage[2]}')`
    );
    weekli.setAttribute("type", "button");
    monthli.setAttribute(
      "onclick",
      `chartTimeSelect("MONTH", '${curPage[0]}', '${curPage[1]}', '${curPage[2]}')`
    );
    monthli.setAttribute("type", "button");
    // yearli.setAttribute(
    //   "onclick",
    //   `UpdateBar("1 Year", "Motion", "${nodeName}")`
    // );
    // yearli.setAttribute("type", "button");
    weekli.innerHTML = '<a class="dropdown-item">1 Week</a>';
    monthli.innerHTML = '<a class="dropdown-item">1 Month</a>';
    // yearli.innerHTML = '<a class="dropdown-item">1 Year</a>';
    li.appendChild(ul);
    ul.appendChild(hourli);
    ul.appendChild(dayli);
    ul.appendChild(weekli);
    ul.appendChild(monthli);
    // ul.appendChild(yearli);
  }
}

function isImage(url) {
  return /\.(jpg|jpeg|png|webp|avif|gif|svg)$/.test(url);
}

function offcanvasChildElRemove(parentId) {
  const offcanvasEl = document.getElementById(parentId);
  while (offcanvasEl.firstChild) {
    offcanvasEl.removeChild(offcanvasEl.lastChild);
  }
}

function appendChildEl(parentId, el, elType, elCl, elId, html) {
  var parentEl = document.getElementById(parentId);
  var element = document.createElement(el);
  element.setAttribute("type", elType);
  element.setAttribute("class", elCl);
  element.setAttribute("id", elId);
  element.innerHTML = html;
  parentEl.appendChild(element);
}

function createFacilitiesList(parentId, UID, elAId, imgSrc, header, Addr=null, Type=null) {
  // console.log(parentId, UID, elAId, imgSrc, header, Addr, Type)
  var parentEl = document.getElementById(parentId);
  let aEl = document.createElement("a");
  let firstDiv = document.createElement("div");
  let image = document.createElement("img");
  let secondDiv = document.createElement("div");
  let thirdDiv = document.createElement("div");
  let title = document.createElement("h4");
  let desc = document.createElement("p");
  
  
  // aEl.setAttribute("href", elAhref);
  // aEl.setAttribute("href", '');
  aEl.setAttribute("class", "list-group-item list-group-item-action");
  aEl.setAttribute("id", elAId);
  firstDiv.setAttribute("class", "row");
  // firstDiv.addEventListener('click', e => {
  //   console.log(e.target)
  //   if(e.target.type == "button"){
  //     updateBtn.onclick = function(){facUpdate(header)}
  //   } else if(e.srcElement.id == "fac-image" || e.srcElement.id == "fac-list"){
  //     aEl.setAttribute('href', elAhref)
  //   }
  // })
  // firstDiv.setAttribute('onclick', 'goToDetails()')
  image.setAttribute("src", imgSrc ?? "https://picsum.photos/200");
  image.setAttribute("class", "col-4");
  image.setAttribute('style', 'object-fit: cover;')
  image.setAttribute("id", "fac-image");
  secondDiv.setAttribute("class", "col-8");
  secondDiv.setAttribute("id", "fac-list");
  thirdDiv.setAttribute("class", "justify-content-between");
  
  title.innerHTML = header;
  desc.setAttribute("class", "mb-1");
  desc.innerHTML = Addr;
  
  parentEl.appendChild(aEl);
  aEl.appendChild(firstDiv);
  firstDiv.appendChild(image);
  firstDiv.appendChild(secondDiv);
  secondDiv.appendChild(thirdDiv);
  thirdDiv.appendChild(title);
  thirdDiv.appendChild(desc);
  if(getCookie('TYPE') == 1){
    let updateBtn = document.createElement('button');
    let deleteBtn = document.createElement('button');
    if(Addr != null){
      updateBtn.setAttribute('onclick', `facUpdate('${header}')`)
      deleteBtn.setAttribute('onclick', `facDelete('${header}', '${UID}')`)
      updateBtn.setAttribute('style', 'position: absolute;right: 45px; top: 2%;')
      deleteBtn.setAttribute('style', 'position: absolute;right: 0%; top: 2%;')
      
    } else if(imgSrc == null){
      updateBtn.setAttribute('onclick', `sensorUpdate('${header}', '${UID}')`)
      deleteBtn.setAttribute('onclick', `sensorDelete('${header}', '${UID}')`)
      updateBtn.setAttribute('style', 'position: absolute;right: 45px; bottom: 2%;')
      deleteBtn.setAttribute('style', 'position: absolute;right: 0%; bottom: 2%;')
      // console.log(Type, Type == air, Type == motion, Type == distance)           
      
    }
    else {
      updateBtn.setAttribute('onclick', `locUpdate('${header}', '${UID}')`)
      deleteBtn.setAttribute('onclick', `locDelete('${header}', '${UID}')`)
      updateBtn.setAttribute('style', 'position: absolute;right: 45px; bottom: 2%;')
      deleteBtn.setAttribute('style', 'position: absolute;right: 0%; bottom: 2%;')
      
    }    
      
    updateBtn.setAttribute('type', 'button')
    updateBtn.setAttribute('class', 'btn btn-info')
      
    updateBtn.innerHTML = '<i class="fa-solid fa-file-pen"></i>'
    updateBtn.style.margin = '1px'
    
    deleteBtn.setAttribute('type', 'button')
    deleteBtn.setAttribute('class', 'btn btn-danger')
    
    // deleteBtn.setAttribute('id', UID)
    deleteBtn.innerHTML = '<i class="fa-solid fa-trash"></i>'
    deleteBtn.style.margin = '1px'
    aEl.appendChild(updateBtn);
    aEl.appendChild(deleteBtn);
  }
  if(Addr != null){
    title.setAttribute("class", "mb-1");
  } else {
    title.setAttribute("class", "mt-3");
  }
  firstDiv.setAttribute("id", Type);
  if(imgSrc == null && Type != null){    
    // console.log('here')
    if(Type == air){
      image.setAttribute("src", "https://www.develcoproducts.com/media/1675/air_q_sensor_hd_web.png");
    } else if (Type == motion){
      image.setAttribute("src", "https://images.squarespace-cdn.com/content/v1/58fb28d7e3df282054f72a55/5aa7b43e-6e3e-4571-b25e-388070332498/philips-hue-motion-sensor.jpg");
    } else {
      image.setAttribute("src", "https://terabee.b-cdn.net/wp-content/uploads/2019/04/2-teraranger-evo-60m-long-range-object-deteection-sensor.jpg");
    }
  }
  
}

// function goToDetails(){
//   console.log('details')
// }



function moblieCheck() {
  let check = false;
  (function (a) {
    if (
      /(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(
        a
      ) ||
      /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(
        a.substr(0, 4)
      )
    )
      check = true;
  })(navigator.userAgent || navigator.vendor || window.opera);
  return check;
}

function mobileAndTabletCheck() {
  let check = false;
  (function (a) {
    if (
      /(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(
        a
      ) ||
      /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(
        a.substr(0, 4)
      )
    )
      check = true;
  })(navigator.userAgent || navigator.vendor || window.opera);
  return check;
}

var originalRation = window.innerHeight + window.innerWidth;
let keyboardIsProbablyOpen = false;
// window.addEventListener("resize", function() {
//   // console.log('working')
//   if(window.innerWidth + window.innerHeight < originalRation){
//     // console.log(true)
//     keyboardIsProbablyOpen = true;
//   }
//   else
//     keyboardIsProbablyOpen = false;
// });

function convertToInternationalCurrencySystem(labelValue) {
  // Nine Zeroes for Billions
  return Math.abs(Number(labelValue)) >= 1.0e9
    ? (Math.abs(Number(labelValue)) / 1.0e9).toFixed(2) + "G"
    : // Six Zeroes for Millions
    Math.abs(Number(labelValue)) >= 1.0e6
    ? (Math.abs(Number(labelValue)) / 1.0e6).toFixed(2) + "M"
    : // Three Zeroes for Thousands
    Math.abs(Number(labelValue)) >= 1.0e3
    ? (Math.abs(Number(labelValue)) / 1.0e3).toFixed(2) + "K"
    : Math.abs(Number(labelValue));
}

function getPercentageIncrease(numA, numB) {
  return Math.round(((numA - numB) / numB) * 100);
}

updateXBtn.addEventListener('click', e => {
  updateUserForm.classList.remove('show');
  updateUserForm.setAttribute('style', 'display: none;')
  updateUserForm.removeAttribute('aria-modal')
  updateUserForm.removeAttribute('role')
  updateUserForm.setAttribute('aria-hidden', 'true')
  fullNameUpdate.readOnly = true
  userNameUpdate.readOnly = true
  emailUpdate.readOnly = true
  phNumberUpdate.readOnly = true  
  updateUserFileBtn.disabled = false
  fullNameUpdate.classList.remove('form-control')
  userNameUpdate.classList.remove('form-control')
  emailUpdate.classList.remove('form-control')
  phNumberUpdate.classList.remove('form-control')
  fullNameUpdate.classList.add('form-control-plaintext')
  userNameUpdate.classList.add('form-control-plaintext')
  emailUpdate.classList.add('form-control-plaintext')
  phNumberUpdate.classList.add('form-control-plaintext')
  removeChildEl('modal-footer')
})

async function userDetail(userName){
  document.querySelector("#Close-button").click()   
  fullNameUpdate.value = '' 
  userNameUpdate.value = '' 
  phNumberUpdate.value = '' 
  emailUpdate.value = ''   
  updateUserForm.setAttribute('class', 'modal fade show')
  updateUserForm.setAttribute('style', 'display: block;')
  updateUserForm.setAttribute('aria-modal', 'true');
  updateUserForm.setAttribute('role', 'dialog');
  updateUserForm.removeAttribute('aria-hidden');
  await fetch(`${domain}API/?act=getUser`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(RequestData()),
  })
  .then((response) => response.json())
  .then((data) => {
    // console.log(data)
    if(data.CODE == 0){
      fullNameUpdate.value = data.DATA[0].DISPLAY_NAME
      userNameUpdate.value = data.DATA[0].LOGIN_NAME
      emailUpdate.value = data.DATA[0].EMAIL
      phNumberUpdate.value = data.DATA[0].PHONE
      userNameUpdate.setAttribute('uid', data.DATA[0].ID)
    }
  })
  .catch((error) => {
    console.error("Error:", error);
  });
}

function removeReadOnly(){  
  var btn = document.createElement('button')
  updateUserFileBtn.disabled = true
  fullNameUpdate.removeAttribute('readonly')
  userNameUpdate.removeAttribute('readonly')
  emailUpdate.removeAttribute('readonly')
  phNumberUpdate.removeAttribute('readonly')
  fullNameUpdate.classList.remove('form-control-plaintext')
  userNameUpdate.classList.remove('form-control-plaintext')
  emailUpdate.classList.remove('form-control-plaintext')
  phNumberUpdate.classList.remove('form-control-plaintext')
  fullNameUpdate.classList.add('form-control')
  userNameUpdate.classList.add('form-control')
  emailUpdate.classList.add('form-control')
  phNumberUpdate.classList.add('form-control')
  btn.setAttribute('class', 'btn btn-primary')
  btn.setAttribute('onclick', 'updateNewUser()')
  btn.setAttribute('id', 'user-update-submit-btn')
  btn.innerText = "Update"
  modalFooter.appendChild(btn)
}

async function updateNewUser(){
  reData = {
    LOGIN_NAME: userNameUpdate.value,
    DISPLAY_NAME: fullNameUpdate.value,
    EMAIL: emailUpdate.value,
    PHONE: phNumberUpdate.value,
    ID: userNameUpdate.getAttribute('uid')
  }
  // console.log(reData)
  Object.assign(reData, RequestData())
  await fetch(`${domain}API/?act=updateUserInfo`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(reData),
  })
  .then((response) => response.json())
  .then((data) => {
    // console.log(data)
    if(data.CODE == 0){
      document.querySelector('#update-user-X-btn').click()
    }
  })
  .catch((error) => {
    console.error("Error:", error);
  });
}

// function autocomplete(inp, arr) {
//   /*the autocomplete function takes two arguments,
//   the text field element and an array of possible autocompleted values:*/
//   var currentFocus;
//   /*execute a function when someone writes in the text field:*/
//   inp.addEventListener("input", function (e) {
//     var a,
//       b,
//       i,
//       val = this.value;
//     /*close any already open lists of autocompleted values*/
//     closeAllLists();
//     if (!val) {
//       return false;
//     }
//     currentFocus = -1;
//     /*create a DIV element that will contain the items (values):*/
//     a = document.createElement("DIV");
//     a.setAttribute("id", this.id + "autocomplete-list");
//     a.setAttribute("class", "autocomplete-items");
//     /*append the DIV element as a child of the autocomplete container:*/
//     this.parentNode.appendChild(a);
//     /*for each item in the array...*/
//     for (i = 0; i < arr.length; i++) {
//       /*check if the item starts with the same letters as the text field value:*/
//       if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
//         /*create a DIV element for each matching element:*/
//         b = document.createElement("DIV");
//         /*make the matching letters bold:*/
//         b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
//         b.innerHTML += arr[i].substr(val.length);
//         /*insert a input field that will hold the current array item's value:*/
//         b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
//         /*execute a function when someone clicks on the item value (DIV element):*/
//         b.addEventListener("click", function (e) {
//           /*insert the value for the autocomplete text field:*/
//           inp.value = this.getElementsByTagName("input")[0].value;
//           /*close the list of autocompleted values,
//               (or any other open lists of autocompleted values:*/
//           closeAllLists();
//         });
//         a.appendChild(b);
//       }
//     }
//   });
//   /*execute a function presses a key on the keyboard:*/
//   inp.addEventListener("keydown", function (e) {
//     var x = document.getElementById(this.id + "autocomplete-list");
//     if (x) x = x.getElementsByTagName("div");
//     if (e.keyCode == 40) {
//       /*If the arrow DOWN key is pressed,
//         increase the currentFocus variable:*/
//       currentFocus++;
//       /*and and make the current item more visible:*/
//       addActive(x);
//     } else if (e.keyCode == 38) {
//       //up
//       /*If the arrow UP key is pressed,
//         decrease the currentFocus variable:*/
//       currentFocus--;
//       /*and and make the current item more visible:*/
//       addActive(x);
//     } else if (e.keyCode == 13) {
//       /*If the ENTER key is pressed, prevent the form from being submitted,*/
//       e.preventDefault();
//       if (currentFocus > -1) {
//         /*and simulate a click on the "active" item:*/
//         if (x) x[currentFocus].click();
//       }
//     }
//   });
//   function addActive(x) {
//     /*a function to classify an item as "active":*/
//     if (!x) return false;
//     /*start by removing the "active" class on all items:*/
//     removeActive(x);
//     if (currentFocus >= x.length) currentFocus = 0;
//     if (currentFocus < 0) currentFocus = x.length - 1;
//     /*add class "autocomplete-active":*/
//     x[currentFocus].classList.add("autocomplete-active");
//   }
//   function removeActive(x) {
//     /*a function to remove the "active" class from all autocomplete items:*/
//     for (var i = 0; i < x.length; i++) {
//       x[i].classList.remove("autocomplete-active");
//     }
//   }
//   function closeAllLists(elmnt) {
//     /*close all autocomplete lists in the document,
//     except the one passed as an argument:*/
//     var x = document.getElementsByClassName("autocomplete-items");
//     for (var i = 0; i < x.length; i++) {
//       if (elmnt != x[i] && elmnt != inp) {
//         x[i].parentNode.removeChild(x[i]);
//       }
//     }
//   }
//   /*execute a function when someone clicks in the document:*/
//   document.addEventListener("click", function (e) {
//     closeAllLists(e.target);
//   });
// }

function removeChildEl(parentId){
  let parent = document.getElementById(parentId)
  while(parent.hasChildNodes()){
    parent.removeChild(parent.firstChild)
  }
}

function isImage(url) {
  return /\.(jpg|jpeg|png|webp|avif|gif|svg)$/.test(url);
}

/* jquery.color.js plugin */ (function (a, e) {
  var o = "backgroundColor borderBottomColor borderLeftColor borderRightColor borderTopColor color columnRuleColor outlineColor textDecorationColor textEmphasisColor",
  n = /^([\-+])=\s*(\d+\.?\d*)/,
  m = [{
      re: /rgba?\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*(?:,\s*(\d?(?:\.\d+)?)\s*)?\)/,
      parse: function (a) {
          return [a[1], a[2], a[3], a[4]]
      }
  }, {
      re: /rgba?\(\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*(?:,\s*(\d?(?:\.\d+)?)\s*)?\)/,
      parse: function (a) {
          return [a[1] * 2.55, a[2] * 2.55, a[3] * 2.55, a[4]]
      }
  }, {
      re: /#([a-f0-9]{2})([a-f0-9]{2})([a-f0-9]{2})/,
      parse: function (a) {
          return [parseInt(a[1], 16), parseInt(a[2], 16), parseInt(a[3], 16)]
      }
  }, {
      re: /#([a-f0-9])([a-f0-9])([a-f0-9])/,
      parse: function (a) {
          return [parseInt(a[1] + a[1], 16), parseInt(a[2] + a[2], 16), parseInt(a[3] + a[3], 16)]
      }
  }, {
      re: /hsla?\(\s*(\d+(?:\.\d+)?)\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*(?:,\s*(\d?(?:\.\d+)?)\s*)?\)/,
      space: "hsla",
      parse: function (a) {
          return [a[1], a[2] / 100, a[3] / 100, a[4]]
      }
  }],
  b = a.Color = function (c, d, e, b) {
      return new a.Color.fn.parse(c, d, e, b)
  }, d = {
      rgba: {
          props: {
              red: {
                  idx: 0,
                  type: "byte"
              },
              green: {
                  idx: 1,
                  type: "byte"
              },
              blue: {
                  idx: 2,
                  type: "byte"
              }
          }
      },
      hsla: {
          props: {
              hue: {
                  idx: 0,
                  type: "degrees"
              },
              saturation: {
                  idx: 1,
                  type: "percent"
              },
              lightness: {
                  idx: 2,
                  type: "percent"
              }
          }
      }
  }, k = {
      "byte": {
          floor: true,
          max: 255
      },
      percent: {
          max: 1
      },
      degrees: {
          mod: 360,
          floor: true
      }
  }, l = b.support = {}, j = a("<p>")[0],
  f, c = a.each;
j.style.cssText = "background-color:rgba(1,1,1,.5)";
l.rgba = j.style.backgroundColor.indexOf("rgba") > -1;
c(d, function (b, a) {
  a.cache = "_" + b;
  a.props.alpha = {
      idx: 3,
      type: "percent",
      def: 1
  }
});

function g(a, c, d) {
  var b = k[c.type] || {};
  if (a == null) return d || !c.def ? null : c.def;
  a = b.floor ? ~~a : parseFloat(a);
  return isNaN(a) ? c.def : b.mod ? (a + b.mod) % b.mod : 0 > a ? 0 : b.max < a ? b.max : a
}
function i(g) {
  var e = b(),
      h = e._rgba = [];
  g = g.toLowerCase();
  c(m, function (j, c) {
      var b, i = c.re.exec(g),
          f = i && c.parse(i),
          a = c.space || "rgba";
      if (f) {
          b = e[a](f);
          e[d[a].cache] = b[d[a].cache];
          h = e._rgba = b._rgba;
          return false
      }
  });
  if (h.length) {
      h.join() === "0,0,0,0" && a.extend(h, f.transparent);
      return e
  }
  return f[g]
}
b.fn = a.extend(b.prototype, {
  parse: function (h, k, n, m) {
      if (h === e) {
          this._rgba = [null, null, null, null];
          return this
      }
      if (h.jquery || h.nodeType) {
          h = a(h).css(k);
          k = e
      }
      var j = this,
          l = a.type(h),
          o = this._rgba = [];
      if (k !== e) {
          h = [h, k, n, m];
          l = "array"
      }
      if (l === "string") return this.parse(i(h) || f._default);
      if (l === "array") {
          c(d.rgba.props, function (b, a) {
              o[a.idx] = g(h[a.idx], a)
          });
          return this
      }
      if (l === "object") {
          if (h instanceof b) c(d, function (b, a) {
              if (h[a.cache]) j[a.cache] = h[a.cache].slice()
          });
          else c(d, function (e, d) {
              var b = d.cache;
              c(d.props, function (a, c) {
                  if (!j[b] && d.to) {
                      if (a === "alpha" || h[a] == null) return;
                      j[b] = d.to(j._rgba)
                  }
                  j[b][c.idx] = g(h[a], c, true)
              });
              if (j[b] && a.inArray(null, j[b].slice(0, 3)) < 0) {
                  j[b][3] = 1;
                  if (d.from) j._rgba = d.from(j[b])
              }
          });
          return this
      }
  },
  is: function (f) {
      var g = b(f),
          a = true,
          e = this;
      c(d, function (h, b) {
          var f, d = g[b.cache];
          if (d) {
              f = e[b.cache] || b.to && b.to(e._rgba) || [];
              c(b.props, function (c, b) {
                  if (d[b.idx] != null) {
                      a = d[b.idx] === f[b.idx];
                      return a
                  }
              })
          }
          return a
      });
      return a
  },
  _space: function () {
      var a = [],
          b = this;
      c(d, function (c, d) {
          b[d.cache] && a.push(c)
      });
      return a.pop()
  },
  transition: function (m, l) {
      var e = b(m),
          i = e._space(),
          a = d[i],
          h = this.alpha() === 0 ? b("transparent") : this,
          j = h[a.cache] || a.to(h._rgba),
          f = j.slice();
      e = e[a.cache];
      c(a.props, function (i, h) {
          var d = h.idx,
              a = j[d],
              b = e[d],
              c = k[h.type] || {};
          if (b === null) return;
          if (a === null) f[d] = b;
          else {
              if (c.mod) if (b - a > c.mod / 2) a += c.mod;
              else if (a - b > c.mod / 2) a -= c.mod;
              f[d] = g((b - a) * l + a, h)
          }
      });
      return this[i](f)
  },
  blend: function (e) {
      if (this._rgba[3] === 1) return this;
      var c = this._rgba.slice(),
          d = c.pop(),
          f = b(e)._rgba;
      return b(a.map(c, function (b, a) {
          return (1 - d) * f[a] + d * b
      }))
  },
  toRgbaString: function () {
      var c = "rgba(",
          b = a.map(this._rgba, function (a, b) {
              return a == null ? b > 2 ? 1 : 0 : a
          });
      if (b[3] === 1) {
          b.pop();
          c = "rgb("
      }
      return c + b.join() + ")"
  },
  toHslaString: function () {
      var c = "hsla(",
          b = a.map(this.hsla(), function (a, b) {
              if (a == null) a = b > 2 ? 1 : 0;
              if (b && b < 3) a = Math.round(a * 100) + "%";
              return a
          });
      if (b[3] === 1) {
          b.pop();
          c = "hsl("
      }
      return c + b.join() + ")"
  },
  toHexString: function (c) {
      var b = this._rgba.slice(),
          d = b.pop();
      c && b.push(~~ (d * 255));
      return "#" + a.map(b, function (a) {
          a = (a || 0).toString(16);
          return a.length === 1 ? "0" + a : a
      }).join("")
  },
  toString: function () {
      return this._rgba[3] === 0 ? "transparent" : this.toRgbaString()
  }
});
b.fn.parse.prototype = b.fn;

function h(b, c, a) {
  a = (a + 1) % 1;
  return a * 6 < 1 ? b + (c - b) * a * 6 : a * 2 < 1 ? c : a * 3 < 2 ? b + (c - b) * (2 / 3 - a) * 6 : b
}
d.hsla.to = function (a) {
  if (a[0] == null || a[1] == null || a[2] == null) return [null, null, null, a[3]];
  var f = a[0] / 255,
      d = a[1] / 255,
      g = a[2] / 255,
      k = a[3],
      c = Math.max(f, d, g),
      j = Math.min(f, d, g),
      b = c - j,
      i = c + j,
      l = i * .5,
      e, h;
  if (j === c) e = 0;
  else if (f === c) e = 60 * (d - g) / b + 360;
  else if (d === c) e = 60 * (g - f) / b + 120;
  else e = 60 * (f - d) / b + 240;
  if (b === 0) h = 0;
  else if (l <= .5) h = b / i;
  else h = b / (2 - i);
  return [Math.round(e) % 360, h, l, k == null ? 1 : k]
};
d.hsla.from = function (a) {
  if (a[0] == null || a[1] == null || a[2] == null) return [null, null, null, a[3]];
  var d = a[0] / 360,
      f = a[1],
      b = a[2],
      g = a[3],
      c = b <= .5 ? b * (1 + f) : b + f - b * f,
      e = 2 * b - c;
  return [Math.round(h(e, c, d + 1 / 3) * 255), Math.round(h(e, c, d) * 255), Math.round(h(e, c, d - 1 / 3) * 255), g]
};
c(d, function (h, f) {
  var i = f.props,
      d = f.cache,
      k = f.to,
      j = f.from;
  b.fn[h] = function (h) {
      if (k && !this[d]) this[d] = k(this._rgba);
      if (h === e) return this[d].slice();
      var m, l = a.type(h),
          n = l === "array" || l === "object" ? h : arguments,
          f = this[d].slice();
      c(i, function (c, a) {
          var b = n[l === "object" ? c : a.idx];
          if (b == null) b = f[a.idx];
          f[a.idx] = g(b, a)
      });
      if (j) {
          m = b(j(f));
          m[d] = f;
          return m
      } else return b(f)
  };
  c(i, function (d, c) {
      if (b.fn[d]) return;
      b.fn[d] = function (b) {
          var f = a.type(b),
              j = d === "alpha" ? this._hsla ? "hsla" : "rgba" : h,
              g = this[j](),
              i = g[c.idx],
              e;
          if (f === "undefined") return i;
          if (f === "function") {
              b = b.call(this, i);
              f = a.type(b)
          }
          if (b == null && c.empty) return this;
          if (f === "string") {
              e = n.exec(b);
              if (e) b = i + parseFloat(e[2]) * (e[1] === "+" ? 1 : -1)
          }
          g[c.idx] = b;
          return this[j](g)
      }
  })
});
b.hook = function (e) {
  var d = e.split(" ");
  c(d, function (d, c) {
      a.cssHooks[c] = {
          "set": function (g, d) {
              var h, f, e = "";
              if (d !== "transparent" && (a.type(d) !== "string" || (h = i(d)))) {
                  d = b(h || d);
                  if (!l.rgba && d._rgba[3] !== 1) {
                      f = c === "backgroundColor" ? g.parentNode : g;
                      while ((e === "" || e === "transparent") && f && f.style) try {
                          e = a.css(f, "backgroundColor");
                          f = f.parentNode
                      } catch (j) {}
                      d = d.blend(e && e !== "transparent" ? e : "_default")
                  }
                  d = d.toRgbaString()
              }
              try {
                  g.style[c] = d
              } catch (j) {}
          }
      };
      a.fx.step[c] = function (d) {
          if (!d.colorInit) {
              d.start = b(d.elem, c);
              d.end = b(d.end);
              d.colorInit = true
          }
          a.cssHooks[c].set(d.elem, d.start.transition(d.end, d.pos))
      }
  })
};
b.hook(o);
a.cssHooks.borderColor = {
  expand: function (b) {
      var a = {};
      c(["Top", "Right", "Bottom", "Left"], function (d, c) {
          a["border" + c + "Color"] = b
      });
      return a
  }
};
f = a.Color.names = {
  aqua: "#00ffff",
  black: "#000000",
  blue: "#0000ff",
  fuchsia: "#ff00ff",
  gray: "#808080",
  green: "#008000",
  lime: "#00ff00",
  maroon: "#800000",
  navy: "#000080",
  olive: "#808000",
  purple: "#800080",
  red: "#ff0000",
  silver: "#c0c0c0",
  teal: "#008080",
  white: "#ffffff",
  yellow: "#ffff00",
  transparent: [null, null, null, 0],
  _default: "#ffffff"
}
})(jQuery)
