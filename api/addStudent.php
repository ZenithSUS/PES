<?php

include('database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $teacherid = $_POST['teacherid'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $acc_status = $_POST['acc_status'];
    $email_verif = $_POST['email_verif'];
    $section = $_POST['section'];
    $course = $_POST['course'];
    $password = md5($_POST['password']);
    
    if (isset($_FILES['filepond']) && $_FILES['filepond']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['filepond']['tmp_name'];
        $fileName = $_FILES['filepond']['name'];
        $fileType = $_FILES['filepond']['type'];
        $imgProp = getimagesize($_FILES['filepond']['tmp_name']);
        $fileData = addslashes(file_get_contents($fileTmpPath));
    } else {
        $fileData = null;
    }
    
    $sql = "INSERT INTO students (student_number, firstname, lastname, email, phone, password, course, section, imgType, img, email_verified, acc_status)
            VALUES ('$teacherid', '$firstname', '$lastname', '$email', '$phone', '$password', '$course', '$section', '{$imgProp['mime']}', '{$fileData}', '$email_verif', '$acc_status')";

    if ($con->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$con->close();

?>