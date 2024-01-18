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

  function openUpdateModal(subjectId) {
    // Fetch course data using AJAX
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);
  
            // Populate the update modal with the fetched data
            document.getElementById("updateSubjectName").value = data.subject_name;
            document.getElementById("updateDescriptiveTitle").value = data.descriptive_title;
            document.getElementById("updateSubjectId").value = subjectId;
  
            // Show the update modal
            document.getElementById("updateModal").style.display = "block";
            setZIndex("0");
        }
    };
    xhttp.open("GET", "getSubjectData.php?subjectId=" + subjectId, true);
    xhttp.send();
  }
  
  // Function to close the update modal
  function closeUpdateModal() {
    var updatemodal = document.getElementById("updateModal");
    updatemodal.style.display = "none";
    setZIndex("1");
  }
  
function openAssignModal(subjectId) {
    // Fetch subject data using AJAX
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            if (this.status == 200) {
                var data = JSON.parse(this.responseText);

                document.getElementById("assignSubjectId").value = subjectId;
                document.getElementById("assignModal").style.display = "block";
                setZIndex("0");

            } else {
                console.error("Error fetching subject data");
            }
        }
    };
    xhttp.open("GET", "getSubjectData.php?subjectId=" + subjectId, true);
    xhttp.send();
}


// Function to close the assign modal
function closeAssignModal() {
    var assignModal = document.getElementById("assignModal");
    assignModal.style.display = "none";
    setZIndex("1");
}
