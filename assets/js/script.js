function _elementId(e){
    return document.getElementById(e);
}
function _query(e){
    return document.querySelector(e);
}
function _queryAll(e){
    return document.querySelectorAll(e);
}


let loginPassword = document.getElementById("loginPassword");
let eyeClose = document.getElementById("eyeClose");
let eyeOpen = document.getElementById("eyeOpen");

function eyeCloseCta(){
    loginPassword.type = "text";
    eyeClose.classList.add("display-none");
    eyeOpen.classList.remove("display-none");
}

function eyeOpenCta(){
    loginPassword.type = "password";
    eyeClose.classList.remove("display-none");
    eyeOpen.classList.add("display-none");
}

const hrefName = window.location.href;
const cut1 = hrefName.substring(hrefName.lastIndexOf("/")+1);
const cut2 = cut1.substring(0,cut1.lastIndexOf(".php"));
if(document.querySelector("["+cut2+"-php]")){
    document.querySelector("["+cut2+"-php]").classList.add("li-current");

    // const anchor = document.querySelectorAll("a");
    // for(let a =0; a<anchor.length; a++){
    //     if(anchor[a].href.substring(anchor[a].href.lastIndexOf("/")+1) === cut2+".php"){
    //         anchor[a].removeAttribute("href");
    //         document.querySelector("["+cut2+"-php]").style.cursor = "default";
    //     }
    // }
}

function logoutAccount(){
    _elementId("logoutAccount").classList.toggle("display-none");
}

if(_elementId("logoutAccount")){
    _elementId("logoutAccount").addEventListener("click", function(e){
        var logoutAccount = _elementId("logoutAccount");
        var rect = logoutAccount.getBoundingClientRect();
        var top = rect.top;
        var bottom = rect.bottom;
        var left = rect.left;
        var right = rect.right;
        
        if(e.pageX < top || e.pageX > bottom || e.pageY < left || e.pageY > right){
            _elementId("logoutAccount").classList.add("display-none");
        }
    });
}

function checkCurrentPasswordCta(){
    var currentPassword = _elementId("currentPassword");
    var checkCurrentPassword = _elementId("checkCurrentPassword");

    if(checkCurrentPassword.checked){
        currentPassword.type = "text";
    }
    else{
        currentPassword.type = "password";
    }
}

function checkNewPasswordCta(){
    var newPassword = _elementId("newPassword");
    var checkNewPassword = _elementId("checkNewPassword");

    if(checkNewPassword.checked){
        newPassword.type = "text";
    }
    else{
        newPassword.type = "password";
    }
}

function usernameFocusCta(){
    if(_elementId("incorrectAccount")){
        _elementId("incorrectAccount").classList.add("display-none");
    }
}

function passwordFocusCta(){
    if(_elementId("incorrectAccount")){
        _elementId("incorrectAccount").classList.add("display-none");
    }
}

function manageAccountCta(){
    const x = new XMLHttpRequest();
    x.onload = function(){
        _elementId("manageAccounts").innerHTML = this.responseText;
        _query(".manage-account").showModal();
    }
    x.open("GET","../universal_re/top_nav.php?manageAccounts");
    x.send();
}

function closeManageAccountCta(){
    _elementId("manageAccountName").value = "";
    _elementId("manageAccountUsername").value = "";
    _elementId("checkCurrentPassword").value = "";
    _elementId("checkNewPassword").value = "";
    _query(".manage-account").close();
}


function submitManageAccountCta(){
    const name = _elementId("manageAccountName").value.trim();
    const username = _elementId("manageAccountUsername").value.trim();
    const currentPassword = _elementId("checkCurrentPassword").value.trim();
    const newPassword = _elementId("checkNewPassword").value.trim();

    if(name !== "" && username !== "" && currentPassword !== "" && newPassword !== ""){
        if(newPassword !== "" && currentPassword === ""){
            alert("Please enter your current password");
            _elementId("checkNewPassword").value = "";
        }
        else{
            
        }
    }
    else{
        return;
    }
}

function manageAccountOverCta(){
    _elementId("accountOptions").classList.remove("display-none");
}
function manageAccountLeaveCta(){
    _elementId("accountOptions").classList.add("display-none");
}

function personalDetailsCta(){
    const x = new XMLHttpRequest();
    x.onload = function(){
        _elementId("personalDetails").innerHTML = this.responseText;
        _query(".personal-details").showModal();
    }
    x.open("GET","../universal_re/top_nav.php?personalDetails");
    x.send();
}

function closePersonalDetailsCta(){
    _elementId("personalDetailsName").value = "";
    _elementId("personalDetailsUsername").value = "";
    _query(".personal-details").close();
}

function submitPersonalDetailsCta(){
    const personalDetailsName = _elementId("personalDetailsName").value.trim();
    const personalDetailsUsername = _elementId("personalDetailsUsername").value.trim();
    const x = new XMLHttpRequest();
    x.onload = function(){
        if(this.responseText === ""){
            window.location.reload();
        }
        else{
            alert("Something went wrong");
            console.log(this.responseText);
        }
    }
    x.open("GET","../universal_re/top_nav.php?personalDetailsName="+encodeURIComponent(personalDetailsName)+"&personalDetailsUsername="+encodeURIComponent(personalDetailsUsername));
    x.send();
}

function changePasswordCta(){
    _query(".change-password").showModal();
}

function closeChangePasswordCta(){
    _elementId("changeCurrentPassword").value = "";
    _elementId("changeCurrentPassword").type = "password";
    _elementId("checkChangeCurrentPassword").checked = false;
    _elementId("changeNewPassword").value = "";
    _elementId("changeNewPassword").type = "password";
    _elementId("checkChangeNewPassword").checked = false;
    _query(".change-password").close();
}

function checkChangeCurrentPasswordCta(){
    var changeCurrentPassword = _elementId("changeCurrentPassword");
    var checkChangeCurrentPassword = _elementId("checkChangeCurrentPassword");

    if(checkChangeCurrentPassword.checked){
        changeCurrentPassword.type = "text";
    }
    else{
        changeCurrentPassword.type = "password";
    }
}

function checkChangeNewPasswordCta(){
    var changeNewPassword = _elementId("changeNewPassword");
    var checkChangeNewPassword = _elementId("checkChangeNewPassword");

    if(checkChangeNewPassword.checked){
        changeNewPassword.type = "text";
    }
    else{
        changeNewPassword.type = "password";
    }
}

function submitChangePasswordCta(){
    var changeCurrentPassword = _elementId("changeCurrentPassword").value.trim();
    var changeNewPassword = _elementId("changeNewPassword").value.trim();

    if(changeCurrentPassword !== "" && changeNewPassword !== ""){

        const x = new XMLHttpRequest();
        x.onload = function(){
            if(this.responseText === "false"){
                alert("Current Password incorrect");
            }
            else{
                alert("Password changed successfully");
                _elementId("changeCurrentPassword").value = "";
                _elementId("changeCurrentPassword").type = "password";
                _elementId("checkChangeCurrentPassword").checked = false;
                _elementId("changeNewPassword").value = "";
                _elementId("changeNewPassword").type = "password";
                _elementId("checkChangeNewPassword").checked = false;
                _query(".change-password").close();
            }
        }
        x.open("GET","../universal_re/top_nav.php?changeCurrentPassword="+encodeURIComponent(changeCurrentPassword)+"&changeNewPassword="+encodeURIComponent(changeNewPassword));
        x.send();
    }
    else{
        return;
    }
}

function logoutAccountCta(){
    var confirmLogout = confirm("Are you sure you want to logout?");
    if (confirmLogout) {
        // Perform logout action here
        // For example, redirect the user to the login page
        window.location.href = "../logout/logout.php";
    }
}
