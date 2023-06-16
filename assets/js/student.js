function viewDetailCta(){
    _query(".update-enrollment").showModal();
}
//view info
function viewDetailCta(id){
    const x = new XMLHttpRequest();
    x.onload = function(){
        _elementId("updateStudents").innerHTML = this.responseText;
        _query(".update-enrollment").showModal();
    }
    x.open("GET","../student_re/view_reports.php?studentId="+encodeURIComponent(id));
    x.send();

}
function printFormCta(){
    _query(".print-form").showModal();
}
//view info
function viewStudentInfoCta(id){
    const x = new XMLHttpRequest();
    x.onload = function(){
        _elementId("updateStudents").innerHTML = this.responseText;
        _query(".update-enrollment").showModal();
    }
    x.open("GET","../student_re/view_reports.php?viewStudentInfo="+encodeURIComponent(id));
    x.send();

}
//view first grading
function StudentGrades1Cta(gradeId){
    const x = new XMLHttpRequest();
    x.onload = function(){
        _elementId("updateGrade").innerHTML = this.responseText;
        _query(".update-grade").showModal();
    }
    x.open("GET","../student_re/view_grades.php?StudentGrades1="+encodeURIComponent(gradeId));
    x.send();

}
//view second grading
function StudentGrades2Cta(gradeId){
    const x = new XMLHttpRequest();
    x.onload = function(){
        _elementId("updateGrade").innerHTML = this.responseText;
        _query(".update-grade").showModal();
    }
    x.open("GET","../student_re/view_grades.php?StudentGrades2="+encodeURIComponent(gradeId));
    x.send();

}
//view first grading
function StudentGrades3Cta(gradeId){
    const x = new XMLHttpRequest();
    x.onload = function(){
        _elementId("updateGrade").innerHTML = this.responseText;
        _query(".update-grade").showModal();
    }
    x.open("GET","../student_re/view_grades.php?StudentGrades3="+encodeURIComponent(gradeId));
    x.send();

}
//view first grading
function StudentGrades4Cta(gradeId){
    const x = new XMLHttpRequest();
    x.onload = function(){
        _elementId("updateGrade").innerHTML = this.responseText;
        _query(".update-grade").showModal();
    }
    x.open("GET","../student_re/view_grades.php?StudentGrades4="+encodeURIComponent(gradeId));
    x.send();

}