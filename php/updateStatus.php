<?php
require_once('userconnection.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $studentId = $_POST["studentId"];
    $subjectId = $_POST["subjectId"];

    try {
        $newconnection = new Connection();
        $connection = $newconnection->openConnection();
        
        $query = "UPDATE grades SET status = 'Printed' WHERE student_id = :studentId AND subject_id = :subjectId";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':studentId', $studentId, PDO::PARAM_INT);
        $stmt->bindParam(':subjectId', $subjectId, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            // Error in the update
            echo "Error updating status: " . print_r($stmt->errorInfo(), true);
        } else {
            // Successful update
            echo "Status updated successfully.";
        }
    } catch (PDOException $e) {
        // Handle database errors
        echo "Database error: " . $e->getMessage();
    }
} else {
    // Invalid request method
    echo "Invalid request method.";
}
?>
