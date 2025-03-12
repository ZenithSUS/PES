<?php

include('database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $teacherid = $_POST['teacherid'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];
    $status = $_POST['status'];
    $section = $_POST['section'];
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
    
    $sql = "INSERT INTO accounts (employee_id, firstname, lastname, email, phone, password, imgType, img, status, section, role)
            VALUES ('$teacherid', '$firstname', '$lastname', '$email', '$phone', '$password', '{$imgProp['mime']}', '{$fileData}', '$status', '$section', '$role')";

    if ($con->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$con->close();

?>