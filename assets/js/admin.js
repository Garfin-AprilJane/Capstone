//add new account
function addNewAccountCta(){
    _query(".new-account").showModal();
    setTimeout(function(){
        _query(".new-account").classList.remove("dialogActive");
    },500);
}
// select for usertype
function userTypeCta(){
    const userType =_elementId("userType").value.trim();
    if(userType === "admin"  || userType === "registrar" || userType === "cashier" || userType === "accounting"){
        _elementId("staffForm").classList.remove("display-none");
        _elementId("studentForm").classList.add("display-none");
    }
    else if(userType ==="student"){
        _elementId("staffForm").classList.add("display-none");
        _elementId("studentForm").classList.remove("display-none");
    }
    else{
        _elementId("staffForm").classList.add("display-none");
        _elementId("studentForm").classList.add("display-none");
    }
}
//searh for student name
function searchStudentNameCta(){
    _elementId("searchStudentName").value = "";
    _elementId("searchStudentResult").value = "";
    _query(".new-account").close();
}
//close account for staff
function closeNewAccountCta(){
    _elementId("staffName").value = "";
    _elementId("sex").value = "";
    _elementId("staffAddress").value = "";
    _elementId("staffContactNumber").value = "";
    _elementId("staffEmailAddress").value = "";
    _elementId("staffUsername").value = "";
    _elementId("staffPassword").value = "";
    _query(".new-account").close();
}
//close account for usertype
function closeNewAccountCta(){
    _elementId("userType").value = "";
    _query(".new-account").close();  
}
//close account for student
function closeNewAccountCta(){
    _elementId("searchStudentResult").value = "";
    _elementId("studentname").value = "";
    _elementId("searchStudentName").value = "";
    _elementId("studentUsername").value = "";
    _elementId("staffConfirmPassword").value = "";
    _query(".new-account").close();  
}
//for admin&registrar submit account
function submitAccountAdminCta(){
    const staffName = _elementId("staffName").value.trim();
    const sex = _elementId("sex").value.trim();
    const staffAddress = _elementId("staffAddress").value.trim();
    const staffContactNumber = _elementId("staffContactNumber").value.trim();
    const staffEmailAddress = _elementId("staffEmailAddress").value.trim();
    const staffUsername = _elementId("staffUsername").value.trim();
    const staffPassword = _elementId("staffPassword").value.trim();
    const staffConfirmPassword = _elementId("staffConfirmPassword").value.trim();
    const userType = _elementId("userType").value.trim();
    const entriesAccount = _elementId("entriesAccount").value.trim();

    if(staffName === "" ||  sex === "" || staffAddress === "" || staffContactNumber === "" || staffEmailAddress === "" || staffUsername === "" || staffPassword === ""||  staffConfirmPassword === ""){
        alert("All fields are required");
    }
    else{
        if(staffPassword === staffConfirmPassword){
            const x = new XMLHttpRequest();
            x.onload = function(){
                if(this.responseText === "username already exist"){
                    alert("Username already exists");
                }
                else{
                    alert("New account added successfully");
                    _elementId("staffName").value = "";
                    _elementId("sex").value = "";
                    _elementId("staffAddress").value = "";
                    _elementId("staffContactNumber").value = "";
                    _elementId("staffEmailAddress").value = "";
                    _elementId("staffUsername").value = "";
                    _elementId("staffPassword").value = "";
                    _query(".new-account").close();
                    _query("[tableAccount]").innerHTML = this.responseText;
                }
            }
            x.open("POST","../admin_re/user_accounts.php");
            x.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            x.send("staffName="+encodeURIComponent(staffName)+"&sex="+encodeURIComponent(sex)+"&staffAddress="+encodeURIComponent(staffAddress)+"&staffContactNumber="+encodeURIComponent(staffContactNumber)+"&staffEmailAddress="+encodeURIComponent(staffEmailAddress)+"&staffUsername="+encodeURIComponent(staffUsername)+"&staffPassword="+encodeURIComponent(staffPassword)+"&entriesAccount="+encodeURIComponent(entriesAccount)+"&userType="+encodeURIComponent(userType));
        }
        else{
            alert("Password not Match");
        }
        
    }
}
//for student submit account
function submitAccountStudentCta(){
    const studentUsername = _elementId("studentUsername").value.trim();
    const studentPassword = _elementId("studentPassword").value.trim();
    const studentConfirmPassword = _elementId("studentConfirmPassword").value.trim();
    const userType = _elementId("userType").value.trim();
    const studentStatus = _elementId("studentStatus").value.trim();
    const entriesAccount = _elementId("entriesAccount").value.trim();

    if(studentUsername === "" ||  studentPassword === "" ||  studentConfirmPassword === ""){
        alert("All fields are required");
    }
    else{
        if(studentPassword === studentConfirmPassword){
            const x = new XMLHttpRequest();
            x.onload = function(){
                if(this.responseText === "username already exist"){
                    alert("Username already exists");
                }
                else{
                    alert("New account added successfully");
                    _elementId("studentUsername").value = "";
                    _elementId("studentPassword").value = "";
                    _elementId("studentStatus").value = "";
                    _query(".new-account").close();
                    _query("[tableAccount]").innerHTML = this.responseText;
                }
            }
            x.open("POST","../admin_re/user_accounts.php");
            x.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            x.send("studentUsername="+encodeURIComponent(studentUsername)+"&studentPassword="+encodeURIComponent(studentPassword)+"&studentStatus="+encodeURIComponent(studentStatus)+"&entriesAccount="+encodeURIComponent(entriesAccount)+"&userType="+encodeURIComponent(userType));
        }
        else{
            alert("Password not Match");
        }
        
    }
}
//search account
function searchAccountCta(){
    const filterAccount = _elementId("filterAccount").value.trim();
    const searchAccount = _elementId("searchAccount").value.trim();
    const entriesAccount = _elementId("entriesAccount").value.trim();

    const x = new XMLHttpRequest();
    x.onload = function(){
        _query("[tableAccount]").innerHTML = this.responseText;
    }
    x.open("GET","../admin_re/user_accounts.php?filterAccount="+encodeURIComponent(filterAccount)+"&searchAccount="+encodeURIComponent(searchAccount)+"&entriesAccount="+encodeURIComponent(entriesAccount));
    x.send();
}

//previous page account
function prevPageAccountCta(prevPage){
    const entriesAccount = _elementId("entriesAccount").value.trim();
    const x = new XMLHttpRequest();
    x.onload = function(){
        _query("[tableAccount]").innerHTML = this.responseText;
    }
    x.open("GET","../admin_re/user_accounts.php?prevPage="+encodeURIComponent(prevPage)+"&entriesAccount="+encodeURIComponent(entriesAccount));
    x.send();
}

//next page account
function nextPageAccountCta(nextPage){
    const entriesAccount = _elementId("entriesAccount").value.trim();
    const x = new XMLHttpRequest();
    x.onload = function(){
        _query("[tableAccount]").innerHTML = this.responseText;
    }
    x.open("GET","../admin_re/user_accounts.php?nextPage="+encodeURIComponent(nextPage)+"&entriesAccount="+encodeURIComponent(entriesAccount));
    x.send();
}

//entries account
function entriesAccountCta(){
    const entriesAccount = _elementId("entriesAccount").value.trim();
    const x = new XMLHttpRequest();
    x.onload = function(){
        _query("[tableAccount]").innerHTML = this.responseText;
    }
    x.open("GET","../admin_re/user_accounts.php?entriesAccount="+encodeURIComponent(entriesAccount)+"&showPerPage");
    x.send();
}

//edit account
function editAccountCta(id){
    const x = new XMLHttpRequest();
    x.onload = function(){
        _elementId("inputAccounts").innerHTML = this.responseText;
        _query(".update-account").showModal();
    }
    x.open("GET","../admin_re/user_accounts.php?editAccount="+encodeURIComponent(id));
    x.send();

}
//view user account
function viewUserCta(userId){
    const x = new XMLHttpRequest();
    x.onload = function(){
        _elementId("viewInputs").innerHTML = this.responseText;
        _query(".view-account").showModal();
    }
    x.open("GET","../admin_re/user_accounts.php?viewUser="+encodeURIComponent(userId));
    x.send();

}
//close update account
function closeUpdateAccountCta(){
    _query(".update-account").close();
    _query(".view-account").close();
}
//submit update account
function submitUpdateAccountCta(){
    const entriesAccount = _elementId("entriesAccount").value.trim();
    const updateAccountRole = _elementId("updateAccountRole").value.trim();
    const updateAccountStatus = _elementId("updateAccountStatus").value.trim();
    const x = new XMLHttpRequest();
    x.onload = function(){
        _query("[tableAccount]").innerHTML = this.responseText;
        _query(".update-account").close();
    }
    x.open("GET","../admin_re/user_accounts.php?updateAccount&entriesAccount="+entriesAccount+"&updateAccountRole="+updateAccountRole+"&updateAccountStatus="+updateAccountStatus);
    x.send();
}
// search for student name for their account
function searchStudentNameCta(){
    const searchStudentName = _elementId("searchStudentName").value.trim();
    const x = new XMLHttpRequest();
    x.onload = function(){
        _elementId("searchStudentResult").innerHTML = this.responseText;
    }
    x.open("GET","../admin_re/user_accounts.php?searchStudentName="+encodeURIComponent(searchStudentName));
    x.send();
}
function studentUserIdCta(studentId){
    const x = new XMLHttpRequest();
    x.onload = function(){
        _elementId("studentAccount").innerHTML = this.responseText;
    }
    x.open("GET","../admin_re/user_accounts.php?studentId="+encodeURIComponent(studentId));
    x.send();
    _elementId("studentAccount").classList.remove("display-none");
    _elementId("studentResult").classList.add("display-none");

}
function validateInput(input) {
    input.value = input.value.replace(/\D/g, '');
    if(input.value.length > 11){
        input.value = input.value.slice(0,11);
    }
}
function validateInputs(input) {
    input.value = input.value.replace(/[^a-zA-Z]/g, '');
}

