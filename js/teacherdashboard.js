let sidebarbtn = document.querySelector('#sidebarbtn');
let sidebar = document.querySelector('.sidebar');

sidebarbtn.onclick = function() {
    sidebar.classList.toggle('active');
};


// Function to open the create modal
function openCreateModal() {
    var modal = document.getElementById("myModal");
    modal.style.display = "block";
  }
  
  // Function to close the create modal
  function closeModal() {
    var modal = document.getElementById("myModal");
    modal.style.display = "none";
  }

  function openUpdateModal(studentId) {
    // Fetch student data using AJAX
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);
  
            // Populate the update modal with the fetched data
            document.getElementById("updateStudentName").value = data.student_name;
            document.getElementById("updateStudentEmail").value = data.student_email;
            
            // You may need to handle the department data differently based on your storage structure
            var departmentOption = document.querySelector("#updateStudentDepartment option[value='" + data.department_id + "|" + data.department_name + "']");
            if (departmentOption) {
                departmentOption.selected = true;
            }

            var courseOption = document.querySelector("#updateStudentCourse option[value='" + data.course_id + "|" + data.course_name + "']");
            if (courseOption) {
                courseOption.selected = true;
            }

            var yearlevelOption = document.querySelector("#updateStudentYearlevel option[value='" + data.yearlevel_id + "|" + data.year_level + "']");
            if (yearlevelOption) {
                yearlevelOption.selected = true;
            }

            document.getElementById("updateStudentPassword").value = data.student_password;
            document.getElementById("updateStudentId").value = studentId;
  
            // Show the update modal
            document.getElementById("updateModal").style.display = "block";
        }
    };
    xhttp.open("GET", "getStudentData.php?studentId=" + studentId, true);
    xhttp.send();
}

  // Function to close the update modal
  function closeUpdateModal() {
    var updatemodal = document.getElementById("updateModal");
    updatemodal.style.display = "none";
  }

let eyeicon = document.getElementById("eyeicon");
let password = document.getElementById("studentPassword");

eyeicon.onclick = function(){
    if(password.type == "password"){
        password.type = "text";
        eyeicon.src = "../images/hide.png";
    }
    else{
        password.type = "password";
        eyeicon.src = "../images/show.png";
    }
}

let updateEyeicon = document.getElementById("updateEyeIcon");
let updatePassword = document.getElementById("updateStudentPassword");

updateEyeicon.onclick = function(){
    if(updatePassword.type == "password"){
        updatePassword.type = "text";
        updateEyeicon.src = "../images/hide.png";
    }
    else{
        updatePassword.type = "password";
        updateEyeicon.src = "../images/show.png";
    }
}