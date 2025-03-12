<?php

    include('database.php');

    $from = isset($_GET['from']) ? $_GET['from'] : "";
    $to = isset($_GET['to']) ? $_GET['to'] : "";
    $d = isset($_GET['d']) ? $_GET['d'] : "";

    if (empty($from) || empty($to)) {
        die(json_encode(["error" => "Date range is required"]));
    }

    $start = new DateTime($from);
    $end = new DateTime($to);
    $end->modify('+1 day'); 

    $employeesQuery = "SELECT DISTINCT accounts.bio_userid, 
                          CONCAT(accounts.first_name, ' ', COALESCE(accounts.middle_name, ''), ' ', accounts.last_name) AS full_name 
                   FROM accounts 
                   WHERE employee_id = ?";

    $stmt = $con->prepare($employeesQuery);
    $stmt->bind_param("s", $d);
    $stmt->execute();
    $employeesResult = $stmt->get_result();

    $employees = [];
    while ($row = $employeesResult->fetch_assoc()) {
        $employees[$row['bio_userid']] = trim($row['full_name']);
    }

    if (empty($employees)) {
        die(json_encode(["error" => "No employees found"]));
    }

    $sql = "SELECT 
                userid, 
                attn_date, 
                DAYNAME(STR_TO_DATE(attn_date, '%m/%d/%Y')) AS day_of_week,
                MIN(CASE WHEN attn_type = 'check-in' THEN attn_time END) AS checkin,
                MAX(CASE WHEN attn_type = 'check-out' THEN attn_time END) AS checkout
            FROM attendances
            WHERE attn_date BETWEEN ? AND ?
            GROUP BY userid, attn_date
            ORDER BY userid, attn_date;";


    $stmt = $con->prepare($sql);
    $stmt->bind_param("ss", $from, $to);
    $stmt->execute();
    $result = $stmt->get_result();

    $attendanceRecords = [];

    while ($row = $result->fetch_assoc()) {
        $userId = $row['userid'];
        $attnDate = $row['attn_date'];

        $checkIn = !empty($row['checkin']) ? $row['checkin'] : '------';
        $checkOut = !empty($row['checkout']) ? $row['checkout'] : '------';

        error_log("User: $userId, Date: $attnDate, Check-in: $checkIn, Check-out: $checkOut");

        $attendanceRecords[$userId][$attnDate] = [
            'day_of_week' => $row['day_of_week'],
            'check_in_time' => $checkIn,
            'check_out_time' => $checkOut,
            'present' => ($checkIn !== '------' || $checkOut !== '------')
        ];
    }

    $data = [];

    foreach ($employees as $empId => $fullName) {
        $current = clone $start;
        while ($current < $end) {
            $dateStr = $current->format('m/d/Y');
            $dayOfWeek = $current->format('l');

            if (isset($attendanceRecords[$empId][$dateStr])) {
                $record = $attendanceRecords[$empId][$dateStr];

                $checkIn = $record['check_in_time'];
                $checkOut = $record['check_out_time'];
                $workHours = 0;
                $remark = 'Absent';

                if ($checkIn !== '------' && $checkOut !== '------') {
                    $checkInTime = DateTime::createFromFormat('m/d/Y h:i:s A', $attnDate . ' ' . $checkIn);
                    $checkOutTime = DateTime::createFromFormat('m/d/Y h:i:s A', $attnDate . ' ' . $checkOut);
                    $officialStartTime = DateTime::createFromFormat('m/d/Y h:i:s A', $attnDate . ' 08:00:00 AM');
                
                    if ($checkInTime && $checkOutTime && $officialStartTime) {
                        $workHours = ($checkOutTime->getTimestamp() - $checkInTime->getTimestamp()) / 3600 - 1;
                
                        $remark = "Present";
                
                        if ($checkInTime > $officialStartTime) {
                            $remark = "Present (Late)";
                        }

                    } else {
                        error_log("Date parsing error: Check your input formats.");
                    }
                }

                $data[] = [
                    'userid' => $empId,
                    'full_name' => $fullName,
                    'attn_date' => $dateStr,
                    'day_of_week' => $record['day_of_week'],
                    'check_in_time' => $checkIn,
                    'check_out_time' => $checkOut,
                    'work_hours' => number_format($workHours, 2),
                    'remark' => $remark
                ];
            } else {
                $data[] = [
                    'userid' => $empId,
                    'full_name' => $fullName,
                    'attn_date' => $dateStr,
                    'day_of_week' => $dayOfWeek,
                    'check_in_time' => '------',
                    'check_out_time' => '------',
                    'work_hours' => '0.00',
                    'remark' => 'Absent'
                ];
            }
            $current->modify('+1 day');
        }
    }

    if (isset($_GET['debug'])) {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        exit;
    }

    header('Content-Type: application/json');
    echo json_encode($data);

?>
