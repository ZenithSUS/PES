<?php

require_once 'database.php';

// $mysect = $_SESSION['section'];
$myid = $_SESSION['user_id'];

//employee total count
$user_all_count = "SELECT COUNT(*) AS all_count FROM accounts";
$user_all_count_stmt = $con->prepare($user_all_count);
$user_all_count_stmt->execute();
$all_result = $user_all_count_stmt->get_result();
$row_all = $all_result->fetch_assoc();
$employee_count = $row_all['all_count'];
$user_all_count_stmt->close();

$dpt = $_SESSION['department'];

$eval_count_general = "SELECT 
                            COUNT(CASE 
                                    WHEN DATE_SUB(STR_TO_DATE(for_eval, '%M %d, %Y'), INTERVAL 10 DAY) <= CURDATE()
                                         AND STR_TO_DATE(for_eval, '%M %d, %Y') >= CURDATE()
                                    THEN 1 
                                END) AS evaluation_count
                       FROM accounts
                       WHERE active = 1";

$general_stmt = $con->prepare($eval_count_general);
$general_stmt->execute();
$general_result = $general_stmt->get_result();
$row_general = $general_result->fetch_assoc();
$evaluation_count = $row_general['evaluation_count'];
$general_stmt->close();

$eval_count_department = "SELECT 
                            COUNT(CASE 
                                    WHEN DATE_SUB(STR_TO_DATE(for_eval, '%M %d, %Y'), INTERVAL 10 DAY) <= CURDATE()
                                         AND STR_TO_DATE(for_eval, '%M %d, %Y') >= CURDATE()
                                    THEN 1 
                                END) AS for_eval_count
                          FROM accounts
                          WHERE active = 1 AND department = ?";


$dept_stmt = $con->prepare($eval_count_department);
$dept_stmt->bind_param('s', $dpt);
$dept_stmt->execute();
$dept_result = $dept_stmt->get_result();
$row_dept = $dept_result->fetch_assoc();
$for_eval_count = $row_dept['for_eval_count'];
$dept_stmt->close();

$sql = "SELECT 
    COUNT(CASE WHEN user_level = 1 THEN 1 END) AS hr_count,
    COUNT(CASE WHEN user_level = 2 THEN 1 END) AS manager_count,
    COUNT(CASE WHEN department = '$dpt' AND user_level = 3 THEN 1 END) AS dept_count,
    COUNT(*) AS user_count
FROM 
    accounts
WHERE 
    user_level != 0";

$result = $con->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $hr_count = $row['hr_count'];
    $manager_count = $row['manager_count'];
    $user_count = $row['user_count'];
    $dept_emp = $row['dept_count'];
} else {
    $hr_count = 0;
    $manager_count = 0;
    $user_count = 0;
}

$sql = "SELECT COUNT(*) as violation_count
        FROM 
            user_violations
        WHERE 
            employee_id = $myid";

$result = $con->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $viocount = $row['violation_count'];
}

$sql = "SELECT COUNT(*) as total_records
        FROM accounts
        WHERE STR_TO_DATE(for_eval, '%M %d, %Y') 
        <= STR_TO_DATE(DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 10 DAY), '%M %d, %Y'), '%M %d, %Y') AND user_level != 0 AND current_eval = '';";

$stmt = $con->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$totalRecords = $row['total_records'];


$sql = "SELECT COUNT(*) as total_records2
        FROM accounts
        WHERE current_eval != '';";

$stmt = $con->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$totalRecords2 = $row['total_records2'];
