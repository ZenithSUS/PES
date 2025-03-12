<?php

include('../api/database.php');

$attendances = json_decode(file_get_contents('php://input'), true);

if ($attendances === null) {
    echo "Error decoding JSON: " . json_last_error_msg();
    exit;
}

if (!is_array($attendances)) {
    echo "Decoded data is not an array.";
    exit;
}

$attendanceTypes = [
    0 => "Check-in",
    1 => "Check-out",
    2 => "Overtime-in",
    3 => "Overtime-out"
];

foreach ($attendances as $attn) {
    $typeStr = $attendanceTypes[$attn['type']] ?? $attn['type'];

    $timestamp = $attn['timestamp']; 
    $attn_date = date("m/d/Y", strtotime($timestamp));
    $attn_time = date("h:i:s A", strtotime($timestamp));

    $sql = "INSERT IGNORE INTO attendances 
                (userid, attn_date, attn_time, attn_timestamp, attn_type) 
            VALUES 
                ('{$attn['user_id']}', '{$attn_date}', '{$attn_time}', '{$timestamp}', '{$typeStr}')";

    if ($con->query($sql) !== TRUE) {
        file_put_contents("error_log.txt", "MySQL Error: " . $con->error . PHP_EOL, FILE_APPEND);
    }
}

echo "Records for users inserted successfully";

?>