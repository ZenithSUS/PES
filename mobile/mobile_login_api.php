<?php

include '../api/database.php';
require_once '../api/session.php';

header('Content-Type: application/json'); // Ensure the response is JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = sanitizeInput($_POST['email']);
    $password = md5(sanitizeInput($_POST['password']));

    $getCredentials = "SELECT students.*, sections.*, courses.*, accounts.firstname AS account_firstname, accounts.lastname AS account_lastname
                    FROM students 
                    LEFT JOIN sections ON sections.section_id = students.section
                    LEFT JOIN courses ON sections.course_id = courses.course_id
                    LEFT JOIN accounts ON accounts.section = students.section
                    WHERE students.email = '$email' AND students.password = '$password'";
    $result = $con->query($getCredentials);

    if ($result && $result->num_rows > 0) {
        $userData = $result->fetch_assoc();

        $response = [
            'message' => 'Login successful',
            'login' => true,
            'firstname' => $userData['firstname'],
            'lastname' => $userData['lastname'],
            'section' => $userData['section_name'],
            'adviser' => $userData['account_firstname'].' '.$userData['account_lastname'],
            'course_name' => $userData['course_name'],
            'session' => $userData['clock'],
            'section_id' => $userData['section_id'],
            'student_number' => $userData['student_number'],
            'student_acc_id' => $userData['student_acc_id'],
            'course_desc' => $userData['course_description'],
            'img' => base64_encode($userData['img']),

        ];

        echo json_encode($response);
    } else {
        returnError('Invalid email or password.');
    }
}

$con->close();

function returnError($message) {
    echo json_encode(['message' => $message, 'login' => false]);
    exit();
}

function sanitizeInput($data) {
    global $con;
    return htmlspecialchars($con->real_escape_string($data));
}
?>