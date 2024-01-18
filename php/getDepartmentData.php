<?php
require_once("userconnection.php");

if (isset($_GET['departmentId'])) {
    $departmentId = $_GET['departmentId'];

    $newconnection = new Connection();
    $connection = $newconnection->openConnection();

    $sql = "SELECT * FROM department WHERE department_id = :departmentId";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':departmentId', $departmentId, PDO::PARAM_INT);
    $stmt->execute();

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($data);
}
?>
