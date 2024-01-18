<?php
require_once("userconnection.php");

if (isset($_GET['teacherId'])) {
    $teacherId = $_GET['teacherId'];

    $newconnection = new Connection();
    $connection = $newconnection->openConnection();

    $sql = "SELECT * FROM teachers WHERE teacher_id = :teacherId";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':teacherId', $teacherId, PDO::PARAM_INT);
    $stmt->execute();

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($data);
}
?>
