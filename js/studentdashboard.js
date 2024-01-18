let sidebarbtn = document.querySelector('#sidebarbtn');
let sidebar = document.querySelector('.sidebar');

sidebarbtn.onclick = function() {
    sidebar.classList.toggle('active');
};

// Modify the function to accept two parameters
function openCreateModal(subjectId, studentId) {
    // Fetch existing data using AJAX
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var existingData = JSON.parse(this.responseText);

            // Set existing data in the modal input fields
            var modal = document.getElementById("myModal");
            modal.style.display = "block";

            // Set the subjectId and studentId values in the hidden input fields
            var subjectIdInput = document.getElementById("subjectId");
            var studentIdInput = document.getElementById("studentId");
            subjectIdInput.value = subjectId;
            studentIdInput.value = studentId;

            document.getElementById("prelimScore").textContent = existingData.prelim || '';
            document.getElementById("midtermScore").textContent = existingData.midterm || '';
            document.getElementById("semifinalScore").textContent = existingData.semi_finals || '';
            document.getElementById("finalScore").textContent = existingData.finals || '';
            document.getElementById("finalGrade").textContent = existingData.final_grade || '';

            // Calculate and display the final grade
            calculateAndDisplayRemarks();
        }
    };

    // Adjust the URL to match your backend script that fetches existing data
    xhttp.open("GET", "getSubjectGradeData.php?subjectId=" + subjectId + "&studentId=" + studentId, true);
    xhttp.send();
}

// Function to close the create modal
  function closeModal() {
    var modal = document.getElementById("myModal");
    modal.style.display = "none";
  }

  function calculateAndDisplayRemarks() {
    // Get the displayed final grade
    var displayedFinalGrade = parseFloat(document.getElementById('finalGrade').textContent) || 0;

    // Determine the corresponding remarks based on the grade scale
    var remarks = getRemarks(displayedFinalGrade);

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
