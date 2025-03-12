<?php
include('database.php');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['start']) && isset($data['end'])) {
    $startDate = $data['start'];
    $endDate = $data['end'];
    $employee = $data['emp'];

    $constant_time_in = '8:00 AM';
    $constant_time_out = '5:00 PM';

    $sql = "
        SELECT 
            attn_date, 
            MAX(CASE WHEN attn_type = 'Check-in' THEN attn_time END) AS time_in,
            MAX(CASE WHEN attn_type = 'Check-out' THEN attn_time END) AS time_out
        FROM 
            attendances 
        WHERE 
            attn_date BETWEEN '$startDate' AND '$endDate' 
            AND userid = $employee
        GROUP BY 
            attn_date
        ORDER BY 
            attn_date DESC;
    ";

    $result = $con->query($sql);
    $html = '';
    $absent = 0;
    $late = 0;
    $undertime = 0;
    $overtime = 0;

    $attendanceRecords = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $attendanceRecords[$row['attn_date']] = [
                'time_in' => $row['time_in'],
                'time_out' => $row['time_out']
            ];
        }
    }

    $startMonth = date('F', strtotime($startDate));
    $endMonth = date('F', strtotime($endDate));

    if ($startMonth === $endMonth) {
        $monthRange = $startMonth; 
    } else {
        $monthRange = $startMonth . '-' . $endMonth; 
    }

    $start = new DateTime($startDate);
    $end = new DateTime($endDate);
    $period = new DatePeriod($start, new DateInterval('P1D'), $end->modify('+1 day'));
    
    foreach ($period as $date) {
        if ($date->format('N') >= 6) {
            continue; 
        }
        $remark = 'Checked';
        $remark_color = 'text-success';
        $formattedDate = $date->format('m/d/Y');
        $dayOfWeek = $date->format('D');

        if (!isset($attendanceRecords[$formattedDate])) {
            $absent++; 
            $remark = 'Absent';
            $html .= '<tr>';
            $html .= '<td class="text-center">' . htmlspecialchars($formattedDate) . ' (' . $dayOfWeek . ')</td>';
            $html .= '<td class="text-center">-----</td>';
            $html .= '<td class="text-center">-----</td>';
            $html .= '<td class="text-center text-danger">'.$remark.'</td>';
            $html .= '</tr>';
        } else {
            $time_in = $attendanceRecords[$formattedDate]['time_in'] ?? 'Absent';
            $time_out = $attendanceRecords[$formattedDate]['time_out'] ?? 'Absent';

            if ($time_in !== 'Absent' && strtotime($time_in) > strtotime($constant_time_in)) {
                $late++;
                $remark = 'Late';
                $remark_color = 'text-warning';
            }

            if ($time_out !== 'Absent' && strtotime($time_out) < strtotime($constant_time_out)) {
                $undertime++;
                $remark = 'Undertime';
                $remark_color = 'text-danger';
            }

            if ($time_out !== 'Absent' && strtotime($time_out) > strtotime($constant_time_out)) {
                $overtime++;
                $remark = 'Overtime';
                $remark_color = 'text-info';
            }

            $html .= '<tr>';
            $html .= '<td class="text-center">' . htmlspecialchars($formattedDate) . ' (' . $dayOfWeek . ')</td>';
            $html .= '<td class="text-center">' . htmlspecialchars($time_in) . '</td>';
            $html .= '<td class="text-center">' . htmlspecialchars($time_out) . '</td>';
            $html .= '<td class="text-center '.$remark_color.'">'.$remark.'</td>';
            $html .= '</tr>';
        }
    }

    echo json_encode(['html' => $html, 'absent' => $absent, 'late' => $late, 'under' => $undertime, 'overtime' => $overtime]);

} else {
    echo 'Invalid date range.';
}
?>
