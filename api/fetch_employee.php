<?php
include 'database.php';

if (isset($_GET['id'])) {
    $employee_id = $_GET['id'];

    $sql = "SELECT * FROM accounts WHERE employee_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $employeeData = $result->fetch_assoc();
        echo json_encode($employeeData);
    } else {
        echo json_encode(["error" => "Employee not found"]);
    }
}
?>