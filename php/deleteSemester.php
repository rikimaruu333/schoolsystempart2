<?php
require_once("userconnection.php");

if (isset($_GET['semesterId'])) {
    $semesterId = $_GET['semesterId'];

    $newconnection = new Connection();
    $connection = $newconnection->openConnection();

    // Delete the semester record
    $sql = "DELETE FROM semester WHERE semester_id = :semesterId";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':semesterId', $semesterId, PDO::PARAM_INT);
    $stmt->execute();

    // Redirect back to the dashboard
    header("Location: semesters.php");
    exit();
}
?>
