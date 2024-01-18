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

  function openUpdateSemesterModal(semesterId) {
    // Fetch semester data using AJAX
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);

            // Populate the update modal with the fetched data
            document.getElementById("updateSemesterName").value = data.semester;
            document.getElementById("updateSemesterId").value = semesterId;

            // Show the update modal
            document.getElementById("updateModal").style.display = "block";
    
        }
    };
    xhttp.open("GET", "getSemesterData.php?semesterId=" + semesterId, true);
    xhttp.send();
}


  // Function to close the update modal
  function closeUpdateModal() {
    var updatemodal = document.getElementById("updateModal");
    updatemodal.style.display = "none";
  }