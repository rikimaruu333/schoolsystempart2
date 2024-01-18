let sidebarbtn = document.querySelector('#sidebarbtn');
let sidebar = document.querySelector('.sidebar');

sidebarbtn.onclick = function() {
    sidebar.classList.toggle('active');
};

function setZIndex(value) {
  var elements = document.querySelectorAll('.tablecontainer th');
  elements.forEach(function(element) {
      element.style.zIndex = value;
  });
}

// Function to open the create modal
function openCreateModal() {
    var modal = document.getElementById("myModal");
    modal.style.display = "block";
    setZIndex("0");
  }
  
  // Function to close the create modal
  function closeModal() {
    var modal = document.getElementById("myModal");
    modal.style.display = "none";
    setZIndex("1");
  }

  function openUpdateModal(teacherId) {
    // Fetch teacher data using AJAX
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);
  
            // Populate the update modal with the fetched data
            document.getElementById("updateTeacherName").value = data.teacher_name;
            document.getElementById("updateTeacherEmail").value = data.teacher_email;
            // You may need to handle the department data differently based on your storage structure
            var departmentOption = document.querySelector("#updateTeacherDepartment option[value='" + data.department_id + "|" + data.department_name + "']");
            if (departmentOption) {
                departmentOption.selected = true;
            }
            document.getElementById("updateTeacherPassword").value = data.teacher_password;
            document.getElementById("updateTeacherId").value = teacherId;

            
            var existingLogoContainer = document.getElementById("updateProfile"); // Adjusted ID here
            existingLogoContainer.style.backgroundImage = "url('" + data.teacher_profile + "')";
  
            // Show the update modal
            document.getElementById("updateModal").style.display = "block";
            setZIndex("0");
        }
    };
    xhttp.open("GET", "getTeacherData.php?teacherId=" + teacherId, true);
    xhttp.send();
}

  // Function to close the update modal
  function closeUpdateModal() {
    var updatemodal = document.getElementById("updateModal");
    updatemodal.style.display = "none";
    setZIndex("1");
  }

let eyeicon = document.getElementById("eyeicon");
let password = document.getElementById("teacherPassword");

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
let updatePassword = document.getElementById("updateTeacherPassword");

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


function handleFileSelect(input) {
    var file = input.files[0];
    var reader = new FileReader();
    reader.onload = function(e) {
        document.querySelector('.profile_img').style.backgroundImage = 'url(' + e.target.result + ')';
    };
    reader.readAsDataURL(file);
  }