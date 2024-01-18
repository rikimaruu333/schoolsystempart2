<?php
require_once("userconnection.php");

if (isset($_GET['studentId'])) {
    $studentId = $_GET['studentId'];

    $newconnection = new Connection();
    $connection = $newconnection->openConnection();

    $sql = "SELECT * FROM students WHERE student_id = :studentId";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':studentId', $studentId, PDO::PARAM_INT);
    $stmt->execute();

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($data);
}
?>
