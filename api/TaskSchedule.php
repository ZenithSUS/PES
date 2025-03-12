<?php

session_start();
include('database.php');

require_once 'C:\xampp\htdocs\oas\PHPMailer\Exception.php';
require_once 'C:\xampp\htdocs\oas\PHPMailer\SMTP.php';
require_once 'C:\xampp\htdocs\oas\PHPMailer\PHPMailer.php';

set_include_path(get_include_path() . PATH_SEPARATOR . 'C:\xampp\htdocs\oas');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
$email = '';

$targetDate = date('F j, Y', strtotime('+10 days'));

$sql = "SELECT *, DATE_FORMAT(STR_TO_DATE(for_eval, '%M %d, %Y'), '%M %e, %Y') AS formatted_eval
        FROM accounts
        WHERE STR_TO_DATE(for_eval, '%M %d, %Y') 
        <= STR_TO_DATE(DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 10 DAY), '%M %d, %Y'), '%M %d, %Y')
        AND current_eval IS NULL
        AND (user_level <= 3 AND user_level > 1)
        ORDER BY STR_TO_DATE(for_eval, '%M %d, %Y') ASC";

$stmt = $con->prepare($sql);
$stmt->execute();

$result = $stmt->get_result();
$userRecords = [];

// if ($result->num_rows > 0) {

//     $userRecord = $result->fetch_assoc();

//     $fname = $userRecord['first_name']." ".$userRecord['middle_name']." ".$userRecord['last_name'];
//     $department = $userRecord['department'];
//     $position = $userRecord['position'];
//     $status = $userRecord['emp_status'];
//     $dateHired = $userRecord['date_hired'];
//     $dateEvaluation = $userRecord['for_eval'];


// } else {

//     echo "User not found";

// }

if ($result->num_rows > 0) {
    while ($userRecord = $result->fetch_assoc()) {
        $userRecords[] = [
            'full_name' => $userRecord['first_name'] . " " . $userRecord['middle_name'] . " " . $userRecord['last_name'],
            'department' => $userRecord['department'],
            'position' => $userRecord['position'],
            'status' => $userRecord['emp_status'],
            'date_hired' => $userRecord['date_hired'],
            'date_evaluation' => $userRecord['for_eval']
        ];
    }
} else {
    echo "User not found";
}

$performance = "Performance";
    
$sql = "SELECT email FROM accounts WHERE position = ? AND user_level = 1";

$stmt = $con->prepare($sql);

$stmt->bind_param('s', $performance);

$stmt->execute();

$result = $stmt->get_result();
$hrRecords = [];

if ($result->num_rows > 0) {

    $hrRecords = $result->fetch_all(MYSQLI_ASSOC);

} else {

    echo "User not found";

}

try {

    // $sendTO = $email;

    // $mail->addAddress($sendTo); 

    foreach ($hrRecords as $record) {
        $mail->addCC($record['email']); 
    }

    $mail->isSMTP();                                                     
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'ea00.ph@gmail.com';
    $mail->Password   = 'dpyqoiouespqozba';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;


    $mail->setFrom('ea00.ph@gmail.com', 'Evaluation System - Human Resource Department');
    // $mail->addAddress($sendTO);

    $mail->isHTML(true);
    $mail->Subject = "Under Regulariztion Employees Evaluation (6th month)";
    $mail->Body    = '';
    $mail->Body .= "
            <!DOCTYPE html>
                    <html dir='ltr' xmlns='http://www.w3.org/1999/xhtml'>
                    <head>
                        <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
                        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
                        <link rel='icon' type='image/png' sizes='16x16' href='../assets/images/favicon.png'>
                        <title>Employee Evaluation</title>
                        <style>
                            body {
                                margin: 0;
                                font-family: Arial, sans-serif;
                                line-height: 1.6;
                                color: #514d6a;
                                background-color: #f8f9fa;
                            }
                            .container {
                                max-width: 600px;
                                margin: auto;
                                background-color: #ffffff;
                                border: 1px solid #dee2e6;
                                border-radius: 0.5rem;
                            }
                            .header {
                                background-color: #0825D1;
                                color: #ffffff;
                                padding: 20px;
                                text-align: center;
                                border-top-left-radius: 0.5rem;
                                border-top-right-radius: 0.5rem;
                            }
                            .content {
                                padding: 20px;
                            }
                            .footer {
                                padding: 10px;
                                text-align: center;
                                font-size: 12px;
                                color: #6c757d;
                            }
                            /* Responsive table styles */
                            .responsive-table {
                                width: 100%;
                                border-collapse: collapse;
                                margin-top: 20px;
                            }
                            .responsive-table th, .responsive-table td {
                                border: 1px solid #dee2e6;
                                padding: 10px;
                                text-align: left;
                            }
                            .responsive-table th {
                                background-color: #f1f1f1;
                            }
                            @media (max-width: 600px) {
                                .responsive-table thead {
                                    display: none;
                                }
                                .responsive-table tr {
                                    display: block;
                                    margin-bottom: 15px;
                                }
                                .responsive-table td {
                                    display: flex;
                                    justify-content: space-between;
                                    text-align: right;
                                    padding: 5px;
                                    border: none;
                                    position: relative;
                                }
                                .responsive-table td::before {
                                    content: attr(data-label);
                                    position: absolute;
                                    left: 0;
                                    font-weight: bold;
                                    text-align: left;
                                }
                            }
                        </style>
                    </head>
                    <body>
                        <div class='container'>
                            <div class='header'>
                                <strong>Employee Evaluation</strong>
                            </div>
                            <div class='' style='background-color: #fff; text-align: center;'>
                                <img src='https://firebasestorage.googleapis.com/v0/b/consultease-9033b.appspot.com/o/user_img%2Finnotor-removebg-preview.png?alt=media&token=2218456f-cc80-48f3-90e5-137437e9a50d' alt=''>
                            </div>
                            <div class='content'>
                                <p>Hello,</p>
                                <p>You have a new employee evaluation to review.</p>

                                <!-- Responsive Table -->
                                <table class='responsive-table'>
                                    <thead>
                                        <tr>
                                            <th>Employee Name</th>
                                            <th>Department</th>
                                            <th>Position</th>
                                            <th>Status</th>
                                            <th>Period Covered</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                                    foreach ($userRecords as $userRecord) {
        $mail->Body .= "
                                                        <tr>
                                                            <td data-label='Employee Name'>{$userRecord['full_name']}</td>
                                                            <td data-label='Department'>{$userRecord['department']}</td>
                                                            <td data-label='Position'>{$userRecord['position']}</td>
                                                            <td data-label='Status'>{$userRecord['status']}</td>
                                                            <td data-label='Period Covered'>5th month Regularization</td>
                                                        </tr>";
                                    }
        $mail->Body .= "
                                        </tbody>
                                    </table>
                        
                                    <div class='appointment-details'>
                                        <p>To maintain regular work, each employee listed must receive a passing grade of 75% or higher.</p>
                                        <p>To evaluate them, please log on to our system at <a href='http://localhost/oas/authentication/SignIn.php'>http://localhost/oas/authentication/SignIn.php</a>.</p>
                                        <p style='margin-bottom: 20px;'>Please complete these evaluations by their respective due dates. Failure to do so may result in the employee's automatic <b>END OF CONTRACT</b>.</p>
                                        
                                        <p>Thank you very much.</p>
                                    </div>
                                </div>
                                <div class='footer'>
                                    &copy; " . date('Y') . " Innotor Evaluation System - No Reply
                                </div>
                            </div>
                        </body>
                        </html>";

    if($mail->send()) {

        // echo '<script>alert("aw")</script>';
        // echo '<script>window.location.href = "../pages/hr/employees.php"</script>';
        echo "Successfully sending to multiple recipients";

    } else {

        echo "Failed sending to multiple recipients";

    }
} catch (Exception $e) {
    //throw $th;
}

?>