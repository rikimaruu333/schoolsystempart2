<?php
require_once "userconnection.php";

// Check if it's a GET request and if the required parameters are set
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['subjectId'], $_GET['departmentId'], $_GET['courseId'], $_GET['yearlevelId'])) {
    $subjectId = $_GET['subjectId'];
    $departmentId = $_GET['departmentId'];
    $courseId = $_GET['courseId'];
    $yearlevelId = $_GET['yearlevelId'];

    try {
        $newconnection = new Connection();
        $connection = $newconnection->openConnection();

        // Prepare and execute the delete query
        $stmt = $connection->prepare("DELETE FROM subjects WHERE subject_id = :subject_id");
        $stmt->bindParam(':subject_id', $subjectId);

        if ($stmt->execute()) {
            // Redirect back to the viewdepartment.php page after successful deletion
            header("Location: yearLevelPage.php?department_id=$departmentId&course_id=$courseId&yearlevel_id=$yearlevelId");
            exit();
        } else {
            // Handle the error if deletion fails
            echo "Error deleting subject. Please try again.";
        }

        $newconnection->closeConnection();
    } catch (PDOException $e) {
        // Handle database connection or query errors
        echo "Error: " . $e->getMessage();
    }
} else {
    // Handle invalid requests
    echo "Invalid request";
}
?>
