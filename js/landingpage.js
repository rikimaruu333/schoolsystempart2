function openStudentLoginModal() {
    var modal = document.getElementById("studentModal");
    modal.style.display = "block";
  }
  
  // Function to close the create modal
  function closeStudentModal() {
    var modal = document.getElementById("studentModal");
    modal.style.display = "none";
  }
  
  function openTeacherLoginModal() {
    var modal = document.getElementById("teacherModal");
    modal.style.display = "block";
  }
  
  // Function to close the create modal
  function closeTeacherModal() {
    var modal = document.getElementById("teacherModal");
    modal.style.display = "none";
  }
  

  
let studenteyeicon = document.getElementById("studenteyeicon");
let studentpassword = document.getElementById("studentPassword");

studenteyeicon.onclick = function(){
    if(studentpassword.type == "password"){
        studentpassword.type = "text";
        studenteyeicon.src = "../images/hide.png";
    }
    else{
        studentpassword.type = "password";
        studenteyeicon.src = "../images/show.png";
    }
}

let teachereyeicon = document.getElementById("teachereyeicon");
let teacherpassword = document.getElementById("teacherPassword");

teachereyeicon.onclick = function(){
    if(teacherpassword.type == "password"){
        teacherpassword.type = "text";
        teachereyeicon.src = "../images/hide.png";
    }
    else{
        teacherpassword.type = "password";
        teachereyeicon.src = "../images/show.png";
    }
}