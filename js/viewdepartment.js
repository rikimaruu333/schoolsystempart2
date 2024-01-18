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

function openCourseModal(courseId) {
  // Fetch course data using AJAX
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4) {
      if (this.status == 200) {
        var data = JSON.parse(this.responseText);

        document.getElementById("CourseName").innerHTML = data.course_name;

        var numCourses = 4; 
        for (var i = 1; i <= numCourses; i++) {
            var elementId = "CourseId" + i;
            var element = document.getElementById(elementId);
            if (element) {
                element.value = courseId;
            }
        }
        
        document.getElementById("openCourseModal").style.display = "block";
      } else {
        // Handle errors here
        console.error("Error fetching course data");
      }
    }
  };
  xhttp.open("GET", "getCourseData.php?courseId=" + courseId, true);
  xhttp.send();
}

// Function to close the create modal
function closeCourseModal() {
  var modal = document.getElementById("openCourseModal");
  modal.style.display = "none";
}

function openUpdateModal(courseId) {
  // Fetch course data using AJAX
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
          var data = JSON.parse(this.responseText);

          // Populate the update modal with the fetched data
          document.getElementById("updateCourseName").value = data.course_name;
          document.getElementById("updateCourseAcronym").value = data.course_acronym;
          document.getElementById("updateCourseId").value = courseId;

          // Show the update modal
          document.getElementById("updateModal").style.display = "block";
      }
  };
  xhttp.open("GET", "getCourseData.php?courseId=" + courseId, true);
  xhttp.send();
}

// Function to close the update modal
function closeUpdateModal() {
  var updatemodal = document.getElementById("updateModal");
  updatemodal.style.display = "none";
}

