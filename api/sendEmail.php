<?php

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
include('database.php');
require('../PHPMailer/Exception.php');
require('../PHPMailer/SMTP.php');
require('../PHPMailer/PHPMailer.php');

$mail = new PHPMailer(true);

$email = '';
$user_to_eval = $_POST['user_to_eval'];
$sql = "SELECT * FROM accounts WHERE employee_id = ?";

$stmt = $con->prepare($sql);

$stmt->bind_param('s', $user_to_eval);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {

    $userRecord = $result->fetch_assoc();

    $fname = $userRecord['first_name']." ".$userRecord['middle_name']." ".$userRecord['last_name'];
    $department = $userRecord['department'];
    $position = $userRecord['position'];
    $status = $userRecord['emp_status'];
    $dateHired = $userRecord['date_hired'];
    $dateEvaluation = date('F, d, Y', strtotime($userRecord['for_eval'] . ' +2 weeks'));

} else {

    echo "User not found";

}

$sql = "SELECT email FROM accounts WHERE department = ? AND user_level = 2";

$stmt = $con->prepare($sql);

$stmt->bind_param('s', $department);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {

    $userRecord = $result->fetch_assoc();

    $email = $userRecord['email'];

} else {

    echo json_encode(["status" => 'No email found for department: ' . $department]);
    exit; // Stop execution if no email is found
}

try {

    if (empty($email)) {
        throw new Exception("Recipient email address is empty.");
    }

    $periodCovered = $status === "Regular" ? "Yearly Evaluation" : "6th month Evaluation";

    $sendTO = $email;
    $mail->isSMTP();
    $mail->CharSet = 'UTF-8';
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'ea00.ph@gmail.com';
    $mail->Password   = 'dpyqoiouespqozba';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    // Set timeouts for better error handling
    $mail->Timeout = 30; // Timeout in seconds
    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true,
        ],
    ];

    $mail->setFrom('ea00.ph@gmail.com', $_SESSION['full'].' - Human Resource Department');
    $mail->addAddress($sendTO);

    $mail->isHTML(true);
    $mail->Subject = $status === "Regular" ? "Under Regularization Employees Evaluation (12th month)" : "Under Employees Evaluation (6th month)";
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
                            <div class='header' style='padding: 20px; text-align: center;'>
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
                                    <tbody>
                                        <tr>
                                            <td data-label='Employee Name'>$fname</td>
                                            <td data-label='Department'>$department</td>
                                            <td data-label='Position'>$position</td>
                                            <td data-label='Status'>$status</td>
                                            <td data-label='Period Covered'>$periodCovered</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class='appointment-details'>
                                    <p style=''>To maintain regular work, the aforementioned individual must get a standard passing grade of 75% or higher.</p>
                                    <p style=''>To evaluate them, please log on to our system at <a href='http://localhost/PES/authentication/SignIn.php'>http://localhost/PES/authentication/SignIn.php</a>.</p>
                                    <p style='margin-bottom: 20px;'>Kindly evaluate this individual not later than $dateEvaluation. Failure to do so, employee will AUTOMATICALLY undergo <b>END OF CONTRACT</b></p>
                                    
                                    <p style=''>Thank you very much.</p>
                                </div>
                            </div>
                            <div class='footer'>
                                &copy; " . date('Y') . " Innotor Evaluation System - No Reply
                            </div>
                        </div>
                    </body>
                    </html>";

    if ($mail->send()) {

        echo json_encode(["status" => 'Send Successfully to'. $email]);

    } else {
        throw new Exception("Failed to send email: " . $mail->ErrorInfo);
    }
} catch (Exception $e) {
    error_log('Error sending message: ' . $e->getMessage());
    echo 'Error sending message: ' . $e->getMessage();
}

?>