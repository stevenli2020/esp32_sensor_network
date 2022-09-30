var addPasswordUsername = document.getElementById('add-password-username')
var addPasswordPassword = document.getElementById('add-password-password')
var addPasswordConfirmPassword = document.getElementById('add-password-confirm-password')
var addPasswordBtn = document.getElementById('add-password-submit-btn')
var url = window.location.href;
url = url.slice(51);
// console.log(url)
code = url.split("&");
// console.log(code);
addPasswordUsername.value = code[1]


// if(checkLogin()){
//     history.back()
// }

async function addPassword(){
    // console.log(addPasswordPassword.value, addPasswordConfirmPassword.value, addPasswordUsername.value)
    // var rData;
    // if(addPasswordPassword.value != addPasswordConfirmPassword){
    //     console.log('not equal', addPasswordPassword.parentElement, addPasswordConfirmPassword.parentElement)
    //     addPasswordPassword.parentElement.classList.add('alert-validate')
    //     addPasswordConfirmPassword.parentElement.classList.add('alert-validate')
    //     // return
    // } else {
    //     addPasswordPassword.parentElement.classList.remove("alert-validate")
    //     addPasswordConfirmPassword.parentElement.classList.remove("alert-validate")
        
    // }
    addPasswordBtn.disabled = true
    rData = {
        LOGIN_NAME: addPasswordUsername.value,
        PWD: addPasswordPassword.value,
        CPWD: addPasswordConfirmPassword.value,
        CODE: code[0],
        AUTH: code[2]
    }
    // Object.assign
    await fetch(`${domain}/API/?act=addPassword`, {
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
            addPasswordBtn.disabled = false
            if(data.MESSAGE.length > 0){
                if(data['MESSAGE'].filter(val => val.includes('Both')).length > 0){
                    addPasswordPassword.parentElement.setAttribute('data-validate', data['MESSAGE'].filter(val => val.includes('Both')));
                    addPasswordPassword.parentElement.classList.add('alert-validate')
                    addPasswordConfirmPassword.parentElement.setAttribute('data-validate', data['MESSAGE'].filter(val => val.includes('Both')));
                    addPasswordConfirmPassword.parentElement.classList.add('alert-validate');
                }
                if(data['MESSAGE'].filter(val => val.includes('Password1')).length > 0){
                    addPasswordPassword.parentElement.setAttribute('data-validate', 'Required');
                    addPasswordPassword.parentElement.classList.add('alert-validate');
                }
                if(data['MESSAGE'].filter(val => val.includes('Confirm')).length > 0){
                    addPasswordConfirmPassword.parentElement.setAttribute('data-validate', "Required");
                    addPasswordConfirmPassword.parentElement.classList.add('alert-validate');
                }
                if(data['MESSAGE'].filter(val => val.includes('Fail')).length > 0){
                    addPasswordUsername.parentElement.setAttribute('data-validate', data['MESSAGE'].filter(val => val.includes('Fail')));
                    addPasswordUsername.parentElement.classList.add('alert-validate');
                }
            }
        } else if(data.CODE == 0){
            addPasswordBtn.disabled = false
            addPasswordUsername.parentElement.classList.remove('alert-validate');
            addPasswordConfirmPassword.parentElement.classList.remove('alert-validate');
            addPasswordPassword.parentElement.classList.remove('alert-validate');
            addPasswordUsername.value = '';
            addPasswordConfirmPassword.value = '';
            addPasswordPassword.value = '';
            window.location = '/dashBoard/';
        }
    })
    
    
}
// (function ($) {
//     "use strict";

    
//     /*==================================================================
//     [ Validate ]*/
//     var input = $('.validate-input .input100');

//     $('.validate-form').on('submit',function(){
//         var check = true;

//         for(var i=0; i<input.length; i++) {
//             if(validate(input[i]) == false){
//                 showValidate(input[i]);
//                 check=false;
//             }
//         }

//         return check;
//     });


//     $('.validate-form .input100').each(function(){
//         $(this).focus(function(){
//            hideValidate(this);
//         });
//     });

//     function validate (input) {
//         if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
//             if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
//                 return false;
//             }
//         }
//         else {
//             if($(input).val().trim() == ''){
//                 return false;
//             }
//         }
//     }

//     function showValidate(input) {
//         var thisAlert = $(input).parent();

//         $(thisAlert).addClass('alert-validate');
//     }

//     function hideValidate(input) {
//         var thisAlert = $(input).parent();

//         $(thisAlert).removeClass('alert-validate');
//     }
    
    

// })(jQuery);