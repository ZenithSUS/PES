<?php
require_once 'session.php';
header('Content-Type: application/json');
include('database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_GET['action'])) {

        switch ($_GET['action']) {

            case 'deactivate':

                    $id = $_GET['id'];
                    deactivateAccount($con, $id);

                break;

            case 'activate':

                    $id = $_GET['id'];
                    activateAccount($con, $id);

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

function deactivateAccount($con, $id) {

    $sql = "UPDATE accounts SET active = 0 WHERE employee_id = $id";

    if ($con->query($sql) === TRUE) {

        echo json_encode(['success' => 'Account deactivated successfully']);

    } else {

        echo json_encode(['error' => 'Error deactivating account: ' . $con->error]);

    }

}
function activateAccount($con, $id) {

    $sql = "UPDATE accounts SET active = 1 WHERE employee_id = $id";

    if ($con->query($sql) === TRUE) {

        echo json_encode(['success' => 'Account activated successfully']);

    } else {

        echo json_encode(['error' => 'Error activating account: ' . $con->error]);

    }

}

?>