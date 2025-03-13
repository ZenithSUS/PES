<?php

include 'database.php';

require_once 'session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $authType = $_GET['auth'];
    $sql = '';

    switch ($authType) {

        case 'login':

            $email = sanitizeInput($_POST['email']);
            $password = md5(sanitizeInput($_POST['password']));

            $getCredentials = "SELECT * FROM accounts WHERE username = '$email' AND password = '$password'";

            $result = $con->query($getCredentials);

            if ($result->num_rows > 0) {

                $userData = $result->fetch_assoc();

                $employeeID = $userData['employee_id'];
                $userFirstname = $userData['first_name'];
                $userMiddlename = $userData['middle_name'];
                $userLastname = $userData['last_name'];
                $userGender = $userData['gender'];
                $userEmail = $userData['email'];
                $userLevel = $userData['user_level'];
                $userName = $userData['username'];
                $userPassword = $userData['password'];
                $_SESSION['role'] = $userData['user_level'];

                $_SESSION['user_id'] = $userData['employee_id'];
                $_SESSION['department'] = $userData['department'];

                $_SESSION['full'] = $userFirstname . " " . $userMiddlename . " " . $userLastname;

                $response = [

                    'employee_id' => $employeeID,
                    'first_name' => $userFirstname,
                    'middle_name' => $userMiddlename,
                    'last_name' => $userLastname,
                    'gender' => $userGender,
                    'email' => $userEmail,
                    'role' => $userLevel,
                    'username' => $userName,
                    'password' => $userPassword,
                    'color' => 'badge-success',
                    'message' => 'Login successful',
                    'login' => true,

                ];

                echo json_encode($response);
            } else {

                returnError('Invalid username or password.');
            }
            break;

        default:
            returnError('Invalid authentication type.');
    }
}

$con->close();

function returnError($message)
{

    echo json_encode(['error' => $message]);
    exit();
}
function sanitizeInput($data)
{

    global $con;
    return htmlspecialchars($con->real_escape_string($data));
}
