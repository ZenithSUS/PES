<?php
include('database.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM accounts WHERE employee_acc_id = $id";
    $result = $con->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Set content type header to JPEG (default assumption)
        header("Content-Type: ".$row['imgType']);

        echo $row['img'];
        echo $row['imgType'];
        echo "adsadadsadad";

    } else {
        // Return an error message or redirect to a placeholder image
        echo "Image not found.";
    }
} else {
    echo "No image ID provided.";
}

$con->close();
?>