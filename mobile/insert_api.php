<?php

include '../api/database.php';

header('Content-Type: application/json');

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['activity_id']) && isset($data['score'])) {

    $activity_id = $data['activity_id'];
    $correct_answers_count = $data['score'];
    $student = $data['student_id'];
    $date = $data['date_taken'];
    $items = $data['items'];
    $percentage = $data['percentage'];
    $performanceCategory = $data['performanceCategory'];
    $description = $data['description'];
    $action = $data['action'];

    $stmt = $con->prepare("INSERT INTO records (activity_id, score, items, percentage, student_id, performanceCateg, description, action, date_taken) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiisissss", $activity_id, $correct_answers_count, $items, $percentage, $student, $performanceCategory, $description, $action, $date);

    if ($stmt->execute()) {
        echo json_encode(array("status" => "success", "message" => "Data inserted successfully"));
    } else {
        echo json_encode(array("status" => "error", "message" => "Error: " . $stmt->error));
    }

    $stmt->close();
} else {
    echo json_encode(array("status" => "error", "message" => "Invalid input"));
}

$con->close();
?>