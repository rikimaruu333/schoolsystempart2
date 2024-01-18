<?php
require_once("userconnection.php");

if (isset($_GET['teacherId'])) {
    $teacherId = $_GET['teacherId'];

    $newconnection = new Connection();
    $connection = $newconnection->openConnection();

    // Delete the teacher record
    $sql = "DELETE FROM teachers WHERE teacher_id = :teacherId";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':teacherId', $teacherId, PDO::PARAM_INT);
    $stmt->execute();

    // Redirect back to the dashboard
    header("Location: teachers.php");
    exit();
}
?>
