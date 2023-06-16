//add new student
function addNewFormCta(){
    _query(".new-enrollment").showModal();
}
//add new schoolyear
function addNewSchoolYearCta(){
    _query(".new-schoolyear").showModal();
}
//close schoolyear modal
function closeNewSchoolYearCta(){
    _elementId("newSchoolYear").value = "";
    _query(".new-schoolyear").close();
}
//submit new school year
function submitNewSchoolYearCta(){
    const newSchoolYear = _elementId("newSchoolYear").value.trim();


    if(newSchoolYear === ""){
        alert("All fields are required");
    }
    else{
        const x = new XMLHttpRequest();
        x.onload = function(){
            if(this.responseText === "School year already exists"){
                alert("School year already exists");
            }
            else{
                alert("New School year added successfully");
                _elementId("newSchoolYear").value = "";
                _query(".new-schoolyear").close();
            }
        }
        x.open("POST","../registrar_re/enroll_student.php");
        x.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        x.send("newSchoolYear="+encodeURIComponent(newSchoolYear));
               
    }
}
//select for schoolyear
function schoolYearCta(){
    const userType =_elementId("schoolYear").value.trim();
    _elementId("enrollmentForm").classList.remove("display-none");
}
//submit new student
function submitNewEnrollCta(){
    const studentLRN = _elementId("studentLRN").value.trim();
    const studentFirstName = _elementId("studentFirstName").value.trim();
    const studentMiddleName = _elementId("studentMiddleName").value.trim();
    const studentLastName = _elementId("studentLastName").value.trim();
    const studentSuffix = _elementId("studentSuffix").value.trim();
    const studentSex = _elementId("studentSex").value.trim();
    const studentBirthDate = _elementId("studentBirthDate").value.trim();
    const studentAge = _elementId("studentAge").value.trim();
    const studentEmailAddress = _elementId("studentEmailAddress").value.trim();
    const studentAddress = _elementId("studentAddress").value.trim();
    const studentYearLevel = _elementId("studentYearLevel").value.trim();
    const studentSection = _elementId("studentSection").value.trim();
    const studentParentGuardian = _elementId("studentParentGuardian").value.trim();
    const studentParentAddress = _elementId("studentParentAddress").value.trim();
    const studentParentOccupation = _elementId("studentParentOccupation").value.trim();
    const studentContactNumber = _elementId("studentContactNumber").value.trim();
    const studentParentContactNumber = _elementId("studentParentContactNumber").value.trim();
    const studentRelation = _elementId("studentRelation").value.trim();
    const studentSchoolYear = _elementId("studentSchoolYear").value.trim();
    const entriesName = _elementId("entriesName").value.trim();

    if(studentLRN === "" ||studentFirstName === "" || studentMiddleName === "" || studentLastName === "" || studentSex === "" || studentBirthDate === "" || studentAge === "" || studentEmailAddress === "" || studentAddress === "" || studentYearLevel === "" || studentSection === "" || studentParentGuardian === ""|| studentParentAddress === ""|| studentParentOccupation === ""|| studentContactNumber === ""|| studentParentContactNumber === ""|| studentRelation === ""|| studentSchoolYear === ""){
        alert("All fields are required");
    }
    else{
        const x = new XMLHttpRequest();
        x.onload = function(){
            if(this.responseText === "Lrn already exists"){
                alert("Lrn already exists");
            }
            else{
                alert("New enrolled student added successfully");
                _elementId("studentLRN").value = "";
                _elementId("studentFirstName").value = "";
                _elementId("studentMiddleName").value = "";
                _elementId("studentLastName").value = "";
                _elementId("studentSuffix").value = "";
                _elementId("studentSex").value = "";
                _elementId("studentAge").value = "";
                _elementId("studentBirthDate").value = "";
                _elementId("studentEmailAddress").value = "";
                _elementId("studentAddress").value = "";
                _elementId("studentYearLevel").value = "";
                _elementId("studentSection").value = "";
                _elementId("studentParentGuardian").value = "";
                _elementId("studentParentOccupation").value = "";
                _elementId("studentContactNumber").value = "";
                _elementId("studentParentAddress").value = "";
                _elementId("studentParentContactNumber").value = "";
                _elementId("studentRelation").value = "";
                _elementId("studentSchoolYear").value = "";
                _query(".new-enrollment").close();
                _query("[tableName]").innerHTML = this.responseText;
            }
        }
        x.open("POST","../registrar_re/enroll_student.php");
        x.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        x.send("studentLRN="+encodeURIComponent(studentLRN)+"&studentFirstName="+encodeURIComponent(studentFirstName)+"&studentMiddleName="+encodeURIComponent(studentMiddleName)+"&studentLastName="+encodeURIComponent(studentLastName)+"&studentSuffix="+encodeURIComponent(studentSuffix)+"&studentSex="+encodeURIComponent(studentSex)+"&studentBirthDate="+encodeURIComponent(studentBirthDate)+"&studentAge="+encodeURIComponent(studentAge)+"&studentEmailAddress="+encodeURIComponent(studentEmailAddress)+"&studentAddress="+encodeURIComponent(studentAddress)+"&studentYearLevel="+encodeURIComponent(studentYearLevel)+"&studentSection="+encodeURIComponent(studentSection)+"&studentParentGuardian="+encodeURIComponent(studentParentGuardian)+"&studentParentOccupation="+encodeURIComponent(studentParentOccupation)+"&studentParentAddress="+encodeURIComponent(studentParentAddress)+"&studentContactNumber="+encodeURIComponent(studentContactNumber)+"&studentParentContactNumber="+encodeURIComponent(studentParentContactNumber)+"&studentRelation="+encodeURIComponent(studentRelation)+"&studentSchoolYear="+encodeURIComponent(studentSchoolYear)+"&entriesName="+encodeURIComponent(entriesName));
               
    }
}
//search student name
function searchStudentCta(){
    const filterName = _elementId("filterName").value.trim();
    const searchName = _elementId("searchName").value.trim();
    const entriesName = _elementId("entriesName").value.trim();

    const x = new XMLHttpRequest();
    x.onload = function(){
        _query("[tableName]").innerHTML = this.responseText;
    }
    x.open("GET","../registrar_re/enroll_student.php?filterName="+encodeURIComponent(filterName)+"&searchName="+encodeURIComponent(searchName)+"&entriesName="+encodeURIComponent(entriesName));
    x.send();
}
//search student for grade
function searchStudentGradeCta(){
    const filterName = _elementId("filterName").value.trim();
    const searchName = _elementId("searchName").value.trim();
    const entriesName = _elementId("entriesName").value.trim();

    const x = new XMLHttpRequest();
    x.onload = function(){
        _query("[tableName]").innerHTML = this.responseText;
    }
    x.open("GET","../registrar_re/encode_grades.php?filterName="+encodeURIComponent(filterName)+"&searchName="+encodeURIComponent(searchName)+"&entriesName="+encodeURIComponent(entriesName));
    x.send();
}

//previous page account
function prevPageNameCta(prevPage){
    const entriesName = _elementId("entriesName").value.trim();
    const x = new XMLHttpRequest();
    x.onload = function(){
        _query("[tableName]").innerHTML = this.responseText;
    }
    x.open("GET","../registrar_re/enroll_student.php?prevPage="+encodeURIComponent(prevPage)+"&entriesName="+encodeURIComponent(entriesName));
    x.send();
}

//next page account
function nextPageNameCta(nextPage){
    const entriesName = _elementId("entriesName").value.trim();
    const x = new XMLHttpRequest();
    x.onload = function(){
        _query("[tableName]").innerHTML = this.responseText;
    }
    x.open("GET","../registrar_re/enroll_student.php?nextPage="+encodeURIComponent(nextPage)+"&entriesName="+encodeURIComponent(entriesName));
    x.send();
}

//entries name
function entriesNameCta(){
    const entriesName = _elementId("entriesName").value.trim();
    const x = new XMLHttpRequest();
    x.onload = function(){
        _query("[tableName]").innerHTML = this.responseText;
    }
    x.open("GET","../registrar_re/enroll_student.php?entriesName="+encodeURIComponent(entriesName)+"&showPerPage");
    x.send();
}

//close schoolyear
function closeEnrollmentFormCta(){
    _elementId("schoolYear").value = "";
    _query(".new-enrollment").close();
}
//close enrollmentform
function closeEnrollmentFormCta(){
    _elementId("studentLRN").value = "";
    _elementId("studentFirstName").value = "";
    _elementId("studentMiddleName").value = "";
    _elementId("studentLastName").value = "";
    _elementId("studentSuffix").value = "";
    _elementId("studentBirthDate").value = "";
    _elementId("studentSex").value = "";
    _elementId("studentAddress").value = "";
    _elementId("studentEmailAddress").value = "";
    _elementId("studentContactNumber").value = "";
    _elementId("studentYearLevel").value = "";
    _elementId("studentSection").value = "";
    _elementId("studentParentGuardian").value = "";
    _elementId("studentParentAddress").value = "";
    _elementId("studentParentOccupation").value = "";
    _elementId("studentParentContactNumber").value = "";
    _elementId("studentRelation").value = "";
    _query(".new-enrollment").close();  
}
// edit info
function editStudentInfoCta(id){
    const x = new XMLHttpRequest();
    x.onload = function(){
        _elementId("updateStudents").innerHTML = this.responseText;
        _query(".update-enrollment").showModal();
    }
    x.open("GET","../registrar_re/enroll_student.php?editStudentInfo="+encodeURIComponent(id));
    x.send();

}
//view info
function viewStudentInfoCta(id){
    const x = new XMLHttpRequest();
    x.onload = function(){
        _elementId("updateStudents").innerHTML = this.responseText;
        _query(".update-enrollment").showModal();
    }
    x.open("GET","../registrar_re/enroll_student.php?viewStudentInfo="+encodeURIComponent(id));
    x.send();

}
//update student info
function submitNewUpdateEnrollCta(){
    const entriesName = _elementId("entriesName").value.trim();
    const updateFirstName = _elementId("updateFirstName").value.trim();
    const updateMiddleName = _elementId("updateMiddleName").value.trim();
    const updateLastName = _elementId("updateLastName").value.trim();
    const updateSuffix = _elementId("updateSuffix").value.trim();
    const updateBirthDate = _elementId("updateBirthDate").value.trim();
    const updateAge = _elementId("updateAge").value.trim();
    const updateSex = _elementId("updateSex").value.trim();
    const updateAddress = _elementId("updateAddress").value.trim();
    const updateEmailAddress = _elementId("updateEmailAddress").value.trim();
    const updateContactNumber = _elementId("updateContactNumber").value.trim();
    const updateYearLevel = _elementId("updateYearLevel").value.trim();
    const updateSection = _elementId("updateSection").value.trim();
    const updateParentGuardian = _elementId("updateParentGuardian").value.trim();
    const updateParentAddress = _elementId("updateParentAddress").value.trim();
    const updateParentOccupation = _elementId("updateParentOccupation").value.trim();
    const updateParentContactNumber = _elementId("updateParentContactNumber").value.trim();
    const updateRelation = _elementId("updateRelation").value.trim();
    const updateSchoolYear = _elementId("updateSchoolYear").value.trim();
    const x = new XMLHttpRequest();
    x.onload = function(){
        _elementId('tableName').innerHTML = this.responseText;
        _query(".update-enrollment").close();
    }
    x.open("POST","../registrar_re/enroll_student.php");
    x.setRequestHeader("Content-type","application/x-www-form-urlencoded")
    x.send("entriesName="+entriesName+"&updateFirstName="+updateFirstName+"&updateMiddleName="+updateMiddleName+"&updateLastName="+updateLastName+"&updateSuffix="+updateSuffix+"&updateAge="+updateAge+"&updateSex="+updateSex+"&updateAddress="+updateAddress+"&updateEmailAddress="+updateEmailAddress+"&updateContactNumber="+updateContactNumber+"&updateYearLevel="+updateYearLevel+"&updateBirthDate="+updateBirthDate+"&updateSection="+updateSection+"&updateParentGuardian="+updateParentGuardian+"&updateParentAddress="+updateParentAddress+"&updateParentOccupation="+updateParentOccupation+"&updateParentContactNumber="+updateParentContactNumber+"&updateRelation="+updateRelation+"&updateSchoolYear="+updateSchoolYear);
}
//close update
function closeUpdateInfoCta(){
    _query(".update-enrollment").close();
}

//add new subjects
function addNewSubjectCta(){
    _query(".new-subject").showModal();
}
//close subject modal
function closeSubjectCta(){
    _elementId("newSubject").value = "";
    _query(".new-subject").close();
}
//submit new subjects
function submitnewSubjectCta(){
    const newSubject = _elementId("newSubject").value.trim();


    if(newSubject === ""){
        alert("All fields are required");
    }
    else{
        const x = new XMLHttpRequest();
        x.onload = function(){
            if(this.responseText === "Subjects already exists"){
                alert("Subjects already exists");
            }
            else{
                alert("New Subjects added successfully");
                _elementId("newSubject").value = "";
            }
        }
        x.open("POST","../registrar_re/encode_grades.php");
        x.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        x.send("newSubject="+encodeURIComponent(newSubject));
               
    }
}
//add new grades
function addStudentsGradeCta(){
    _query(".new-subject").showModal();
}
//add select grading
function addStudentsGradeCta(){
    _query(".add-grade").showModal();
}
//close selection for grading
function closeGradeCta(){
    _elementId("gradingPeriod").value = "";
    _query(".add-grade").close();
}
//choose grading
function gradingPeriodCta(){
    const gradingPeriod =_elementId("gradingPeriod").value.trim();
    if(gradingPeriod === "firstgrading"){
        _elementId("studentInfoForFirstGrading").classList.remove("display-none");
        _elementId("studentInfoForSecondGrading").classList.add("display-none");
        _elementId("studentInfoForThirdGrading").classList.add("display-none");
        _elementId("studentInfoForFourthGrading").classList.add("display-none");
    }
     else if(gradingPeriod ==="secondgrading"){
         _elementId("studentInfoForFirstGrading").classList.add("display-none");
         _elementId("studentInfoForSecondGrading").classList.remove("display-none");
         _elementId("studentInfoForThirdGrading").classList.add("display-none");
         _elementId("studentInfoForFourthGrading").classList.add("display-none");
     }
     else if(gradingPeriod ==="thirdgrading"){
        _elementId("studentInfoForFirstGrading").classList.add("display-none");
         _elementId("studentInfoForSecondGrading").classList.add("display-none");
         _elementId("studentInfoForThirdGrading").classList.remove("display-none");
         _elementId("studentInfoForFourthGrading").classList.add("display-none");
     }
     else if(gradingPeriod ==="fourthgrading"){
        _elementId("studentInfoForFirstGrading").classList.add("display-none");
         _elementId("studentInfoForSecondGrading").classList.add("display-none");
         _elementId("studentInfoForThirdGrading").classList.add("display-none");
         _elementId("studentInfoForFourthGrading").classList.remove("display-none");
     }
    else{
        _elementId("studentInfoForFirstGrading").classList.add("display-none");
        _elementId("studentInfoForSecondGrading").classList.add("display-none");
        _elementId("studentInfoForThirdGrading").classList.add("display-none");
        _elementId("studentInfoForFourthGrading").classList.add("display-none");
    }
}
function submitGradesCta(){
    const studentId = _elementId("studentId").value.trim();
    const subjectEnglish = _elementId("subjectEnglish").value.trim();
    const subjectFilipino = _elementId("subjectFilipino").value.trim();
    const subjectMath = _elementId("subjectMath").value.trim();
    const subjectScience = _elementId("subjectScience").value.trim();
    const subjectAP = _elementId("subjectAP").value.trim();
    const subjectEsp = _elementId("subjectEsp").value.trim();
    const subjectTle = _elementId("subjectTle").value.trim();
    const subjectMusic = _elementId("subjectMusic").value.trim();
    const subjectArts = _elementId("subjectArts").value.trim();
    const subjectPe = _elementId("subjectPe").value.trim();
    const subjectHealth = _elementId("subjectHealth").value.trim();
    const average = _elementId("average").value.trim();
    const gradingPeriod = _elementId("gradingPeriod").value.trim();

    if(subjectEnglish === "" || subjectFilipino === "" || subjectMath === "" || subjectScience === "" || subjectAP === "" || subjectEsp === "" || subjectTle === "" || subjectMusic === "" || subjectArts === "" || subjectPe === "" || subjectHealth === ""){
        alert("All fields are required");
    }
    else{
        const x = new XMLHttpRequest();
        x.onload = function(){
            if(this.responseText === "grade exist"){
                alert("Grades already exists");
            }
            else{
                alert("New grades added successfully");
                _elementId("subjectEnglish").value = "";
                _elementId("subjectFilipino").value = "";
                _elementId("subjectMath").value = "";
                _elementId("subjectScience").value = "";
                _elementId("subjectAP").value = "";
                _elementId("subjectEsp").value = "";
                _elementId("subjectTle").value = "";
                _elementId("subjectMusic").value = "";
                _elementId("subjectArts").value = "";
                _elementId("subjectPe").value = "";
                _elementId("subjectHealth").value = "";
                _elementId("average").value = "";
                _query(".add-grade").close();
            }
        }
        x.open("POST","../registrar_re/encode_grades.php");
        x.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        x.send("subjectEnglish="+encodeURIComponent(subjectEnglish)+"&studentId="+encodeURIComponent(studentId)+"&subjectFilipino="+encodeURIComponent(subjectFilipino)+"&subjectMath="+encodeURIComponent(subjectMath)+"&subjectScience="+encodeURIComponent(subjectScience)+"&subjectAP="+encodeURIComponent(subjectAP)+"&subjectEsp="+encodeURIComponent(subjectEsp)+"&subjectTle="+encodeURIComponent(subjectTle)+"&subjectMusic="+encodeURIComponent(subjectMusic)+"&subjectArts="+encodeURIComponent(subjectArts)+"&subjectPe="+encodeURIComponent(subjectPe)+"&subjectHealth="+encodeURIComponent(subjectHealth)+"&average="+encodeURIComponent(average)+"&gradingPeriod="+gradingPeriod);
    }
}

//update first grading
function updateStudentGrades1Cta(gradeId){
    const x = new XMLHttpRequest();
    x.onload = function(){
        _elementId("updateGrade").innerHTML = this.responseText;
        _query(".update-grade").showModal();
    }
    x.open("GET","../registrar_re/encode_grades.php?updateStudentGrades1="+encodeURIComponent(gradeId));
    x.send();

}
//update second grading
function updateStudentGrades2Cta(id){
    const x = new XMLHttpRequest();
    x.onload = function(){
        _elementId("updateGrade").innerHTML = this.responseText;
        _query(".update-grade").showModal();
    }
    x.open("GET","../registrar_re/encode_grades.php?updateStudentGrades2="+encodeURIComponent(id));
    x.send();

}
//update third Grading
function updateStudentGrades3Cta(id){
    const x = new XMLHttpRequest();
    x.onload = function(){
        _elementId("updateGrade").innerHTML = this.responseText;
        _query(".update-grade").showModal();
    }
    x.open("GET","../registrar_re/encode_grades.php?updateStudentGrades3="+encodeURIComponent(id));
    x.send();

}
//update fourth Grading
function updateStudentGrades4Cta(id){
    const x = new XMLHttpRequest();
    x.onload = function(){
        _elementId("updateGrade").innerHTML = this.responseText;
        _query(".update-grade").showModal();
    }
    x.open("GET","../registrar_re/encode_grades.php?updateStudentGrades4="+encodeURIComponent(id));
    x.send();

}
//close update
function closeUpdateGradeCta(){
    _query(".update-grade").close();
}
function submitNewUpdateGrade1Cta(){
    const updateSubjectEnglish = _elementId("updateSubjectEnglish").value.trim();
    const updateSubjectFilipino = _elementId("updateSubjectFilipino").value.trim();
    const updateSubjectMath = _elementId("updateSubjectMath").value.trim();
    const updateSubjectScience = _elementId("updateSubjectScience").value.trim();
    const updateSubjectAP = _elementId("updateSubjectAP").value.trim();
    const updateSubjectEsp = _elementId("updateSubjectEsp").value.trim();
    const updateSubjectTle = _elementId("updateSubjectTle").value.trim();
    const updateSubjectMusic = _elementId("updateSubjectMusic").value.trim();
    const updateSubjectArts = _elementId("updateSubjectArts").value.trim();
    const updateSubjectPe = _elementId("updateSubjectPe").value.trim();
    const updateSubjectHealth = _elementId("updateSubjectHealth").value.trim();

        const x = new XMLHttpRequest();
        x.onload = function(){
            _query(".update-grade").close();
        }
        x.open("POST","../registrar_re/encode_grades.php");
        x.setRequestHeader("Content-type","application/x-www-form-urlencoded")
        x.send("updateSubjectEnglish="+updateSubjectEnglish+"&updateSubjectFilipino="+updateSubjectFilipino+"&updateSubjectMath="+updateSubjectMath+"&updateSubjectScience="+updateSubjectScience+"&updateSubjectAP="+updateSubjectAP+"&updateSubjectEsp="+updateSubjectEsp+"&updateSubjectTle="+updateSubjectTle+"&updateSubjectMusic="+updateSubjectMusic+"&updateSubjectArts="+updateSubjectArts+"&updateSubjectPe="+updateSubjectPe+"&updateSubjectHealth="+updateSubjectHealth);
}
//for contact number
function validateInputContactNum(input) {
    input.value = input.value.replace(/\D/g, '');
    if(input.value.length > 11){
        input.value = input.value.slice(0,11);
    }
}
//for name and others
function validateInputs(input) {
    input.value = input.value.replace(/[^A-Za-z\s]+/g, '');
}
//for grades
function validateInputGrades(input) {
    input.value = input.value.replace(/[^0-9]/g, '');
    if(input.value.length > 2){
        input.value = input.value.slice(0,2);
    }
}
//for lrn
function validateInputLrn(input) {
    input.value = input.value.replace(/\D/g, '');
    if(input.value.length > 12){
        input.value = input.value.slice(0,12);
    }
}
//for age
function validateInputAge(input) {
    input.value = input.value.replace(/\D/g, '');
    if(input.value.length > 2){
        input.value = input.value.slice(0,2);
    }
}
//for address
function validateInputsAddress(input) {
    input.value = input.value.replace(/[^A-Za-z.\-_,\s]+/g, '');
}
//calculate age
function calculateAge(){
    var studentBirthDateInput = document.getElementById("studentBirthDate");
    var studentAgeInput = document.getElementById("studentAge");

    var studentBirthDate = new Date(studentBirthDateInput.value);
    var today = new Date();

    var studentAge = today.getFullYear() - studentBirthDate.getFullYear();
    var monthDiff = today.getMonth() - studentBirthDate.getMonth();
    if(monthDiff < 0 || (monthDiff === 0 && today.getDate() < studentBirthDate.getDate())){
        studentAge--; 
    }
    studentAgeInput.value = studentAge;
}
//update age
function updatecalculateAge(){
    var updateBirthDateInput = document.getElementById("updateBirthDate");
    var updateAgeInput = document.getElementById("updateAge");

    var updateBirthDate = new Date(updateBirthDateInput.value);
    var today = new Date();

    var updateAge = today.getFullYear() - updateBirthDate.getFullYear();
    var monthDiff = today.getMonth() - updateBirthDate.getMonth();
    if(monthDiff < 0 || (monthDiff === 0 && today.getDate() < updateBirthDate.getDate())){
        updateAge--; 
    }
    updateAgeInput.value = updateAge;
}
//calculate grades
const gradeInputs = document.querySelectorAll('.grade-input');
gradeInputs.forEach(input =>{
    input.addEventListener('input', calculateAverage);
});
function calculateAverage(){
    let sum = 0;

    gradeInputs.forEach(input =>{
        const value = parseInt(input.value) || 0;
        sum += value;
    });

    const average = sum / 11;

    document.getElementById('average').value = average.toFixed(2);
}
//second
const gradeInputsTwo = document.querySelectorAll('.grade-inputTwo');
gradeInputsTwo.forEach(input =>{
    input.addEventListener('input', calculateAverage2);
});
function calculateAverage2(){
    let sum = 0;

    gradeInputsTwo.forEach(input =>{
        const value = parseInt(input.value) || 0;
        sum += value;
    });

    const averageTwo = sum / 11;

    document.getElementById('averageTwo').value = averageTwo.toFixed(2);
}
//third
const gradeInputsThree = document.querySelectorAll('.grade-inputThree');
gradeInputsThree.forEach(input =>{
    input.addEventListener('input', calculateAverage3);
});
function calculateAverage3(){
    let sum = 0;

    gradeInputsThree.forEach(input =>{
        const value = parseInt(input.value) || 0;
        sum += value;
    });

    const averageThree = sum / 11;

    document.getElementById('averageThree').value = averageThree.toFixed(2);
}
//fourth
const gradeInputsFourth = document.querySelectorAll('.grade-inputFourth');
gradeInputsFourth.forEach(input =>{
    input.addEventListener('input', calculateAverage4);
});
function calculateAverage4(){
    let sum = 0;

    gradeInputsFourth.forEach(input =>{
        const value = parseInt(input.value) || 0;
        sum += value;
    });

    const averageFourth = sum / 11;

    document.getElementById('averageFourth').value = averageFourth.toFixed(2);
}
//update grades
const updateGradeInputs = document.querySelectorAll('.grade-inputs');
updateGradeInputs.forEach(input =>{
    input.addEventListener('input', calculateAverageOne);
});
function calculateAverageOne(){
    let sum = 0;

    updateGradeInputs.forEach(input =>{
        const value = parseInt(input.value) || 0;
        sum += value;
    });
    const updateAverage = sum / 11;

    document.getElementById('updateAverage').value = updateAverage.toFixed(2);
}