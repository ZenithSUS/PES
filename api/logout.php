<?php

    include('session.php');

    session_destroy();

    // if (isset($_GET['logout'])) {
    //     if($_GET['user'] == 'logout') {
    //         echo json_encode(['message' => 'Logout Successfully']);
    //     } else {
    
    //         echo '<script>alert("Logout Successfully")</script>';
    //         echo '<script>localStorage.clear();</script>';
    //         echo '<script>window.location.href="../authentication/SignIn.php"</script>';
    //         echo json_encode(['message' => 'Logout Successfully']);
    
    //     }

    // } else {

    //     echo '<script>alert("Logout Successfully")</script>';
    //     echo '<script>localStorage.clear();</script>';
    //     echo '<script>window.location.href="../authentication/SignIn.php"</script>';
    //     echo json_encode(['message' => 'Logout Successfully']);

    // }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo json_encode(['message' => 'Logout Successfully']);
    } else {
        echo json_encode(['error' => 'Invalid request method']);
    }


?>