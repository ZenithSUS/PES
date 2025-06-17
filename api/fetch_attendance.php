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

function getLateMinutes($checkInTime, $isNightShift)
{
    $cutoffTime = $isNightShift ? strtotime("8:00:00 PM") : strtotime("8:00:00 AM");

    $checkTime = strtotime($checkInTime);

    if ($checkTime === false) {
        return 0;
    }

    if ($checkTime > $cutoffTime) {
        $lateSeconds = $checkTime - $cutoffTime;
        $lateMinutes = $lateSeconds / 60;
        return round($lateMinutes);
    }

    return 0;
}

function isNightShift($time)
{
    $startTime = strtotime("8:00:00 PM");
    $checkTime = strtotime($time);

    if ($checkTime === false) {
        return false;
    }

    if ($checkTime >= $startTime) {
        return true;
    }

    $midnight = strtotime("12:00:00 AM");
    $nextDay5AM = strtotime("5:00:00 AM");
    return ($checkTime >= $midnight && $checkTime < $nextDay5AM);
}

function isOutTime5($checkOut, $isNightShift) {
    $timeOutIs5 = $isNightShift ? strtotime("5:00:00 AM") : strtotime("5:00:00 PM");
    $checkOut = strtotime($checkOut);
    return $checkOut >= $timeOutIs5;
}

function overtimeHours($checkOutTime, $isNightShift)
{
    // Standard end of workday for day and night shifts
    $standardEndTime = $isNightShift 
        ? DateTime::createFromFormat('h:i:s A', '05:00:00 AM') 
        : DateTime::createFromFormat('h:i:s A', '05:00:00 PM');
    
    // Parse the check-out time
    $checkOut = DateTime::createFromFormat('h:i:s A', $checkOutTime);
    
    // If check-out time is invalid, return 0
    if (!$checkOut) {
        return 0;
    }
    
    // Adjust for night shifts
    if ($isNightShift) {
        if ($checkOut < $standardEndTime) {
            $checkOut->modify('+1 day');
        }
    }
    
    // Calculate time difference
    $timeDiff = $checkOut->getTimestamp() - $standardEndTime->getTimestamp();
    $overtimeMinutes = $timeDiff / 60;

    
    if ($overtimeMinutes <= 0) {
        return 0;
    }
    
    // Dynamic overtime calculation
    // Add 0.5 for every 30-minute increment
    $overtimeHours = floor($overtimeMinutes / 30) * 0.5;
    
    return $overtimeHours;
}

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
    (
      SELECT o.id
      FROM attendances AS o
      WHERE o.userid = c.userid
        AND o.attn_type = 'check-out'
        AND (
            (
              STR_TO_DATE(c.attn_time, '%h:%i:%s %p') < STR_TO_DATE('06:00:00 PM', '%h:%i:%s %p')
              AND o.attn_date = c.attn_date
              AND STR_TO_DATE(o.attn_time, '%h:%i:%s %p') > STR_TO_DATE(c.attn_time, '%h:%i:%s %p')
            )
            OR
            (
              STR_TO_DATE(c.attn_time, '%h:%i:%s %p') >= STR_TO_DATE('06:00:00 PM', '%h:%i:%s %p')
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
    ) AS checkout_id,
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
$totalWorkHours = 0;

while ($row = $result->fetch_assoc()) {
    $userId = $row['userid'];
    $attnDate = $row['checkin_date'];

    $checkIn = !empty($row['checkin_time']) ? $row['checkin_time'] : '------';
    $checkOut = !empty($row['checkout_time']) ? $row['checkout_time'] : '------';

    $workHours = 0;
    $overtime = 0;
    $isNightTime = isNightShift($checkIn);

    if ($checkIn !== '------' && $checkOut !== '------') {
        try {
            $checkInTime = DateTime::createFromFormat('m/d/Y h:i:s A', $attnDate . ' ' . $checkIn);
            $checkOutDate = $attnDate;

            if ($checkInTime && $checkInTime->format('H') >= 18) {
                $isNightTime = true;
                $checkOutDate = DateTime::createFromFormat('m/d/Y', $attnDate)->modify('+1 day')->format('m/d/Y');
            }

            $checkOutTime = DateTime::createFromFormat('m/d/Y h:i:s A', $checkOutDate . ' ' . $checkOut);

            if ($checkInTime && $checkOutTime) {
                $workHours = ($checkOutTime->getTimestamp() - $checkInTime->getTimestamp()) / 3600;

                if ($workHours > 4) {
                    $workHours -= 1;
                }
                
                $overtime = overtimeHours($checkOut, $isNightTime);
            }
        } catch (Exception $e) {
            error_log("Error processing time data: " . $e->getMessage());
        }
    }

    $attendanceRecords[$userId][$attnDate] = [
        'day_of_week' => $row['day_of_week'],
        'check_in_time' => $checkIn,
        'check_out_time' => $checkOut,
        'late' => getLateMinutes($checkIn, $isNightTime),
        'overtime' => $overtime,
        'present' => ($checkIn !== '------' || $checkOut !== '------')
    ];
}

$data = [];

foreach ($employees as $empId => $fullName) {
    $totalWorkHours = 0;
    $totalLateMinutes = 0;
    $totalOvertimeHours = 0;
    
    $current = clone $start;
    while ($current < $end) {
        $dateStr = $current->format('m/d/Y');
        $dayOfWeek = $current->format('l');

        if (isset($attendanceRecords[$empId][$dateStr])) {
            $record = $attendanceRecords[$empId][$dateStr];

            $checkIn = $record['check_in_time'];
            $checkOut = $record['check_out_time'];
            $lateTime = $record['late'];
            $overtime = $record['overtime'];
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

                        if(isOutTime5($checkOut, $isNightTime)) {
                            $workHours = 8;
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
                    
                    $totalWorkHours += $workHours;
                    $totalLateMinutes += $lateTime;
                    $totalOvertimeHours += $overtime;
                    
                } catch (Exception $e) {
                    error_log("Error processing time data: " . $e->getMessage());
                }
            }
            
            $checkHourRange = $workHours >= 8 || $workHours == 0;
            $formattedHours = number_format(min($workHours, 8), $checkHourRange ? 0 : 2);
            $formattedTotalHours = number_format($totalWorkHours, $totalWorkHours == (int)$totalWorkHours ? 0 : 2);
            
            // Keep decimal format for individual records, but add "hr" for totals
            $formattedOvertime = number_format($overtime, $overtime == 0 ? 0 : 2);
            $formattedTotalOvertime = number_format($totalOvertimeHours, $totalOvertimeHours == (int)$totalOvertimeHours ? 0 : 2) . ' hr';
            
            $data[] = [
                'userid' => $empId,
                'full_name' => $fullName,
                'attn_date' => $dateStr,
                'day_of_week' => $record['day_of_week'],
                'check_in_time' => $checkIn,
                'check_out_time' => $checkOut,
                'work_hours' => $formattedHours,
                'remark' => $remark,
                'late' => $lateTime,
                'overtime' => $formattedOvertime,
                'is_night_shift' => $isNightShift,
                'total_work_hours' => $formattedTotalHours,
                'total_late_minutes' => $totalLateMinutes . ' min',
                'total_overtime' => $formattedTotalOvertime,
            ];
        } else {
            $formattedTotalHours = number_format($totalWorkHours, $totalWorkHours == (int)$totalWorkHours ? 0 : 2) . ' hr';
            $formattedTotalOvertime = number_format($totalOvertimeHours, $totalOvertimeHours == (int)$totalOvertimeHours ? 0 : 2) . ' hr';
            
            $data[] = [
                'userid' => $empId,
                'full_name' => $fullName,
                'attn_date' => $dateStr,
                'day_of_week' => $dayOfWeek,
                'check_in_time' => '------',
                'check_out_time' => '------',
                'work_hours' => 0,
                'remark' => 'Absent',
                'late' => 0,
                'overtime' => '0',
                'is_night_shift' => false,
                'total_work_hours' => $formattedTotalHours,
                'total_late_minutes' => $totalLateMinutes . ' min',
                'total_overtime' => $formattedTotalOvertime,
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