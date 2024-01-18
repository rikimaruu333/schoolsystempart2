<?php
require_once("userconnection.php");

if (isset($_GET['studentId'])) {
    $studentId = $_GET['studentId'];

    $newconnection = new Connection();
    $connection = $newconnection->openConnection();

    // Delete the student record
    $sql = "DELETE FROM students WHERE student_id = :studentId";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':studentId', $studentId, PDO::PARAM_INT);
    $stmt->execute();

    // Redirect back to the dashboard
    header("Location: students.php");
    exit();
}
?>
