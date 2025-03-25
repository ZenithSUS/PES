<?php

include('database.php');

$from = isset($_GET['from']) ? $_GET['from'] : "";
$to = isset($_GET['to']) ? $_GET['to'] : "";

if (empty($from) || empty($to)) {
    die(json_encode(["error" => "Date range is required"]));
}

$start = new DateTime($from);
$end = new DateTime($to);
$end->modify('+1 day'); 

$employeesQuery = "SELECT DISTINCT accounts.bio_userid, 
                        CONCAT(accounts.first_name, ' ', COALESCE(accounts.middle_name, ''), ' ', accounts.last_name) AS full_name 
                FROM accounts";
$employeesResult = $con->query($employeesQuery);

$employees = [];
while ($row = $employeesResult->fetch_assoc()) {
    $employees[$row['bio_userid']] = trim($row['full_name']);
}

if (empty($employees)) {
    die(json_encode(["error" => "No employees found"]));
}

$sql = "SELECT
    c.id AS checkin_id,
    c.userid,
    c.attn_date AS checkin_date,
    c.attn_time AS checkin_time,
    /* Earliest matching checkout ID */
    (
      SELECT o.id
      FROM attendances AS o
      WHERE o.userid = c.userid
        AND o.attn_type = 'check-out'
        AND (
            -- Day shift: check-out on same date, after check-in time
            (
              STR_TO_DATE(c.attn_time, '%h:%i:%s %p') < STR_TO_DATE('06:00:00 PM', '%h:%i:%s %p')
              AND o.attn_date = c.attn_date
              AND STR_TO_DATE(o.attn_time, '%h:%i:%s %p') > STR_TO_DATE(c.attn_time, '%h:%i:%s %p')
            )
            OR
            -- Night shift: check-out on next date (no time check needed)
            (
              STR_TO_DATE(c.attn_time, '%h:%i:%s %p') >= STR_TO_DATE('06:00:00 PM', '%h:%i:%s %p')
              AND o.attn_date = DATE_FORMAT(
                  DATE_ADD(STR_TO_DATE(c.attn_date, '%m/%d/%Y'), INTERVAL 1 DAY),
                  '%m/%d/%Y'
              )
            )
        )
      ORDER BY 
        -- earliest valid check-out by date, then by time
        STR_TO_DATE(o.attn_date, '%m/%d/%Y'),
        STR_TO_DATE(o.attn_time, '%h:%i:%s %p')
      LIMIT 1
    ) AS checkout_id,

    /* Earliest matching checkout date */
    (
      SELECT o.attn_date
      FROM attendances AS o
      WHERE o.userid = c.userid
        AND o.attn_type = 'check-out'
        AND (
            (STR_TO_DATE(c.attn_time, '%h:%i:%s %p') < STR_TO_DATE('06:00:00 PM', '%h:%i:%s %p')
             AND o.attn_date = c.attn_date
             AND STR_TO_DATE(o.attn_time, '%h:%i:%s %p') > STR_TO_DATE(c.attn_time, '%h:%i:%s %p')
            )
            OR
            (STR_TO_DATE(c.attn_time, '%h:%i:%s %p') >= STR_TO_DATE('06:00:00 PM', '%h:%i:%s %p')
             AND o.attn_date = DATE_FORMAT(
                 DATE_ADD(STR_TO_DATE(c.attn_date, '%m/%d/%Y'), INTERVAL 1 DAY),
                 '%m/%d/%Y'
             )
            )
        )
      ORDER BY
        STR_TO_DATE(o.attn_date, '%m/%d/%Y'),
        STR_TO_DATE(o.attn_time, '%h:%i:%s %p')
      LIMIT 1
    ) AS checkout_date,

    /* Earliest matching checkout time */
    (
      SELECT o.attn_time
      FROM attendances AS o
      WHERE o.userid = c.userid
        AND o.attn_type = 'check-out'
        AND (
            (STR_TO_DATE(c.attn_time, '%h:%i:%s %p') < STR_TO_DATE('06:00:00 PM', '%h:%i:%s %p')
             AND o.attn_date = c.attn_date
             AND STR_TO_DATE(o.attn_time, '%h:%i:%s %p') > STR_TO_DATE(c.attn_time, '%h:%i:%s %p')
            )
            OR
            (STR_TO_DATE(c.attn_time, '%h:%i:%s %p') >= STR_TO_DATE('06:00:00 PM', '%h:%i:%s %p')
             AND o.attn_date = DATE_FORMAT(
                 DATE_ADD(STR_TO_DATE(c.attn_date, '%m/%d/%Y'), INTERVAL 1 DAY),
                 '%m/%d/%Y'
             )
            )
        )
      ORDER BY
        STR_TO_DATE(o.attn_date, '%m/%d/%Y'),
        STR_TO_DATE(o.attn_time, '%h:%i:%s %p')
      LIMIT 1
    ) AS checkout_time,

    -- day of week, if you like
    DAYNAME(STR_TO_DATE(c.attn_date, '%m/%d/%Y')) AS day_of_week

FROM attendances c
WHERE c.attn_type = 'check-in'
  AND STR_TO_DATE(c.attn_date, '%m/%d/%Y')
      BETWEEN STR_TO_DATE(?,'%m/%d/%Y')
      AND STR_TO_DATE(?,'%m/%d/%Y')
ORDER BY 
    c.userid,
    STR_TO_DATE(c.attn_date, '%m/%d/%Y'),
    STR_TO_DATE(c.attn_time, '%h:%i:%s %p');";

$stmt = $con->prepare($sql);
$stmt->bind_param("ss", $from, $to);
$stmt->execute();
$result = $stmt->get_result();

$attendanceRecords = [];

while ($row = $result->fetch_assoc()) {
    $userId = $row['userid'];
    $attnDate = $row['checkin_date'];

    $checkIn = !empty($row['checkin_time']) ? $row['checkin_time'] : '------';
    $checkOut = !empty($row['checkout_time']) ? $row['checkout_time'] : '------';

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
            $isNightShift = false;

            if ($checkIn !== '------' && $checkOut !== '------') {
                try {
                    $checkInTime = DateTime::createFromFormat('m/d/Y h:i:s A', $dateStr . ' ' . $checkIn);
                    $checkOutDate = $dateStr;
                    
                    // Check if this is a night shift (check-in after 6PM)
                    if ($checkInTime && $checkInTime->format('H') >= 18) {
                        $isNightShift = true;
                        $checkOutDate = $current->format('m/d/Y');
                        $checkOutTime = DateTime::createFromFormat('m/d/Y h:i:s A', $checkOutDate . ' ' . $checkOut);
                        if ($checkOutTime < $checkInTime) {
                            $checkOutTime->modify('+1 day');
                        }
                    } else {
                        $checkOutTime = DateTime::createFromFormat('m/d/Y h:i:s A', $checkOutDate . ' ' . $checkOut);
                    }

                    if ($checkInTime && $checkOutTime) {
                        $workHours = ($checkOutTime->getTimestamp() - $checkInTime->getTimestamp()) / 3600;
                        
                        // Subtract 1 hour for lunch if work hours > 4
                        if ($workHours > 4) {
                            $workHours -= 1;
                        }

                        $officialDayStartTime = DateTime::createFromFormat('m/d/Y h:i:s A', $dateStr . ' 08:00:00 AM');
                        $officialDayEndTime = DateTime::createFromFormat('m/d/Y h:i:s A', $dateStr . ' 04:00:00 PM');
                        $officialNightStartTime = DateTime::createFromFormat('m/d/Y h:i:s A', $dateStr . ' 08:00:00 PM');

                        $remark = "Present";

                        if (!$isNightShift && $checkInTime > $officialDayStartTime) {
                            $remark = "Late";
                        } elseif ($isNightShift && $checkInTime > $officialNightStartTime) {
                            $remark = "Late";
                        }

                        if ($workHours < 8) {
                            $remark = ($remark === "Present") ? "Undertime" : $remark . " (Undertime)";
                        }
                    }
                } catch (Exception $e) {
                    error_log("Error processing time data: " . $e->getMessage());
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
                'remark' => $remark,
                'is_night_shift' => $isNightShift
            ];
        } else {
            $data[] = [
                'userid' => $empId,
                'full_name' => $fullName,
                'attn_date' => $dateStr,
                'day_of_week' => $dayOfWeek,
                'check_in_time' => '------',
                'check_out_time' => '------',
                'work_hours' => 0,
                'remark' => 'Absent',
                'is_night_shift' => false
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