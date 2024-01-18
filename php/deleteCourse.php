<?php
require_once "userconnection.php";

// Check if it's a GET request and if the required parameters are set
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['courseId'], $_GET['departmentId'])) {
    $courseId = $_GET['courseId'];
    $departmentId = $_GET['departmentId'];

    try {
        $newconnection = new Connection();
        $connection = $newconnection->openConnection();

        // Prepare and execute the delete query
        $stmt = $connection->prepare("DELETE FROM course WHERE course_id = :course_id");
        $stmt->bindParam(':course_id', $courseId);

        if ($stmt->execute()) {
            // Redirect back to the viewdepartment.php page after successful deletion
            header("Location: viewdepartment.php?department_id=$departmentId");
            exit();
        } else {
            // Handle the error if deletion fails
            echo "Error deleting course. Please try again.";
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
