<?php

include '../api/database.php';
require_once '../api/session.php';

header('Content-Type: application/json');

ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '../logs/php-error.log');
error_reporting(E_ALL);

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $lecture_name = sanitizeInput($_POST['lecture_name']);
        $section_id = sanitizeInput($_POST['course_id_section']);
        $employee = sanitizeInput($_POST['employee_id']);
        $status = sanitizeInput($_POST['status']);

        // File Upload
        if (isset($_FILES['filepond']) && $_FILES['filepond']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['filepond']['tmp_name'];
            $fileName = $_FILES['filepond']['name'];
            $fileType = $_FILES['filepond']['type'];

            $allowedTypes = ['application/pdf'];
            if (!in_array($fileType, $allowedTypes)) {
                returnError('Invalid file type. Only PDF files are allowed.');
            }

            $targetDir = "../uploads/";
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $uniqueFileName = uniqid() . "_" . basename($fileName);
            $targetFilePath = $targetDir . $uniqueFileName;

            if (!move_uploaded_file($fileTmpPath, $targetFilePath)) {
                returnError('Error moving uploaded file.');
            }

            $relativeFilePath = 'uploads/' . $uniqueFileName;
        } else {
            returnError('No PDF file uploaded or there was an upload error.');
        }

        // Image Upload
        if (isset($_FILES['filepond2']) && $_FILES['filepond2']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath2 = $_FILES['filepond2']['tmp_name'];
            $fileName2 = $_FILES['filepond2']['name'];
            $fileType2 = $_FILES['filepond2']['type'];
            
            $allowedTypes2 = ['image/png', 'image/jpeg', 'image/gif'];
            if (!in_array($fileType2, $allowedTypes2)) {
                returnError('Invalid image type. Only PNG, JPEG, and GIF images are allowed.');
            }

            list($width, $height) = getimagesize($fileTmpPath2);
            if ($width < 100 || $height < 100) { 
                returnError('Image dimensions must be at least 100x100 pixels.');
            }

            $imgProp = getimagesize($fileTmpPath2);
            $fileData = file_get_contents($fileTmpPath2);
        } else {
            returnError('No image file uploaded or there was an upload error.');
        }

        // Insert into database
        $sql = "INSERT INTO lectures (lecture_name, section_id, employee_acc_id, status, fileType, file, imgType, imageFile) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $null = NULL;
        $stmt->bind_param('ssiisssb', $lecture_name, $section_id, $employee, $status, $fileType, $relativeFilePath, $imgProp['mime'], $null);
        $stmt->send_long_data(7, $fileData);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Resource added successfully.']);
        } else {
            returnError('Error adding resource: ' . $stmt->error);
        }
    } else {
        returnError('Invalid request method.');
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    returnError('An unexpected error occurred.');
}

$con->close();

function returnError($message) {
    echo json_encode(['error' => $message]);
    exit();
}

function sanitizeInput($data) {
    global $con;
    return htmlspecialchars($con->real_escape_string($data));
}
?>