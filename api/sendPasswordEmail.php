<?php
// Initialize session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Set headers to handle AJAX request
header('Content-Type: application/json');

include('database.php');

require('../PHPMailer/Exception.php');
require('../PHPMailer/SMTP.php');
require('../PHPMailer/PHPMailer.php');

// Load PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Function to validate email format
function isValidEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Process the password recovery request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get email from POST data
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    // Initialize response array
    $response = [
        'success' => false,
        'message' => ''
    ];

    // Validate the email
    if (empty($email)) {
        $response['message'] = 'Email is required';
        echo json_encode($response);
        exit;
    }

    if (!isValidEmail($email)) {
        $response['message'] = 'Invalid email format';
        echo json_encode($response);
        exit;
    }

    try {
        // Check if the email exists in the database
        $stmt = $con->prepare("SELECT * FROM accounts WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            // Don't reveal if email exists or not for security purposes
            $response['message'] = 'If your email exists in our system, you will receive your password shortly';
            $response['success'] = true;
            echo json_encode($response);
            exit;
        }

        $user = $result->fetch_assoc();

        // Set the new fixed password (plaintext for email)
        $newPassword = "innotor2024";

        // Create MD5 hash directly without any additional processing
        $hashedPassword = md5($newPassword);

        // For debugging (remove in production)
        // error_log("Plain password: " . $newPassword);
        // error_log("Hashed password: " . $hashedPassword);

        // Update the user's password in the database with the MD5 hash
        $updateStmt = $con->prepare("UPDATE accounts SET password = ? WHERE email = ?");
        $updateStmt->bind_param("ss", $hashedPassword, $email);
        $updateStmt->execute();

        if ($updateStmt->affected_rows === 0 && $con->errno !== 0) {
            // Only throw exception if there's a real error, not just when no rows changed
            throw new Exception("Failed to update password: " . $con->error);
        }

        // Setup PHPMailer
        $mail = new PHPMailer(true);

        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username = 'ea00.ph@gmail.com';
        $mail->Password = 'dpyqoiouespqozba';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->Timeout = 30; // Timeout in seconds
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ],
        ];

        // Recipients
        $mail->setFrom('ea00.ph@gmail.com', 'Password Recovery');
        $mail->addAddress($email, $user['username'] ?? 'User');

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your Reset Password';

        // Email body
        $mail->Body = '
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    line-height: 1.6;
                    color: #333;
                }
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                    border: 1px solid #ddd;
                    border-radius: 5px;
                }
                .header {
                    background-color: #f8f9fa;
                    padding: 15px;
                    text-align: center;
                    border-bottom: 1px solid #ddd;
                }
                .content {
                    padding: 20px;
                }
                .password-box {
                    background-color: #f8f9fa;
                    border: 1px solid #ddd;
                    padding: 10px;
                    margin: 15px 0;
                    text-align: center;
                    font-size: 18px;
                    letter-spacing: 1px;
                }
                .footer {
                    margin-top: 20px;
                    font-size: 12px;
                    text-align: center;
                    color: #6c757d;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h2>Your Password Has Been Reset</h2>
                </div>
                <div class="content">
                    <p>Hello ' . ($user['name'] ?? 'User') . ',</p>
                    <p>We have reset your account password as requested. Your new password is:</p>
                    <div class="password-box">
                        <strong>' . $newPassword . '</strong>
                    </div>
                    <p>For security reasons, we strongly recommend changing your password after logging in.</p>
                    <p>If you did not request this password reset, please contact our support team immediately as your account may be at risk.</p>
                    <p>Regards,<br>Your Website Team</p>
                </div>
                <div class="footer">
                    <p>This is an automated message. Please do not reply to this email.</p>
                    <p>&copy; ' . date('Y') . ' Your Company. All rights reserved.</p>
                </div>
            </div>
        </body>
        </html>
        ';

        // Plain text version
        $mail->AltBody = 'Hello ' . ($user['username'] ?? 'User') . ',

We have reset your account password as requested. Your new password is:

' . $newPassword . '

For security reasons, we strongly recommend changing your password after logging in.

If you did not request this password reset, please contact our support team immediately as your account may be at risk.

Regards,
Innotor Philippines Inc.';

        // Send email
        $mail->send();

        // Return success response
        $response['success'] = true;
        $response['message'] = 'Password has been reset. Please check your email for the new password.';
    } catch (Exception $e) {
        // Log the error (don't expose detailed error to user)
        error_log('Password reset error: ' . $e->getMessage());

        // Return generic error
        $response['message'] = 'There was an error processing your request. Please try again later.';
    }

    // Make sure all browsers treat this as JSON
    header('Content-Type: application/json');

    // Send the response
    echo json_encode($response);
    exit;
} else {
    // If not a POST request, redirect to the reset password form
    header('Location: ../password-reset.php');
    exit;
}
