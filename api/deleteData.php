<?php

include('database.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $deleteType = $_GET['delete'];

    $id = $_GET['id'];

    switch ($deleteType) {

        case 'deleteCourse':

            $sql = "DELETE from hr_violation_list WHERE violation_id = $id";

            break;

        case 'regularization':

            $sql = "UPDATE accounts SET emp_status = 'Regular' WHERE employee_id = $id";

            break;

        case 'violation':

            $id = $_GET['id'];
            $vio = $_GET['vio'];
            $stat = $_GET['stat'];
            $dept = $_GET['dept'];
            $dateNow = date("F j, Y");
            $sql = "INSERT INTO user_violations (employee_id, violation_id, department, vdate, status) VALUES ($id, $vio, '$dept', '$dateNow', '$stat')";

            break;

        case 'updviolation':

            $id = $_GET['id'];
            $vioId = $_GET['vioId'];
            $stat = $_GET['stat'];
            $sanction = $_GET['sanction'];
            $dateNow = date("F j, Y");
            $sql = "UPDATE user_violations SET status = '$stat', sanction = '$sanction' WHERE employee_id = $id AND violation_id = $vioId";

            break;

        case 'reset':

            $id = $_GET['id'];
            $pass = md5("innotor2024");
            $sql = "UPDATE accounts SET password = '$pass' WHERE employee_id = $id";

            break;

        case 'password':
            $id = $_GET['id'];
            $cur = $_GET['cur'];
            $newz = $_GET['new'];
            $cnew = $_GET['cnew'];

            $stmt = $con->prepare("SELECT password FROM accounts WHERE employee_id = ?");
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if (!$row) {
                die("User not found.");
            }

            $hashedPassword = $row['password'];

            if (md5($cur) !== $hashedPassword) {
                die("Current password is incorrect.");
            }

            if ($newz !== $cnew) {
                die("New passwords do not match.");
            }

            $hashedNewPassword = md5($newz);

            $updateStmt = $con->prepare("UPDATE accounts SET password = ? WHERE employee_id = ?");
            $updateStmt->bind_param("ss", $hashedNewPassword, $id);
            $updateStmt->execute();

            die("Password updated successfully. Please log in again.");

        case 'revert':

            $id = $_GET['id'];
            $archive = 0;
            $active = 1;
            $sql = "UPDATE accounts SET active = $active, archived = $archive  WHERE employee_id = $id";

            break;

        case 'accStat':

            $id = $_GET['id'];
            $stat = $_GET['stat'];
            $archive = 0;
            $active = 0;

            if ($stat == 'Resigned') {
                $archive = 2;
            } else if ($stat == 'Suspended') {
                $archive = 1;
            } else if ($stat == 'Terminated') {
                $archive = 3;
            }

            $dateNow = date("F j, Y");

            if ($stat == 'Resigned') {
                $archive = 2;
                $sql = "UPDATE accounts SET date_hired = '$dateNow', active = $active, archived = $archive WHERE employee_id = $id";
            } else if ($stat == 'Suspended') {
                $archive = 1;
                $sql = "UPDATE accounts SET active = $active, archived = $archive WHERE employee_id = $id";
            } else if ($stat == 'Terminated') {
                $archive = 3;
                $sql = "UPDATE accounts SET date_hired = $dateNow, active = $active, archived = $archive WHERE employee_id = $id";
            }

            break;

        default:
            returnError('Invalid insertion type.');
    }

    if ($con->query($sql) === TRUE) {
        echo json_encode(['message' => 'New record created successfully']);
    } else {
        returnError('Error: ' . $sql . '<br>' . $con->error);
    }
}

$con->close();

function returnError($message)
{
    echo json_encode(['error' => $message]);
    exit();
}
