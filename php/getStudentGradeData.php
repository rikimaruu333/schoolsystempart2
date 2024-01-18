<?php
require_once("userconnection.php");

if (isset($_GET['studentId']) && isset($_GET['subjectId']) && isset($_GET['teacherId'])) {
    $studentId = $_GET['studentId'];
    $subjectId = $_GET['subjectId'];
    $teacherId = $_GET['teacherId'];

    $newconnection = new Connection();
    $connection = $newconnection->openConnection();

    $sql = "SELECT * FROM grades WHERE student_id = :studentId AND subject_id = :subjectId AND teacher_id = :teacherId";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':studentId', $studentId, PDO::PARAM_INT);
    $stmt->bindParam(':subjectId', $subjectId, PDO::PARAM_INT);
    $stmt->bindParam(':teacherId', $teacherId, PDO::PARAM_INT);
    $stmt->execute();

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($data);
}
?>
