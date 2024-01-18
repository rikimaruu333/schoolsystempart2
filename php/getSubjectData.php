<?php
require_once("userconnection.php");

if (isset($_GET['subjectId'])) {
    $subjectId = $_GET['subjectId'];

    $newconnection = new Connection();
    $connection = $newconnection->openConnection();

    $sql = "SELECT * FROM subjects WHERE subject_id = :subjectId";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':subjectId', $subjectId, PDO::PARAM_INT);
    $stmt->execute();

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($data);
}
?>
