let sidebarbtn = document.querySelector('#sidebarbtn');
let sidebar = document.querySelector('.sidebar');

sidebarbtn.onclick = function() {
    sidebar.classList.toggle('active');
};

function openCreateModal(studentId, subjectId, teacherId) {
    // Fetch existing data using AJAX
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var existingData = JSON.parse(this.responseText);

            // Set existing data in the modal input fields
            var modal = document.getElementById("myModal");
            modal.style.display = "block";

            // Set the studentId value in the hidden input field
            var studentIdInput = document.getElementById("studentId");
            studentIdInput.value = studentId;
            
            var subjectIdInput = document.getElementById("subjectId");
            subjectIdInput.value = subjectId;
            
            var teacherIdInput = document.getElementById("teacherId");
            teacherIdInput.value = teacherId;

            // Populate input fields with existing data
            document.getElementById("prelimScore").value = existingData.prelim || '';
            document.getElementById("midtermScore").value = existingData.midterm || '';
            document.getElementById("semifinalScore").value = existingData.semi_finals || '';
            document.getElementById("finalScore").value = existingData.finals || '';

            // Calculate and display the final grade
            calculateFinalGrade();
        }
    };
    // Adjust the URL to match your backend script that fetches existing data
    xhttp.open("GET", "getStudentGradeData.php?studentId=" + studentId + "&subjectId=" + subjectId + "&teacherId=" + teacherId, true);
    xhttp.send();
}


  
  // Function to close the create modal
  function closeModal() {
    var modal = document.getElementById("myModal");
    modal.style.display = "none";
  }


  function calculateFinalGrade() {
    // Get the input values
    var prelimScore = parseFloat(document.getElementById('prelimScore').value) || 0;
    var midtermScore = parseFloat(document.getElementById('midtermScore').value) || 0;
    var semifinalScore = parseFloat(document.getElementById('semifinalScore').value) || 0;
    var finalScore = parseFloat(document.getElementById('finalScore').value) || 0;

    // Set the maximum possible points (assumed to be 100 for each score)
    var maxPoints = 100;

    // Calculate the total points earned
    var totalPointsEarned = prelimScore + midtermScore + semifinalScore + finalScore;

    // Calculate the final grade as a percentage
    var finalGradePercentage = (totalPointsEarned / (4 * maxPoints)) * 100;

    // Display the final grade
    var finalGradeElement = document.getElementById('finalGrade');
    var finalGradePercentageFormatted = finalGradePercentage.toFixed(2);
    finalGradeElement.textContent = finalGradePercentageFormatted;

        // Determine the corresponding remarks based on the grade scale
        var remarks = getRemarks(finalGradePercentage);

        // Display the remarks
        var remarksElement = document.getElementById('remarks');
        remarksElement.textContent = remarks;
}

function getRemarks(finalGradePercentage) {
    // Round the final grade to the nearest 0.1
    var roundedGrade = Math.round(finalGradePercentage * 10) / 10;

    // Grade scale and remarks
    var gradeScale = [
        { grade: '1.0', range: [99.0, 100], remark: 'Excellent' },
        { grade: '1.1', range: [97.0, 99.0], remark: 'Superior' },
        { grade: '1.2', range: [95.0, 97.0], remark: 'Superior' },
        { grade: '1.3', range: [93.0, 95.0], remark: 'Very Satisfactory' },
        { grade: '1.4', range: [91.0, 93.0], remark: 'Very Satisfactory' },
        { grade: '1.5', range: [90.0, 91.0], remark: 'Satisfactory' },
        { grade: '1.6', range: [89.0, 90.0], remark: 'Satisfactory' },
        { grade: '1.7', range: [88.0, 89.0], remark: 'Fairly Satisfactory' },
        { grade: '1.8', range: [87.0, 88.0], remark: 'Fairly Satisfactory' },
        { grade: '1.9', range: [86.0, 87.0], remark: 'Barely Satisfactory' },
        { grade: '2.0', range: [85.0, 86.0], remark: 'Barely Satisfactory' },
        { grade: '2.1', range: [84.0, 85.0], remark: 'Poor Satisfactory' },
        { grade: '2.2', range: [83.0, 84.0], remark: 'Poor Satisfactory' },
        { grade: '2.3', range: [82.0, 83.0], remark: 'Poor Satisfactory' },
        { grade: '2.4', range: [81.0, 82.0], remark: 'Poor Satisfactory' },
        { grade: '2.5', range: [80.0, 81.0], remark: 'Unsatisfactory' },
        { grade: '2.6', range: [79.0, 80.0], remark: 'Unsatisfactory' },
        { grade: '2.7', range: [78.0, 79.0], remark: 'Unsatisfactory' },
        { grade: '2.8', range: [77.0, 78.0], remark: 'Unsatisfactory' },
        { grade: '2.9', range: [76.0, 77.0], remark: 'Unsatisfactory' },
        { grade: '3.0', range: [75.0, 76.0], remark: 'Unsatisfactory' },
        { grade: 'Below 3.0', range: [60.0, 74.99], remark: 'Failed' },
        { grade: 'No Grade', range: [0, 59.99], remark: 'No Grade' },
    ];

    for (var i = 0; i < gradeScale.length; i++) {
        var gradeInfo = gradeScale[i];
        var minRange = gradeInfo.range[0];
        var maxRange = gradeInfo.range[1];

        if (roundedGrade >= minRange && roundedGrade <= maxRange) {
            return (roundedGrade < 75.0) ? gradeInfo.remark : gradeInfo.grade;
        }
    }

    return 'Remark not found'; 
}


function updateStatus(studentId, subjectId) {
    var confirmation = confirm('Students will be able to view their grades. Print grades?');
    
    if (confirmation) {
        // Send AJAX request to update the table
        $.ajax({
            type: "POST",
            url: "updateStatus.php",
            data: {
                studentId: studentId,
                subjectId: subjectId
            },
            success: function(response) {
                // Handle the response from the server (if needed)
                console.log(response);
                // Optionally, you can redirect or perform additional actions here
            },
            error: function(error) {
                // Handle the error (if needed)
                console.error(error);
            }
        });
    }
}

function openGradesModal() {
    var modal = document.getElementById("gradesModal");
    modal.style.display = "block";
  }

function closeGradesModal() {
    var modal = document.getElementById("gradesModal");
    modal.style.display = "none";
  }

