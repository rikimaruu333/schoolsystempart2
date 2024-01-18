<?php
require_once("userconnection.php");

if (isset($_GET['courseId'])) {
    $courseId = $_GET['courseId'];

    $newconnection = new Connection();
    $connection = $newconnection->openConnection();

    $sql = "SELECT * FROM course WHERE course_id = :courseId";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':courseId', $courseId, PDO::PARAM_INT);
    $stmt->execute();

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($data);
}
?>
