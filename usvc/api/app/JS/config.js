const domain = 'http://167.99.77.130/'
const loginPage = `${domain}API/Auth/login/`
const dashBoardPage = `${domain}dashBoard/`
const detailPage = `${dashBoardPage}Detail/`
const nodePage = `${dashBoardPage}Node/`
const facilityPage = `${dashBoardPage}Facility/`
const air = "a9"
const motion = "03"
const distance = "0d"
const oriBorder = '1px solid #ced4da'
const redBorder = '1px solid red'


function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

function eraseCookie(name) {   
    document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

function checkLogin() {
    let user = getCookie("USERNAME");
    let token = getCookie("TOKEN");
    let type = getCookie("TYPE");
    // console.log("user " + user)
    if (user == null || token == null || type == null) {
    //   alert("Welcome again " + user);
        // console.log("checked")
        // window.location.href = loginPage
        return false
    } else {
        return true
    }
}

function RequestData(){
    return Rdata = {
        LOGIN_NAME: getCookie("USERNAME"),
        CODE: getCookie("TOKEN"),
        TYPE: getCookie("TYPE")
    }
}

function logout(){
    
    if(checkLogin()){
        fetch(`${domain}API/?act=logout`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(RequestData()),
        })
        .then((response) => response.json())
        .then(data => {
            if(data.CODE == 0){
                eraseCookie("USERNAME")
                eraseCookie("TOKEN")
                location.reload()
            } else {
                alert("Fail to logout")
                // location.reload()
            }
        })
        .catch((error) => {
            console.error("Error:", error);
        });
    } else {
        return
    }
}

function gotologin(){
    document.querySelector("#Close-button").click();
    window.location.href = loginPage
}
