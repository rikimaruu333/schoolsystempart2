<?php
require_once("userconnection.php");

if (isset($_GET['semesterId'])) {
    $semesterId = $_GET['semesterId'];

    $newconnection = new Connection();
    $connection = $newconnection->openConnection();

    $sql = "SELECT * FROM semester WHERE semester_id = :semesterId";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':semesterId', $semesterId, PDO::PARAM_INT);
    $stmt->execute();

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($data);
}
?>
