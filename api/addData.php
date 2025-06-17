<?php

header('Content-Type: application/json');
include('database.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $insertionType = $_GET['insertion'];
    $sql = '';

    switch ($insertionType) {

        case 'addViolation':

            $vtitle = sanitizeInput($_POST['violation_title']);
            $vdesc = sanitizeInput($_POST['violation_description']);

            if (empty($vtitle)) {
                returnError('Please enter violation name/title.');
            }
            if (empty($vdesc)) {
                returnError('Please add a violation description.');
            }

            $sql = "INSERT INTO hr_violation_list (violation_title, violation_desc)
                    VALUES ('$vtitle', '$vdesc')";

            if ($con->query($sql) === TRUE) {
                echo json_encode(['message' => 'Violation Added']);
            } else {
                returnError('Error updating record: ' . $con->error);
            }

            break;

        case 'newEmployee':

            $firstname = sanitizeInput($_POST['firstname']);
            $middlename = sanitizeInput($_POST['middlename']);
            $lastname = sanitizeInput($_POST['lastname']);
            $gender = sanitizeInput($_POST['gender'] ?? "");
            $department = sanitizeInput($_POST['department'] ?? "");
            $position = sanitizeInput($_POST['position'] ?? "");
            $employee_id = sanitizeInput($_POST['employee_id']);
            $role = sanitizeInput($_POST['role'] ?? "");
            $email = sanitizeInput($_POST['email']);
            $phone = sanitizeInput($_POST['phone']);
            $dateHired = sanitizeInput($_POST['dateHired']);
            $formattedDateHired = date("F j, Y", strtotime($dateHired));
            $username = sanitizeInput($_POST['username']);
            $password = md5("innotor2024"); // Using md5 for hashing
            $status = sanitizeInput($_POST['emps'] ?? "");
            $rfid = sanitizeInput($_POST['rfid']);
            $archived = 0;
            $otp = '';
            $active = 1;
            $date = DateTime::createFromFormat('F j, Y', $formattedDateHired);
            $date->modify('+5 months +2 weeks');
            $for_eval = $date->format('F j, Y');

            if (
                empty($firstname) || empty($lastname) || empty($gender) || empty($department) ||
                empty($position) || empty($employee_id) || empty($role) || empty($email) ||
                empty($phone) || empty($dateHired) || empty($username) || empty($password) ||
                empty($status)
            ) {
                returnError('All fields are required.');
            }

            $allowedTypes = ['image/png', 'image/jpeg', 'image/gif'];
            $uploadDir = __DIR__ . '/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $imagePath = handleFileUpload($_FILES['filepond'], $allowedTypes, $uploadDir, $employee_id);

            $stmt = $con->prepare("INSERT INTO accounts 
                (employee_id, first_name, middle_name, last_name, gender, department, emp_status, position, date_hired, username, password, email, phone, img, active, archived, user_level, for_eval, bio_userid) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            if (!$stmt) {
                returnError("Error preparing the statement: " . $con->error);
            }

            $stmt->bind_param(
                "ssssssssssssssiiiss",
                $employee_id,
                $firstname,
                $middlename,
                $lastname,
                $gender,
                $department,
                $status,
                $position,
                $formattedDateHired,
                $username,
                $password,
                $email,
                $phone,
                $imagePath,
                $active,
                $archived,
                $role,
                $for_eval,
                $rfid
            );

            if ($stmt->execute()) {
                echo json_encode(['message' => 'Employee Data Added Successfully']);
            } else {
                returnError('Error inserting record: ');
            }

            break;

        case 'updEmployee':

            $firstname = sanitizeInput($_POST['firstname']);
            $middlename = sanitizeInput($_POST['middlename']);
            $lastname = sanitizeInput($_POST['lastname']);
            $gender = sanitizeInput($_POST['gender']);
            $department = sanitizeInput($_POST['department']);
            $position = sanitizeInput($_POST['position']);
            $employee_id = sanitizeInput($_POST['employee_id']);
            $role = sanitizeInput($_POST['role']);
            $email = sanitizeInput($_POST['email']);
            $phone = sanitizeInput($_POST['phone']);
            $dateHired = sanitizeInput($_POST['dateHired']);
            $formattedDateHired = date("F j, Y", strtotime($dateHired));
            $username = sanitizeInput($_POST['username']);
            $status = sanitizeInput($_POST['emps']);
            $rfid = sanitizeInput($_POST['rfid']);
            $archived = 0;
            $active = 1;

            $date = DateTime::createFromFormat('F j, Y', $formattedDateHired);

            if ($status === "Probationary") {
                $date->modify('+11 months +2 weeks');
                $for_eval = $date->format('F j, Y');
            } else if ($status === "Contractual") {
                $date->modify('+5 months +2 weeks');
                $for_eval = $date->format('F j, Y');
            } else {
                $for_eval = null;
            }

            $forEvalQuery = (isset($for_eval) || !is_null($for_eval) || $for_eval != "") ? "for_eval = ? ," : "";

            if (
                empty($firstname) || empty($lastname) || empty($gender) || empty($department) ||
                empty($position) || empty($employee_id) || empty($role) || empty($email) ||
                empty($phone) || empty($dateHired) || empty($username) || empty($status)
            ) {
                returnError('All fields are required.');
            }

            $allowedTypes = ['image/png', 'image/jpeg', 'image/gif'];
            $uploadDir = __DIR__ . '/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if (!empty($_FILES['filepond']['name']) && $_FILES['filepond']['error'] === UPLOAD_ERR_OK) {
                $imagePath = handleFileUpload($_FILES['filepond'], $allowedTypes, $uploadDir, $employee_id);
                $updateImageQuery = ", img = ?";
            } else {
                // Retrieve the existing image path if no new image is uploaded
                $stmtSelect = $con->prepare("SELECT img FROM accounts WHERE employee_id = ?");
                $stmtSelect->bind_param("s", $employee_id);
                $stmtSelect->execute();
                $result = $stmtSelect->get_result();
                $row = $result->fetch_assoc();
                $imagePath = $row['img'] ?? null; // Set to NULL if no existing image
                $updateImageQuery = $imagePath ? ", img = ?" : ""; // Only update if there's an image
            }

            $query = "UPDATE accounts SET 
                        first_name = ?, 
                        middle_name = ?, 
                        last_name = ?, 
                        gender = ?, 
                        department = ?, 
                        emp_status = ?, 
                        position = ?, 
                        date_hired = ?, 
                        username = ?, 
                        email = ?, 
                        phone = ?, 
                        active = ?, 
                        archived = ?, 
                        user_level = ?, 
                        $forEvalQuery 
                        bio_userid = ? 
                        $updateImageQuery 
                        WHERE employee_id = ?";

            $stmt = $con->prepare($query);

            if (!$stmt) {
                returnError("Error preparing the statement: " . $con->error);
            }

            if ($updateImageQuery && !$forEvalQuery) {
                $stmt->bind_param(
                    "ssssssssssiiisiss",
                    $firstname,
                    $middlename,
                    $lastname,
                    $gender,
                    $department,
                    $status,
                    $position,
                    $formattedDateHired,
                    $username,
                    $email,
                    $phone,
                    $active,
                    $archived,
                    $role,
                    $rfid,
                    $imagePath,
                    $employee_id
                );
            } elseif ($forEvalQuery && $forEvalQuery) {
                $stmt->bind_param(
                    "ssssssssssiiississ",
                    $firstname,
                    $middlename,
                    $lastname,
                    $gender,
                    $department,
                    $status,
                    $position,
                    $formattedDateHired,
                    $username,
                    $email,
                    $phone,
                    $active,
                    $archived,
                    $role,
                    $for_eval,
                    $rfid,
                    $imagePath,
                    $employee_id
                );
            } else {
                $stmt->bind_param(
                    "ssssssssssiiisss",
                    $firstname,
                    $middlename,
                    $lastname,
                    $gender,
                    $department,
                    $status,
                    $position,
                    $formattedDateHired,
                    $username,
                    $email,
                    $phone,
                    $active,
                    $archived,
                    $role,
                    $for_eval,
                    $rfid,
                    $employee_id
                );
            }

            if ($stmt->execute()) {
                echo json_encode(['message' => 'Employee Data Updated Successfully']);
            } else {
                returnError('Error updating record: ' . $stmt->error);
            }

            break;

        default:
            returnError('Invalid insertion type.');
    }
}

$con->close();

function returnError($message)
{
    echo json_encode(value: ['error' => $message]);
    exit;
}

function sanitizeInput($data)
{
    global $con;
    return htmlspecialchars($con->real_escape_string($data));
}

function handleFileUpload($file, $allowedTypes, $uploadDir, $empID)
{
    if ($file['error'] !== UPLOAD_ERR_OK) {
        returnError('File upload error.');
    }

    if (!in_array($file['type'], $allowedTypes)) {
        returnError('Invalid file type. Only PNG, JPEG, and GIF images are allowed.');
    }

    if ($file['size'] === 0) {
        returnError('File size must be greater than 0.');
    }

    $uniqueFileName = $empID . '_' . basename($file['name']);
    $destinationPath = $uploadDir . $uniqueFileName;

    if (!move_uploaded_file($file['tmp_name'], $destinationPath)) {
        returnError('Failed to upload the file.');
    }

    return 'uploads/' . $uniqueFileName;
}
