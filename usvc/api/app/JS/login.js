var loginUsername = document.getElementById('login-username')
var loginPassword = document.getElementById('login-password')
var loginBtn = document.getElementById('login-submit-btn')


if(checkLogin()){
    window.location.href = document.referrer;
}

async function login(){
    loginBtn.disabled = true
    loginUsername.parentElement.classList.remove('alert-validate');
    loginPassword.parentElement.classList.remove('alert-validate');
    // loginUsername.value = '';
    // loginPassword.value = '';
    rData = {
        LOGIN_NAME: loginUsername.value,
        PWD: loginPassword.value,
        AUTH: 2
    }
    await fetch(`${domain}/API/?act=login`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(rData),
    })
    .then((response) => response.json())
    .then((data) => {
        console.log(data);
        if(data.CODE == -1){
            loginBtn.disabled = false
            if(data.MESSAGE.length > 0){
                if(data['MESSAGE'].filter(val => val.includes('Username')).length > 0){
                    loginUsername.parentElement.setAttribute('data-validate', data['MESSAGE'].filter(val => val.includes('Username')));
                    loginUsername.parentElement.classList.add('alert-validate')
                }
                if(data['MESSAGE'].filter(val => val.includes('Password')).length > 0){
                    loginPassword.parentElement.setAttribute('data-validate', data['MESSAGE'].filter(val => val.includes('Password')));
                    loginPassword.parentElement.classList.add('alert-validate');
                }
                if(data['MESSAGE'].filter(val => val.includes('Unauthorised')).length > 0){
                    loginUsername.parentElement.setAttribute('data-validate', data['MESSAGE'].filter(val => val.includes('Unauthorised')).length > 0);
                    loginUsername.parentElement.classList.add('alert-validate');
                }
            }
        } else if(data.CODE == 0){
            window.location.href = document.referrer;
            loginBtn.disabled = false
            loginUsername.parentElement.classList.remove('alert-validate');
            loginPassword.parentElement.classList.remove('alert-validate');
            loginUsername.value = '';
            loginPassword.value = '';
            console.log(data)
            setCookie("TYPE", data.TYPE, 1);
            setCookie("USERNAME", data.UNAME, 1);
            setCookie("TOKEN", data.TOKEN, 1);
            // window.location.href = dashBoardPage;
        }
    })
    
    
}