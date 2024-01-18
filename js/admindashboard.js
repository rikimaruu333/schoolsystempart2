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

function openUpdateModal(departmentId) {
  // Fetch department data using AJAX
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
          var data = JSON.parse(this.responseText);

          // Populate the update modal with the fetched data
          document.getElementById("updateDepartmentName").value = data.department_name;
          document.getElementById("updateDepartmentAcronym").value = data.department_acronym;
          document.getElementById("updateDepartmentId").value = departmentId;

          // Display the existing logo in the image container
          var existingLogoContainer = document.getElementById("updateLogo2"); // Adjusted ID here
          existingLogoContainer.style.backgroundImage = "url('" + data.department_logo + "')";

          document.getElementById("updateModal").style.display = "block";
      }
  };
  xhttp.open("GET", "getDepartmentData.php?departmentId=" + departmentId, true);
  xhttp.send();
}


// Function to close the update modal
function closeUpdateModal() {
  var updatemodal = document.getElementById("updateModal");
  updatemodal.style.display = "none";
}

function handleFileSelect(input) {
  var file = input.files[0];
  var reader = new FileReader();
  reader.onload = function(e) {
      document.querySelector('.profile_img').style.backgroundImage = 'url(' + e.target.result + ')';
  };
  reader.readAsDataURL(file);
}

function handleFileSelect2(input) {
  var file = input.files[0];
  var reader = new FileReader();
  reader.onload = function(e) {
      document.querySelector('.profile_img2').style.backgroundImage = 'url(' + e.target.result + ')';
  };
  reader.readAsDataURL(file);
}
