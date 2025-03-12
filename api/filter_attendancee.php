<?php
include('database.php');

$data = json_decode(file_get_contents('php://input'), true);

if (!empty($_GET['start']) && !empty($_GET['end']) && !empty($_GET['emp'])) {
    $startDate = DateTime::createFromFormat('m/d/Y', $_GET['start'])->format('m/d/Y');
    $endDate = DateTime::createFromFormat('m/d/Y', $_GET['end'])->format('m/d/Y');
    $employee = $_GET['emp'];

    $constant_time_in = '08:00 AM';
    $constant_time_out = '05:00 PM';

    $sql = "
        SELECT 
            DATE_FORMAT(attn_date, '%m/%d/%Y') AS attn_date, 
            MIN(CASE WHEN attn_type = 'Check-in' THEN attn_time END) AS time_in,
            MAX(CASE WHEN attn_type = 'Check-out' THEN attn_time END) AS time_out
        FROM 
            attendances 
        WHERE 
            attn_date BETWEEN STR_TO_DATE('$startDate', '%m/%d/%Y') AND STR_TO_DATE('$endDate', '%m/%d/%Y')
            AND userid = '$employee'
        GROUP BY 
            attn_date
        ORDER BY 
            attn_date ASC;
    ";

    $result = $con->query($sql);
    $attendanceRecords = [];

    while ($row = $result->fetch_assoc()) {
        $attendanceRecords[$row['attn_date']] = [
            'time_in' => $row['time_in'],
            'time_out' => $row['time_out']
        ];
    }

    $absent = 0;
    $late = 0;
    $undertime = 0;
    $overtime = 0;
    $html = '';

    $start = DateTime::createFromFormat('m/d/Y', $startDate);
    $end = DateTime::createFromFormat('m/d/Y', $endDate);
    $period = new DatePeriod($start, new DateInterval('P1D'), $end->modify('+1 day'));

    foreach ($period as $date) {
        $formattedDate = $date->format('m/d/Y');
        $dayOfWeek = $date->format('D');

        if ($date->format('N') >= 6) {
            continue;
        }

        if (!isset($attendanceRecords[$formattedDate])) {
            $absent++;
            $html .= "<tr>
                        <td class='text-center'>$formattedDate ($dayOfWeek)</td>
                        <td class='text-center'>-----</td>
                        <td class='text-center'>-----</td>
                        <td class='text-center text-danger'>Absent</td>
                      </tr>";
        } else {
            $time_in = $attendanceRecords[$formattedDate]['time_in'] ?? 'Absent';
            $time_out = $attendanceRecords[$formattedDate]['time_out'] ?? 'Absent';

            $remark = 'Checked';
            $remark_color = 'text-success';

            $timeInObject = ($time_in !== 'Absent') ? DateTime::createFromFormat('h:i:s A', $time_in) : null;
            $constantTimeInObject = DateTime::createFromFormat('h:i A', $constant_time_in);

            if ($timeInObject && $constantTimeInObject && $timeInObject > $constantTimeInObject) {
                $late++;
                $remark = 'Late';
                $remark_color = 'text-warning';
            }

            $timeOutObject = ($time_out !== 'Absent') ? DateTime::createFromFormat('h:i:s A', $time_out) : null;
            $constantTimeOutObject = DateTime::createFromFormat('h:i A', $constant_time_out);

            if ($timeOutObject && $constantTimeOutObject && $timeOutObject < $constantTimeOutObject) {
                $undertime++;
                $remark = 'Undertime';
                $remark_color = 'text-danger';
            }

            if ($timeOutObject && $constantTimeOutObject && $timeOutObject > $constantTimeOutObject) {
                $overtime++;
                $remark = 'Overtime';
                $remark_color = 'text-info';
            }

            $html .= "<tr>
                        <td class='text-center'>$formattedDate ($dayOfWeek)</td>
                        <td class='text-center'>$time_in</td>
                        <td class='text-center'>$time_out</td>
                        <td class='text-center $remark_color'>$remark</td>
                      </tr>";
        }
    }

    echo json_encode([
        'html' => $html,
        'absent' => $absent,
        'late' => $late,
        'under' => $undertime,
        'overtime' => $overtime,
        'emp' => $employee
    ]);
} else {
    echo json_encode([
        'error' => 'Invalid input data.',
        'received_start' => $_GET['start'] ?? 'N/A',
        'received_end' => $_GET['end'] ?? 'N/A',
        'emp' => $employee
    ]);
}
?>
