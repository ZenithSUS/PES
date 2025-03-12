<?php
include("./database.php");
header('Content-Type: application/json');

$code = isset($_POST['code']) ? $_POST['code'] : null;
$evaluator_role = isset($_POST['evaluator_role']) ? $_POST['evaluator_role'] : null;
$user_to_eval = isset($_POST['user_to_eval']) ? $_POST['user_to_eval'] : null;
$today = date("F j, Y");

if (!$code) {
    echo json_encode(['success' => false, 'message' => 'Request code is required']);
    exit;
}

if (!$evaluator_role) {
    echo json_encode(['success' => false, 'message' => 'Evaluator role is required']);
    exit;
}

if (!$user_to_eval) {
    echo json_encode(['success' => false, 'message' => 'Employee ID is missing']);
    exit;
}

$sourceFile = '../forms/evaluation_form_template.xlsx';
$newFileName = '../forms/evaluation/'. $code .'.xlsx';

if (!file_exists($sourceFile)) {
    echo json_encode(['success' => false, 'message' => 'Source file not found']);
    exit;
}

if (copy($sourceFile, $newFileName)) {

    $updateStatus = "UPDATE accounts SET current_eval = ? WHERE employee_id = ?";

    $stmt = $con->prepare($updateStatus);
    $stmt->bind_param("ss", $newFileName,$user_to_eval);
    
    if ($stmt->execute()) {

        $updateStatus = "INSERT INTO evaluation(account_id, evaluation_date, evaluator_hr, evaluation_file) VALUES(?, ?, ?, ?)";

        $stmt = $con->prepare($updateStatus);
        $stmt->bind_param("ssss", $user_to_eval, $today, $_SESSION['user_id'], $newFileName);
        
        if ($stmt->execute()) {
            
            echo json_encode(['success' => true, 'newFileName' => $newFileName]);
    
        } else {
    
            echo json_encode(['success' => false, 'message' => 'Failed to update status']);
    
        }

    } else {

        echo json_encode(['success' => false, 'message' => 'Failed to update status']);

    }
    
    $stmt->close();

} else {
    echo json_encode(['success' => false, 'message' => 'Failed to copy and rename the file']);
}