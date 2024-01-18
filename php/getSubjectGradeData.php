<?php
require_once("userconnection.php");

if (isset($_GET['subjectId']) && isset($_GET['studentId'])) {
    $subjectId = $_GET['subjectId'];
    $studentId = $_GET['studentId'];

    $newconnection = new Connection();
    $connection = $newconnection->openConnection();

    $sql = "SELECT * FROM grades WHERE subject_id = :subjectId AND student_id = :studentId AND status = 'Printed'";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':subjectId', $subjectId, PDO::PARAM_INT);
    $stmt->bindParam(':studentId', $studentId, PDO::PARAM_INT);
    $stmt->execute();

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($data);
}
?>
