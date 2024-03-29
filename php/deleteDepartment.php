<?php
require_once("userconnection.php");

if (isset($_GET['departmentId'])) {
    $departmentId = $_GET['departmentId'];

    $newconnection = new Connection();
    $connection = $newconnection->openConnection();

    // Delete the department record
    $sql = "DELETE FROM department WHERE department_id = :departmentId";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':departmentId', $departmentId, PDO::PARAM_INT);
    $stmt->execute();

    // Redirect back to the dashboard
    header("Location: admindashboard.php");
    exit();
}
?>
