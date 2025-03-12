<?php
require_once 'session.php';
header('Content-Type: application/json');
include('database.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action'])) {

        switch ($_GET['action']) {

            case 'getAccounts':

                    $u = $_GET['u'];
                    getAccounts($con, $u);

                break;

            case 'getHR':

                    $u = $_GET['u'];
                    getHR($con, $u);

                break;

            case 'getManagers':

                    $u = $_GET['u'];
                    getManagers($con, $u);

                break;

            case 'getLastID':

                    getLastID($con);

                break;


            case 'getLastRFID':

                    getLastRFID($con);

                break;

            case 'getEmployeeData':

                    $id = $_GET['id'];

                    getEmployeeData($con, $id);

                break;

            default:

                echo json_encode(['error' => 'Invalid action']);

        }
    } else {

        echo json_encode(['error' => 'No action specified']);

    }

} else {
    echo json_encode(['error' => 'Invalid request method']);
}

$con->close();

function getAccounts($con, $u) {

    $sql = "SELECT * FROM accounts WHERE employee_id != $u and active = 1 and user_level = 3";
    $result = $con->query($sql);

    if ($result && $result->num_rows > 0) {
        $accounts = [];
        while ($row = $result->fetch_assoc()) {
            $accounts[] = [

                'id' => $row['employee_id'],
                'firstname' => $row['first_name'],
                'middlename' => $row['middle_name'],
                'lastname' => $row['last_name'],
                'email' => $row['email'],
                'phone' => $row['phone'],
                'designation' => $row['department'],
                'for_eval' => $row['for_eval'],
                'hired_date' => $row['date_hired'],
                'active' => $row['active'],
                'username' => $row['username'],
                'emps' => $row['emp_status'],
                'user_level' => $row['user_level'],
                'img' => base64_encode($row['img']),
                'imgt' => $row['imgType'],

            ];
        }
        echo json_encode($accounts);
    } else {
        echo json_encode(['error' => 'No records found']);
    }
}


function getHR($con, $u) {

    $sql = "SELECT * FROM accounts WHERE employee_id != $u and active = 1 and user_level = 1";
    $result = $con->query($sql);

    if ($result && $result->num_rows > 0) {
        $accounts = [];
        while ($row = $result->fetch_assoc()) {
            $accounts[] = [

                'id' => $row['employee_id'],
                'firstname' => $row['first_name'],
                'middlename' => $row['middle_name'],
                'lastname' => $row['last_name'],
                'email' => $row['email'],
                'phone' => $row['phone'],
                'designation' => $row['department'],
                'for_eval' => $row['for_eval'],
                'hired_date' => $row['date_hired'],
                'active' => $row['active'],
                'username' => $row['username'],
                'emps' => $row['emp_status'],
                'user_level' => $row['user_level'],
                'img' => base64_encode($row['img']),
                'imgt' => $row['imgType'],

            ];
        }
        echo json_encode($accounts);
    } else {
        echo json_encode(['error' => 'No records found']);
    }
}

function getManagers($con, $u) {

    $sql = "SELECT * FROM accounts WHERE employee_id != $u and active = 1 and user_level = 2";
    $result = $con->query($sql);

    if ($result && $result->num_rows > 0) {
        $accounts = [];
        while ($row = $result->fetch_assoc()) {
            $accounts[] = [

                'id' => $row['employee_id'],
                'firstname' => $row['first_name'],
                'middlename' => $row['middle_name'],
                'lastname' => $row['last_name'],
                'email' => $row['email'],
                'phone' => $row['phone'],
                'designation' => $row['department'],
                'for_eval' => $row['for_eval'],
                'hired_date' => $row['date_hired'],
                'active' => $row['active'],
                'username' => $row['username'],
                'emps' => $row['emp_status'],
                'user_level' => $row['user_level'],
                'img' => base64_encode($row['img']),
                'imgt' => $row['imgType'],

            ];
        }
        echo json_encode($accounts);
    } else {
        echo json_encode(['error' => 'No records found']);
    }
}


function getEmployeeData($con, $id) {

    $sql = "SELECT * FROM accounts WHERE employee_id = $id and active = 1";
    $result = $con->query($sql);

    if ($result && $result->num_rows > 0) {
        $accounts = [];
        while ($row = $result->fetch_assoc()) {
            $accounts[] = [

                'id' => $row['employee_id'],
                'firstname' => $row['first_name'],
                'middlename' => $row['middle_name'],
                'lastname' => $row['last_name'],
                'email' => $row['email'],
                'phone' => $row['phone'],
                'designation' => $row['department'],
                'for_eval' => $row['for_eval'],
                'hired_date' => $row['date_hired'],
                'active' => $row['active'],
                'username' => $row['username'],
                'user_level' => $row['user_level'],
                'img' => base64_encode($row['img']),
                'imgt' => $row['imgType'],

            ];
        }
        echo json_encode($accounts);
    } else {
        echo json_encode(['error' => 'No records found']);
    }
}

function getLastID($con) {

    $query = "SELECT employee_id FROM accounts ORDER BY employee_id DESC LIMIT 1";
    $result = $con->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastEmployeeId = $row['employee_id'];
        
        echo json_encode(['last_employee_id' => $lastEmployeeId]);
    } else {
        echo json_encode(['error' => 'Could not retrieve last employee ID or no records found.']);
    }
}


function getLastRFID($con) {

    $query = "SELECT bio_userid FROM accounts ORDER BY bio_userid * 1 DESC LIMIT 1";
    $result = $con->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastEmployeeId = $row['bio_userid'];
        
        echo json_encode(['last_employee_id' => $lastEmployeeId]);
    } else {
        echo json_encode(['error' => 'Could not retrieve last employee ID or no records found.']);
    }
}

?>